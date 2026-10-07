<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo esc_attr(get_bloginfo('description') ?: 'Renew Group of Companies — technology, beauty education, construction, and hair & skin care businesses.'); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if (renew_mod('loader_show', '1') === '1'):
  $renew_loader_id = get_theme_mod('renew_loader_logo') ?: get_theme_mod('renew_logo');
  $renew_loader_logo = $renew_loader_id ? wp_get_attachment_image_url($renew_loader_id, 'full') : renew_asset('images/renew-group-logo.png');
  $renew_loader_bg = sanitize_hex_color(renew_mod('loader_bg', '#021412')) ?: '#021412';
  $renew_loader_ac = sanitize_hex_color(renew_mod('loader_accent', '#dbb678')) ?: '#dbb678';
  $renew_loader_ms = max(1, min(30, (int) renew_mod('loader_timeout', '8'))) * 1000; ?>
<div id="pageLoader" class="page-loader" role="status" aria-label="Loading" style="--pl-bg: <?php echo esc_attr($renew_loader_bg); ?>; --pl-accent: <?php echo esc_attr($renew_loader_ac); ?>">
  <div class="pl-box">
    <span class="pl-ring"></span><span class="pl-ring pl-ring-2"></span>
    <img src="<?php echo esc_url($renew_loader_logo); ?>" alt="">
  </div>
  <?php if (get_theme_mod('renew_loader_text', 'Loading') !== ''): ?><p class="pl-text"><?php echo esc_html(get_theme_mod('renew_loader_text', 'Loading')); ?></p><?php endif; ?>
</div>
<script>setTimeout(function(){var l=document.getElementById("pageLoader");if(l)l.classList.add("is-done");},<?php echo (int) $renew_loader_ms; ?>);</script>
<?php endif; ?>

<!-- TOPBAR -->
<?php if (renew_mod('topbar_show', '1') === '1'):
  $tb_location = renew_mod('topbar_location') ?: renew_mod('footer_location');
  $tb_email    = renew_mod('topbar_email') ?: renew_mod('footer_email');
  $tb_phone    = renew_mod('topbar_phone') ?: renew_mod('footer_phone'); ?>
  <div class="renew-topbar">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div class="topbar-info d-flex flex-wrap gap-3">
        <?php if ($tb_location): ?>
        <a class="topbar-item" href="#contact"><i class="bi bi-geo-alt"></i> <span><?php echo esc_html($tb_location); ?></span></a>
        <?php endif; ?>
        <?php if ($tb_email): ?>
        <a class="topbar-item" href="mailto:<?php echo esc_attr($tb_email); ?>"><i class="bi bi-envelope"></i> <span><?php echo esc_html($tb_email); ?></span></a>
        <?php endif; ?>
        <?php if ($tb_phone): ?>
        <a class="topbar-item" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $tb_phone)); ?>"><i class="bi bi-telephone"></i> <span><?php echo esc_html($tb_phone); ?></span></a>
        <?php endif; ?>
      </div>
      <?php if (renew_mod('topbar_social', '1') === '1'): ?>
      <div class="topbar-social d-flex gap-2">
        <?php renew_render_social_icons(); ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
<!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg fixed-top renew-nav">
    <div class="container">
      <?php
        $renew_logo_id = get_theme_mod('renew_logo');

        if ($renew_logo_id) {
            $renew_logo_url = wp_get_attachment_image_url(
                $renew_logo_id,
                'full'
            );
        } else {
            $renew_logo_url = renew_asset('images/renew-group-logo.png');
        }
        ?>
      <a class="navbar-brand" href="<?php echo esc_url(renew_url('nav_home_url', home_url('/'))); ?>">
        <img class="navbar-logo" src="<?php echo esc_url($renew_logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
        data-bs-target="#mainNav">
        <i class="bi bi-list fs-2"></i>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
          <li class="nav-item"><a class="nav-link active" href="<?php echo esc_url(renew_url('nav_home_url', home_url('/'))); ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(renew_url('nav_companies_url', '#businesses')); ?>">Companies</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(renew_url('nav_about_url', '#about')); ?>">About</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(renew_url('nav_values_url', '#values')); ?>">Why Us</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(renew_url('nav_team_url', '#team')); ?>">Team</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(renew_url('nav_partner_url', '#partner')); ?>">Partner With Us</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo esc_url(renew_url('nav_faq_url', '#faq')); ?>">FAQ</a></li>
          <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
            <a class="btn btn-brand btn-sm px-4" href="<?php echo esc_url(renew_url('nav_contact_url', '#contact')); ?>">Get in Touch <i class="bi bi-arrow-right ms-1"></i></a>
          </li>
          <li class="nav-item ms-lg-2 mt-2 mt-lg-0" hidden style="display: none;">
            <button class="theme-toggle is-orange" id="themeToggle" type="button" aria-pressed="true"
              aria-label="Switch to purple theme">
              <i class="bi bi-palette2" aria-hidden="true"></i><span>Purple</span>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  
