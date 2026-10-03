<?php
/**
 * Enquiries: database storage, HTML email, and admin inbox viewer.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('RENEW_ENQUIRY_DB_VERSION', '1');

function renew_enquiry_table() {
    global $wpdb;
    return $wpdb->prefix . 'renew_enquiries';
}

function renew_enquiry_install_table() {
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $table   = renew_enquiry_table();
    $charset = $wpdb->get_charset_collate();

    dbDelta("CREATE TABLE {$table} (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        form_type varchar(20) NOT NULL DEFAULT 'contact',
        name varchar(120) NOT NULL DEFAULT '',
        email varchar(190) NOT NULL DEFAULT '',
        phone varchar(40) NOT NULL DEFAULT '',
        business varchar(190) NOT NULL DEFAULT '',
        partner_brand varchar(190) NOT NULL DEFAULT '',
        message text NULL,
        subject varchar(255) NOT NULL DEFAULT '',
        email_html longtext NULL,
        mail_status varchar(20) NOT NULL DEFAULT 'pending',
        ip_address varchar(45) NOT NULL DEFAULT '',
        created_at datetime NOT NULL,
        PRIMARY KEY  (id),
        KEY created_at (created_at)
    ) {$charset};");

    update_option('renew_enquiry_db_version', RENEW_ENQUIRY_DB_VERSION);
}
add_action('after_switch_theme', 'renew_enquiry_install_table');

function renew_enquiry_maybe_install() {
    if (get_option('renew_enquiry_db_version') !== RENEW_ENQUIRY_DB_VERSION) {
        renew_enquiry_install_table();
    }
}
add_action('init', 'renew_enquiry_maybe_install');

/**
 * Render the HTML email from templates/emails/enquiry.php.
 */
function renew_enquiry_email_html(array $d) {
    $file = get_template_directory() . '/templates/emails/enquiry.php';
    if (!is_readable($file)) {
        return '';
    }

    $site = get_bloginfo('name');
    $logo = renew_mod('orbit_group_logo') ? wp_get_attachment_image_url(renew_mod('orbit_group_logo'), 'full') : renew_asset('images/renew-group-logo.png');

    ob_start();
    include $file;
    return ob_get_clean();
}

/**
 * Handle both contact and popup (partner) enquiries.
 */
function renew_handle_enquiry() {
    check_ajax_referer('renew_enquiry_nonce', 'nonce');

    $type          = (isset($_POST['form_type']) && sanitize_key(wp_unslash($_POST['form_type'])) === 'partner') ? 'partner' : 'contact';
    $name          = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $phone         = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $email         = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $business      = isset($_POST['business']) ? sanitize_text_field(wp_unslash($_POST['business'])) : '';
    $partner_brand = isset($_POST['partner_brand']) ? sanitize_text_field(wp_unslash($_POST['partner_brand'])) : '';
    $message       = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

    if ($name === '' || $phone === '') {
        wp_send_json_error(array('message' => 'Please enter your name and phone number.'), 422);
    }

    $digits = preg_replace('/\D+/', '', $phone);
    if (!preg_match('/^(?:91)?[6-9][0-9]{9}$/', $digits)) {
        wp_send_json_error(array('message' => 'Please enter a valid Indian mobile number.'), 422);
    }

    if ($email !== '' && !is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'), 422);
    }

    $data = array(
        'form_type'     => $type,
        'name'          => $name,
        'email'         => $email,
        'phone'         => $phone,
        'business'      => $business,
        'partner_brand' => $partner_brand,
        'message'       => $message,
        'created_at'    => current_time('mysql'),
    );

    $subject = ($type === 'partner')
        ? 'New Renew Group partnership enquiry'
        : 'New Renew Group website enquiry';
    if ($name !== '') {
        $subject .= ' - ' . $name;
    }

    $html = renew_enquiry_email_html($data);

    // Store first so no enquiry is lost if mail delivery fails.
    global $wpdb;
    $table    = renew_enquiry_table();
    $inserted = $wpdb->insert($table, array_merge($data, array(
        'subject'     => $subject,
        'email_html'  => $html,
        'mail_status' => 'pending',
        'ip_address'  => isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '',
    )));
    $row_id = $inserted ? (int) $wpdb->insert_id : 0;

    $headers = array('Content-Type: text/html; charset=UTF-8');
    if ($email) {
        $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';
    }

    $sent = wp_mail(get_option('admin_email'), $subject, $html, $headers);

    if ($row_id) {
        $wpdb->update($table, array('mail_status' => $sent ? 'sent' : 'failed'), array('id' => $row_id));
    }

    if (!$sent && !$row_id) {
        wp_send_json_error(array(
            'message' => 'Your enquiry could not be sent right now. Please contact us by phone or email.'
        ), 500);
    }

    wp_send_json_success(array(
        'message' => ($type === 'partner')
            ? 'Thank you. Your partnership enquiry has been sent to the Renew Group team.'
            : 'Thank you. Your enquiry has been sent to the Renew Group team.'
    ));
}
add_action('wp_ajax_renew_submit_enquiry', 'renew_handle_enquiry');
add_action('wp_ajax_nopriv_renew_submit_enquiry', 'renew_handle_enquiry');

/* ---------------------------------------------------------------------
 * Admin: enquiry list + inbox-style email viewer
 * ------------------------------------------------------------------- */

