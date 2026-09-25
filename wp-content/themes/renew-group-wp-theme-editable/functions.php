<?php
/**
 * Renew Group of Companies WordPress Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

define('RENEW_THEME_VERSION', '1.0.1');

function renew_asset($path = '') {
    return trailingslashit(get_template_directory_uri()) . 'assets/' . ltrim($path, '/');
}

function renew_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 120,
        'width'       => 320,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'renew-group'),
        'footer'  => __('Footer Menu', 'renew-group'),
    ));

    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'renew_setup');

function renew_enqueue_assets() {
    // Local stylesheets.
    wp_enqueue_style('renew-bootstrap', renew_asset('css/bootstrap.min.css'), array(), '5.3.3');
    wp_enqueue_style('renew-bootstrap-icons', renew_asset('css/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css'), array('renew-bootstrap'), '1.11.3');
    wp_enqueue_style('renew-aos', renew_asset('css/aos.css'), array(), '2.3.4');
    wp_enqueue_style('renew-swiper', renew_asset('css/swiper-bundle.min.css'), array(), '11');
    wp_enqueue_style('renew-fonts', renew_asset('css/fonts.css'), array(), RENEW_THEME_VERSION);
    wp_enqueue_style('renew-design', renew_asset('css/style.css'), array('renew-bootstrap', 'renew-fonts'), RENEW_THEME_VERSION);
    // wp_enqueue_style('renew-theme', get_stylesheet_uri(), array('renew-design'), RENEW_THEME_VERSION);

    // Local JavaScript libraries.
    wp_enqueue_script('renew-jquery', renew_asset('js/jquery-3.7.1.min.js'), array(), '3.7.1', true);
    wp_enqueue_script('renew-bootstrap', renew_asset('js/bootstrap.bundle.min.js'), array('renew-jquery'), '5.3.3', true);
    wp_enqueue_script('renew-aos', renew_asset('js/aos.js'), array(), '2.3.4', true);
    wp_enqueue_script('renew-swiper', renew_asset('js/swiper-bundle.min.js'), array(), '11', true);
    wp_enqueue_script('renew-script', renew_asset('js/script.js'), array('renew-jquery', 'renew-bootstrap', 'renew-aos', 'renew-swiper'), RENEW_THEME_VERSION, true);

    wp_localize_script('renew-script', 'RenewTheme', array(
        'ajaxUrl'  => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('renew_enquiry_nonce'),
        'assetUrl' => trailingslashit(renew_asset('')),
        'themeUrl' => trailingslashit(get_template_directory_uri()),
    ));
}
add_action('wp_enqueue_scripts', 'renew_enqueue_assets');

function renew_body_classes($classes) {
    $classes[] = 'renew-group-theme';
    return $classes;
}
add_filter('body_class', 'renew_body_classes');

function renew_enqueue_admin_editor_style() {
    add_editor_style(renew_asset('css/fonts.css'));
}
add_action('admin_init', 'renew_enqueue_admin_editor_style');

/**
 * Handle both contact and partnership enquiries.
 * Uses WordPress' configured wp_mail() transport.
 */
