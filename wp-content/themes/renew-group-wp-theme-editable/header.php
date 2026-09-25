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
            <a class="btn btn-brand btn-sm px-4" href="<?php echo esc_url(renew_url('nav_contact_url', '#contact')); ?>">Contact Us <i
                class="bi bi-arrow-up-right ms-1"></i></a>
          </li>
          <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
            <button class="theme-toggle" id="themeToggle" type="button" aria-pressed="false"
              aria-label="Switch to orange theme">
              <i class="bi bi-palette2" aria-hidden="true"></i><span>Orange</span>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  
