<?php
/**
 * Enquiry notification email (HTML).
 *
 * Variables available (all raw, escape on output):
 *   $d    array  form_type, name, email, phone, business, partner_brand, message, created_at
 *   $site string site name
 *   $logo string logo URL
 *
 * Colours mirror the theme tokens in assets/css/style.css.
 */
if (!defined('ABSPATH')) {
    exit;
}

$title = ($d['form_type'] === 'partner') ? 'New Partnership Enquiry' : 'New Website Enquiry';

$rows = array(
    'Name'    => $d['name'],
    'Phone'   => $d['phone'],
    'Email'   => $d['email'] !== '' ? $d['email'] : 'Not provided',
    'Enquiry' => $d['business'] !== '' ? $d['business'] : 'Not specified',
);
if ($d['partner_brand'] !== '') {
    $rows['Partner brand'] = $d['partner_brand'];
}
$rows['Received'] = $d['created_at'];

$navy   = '#1c1533';
$purple = '#9400D3';
$deep   = '#6d00a8';
$lav    = '#F3E8FF';
$line   = '#e9d8f8';
$ink    = '#2a2140';
$muted  = '#5d5970';
$sans   = "'DM Sans',Arial,Helvetica,sans-serif";
$serif  = "'Playfair Display',Georgia,serif";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo esc_html($title); ?></title>
</head>
<body style="margin:0;padding:0;background:<?php echo $lav; ?>;font-family:<?php echo $sans; ?>;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:<?php echo $lav; ?>;padding:28px 12px;">
  <tr><td align="center">
    <table role="presentation" width="620" cellpadding="0" cellspacing="0" style="max-width:620px;width:100%;background:#ffffff;border:1px solid <?php echo $line; ?>;border-radius:14px;overflow:hidden;">

      <tr>
        <td style="background:<?php echo $navy; ?>;padding:24px 32px;border-bottom:4px solid <?php echo $purple; ?>;">
          <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($site); ?>" height="40" style="display:block;border:0;height:40px;width:auto;">
        </td>
      </tr>

      <tr>
        <td style="padding:32px 32px 8px;">
          <div style="font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:<?php echo $purple; ?>;">
            <?php echo $d['form_type'] === 'partner' ? 'Partner Enquiry' : 'Website Enquiry'; ?>
          </div>
          <h1 style="margin:8px 0 0;font-family:<?php echo $serif; ?>;font-size:26px;line-height:1.25;color:<?php echo $navy; ?>;font-weight:700;">
            <?php echo esc_html($title); ?>
          </h1>
          <p style="margin:10px 0 0;font-size:14px;line-height:1.6;color:<?php echo $muted; ?>;">
            Someone just submitted the form on your website. Details are below.
          </p>
        </td>
      </tr>

      <tr>
        <td style="padding:16px 32px 8px;">
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
            <?php foreach ($rows as $label => $value): ?>
              <tr>
                <td style="padding:11px 0;border-bottom:1px solid <?php echo $line; ?>;width:130px;font-size:12px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:<?php echo $muted; ?>;vertical-align:top;"><?php echo esc_html($label); ?></td>
                <td style="padding:11px 0;border-bottom:1px solid <?php echo $line; ?>;font-size:14px;font-weight:600;color:<?php echo $ink; ?>;"><?php echo esc_html($value); ?></td>
              </tr>
            <?php endforeach; ?>
          </table>
        </td>
      </tr>

      <tr>
        <td style="padding:16px 32px 8px;">
          <div style="font-size:12px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:<?php echo $muted; ?>;margin-bottom:8px;">Message</div>
          <div style="background:<?php echo $lav; ?>;border-left:4px solid <?php echo $purple; ?>;border-radius:8px;padding:16px 18px;font-size:14px;line-height:1.7;color:<?php echo $ink; ?>;">
            <?php echo $d['message'] !== '' ? nl2br(esc_html($d['message'])) : '<em style="color:' . $muted . ';">Not provided</em>'; ?>
          </div>
        </td>
      </tr>

      <?php if ($d['phone'] !== ''): ?>
      <tr>
        <td style="padding:20px 32px 32px;">
          <a href="tel:<?php echo esc_attr(preg_replace('/[^\d+]/', '', $d['phone'])); ?>" style="display:inline-block;background:<?php echo $purple; ?>;color:#ffffff;text-decoration:none;font-size:14px;font-weight:700;padding:13px 26px;border-radius:999px;">Call <?php echo esc_html($d['name']); ?></a>
          <?php if ($d['email'] !== ''): ?>
            <a href="mailto:<?php echo esc_attr($d['email']); ?>" style="display:inline-block;margin-left:8px;color:<?php echo $deep; ?>;text-decoration:none;font-size:14px;font-weight:700;padding:12px 24px;border:1px solid <?php echo $purple; ?>;border-radius:999px;">Reply by email</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endif; ?>

      <tr>
        <td style="background:<?php echo $navy; ?>;padding:18px 32px;text-align:center;font-size:12px;line-height:1.6;color:#cdbfe6;">
          Sent from <?php echo esc_html($site); ?> &middot; <a href="<?php echo esc_url(home_url('/')); ?>" style="color:#ED80E9;text-decoration:none;"><?php echo esc_html(home_url('/')); ?></a>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