function renew_enquiry_admin_menu() {
    add_menu_page('Enquiries', 'Enquiries', 'manage_options', 'renew-enquiries', 'renew_enquiry_admin_page', 'dashicons-email-alt', 26);
}
add_action('admin_menu', 'renew_enquiry_admin_menu');

function renew_enquiry_admin_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    global $wpdb;
    $table    = renew_enquiry_table();
    $per_page = 20;
    $paged    = max(1, isset($_GET['paged']) ? (int) $_GET['paged'] : 1);
    $total    = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
    $pages    = max(1, (int) ceil($total / $per_page));
    $offset   = ($paged - 1) * $per_page;
    $rows     = $wpdb->get_results($wpdb->prepare(
        "SELECT id, name, email, phone, mail_status FROM {$table} ORDER BY id DESC LIMIT %d OFFSET %d",
        $per_page,
        $offset
    ));
    $nonce = wp_create_nonce('renew_view_enquiry');
    ?>
    <div class="wrap">
        <h1>Contact Enquiries</h1>
        <table class="widefat striped" style="margin-top:12px;">
            <thead>
                <tr>
                    <th style="width:60px;">S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th style="width:120px;">Email Template</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$rows): ?>
                <tr><td colspan="5">No enquiries yet.</td></tr>
            <?php else: foreach ($rows as $i => $r): ?>
                <tr>
                    <td><?php echo (int) ($offset + $i + 1); ?></td>
                    <td><?php echo esc_html($r->name); ?></td>
                    <td><?php echo $r->email !== '' ? esc_html($r->email) : '&mdash;'; ?></td>
                    <td><?php echo esc_html($r->phone); ?></td>
                    <td>
                        <a href="#" class="renew-view-mail" data-id="<?php echo (int) $r->id; ?>" title="View email">
                            <span class="dashicons dashicons-email-alt" style="font-size:22px;width:22px;height:22px;"></span>
                        </a>
                        <?php if ($r->mail_status === 'failed'): ?>
                            <span style="color:#b32d2e;font-size:11px;">not delivered</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
        <?php
        $links = paginate_links(array(
            'base'      => add_query_arg('paged', '%#%'),
            'format'    => '',
            'current'   => $paged,
            'total'     => $pages,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
        ));
        if ($links) {
            echo '<div class="tablenav"><div class="tablenav-pages">' . $links . '</div></div>';
        }
        ?>
    </div>

    <div id="renew-mail-modal" style="display:none;position:fixed;inset:0;z-index:100000;background:rgba(0,0,0,.55);">
        <div style="position:absolute;top:5%;left:50%;transform:translateX(-50%);width:min(820px,94vw);height:90%;background:#fff;border-radius:8px;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.4);">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:16px 20px;border-bottom:1px solid #e2e2e2;background:#f6f7f7;">
                <div>
                    <h2 id="rm-subject" style="margin:0 0 8px;font-size:18px;"></h2>
                    <div style="font-size:13px;line-height:1.7;color:#50575e;">
                        <div><strong>From:</strong> <span id="rm-from"></span></div>
                        <div><strong>To:</strong> <span id="rm-to"></span></div>
                        <div><strong>Date:</strong> <span id="rm-date"></span></div>
                    </div>
                </div>
                <button type="button" class="button" id="rm-close" aria-label="Close">&times;</button>
            </div>
            <iframe id="rm-body" sandbox="" style="flex:1;border:0;width:100%;background:#fff;"></iframe>
        </div>
    </div>

    <script>
    (function () {
        var modal = document.getElementById('renew-mail-modal');
        var frame = document.getElementById('rm-body');
        function close() { modal.style.display = 'none'; frame.srcdoc = ''; }
        document.getElementById('rm-close').addEventListener('click', close);
        modal.addEventListener('click', function (e) { if (e.target === modal) close(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });

        document.querySelectorAll('.renew-view-mail').forEach(function (a) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                var body = new URLSearchParams({
                    action: 'renew_view_enquiry',
                    id: a.dataset.id,
                    _wpnonce: '<?php echo esc_js($nonce); ?>'
                });
                fetch(ajaxurl, { method: 'POST', body: body })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        if (!res.success) { alert('Could not load email.'); return; }
                        var m = res.data;
                        document.getElementById('rm-subject').textContent = m.subject;
                        document.getElementById('rm-from').textContent = m.from;
                        document.getElementById('rm-to').textContent = m.to;
                        document.getElementById('rm-date').textContent = m.date;
                        frame.srcdoc = m.html;
                        modal.style.display = 'block';
                    });
            });
        });
    })();
    </script>
    <?php
}

function renew_enquiry_ajax_view() {
    check_ajax_referer('renew_view_enquiry');
    if (!current_user_can('manage_options')) {
        wp_send_json_error(null, 403);
    }
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare(
        'SELECT * FROM ' . renew_enquiry_table() . ' WHERE id = %d',
        isset($_POST['id']) ? (int) $_POST['id'] : 0
    ));
    if (!$row) {
        wp_send_json_error(null, 404);
    }
    wp_send_json_success(array(
        'subject' => $row->subject,
        'from'    => $row->email !== '' ? $row->name . ' <' . $row->email . '>' : $row->name . ' (via website form)',
        'to'      => get_option('admin_email'),
        'date'    => mysql2date('D, j M Y, g:i A', $row->created_at),
        'html'    => $row->email_html,
    ));
}
add_action('wp_ajax_renew_view_enquiry', 'renew_enquiry_ajax_view');