function renew_handle_enquiry() {
    check_ajax_referer('renew_enquiry_nonce', 'nonce');

    $type = isset($_POST['form_type']) ? sanitize_key(wp_unslash($_POST['form_type'])) : 'contact';
    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $business = isset($_POST['business']) ? sanitize_text_field(wp_unslash($_POST['business'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

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

    $admin_email = get_option('admin_email');
    $subject = ($type === 'partner')
        ? 'New Renew Group partnership enquiry'
        : 'New Renew Group website enquiry';

    $body  = "Name: {$name}\n";
    $body .= "Phone: {$phone}\n";
    $body .= "Email: " . ($email ?: 'Not provided') . "\n";
    $body .= "Business: " . ($business ?: 'Not specified') . "\n";
    $body .= "Message: " . ($message ?: 'Not provided') . "\n";
    $body .= "\nSubmitted from: " . home_url('/') . "\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    if ($email) {
        $headers[] = 'Reply-To: ' . $email;
    }

    $sent = wp_mail($admin_email, $subject, $body, $headers);

    if (!$sent) {
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

/**
 * Add a useful fallback title if WordPress has no site tagline.
 */
function renew_document_title_parts($title) {
    if (is_front_page()) {
        $title['title'] = 'Renew Group of Companies';
    }
    return $title;
}
add_filter('document_title_parts', 'renew_document_title_parts');

function renew_favicon() {

    $favicon_id = get_theme_mod('renew_favicon');

    if (!$favicon_id) {
        return;
    }

    $favicon_url = wp_get_attachment_image_url(
        $favicon_id,
        'full'
    );

    if (!$favicon_url) {
        return;
    }

    echo '<link rel="icon" href="' .
        esc_url($favicon_url) .
        '" type="image/png">' . "\n";

    echo '<link rel="apple-touch-icon" href="' .
        esc_url($favicon_url) .
        '">' . "\n";
}

add_action('wp_head', 'renew_favicon', 1);

/**
 * Homepage content editor.
 * Edit content from WordPress Admin -> Appearance -> Customize -> Renew Homepage Content.
 */
function renew_mod($key, $default = '') {
    // get_theme_mod() only reads values saved to the database. The Customizer
    // setting defaults are not automatically returned by get_theme_mod() on
    // the normal frontend request, so use the same defaults here as a fallback.
    $value = get_theme_mod('renew_' . $key, null);
    if ($value !== null && $value !== '') {
        return $value;
    }

    $defaults = renew_homepage_defaults();
    return array_key_exists($key, $defaults) ? $defaults[$key] : $default;
}

/**
 * Get editable homepage URL.
 */
function renew_url($key, $default = '#') {
    $value = get_theme_mod('renew_' . $key, '');

    if ($value !== '') {
        return esc_url($value);
    }

    return esc_url($default);
}

function renew_homepage_defaults() {
    static $defaults = null;
    if ($defaults !== null) { return $defaults; }
    $defaults = array(
        'nav_home_url'       => home_url('/'),
        'nav_companies_url'  => '#businesses',
        'nav_about_url'      => '#about',
        'nav_values_url'     => '#values',
        'nav_team_url'       => '#team',
        'nav_partner_url'    => '#partner',
        'nav_faq_url'        => '#faq',
        'nav_contact_url'    => '#contact',
        'hero_primary_url'   => '#businesses',
        'hero_secondary_url' => '#contact',
        'biz1_url' => '#contact',
        'biz2_url' => '#contact',
        'biz3_url' => '#contact',
        'biz4_url' => '#contact',
        'about_button_url' => '#values',
        'partner1_url' => '#partnerEnquiryModal',
        'partner2_url' => '#partnerEnquiryModal',
        'partner3_url' => '#partnerEnquiryModal',
        'hero_eyebrow' => 'RENEW GROUP OF COMPANIES',
        'hero_title' => 'One parent company.|Four focused brands.|Built to grow.',
        'hero_copy' => 'Renew is the parent company behind Renew Plus Hair & Skin Care (clinical hair & skin care), The New Mars Properties (Builders & Land Promoters), Zelora Infotech (software & AI) and Rivan Institute of Aesthetic Science (beauty & cosmetology training) creating one shared platform for care, innovation and long-term growth.',
        'hero_primary' => 'Explore Our Businesses',
        'hero_secondary' => 'Talk to Us',
        'hero_note1' => 'One parent company, four business arms under one vision',
        'hero_note2' => 'Innovation, beauty education and clinical care — each led by domain experts',
        'hero_note3' => 'Serving clients, students and patients across South India and beyond',
        'hero_year' => '2000',
        'orbit_group_logo' => '',
        'orbit_renewplus_logo' => '',
        'orbit_zelora_logo' => '',
        'orbit_rivan_logo' => '',
        'orbit_mars_logo' => '',
        'stat1_value' => '4',
        'stat1_label' => 'Businesses in our group',
        'stat2_value' => '2000',
        'stat2_label' => 'Established in',
        'stat3_value' => '25',
        'stat3_suffix' => 'K',
        'stat3_label' => 'Customers reached',
        'stat4_value' => '13',
        'stat4_suffix' => '+',
        'stat4_label' => 'Presence across South India',
        'business_eyebrow' => 'OUR BUSINESSES',
        'business_title' => 'Four brands.|from One root.',
        'business_intro' => 'Each business runs with its own domain expertise, united by the Renew parent company standard of accountability, innovation and care.',
        'biz1_name' => 'Renew Plus Hair And Skin Care',
        'biz1_category' => 'HAIR TRANSPLANT · SKIN CARE',
        'biz1_description' => 'Natural-looking hair transplant, GFC and complete skin care treatments delivered with medical precision and patient care.',
        'biz1_chips' => 'Hair Transplant,PRP,GFC,Skin Care,Laser',
        'biz1_link' => 'View treatments',
        'biz2_name' => 'Zelora Infotech Private Limited',
        'biz2_category' => 'SOFTWARE · AI · AUTOMATION',
        'biz2_description' => 'ERP development, mobile apps, AI integration, business growth consulting, and practical software solutions for growing organizations.',
        'biz2_chips' => 'ERP,Mobile Apps,AI Integration,Cloud,Automation',
        'biz2_link' => 'See what Zelora builds',
        'biz3_name' => 'Rivan Institute of Aesthetic Science',
        'biz3_category' => 'BEAUTY · COSMETOLOGY · CAREERS',
        'biz3_description' => 'Professional beauty and cosmetology training — makeup, hairstyling, skin care and salon management — taught by industry practitioners.',
        'biz3_chips' => 'Aesthetic Science,Clinical Training,Certification,Mentorship,Career Support',
        'biz3_link' => 'Explore Rivan Institute',
        'biz4_name' => 'The New Mars Properties',
        'biz4_category' => 'BUILDERS · LAND PROMOTERS',
        'biz4_description' => 'Residential and commercial construction, plotted developments and land promotion shaped around reliable planning, quality execution and long-term value.',
        'biz4_chips' => 'Construction,Land Promotion,Residential,Commercial',
        'biz4_link' => 'Explore The New Mars Properties',
        'about_eyebrow' => 'ABOUT RENEW GROUP',
        'about_title' => 'Independent brands, shared standards.',
        'about_lead' => 'Renew is the parent company behind four focused business brands. Each has its own specialty, but every team works with the same focus on trust, accountability and meaningful outcomes.',
        'about_item1' => 'Four independent brands — Renew Plus Hair And Skin Care, The New Mars Properties, Zelora Infotech and Rivan Institute of Aesthetic Science.',
        'about_item2' => 'A shared culture of accountability — honest advice first, and long-term value over shortcuts.',
        'about_item3' => 'Decisions guided by long-term trust with clients, students and patients.',
        'about_item4' => 'One parent identity, four independently accountable teams.',
        'about_button' => 'What guides us',
        'values_eyebrow' => 'WHY CHOOSE US',
        'values_title' => 'What holds the group together',
        'value1_title' => 'Diversified Expertise',
        'value1_text' => 'Software, beauty training and clinical care under one group, each led by domain specialists.',
        'value2_title' => 'Family-Run Values',
        'value2_text' => 'Decisions made for long-term trust with clients, students and patients — not short-term numbers.',
        'value3_title' => 'Transparent Governance',
        'value3_text' => 'Every business is held to the same standard of honest advice and accountable delivery.',
        'value4_title' => 'Community-First Growth',
        'value4_text' => 'We grow by opening new centres and cities where they genuinely help people, not just market size.',
        'team_eyebrow' => 'LEADERSHIP',
        'team_title' => 'The people accountable for our direction.',
        'team_intro' => 'Meet the leaders shaping Renew Group across healthcare, technology and education.',
        'team1_image' => '',
        'team1_name' => 'Mr. Lokesh Balakrishnan',
        'team1_role' => 'Chief Executive Officer & Founder',
        'team1_bio' => 'Founded the group and sets its direction across healthcare, technology and education.',
        'team2_image' => '',
        'team2_name' => 'Ms. Divya Rajendran',
        'team2_role' => 'Chief Financial Officer & Co-Founder',
        'team2_bio' => 'Co-founded the group and leads finance, governance and the structure the four companies run on.',
        'team3_image' => '',
        'team3_name' => 'To be announced',
        'team3_role' => 'Chief Operating Officer',
        'team3_bio' => 'Will oversee day-to-day operations across Renew Plus, Zelora Infotech, Rivan Institute and The New Mars Properties, driving execution and operational excellence group-wide.',
        'team4_image' => '',
        'team4_name' => 'To be announced',
        'team4_role' => 'General Manager',
        'team4_bio' => 'Will manage daily operations, coordinate teams and ensure smooth delivery across the group\'s business verticals.',
        'team5_image' => '',
        'team5_name' => 'To be announced',
        'team5_role' => 'Chief Growth Officer',
        'team5_bio' => 'Will lead growth strategy, partnerships and market expansion across the group\'s healthcare, technology, education and real estate businesses.',
        'partner_eyebrow' => 'PARTNER WITH US',
        'partner_title' => 'Grow with Renew Group',
        'partner_intro' => 'Every business in the group welcomes partners who share our standard of care — pick the path that fits you.',
        'partner1_brand' => 'Renew Plus',
        'partner1_title' => 'Become a Franchise Partner',
        'partner1_text' => 'Partner with Renew Plus Hair And Skin Care with proven business models, training and ongoing support.',
        'partner1_tags' => 'GFC,PRP,Transplant,Skin,Laser',
        'partner1_button' => 'Start a Franchise Enquiry',
        'partner2_brand' => 'Zelora Infotech',
        'partner2_title' => 'Become a Technology Partner',
        'partner2_text' => 'Refer or resell Zelora\'s ERP, mobile app and AI integration work in your region as an associate partner.',
        'partner2_tags' => '',
        'partner2_button' => 'Discuss a Partnership',
        'partner3_brand' => 'Rivan Institute of Aesthetic Science',
        'partner3_title' => 'Become a Training Partner',
        'partner3_text' => 'License Rivan Institute of Aesthetic Science\'s beauty and cosmetology curriculum and certified trainers to run a training centre in your city.',
        'partner3_tags' => '',
        'partner3_button' => 'Explore Training Partnership',
        'faq_eyebrow' => 'FAQ',
        'faq_title' => 'Frequently asked questions',
        'faq1_question' => 'What businesses does Renew Group run?',
        'faq1_answer' => 'Renew Group brings together Renew Plus Hair And Skin Care, Zelora Infotech Private Limited and Rivan Institute of Aesthetic Science.',
        'faq2_question' => 'Does Zelora Infotech build custom ERP systems?',
        'faq2_answer' => 'Yes. Zelora Infotech focuses on practical business software including ERP, mobile applications, AI integrations and automation.',
        'faq3_question' => 'What courses does Rivan Institute of Aesthetic Science offer?',
        'faq3_answer' => 'Rivan Institute of Aesthetic Science provides professional beauty and cosmetology training covering areas such as makeup, hair styling, skin care and salon management.',
        'faq4_question' => 'How do I enrol in a course at Rivan Institute of Aesthetic Science?',
        'faq4_answer' => 'Use the contact form below and select Rivan Institute of Aesthetic Science. The team can guide you through available programmes, schedules and admissions.',
        'faq5_question' => 'What treatments are available at Renew Plus?',
        'faq5_answer' => 'Renew Plus provides hair and skin care services including hair transplant, PRP, GFC and other clinical skin-care treatments.',
        'faq6_question' => 'Can I partner or franchise with a Renew Group business?',
        'faq6_answer' => 'Partnership opportunities are available across the group’s business lines. Contact the team with your location and partnership interest to discuss the suitable model.',
        'contact_eyebrow' => 'GET IN TOUCH',
        'contact_title' => 'Talk to the right team.',
        'contact_intro' => 'Tell us which business you need — Renew Plus, The New Mars Properties, Zelora Infotech or Rivan Institute of Aesthetic Science — and the right team will reach out.',
        'contact_phone' => '9150668660',
        'contact_location' => 'Tamil Nadu, India',
        'contact_email1' => 'renewplus@example.com',
        'contact_email2' => 'info@zelorainfotech.com',
        'contact_email3' => 'admissions@rivaninstitute.com',
        'contact_email4' => 'info@marsbuilders.com',
    );
    return $defaults;
}

function renew_homepage_customizer($wp_customize) {
    $wp_customize->add_panel('renew_homepage', array(
        'title' => __('Renew Homepage Content', 'renew-group'),
        'description' => __('All homepage text can be edited here. Changes appear in the live preview.', 'renew-group'),
        'priority' => 20,
    ));

    $groups = array(
        'navigation' => 'Navigation',
        'hero' => 'Hero',
        'stats' => 'Statistics',
        'businesses' => 'Businesses',
        'about' => 'About',
        'values' => 'Why Us',
        'team' => 'Leadership',
        'partner' => 'Partners',
        'faq' => 'FAQ',
        'contact' => 'Contact',
    );

    foreach ($groups as $id => $title) {
        $wp_customize->add_section('renew_home_' . $id, array(
            'title' => __($title, 'renew-group'),
            'panel' => 'renew_homepage',
        ));
    }

    $fields = array(
        'navigation' => array(
            array('nav_home_url','Home URL',home_url('/'),'url'),
            array('nav_companies_url','Companies URL','#businesses','url'),
            array('nav_about_url','About URL','#about','url'),
            array('nav_values_url','Why Us URL','#values','url'),
            array('nav_team_url','Team URL','#team','url'),
            array('nav_partner_url','Partner With Us URL','#partner','url'),
            array('nav_faq_url','FAQ URL','#faq','url'),
            array('nav_contact_url','Contact Us URL','#contact','url'),
        ),
        'hero' => array(
            array('hero_eyebrow', 'Eyebrow', 'RENEW GROUP OF COMPANIES', 'text'),
            array('hero_title', 'Heading', 'One parent company.|Four focused brands.|Built to grow.', 'textarea'),
            array('hero_copy', 'Description', 'Renew is the parent company behind Renew Plus Hair & Skin Care (clinical hair & skin care), The New Mars Properties (Builders & Land Promoters), Zelora Infotech (software & AI) and Rivan Institute of Aesthetic Science (beauty & cosmetology training) creating one shared platform for care, innovation and long-term growth.', 'textarea'),
            array('hero_primary', 'Primary button', 'Explore Our Businesses', 'text'),
            array('hero_primary_url', 'Primary button URL', '#businesses', 'url'),

            array('hero_secondary', 'Secondary button', 'Talk to Us', 'text'),
            array('hero_secondary_url', 'Secondary button URL', '#contact', 'url'),
            array('hero_note1', 'Note 1', 'One parent company, four business arms under one vision', 'text'),
            array('hero_note2', 'Note 2', 'Innovation, beauty education and clinical care — each led by domain experts', 'text'),
            array('hero_note3', 'Note 3', 'Serving clients, students and patients across South India and beyond', 'text'),
            array('hero_year', 'Established year', '2000', 'text'),
            array('orbit_group_logo', 'Orbit center logo', '', 'image'),
            array('orbit_renewplus_logo', 'Renew Plus orbit logo', '', 'image'),
            array('orbit_zelora_logo', 'Zelora orbit logo', '', 'image'),
            array('orbit_rivan_logo', 'Rivan orbit logo', '', 'image'),
            array('orbit_mars_logo', 'Mars orbit logo', '', 'image'),
        ),
        'stats' => array(
            array('stat1_value', 'Businesses value', '4', 'text'),
            array('stat1_label', 'Businesses label', 'Businesses in our group', 'text'),
            array('stat2_value', 'Established value', '2000', 'text'),
            array('stat2_label', 'Established label', 'Established in', 'text'),
            array('stat3_value', 'Customers value', '25', 'text'),
            array('stat3_suffix', 'Customers suffix', 'K', 'text'),
            array('stat3_label', 'Customers label', 'Customers reached', 'text'),
            array('stat4_value', 'Presence value', '13', 'text'),
            array('stat4_suffix', 'Presence suffix', '+', 'text'),
            array('stat4_label', 'Presence label', 'Presence across South India', 'text'),
        ),
        'businesses' => array(
            array('business_eyebrow', 'Eyebrow', 'OUR BUSINESSES', 'text'),
            array('business_title', 'Heading', 'Four brands. from One root.', 'textarea'),
            array('business_intro', 'Description', 'Each business runs with its own domain expertise, united by the Renew parent company standard of accountability, innovation and care.', 'textarea'),
            array('biz1_name', 'Business 1 name', 'Renew Plus Hair And Skin Care', 'text'),
            array('biz1_category', 'Business 1 category', 'HAIR TRANSPLANT · SKIN CARE', 'text'),
            array('biz1_description', 'Business 1 description', 'Natural-looking hair transplant, GFC and complete skin care treatments delivered with medical precision and patient care.', 'textarea'),
            array('biz1_chips', 'Business 1 tags', 'Hair Transplant,PRP,GFC,Skin Care,Laser', 'text'),
            array('biz1_link','Business 1 button','View treatments','text'),
            array('biz1_url','Business 1 URL','#contact','url'),
            array('biz2_name', 'Business 2 name', 'Zelora Infotech Private Limited', 'text'),
            array('biz2_category', 'Business 2 category', 'SOFTWARE · AI · AUTOMATION', 'text'),
            array('biz2_description', 'Business 2 description', 'ERP development, mobile apps, AI integration, business growth consulting, and practical software solutions for growing organizations.', 'textarea'),
            array('biz2_chips', 'Business 2 tags', 'ERP,Mobile Apps,AI Integration,Cloud,Automation', 'text'),
            array('biz2_link', 'Business 2 button', 'See what Zelora builds', 'text'),
            array('biz2_url','Business 2 URL','#contact','url'),
            array('biz3_name', 'Business 3 name', 'Rivan Institute of Aesthetic Science', 'text'),
            array('biz3_category', 'Business 3 category', 'BEAUTY · COSMETOLOGY · CAREERS', 'text'),
            array('biz3_description', 'Business 3 description', 'Professional beauty and cosmetology training — makeup, hairstyling, skin care and salon management — taught by industry practitioners.', 'textarea'),
            array('biz3_chips', 'Business 3 tags', 'Aesthetic Science,Clinical Training,Certification,Mentorship,Career Support', 'text'),
            array('biz3_link', 'Business 3 button', 'Explore Rivan Institute', 'text'),
            array('biz3_url','Business 3 URL','#contact','url'),
            array('biz4_name', 'Business 4 name', 'The New Mars Properties', 'text'),
            array('biz4_category', 'Business 4 category', 'BUILDERS · LAND PROMOTERS', 'text'),
            array('biz4_description', 'Business 4 description', 'Residential and commercial construction, plotted developments and land promotion shaped around reliable planning, quality execution and long-term value.', 'textarea'),
            array('biz4_chips', 'Business 4 tags', 'Construction,Land Promotion,Residential,Commercial', 'text'),
            array('biz4_link', 'Business 4 button', 'Explore The New Mars Properties', 'text'),
            array('biz4_url','Business 4 URL','#contact','url'),
        ),
        'about' => array(
            array('about_eyebrow','Eyebrow','ABOUT RENEW GROUP','text'), array('about_title','Heading','Independent brands, shared standards.','textarea'),
            array('about_lead','Introduction','Renew is the parent company behind four focused business brands. Each has its own specialty, but every team works with the same focus on trust, accountability and meaningful outcomes.','textarea'),
            array('about_item1','Point 1','Four independent brands — Renew Plus Hair And Skin Care, The New Mars Properties, Zelora Infotech and Rivan Institute of Aesthetic Science.','textarea'),
            array('about_item2','Point 2','A shared culture of accountability — honest advice first, and long-term value over shortcuts.','textarea'),
            array('about_item3','Point 3','Decisions guided by long-term trust with clients, students and patients.','textarea'),
            array('about_item4','Point 4','One parent identity, four independently accountable teams.','textarea'),
            array('about_button','Button','What guides us','text'),
            array('about_button_url','Button URL','#values','url'),
        ),
        'values' => array(
            array('values_eyebrow', 'Eyebrow', 'WHY CHOOSE US', 'text'),
            array('values_title', 'Heading', 'What holds the group together', 'text'),
            array('value1_title', 'Value 1 title', 'Diversified Expertise', 'text'),
            array('value1_text', 'Value 1 description', 'Software, beauty training and clinical care under one group, each led by domain specialists.', 'textarea'),
            array('value2_title', 'Value 2 title', 'Family-Run Values', 'text'),
            array('value2_text', 'Value 2 description', 'Decisions made for long-term trust with clients, students and patients — not short-term numbers.', 'textarea'),
            array('value3_title', 'Value 3 title', 'Transparent Governance', 'text'),
            array('value3_text', 'Value 3 description', 'Every business is held to the same standard of honest advice and accountable delivery.', 'textarea'),
            array('value4_title', 'Value 4 title', 'Community-First Growth', 'text'),
            array('value4_text', 'Value 4 description', 'We grow by opening new centres and cities where they genuinely help people, not just market size.', 'textarea'),
        ),
        'team' => array(
            array('team_eyebrow', 'Eyebrow', 'LEADERSHIP', 'text'),
            array('team_title', 'Heading', 'The people accountable for our direction.', 'textarea'),
            array('team_intro', 'Description', 'Meet the leaders shaping Renew Group across healthcare, technology and education.', 'textarea'),
            array('team1_image', 'Leader 1 photo', '', 'image'),
            array('team1_name', 'Leader 1 name', 'Mr. Lokesh Balakrishnan', 'text'),
            array('team1_role', 'Leader 1 role', 'Chief Executive Officer & Founder', 'text'),
            array('team1_bio', 'Leader 1 bio', 'Founded the group and sets its direction across healthcare, technology and education.', 'textarea'),
            array('team2_image', 'Leader 2 photo', '', 'image'),
            array('team2_name', 'Leader 2 name', 'Ms. Divya Rajendran', 'text'),
            array('team2_role', 'Leader 2 role', 'Chief Financial Officer & Co-Founder', 'text'),
            array('team2_bio', 'Leader 2 bio', 'Co-founded the group and leads finance, governance and the structure the four companies run on.', 'textarea'),
            array('team3_image', 'Leader 3 photo', '', 'image'),
            array('team3_name', 'Leader 3 name', 'To be announced', 'text'),
            array('team3_role', 'Leader 3 role', 'Chief Operating Officer', 'text'),
            array('team3_bio', 'Leader 3 bio', "Will oversee day-to-day operations across Renew Plus, Zelora Infotech, Rivan Institute and The New Mars Properties, driving execution and operational excellence group-wide.", 'textarea'),
            array('team4_image', 'Leader 4 photo', '', 'image'),
            array('team4_name', 'Leader 4 name', 'To be announced', 'text'),
            array('team4_role', 'Leader 4 role', 'General Manager', 'text'),
            array('team4_bio', 'Leader 4 bio', "Will manage daily operations, coordinate teams and ensure smooth delivery across the group's business verticals.", 'textarea'),
            array('team5_image', 'Leader 5 photo', '', 'image'),
            array('team5_name', 'Leader 5 name', 'To be announced', 'text'),
            array('team5_role', 'Leader 5 role', 'Chief Growth Officer', 'text'),
            array('team5_bio', 'Leader 5 bio', "Will lead growth strategy, partnerships and market expansion across the group's healthcare, technology, education and real estate businesses.", 'textarea'),
        ),
        'partner' => array(
            array('partner_eyebrow', 'Eyebrow', 'PARTNER WITH US', 'text'),
            array('partner_title', 'Heading', 'Grow with Renew Group', 'text'),
            array('partner_intro', 'Description', 'Every business in the group welcomes partners who share our standard of care — pick the path that fits you.', 'textarea'),
            array('partner1_brand', 'Partner 1 brand', 'Renew Plus', 'text'),
            array('partner1_title', 'Partner 1 title', 'Become a Franchise Partner', 'text'),
            array('partner1_text', 'Partner 1 description', 'Partner with Renew Plus Hair And Skin Care with proven business models, training and ongoing support.', 'textarea'),
            array('partner1_tags', 'Partner 1 tags', 'GFC,PRP,Transplant,Skin,Laser', 'text'),
            array('partner1_button', 'Partner 1 button', 'Start a Franchise Enquiry', 'text'),
            array(
                'partner1_url',
                'Partner 1 URL',
                '#partnerEnquiryModal',
                'url'
            ),
            array('partner2_brand', 'Partner 2 brand', 'Zelora Infotech', 'text'),
            array('partner2_title', 'Partner 2 title', 'Become a Technology Partner', 'text'),
            array('partner2_text', 'Partner 2 description', "Refer or resell Zelora's ERP, mobile app and AI integration work in your region as an associate partner.", 'textarea'),
            array('partner2_tags', 'Partner 2 tags', '', 'text'),
            array('partner2_button', 'Partner 2 button', 'Discuss a Partnership', 'text'),
            array(
                'partner2_url',
                'Partner 2 URL',
                '#partnerEnquiryModal',
                'url'
            ),
            array('partner3_brand', 'Partner 3 brand', 'Rivan Institute of Aesthetic Science', 'text'),
            array('partner3_title', 'Partner 3 title', 'Become a Training Partner', 'text'),
            array('partner3_text', 'Partner 3 description', "License Rivan Institute of Aesthetic Science's beauty and cosmetology curriculum and certified trainers to run a training centre in your city.", 'textarea'),
            array('partner3_tags', 'Partner 3 tags', '', 'text'),
            array('partner3_button', 'Partner 3 button', 'Explore Training Partnership', 'text'),
            array(
                'partner3_url',
                'Partner 3 URL',
                '#partnerEnquiryModal',
                'url'
            ),
        ),
        'faq' => array(
            array('faq_eyebrow', 'Eyebrow', 'FAQ', 'text'),
            array('faq_title', 'Heading', 'Frequently asked questions', 'text'),
            array('faq1_question', 'Question 1', 'What businesses does Renew Group run?', 'text'),
            array('faq1_answer', 'Answer 1', 'Renew Group brings together Renew Plus Hair And Skin Care, Zelora Infotech Private Limited and Rivan Institute of Aesthetic Science.', 'textarea'),
            array('faq2_question', 'Question 2', 'Does Zelora Infotech build custom ERP systems?', 'text'),
            array('faq2_answer', 'Answer 2', 'Yes. Zelora Infotech focuses on practical business software including ERP, mobile applications, AI integrations and automation.', 'textarea'),
            array('faq3_question', 'Question 3', 'What courses does Rivan Institute of Aesthetic Science offer?', 'text'),
            array('faq3_answer', 'Answer 3', 'Rivan Institute of Aesthetic Science provides professional beauty and cosmetology training covering areas such as makeup, hair styling, skin care and salon management.', 'textarea'),
            array('faq4_question', 'Question 4', 'How do I enrol in a course at Rivan Institute of Aesthetic Science?', 'text'),
            array('faq4_answer', 'Answer 4', 'Use the contact form below and select Rivan Institute of Aesthetic Science. The team can guide you through available programmes, schedules and admissions.', 'textarea'),
            array('faq5_question', 'Question 5', 'What treatments are available at Renew Plus?', 'text'),
            array('faq5_answer', 'Answer 5', 'Renew Plus provides hair and skin care services including hair transplant, PRP, GFC and other clinical skin-care treatments.', 'textarea'),
            array('faq6_question', 'Question 6', 'Can I partner or franchise with a Renew Group business?', 'text'),
            array('faq6_answer', 'Answer 6', 'Partnership opportunities are available across the group’s business lines. Contact the team with your location and partnership interest to discuss the suitable model.', 'textarea'),
        ),
        'contact' => array(
            array('contact_eyebrow', 'Eyebrow', 'GET IN TOUCH', 'text'),
            array('contact_title', 'Heading', 'Talk to the right team.', 'text'),
            array('contact_intro', 'Description', 'Tell us which business you need — Renew Plus, The New Mars Properties, Zelora Infotech or Rivan Institute of Aesthetic Science — and the right team will reach out.', 'textarea'),
            array('contact_phone', 'Phone', '9150668660', 'text'),
            array('contact_location', 'Location', 'Tamil Nadu, India', 'text'),
            array('contact_email1', 'Renew Plus email', 'renewplus@example.com', 'text'),
            array('contact_email2', 'Zelora email', 'info@zelorainfotech.com', 'text'),
            array('contact_email3', 'Rivan email', 'admissions@rivaninstitute.com', 'text'),
            array('contact_email4', 'Mars email', 'info@marsbuilders.com', 'text'),
        ),
    );

    foreach ($fields as $section => $controls) {
        foreach ($controls as $field) {
            $key=$field[0]; $label=$field[1]; $default=$field[2]; $type=$field[3];
            // $sanitize = ($type === 'textarea') ? 'sanitize_textarea_field' : (($type === 'image') ? 'absint' : 'sanitize_text_field');
            $sanitize = ($type === 'textarea')
                ? 'sanitize_textarea_field'
                : (($type === 'image')
                    ? 'absint'
                    : (($type === 'url')
                        ? 'esc_url_raw'
                        : 'sanitize_text_field'));
            $wp_customize->add_setting('renew_'.$key, array(
                'default'=>$default,
                'sanitize_callback'=>$sanitize,
                'transport'=>'refresh',
            ));
            if ($type === 'image') {
                $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'renew_'.$key, array(
                    'label'=>__($label,'renew-group'),
                    'section'=>'renew_home_'.$section,
                    'mime_type'=>'image',
                )));
            } else {
                $wp_customize->add_control('renew_'.$key, array(
                    'label'=>__($label,'renew-group'),
                    'section'=>'renew_home_'.$section,
                    'type'=>$type,
                ));
            }
        }
    }
}
add_action('customize_register', 'renew_homepage_customizer');
/**
 * Renew Group Branding
 *
 * Manage website logo and favicon from:
 * Appearance -> Customize -> Logo & Favicon
 */
function renew_branding_customizer($wp_customize) {

    /*
     * Logo & Favicon section
     */
    $wp_customize->add_section('renew_branding', array(
        'title'       => __('Logo & Favicon', 'renew-group'),
        'description' => __('Manage your Renew Group website logo and favicon.', 'renew-group'),
        'priority'    => 5,
    ));


    /*
     * Website Logo
     */
    $wp_customize->add_setting('renew_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'renew_logo',
            array(
                'label'       => __('Website Logo', 'renew-group'),
                'description' => __('Upload the main Renew Group logo.', 'renew-group'),
                'section'     => 'renew_branding',
                'mime_type'   => 'image',
            )
        )
    );


    /*
     * Footer Logo
     */
    $wp_customize->add_setting('renew_footer_logo', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'renew_footer_logo',
            array(
                'label'       => __('Footer Logo', 'renew-group'),
                'description' => __('Upload the logo shown in the footer. Falls back to the Website Logo if empty.', 'renew-group'),
                'section'     => 'renew_branding',
                'mime_type'   => 'image',
            )
        )
    );


    /*
     * Favicon
     */
    $wp_customize->add_setting('renew_favicon', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'renew_favicon',
            array(
                'label'       => __('Favicon', 'renew-group'),
                'description' => __('Upload your website favicon. A square PNG is recommended.', 'renew-group'),
                'section'     => 'renew_branding',
                'mime_type'   => 'image',
            )
        )
    );
}

add_action('customize_register', 'renew_branding_customizer');