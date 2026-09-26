<!-- FOOTER -->
<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-5">
        <?php
        $renew_footer_logo_id = get_theme_mod('renew_footer_logo');

        if (!$renew_footer_logo_id) {
          $renew_footer_logo_id = get_theme_mod('renew_logo');
        }

        if ($renew_footer_logo_id) {
          $renew_logo_url = wp_get_attachment_image_url(
            $renew_footer_logo_id,
            'full'
          );
        } else {
          $renew_logo_url = renew_asset('images/renew-group-logo.png');
        }
        ?>
        <a class="navbar-brand footer-brand" href="#home">
          <img class="footer-group-logo" src="<?php echo esc_url($renew_logo_url); ?>" alt="Renew Group logo">
        </a>
        <p class="footer-copy mt-3"><?php echo esc_html(renew_mod('footer_copy')); ?></p>
        <div class="footer-social">
          <?php
            $renew_social_links = array(
                'facebook'  => array('bi-facebook', 'Facebook'),
                'instagram' => array('bi-instagram', 'Instagram'),
                'linkedin'  => array('bi-linkedin', 'LinkedIn'),
                'twitter'   => array('bi-twitter-x', 'Twitter / X'),
                'youtube'   => array('bi-youtube', 'YouTube'),
                'whatsapp'  => array('bi-whatsapp', 'WhatsApp'),
            );
            foreach ($renew_social_links as $renew_social_key => $renew_social_meta) {
                $renew_social_url = renew_mod('social_' . $renew_social_key);
                if ($renew_social_url === '') {
                    continue;
                }
                list($renew_social_icon, $renew_social_label) = $renew_social_meta;
                ?>
                <a href="<?php echo esc_url($renew_social_url); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($renew_social_label); ?>"><i class="bi <?php echo esc_attr($renew_social_icon); ?>"></i></a>
                <?php
            }
          ?>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <h6><?php echo esc_html(renew_mod('footer_col2_title')); ?></h6>
        <?php
          $renew_footer_col2_menu = (int) get_theme_mod('renew_footer_col2_menu', 0);
          if ($renew_footer_col2_menu && wp_get_nav_menu_object($renew_footer_col2_menu)) {
              wp_nav_menu(array(
                  'menu'        => $renew_footer_col2_menu,
                  'container'   => false,
                  'items_wrap'  => '%3$s',
                  'depth'       => 1,
                  'fallback_cb' => false,
                  'walker'      => new Renew_Footer_Nav_Walker(),
              ));
          } else {
              ?>
              <a href="#about">About Us</a><a href="#businesses">Our Businesses</a><a
                href="#partner">Partner With Us</a><a href="#faq">FAQ</a><a href="#contact">Contact</a>
              <?php
          }
        ?>
      </div>
      <div class="col-6 col-lg-2">
        <h6><?php echo esc_html(renew_mod('footer_col3_title')); ?></h6>
        <?php
          $renew_footer_col3_menu = (int) get_theme_mod('renew_footer_col3_menu', 0);
          if ($renew_footer_col3_menu && wp_get_nav_menu_object($renew_footer_col3_menu)) {
              wp_nav_menu(array(
                  'menu'        => $renew_footer_col3_menu,
                  'container'   => false,
                  'items_wrap'  => '%3$s',
                  'depth'       => 1,
                  'fallback_cb' => false,
                  'walker'      => new Renew_Footer_Nav_Walker(),
              ));
          } else {
              ?>
              <a href="#businesses">Renew Plus</a>
              <a href="#businesses">Zelora Infotech</a>
              <a href="#businesses">Rivan Institute of Aesthetic Science</a>
              <a href="#businesses">The New Mars Properties</a>
              <?php
          }
        ?>
      </div>
      <div class="col-lg-3">
        <h6><?php echo esc_html(renew_mod('footer_col4_title')); ?></h6><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', renew_mod('footer_phone'))); ?>"><i class="bi bi-telephone me-2"></i><?php echo esc_html(renew_mod('footer_phone')); ?></a><a
          href="mailto:<?php echo esc_attr(renew_mod('footer_email')); ?>"><i class="bi bi-envelope me-2"></i><?php echo esc_html(renew_mod('footer_email')); ?></a><a
          href="#contact"><i class="bi bi-geo-alt me-2"></i><?php echo esc_html(renew_mod('footer_location')); ?></a>
      </div>
    </div>
    <div class="footer-bottom"><span><?php echo esc_html(renew_mod('footer_copyright')); ?></span><span><?php echo esc_html(renew_mod('footer_tagline')); ?></span></div>
  </div>
</footer>

<button class="back-top" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

<div class="modal fade" id="partnerEnquiryModal" tabindex="-1" aria-labelledby="partnerEnquiryTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content partner-enquiry-modal">
      <div class="modal-header">
        <div>
          <div class="eyebrow mb-2"><span></span> PARTNER ENQUIRY</div>
          <h2 class="modal-title" id="partnerEnquiryTitle">Start a conversation</h2>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="partnerEnquiryForm" class="partner-enquiry-form">
        <div class="modal-body">
          <p class="partner-enquiry-intro">Tell us a little about your partnership interest.</p>
          <input type="hidden" name="business">
          <div class="row g-3">
            <div class="col-md-6"><label>Full Name</label><input type="text" class="form-control" name="name"
                placeholder="Your name" minlength="2" maxlength="80" autocomplete="name" required></div>
            <div class="col-md-6"><label>Phone Number</label><input type="tel" class="form-control" name="phone"
                placeholder="10-digit mobile number" pattern="(?:\+91[\s-]?)?[6-9][0-9]{9}" minlength="10"
                maxlength="14" autocomplete="tel" required></div>
            <div class="col-12"><label>Email <small>(optional)</small></label><input type="email" class="form-control"
                name="email" placeholder="you@example.com" maxlength="120" autocomplete="email"></div>
            <div class="col-12"><label>Message <small>(optional)</small></label><textarea class="form-control"
                name="message" rows="4" maxlength="1000"
                placeholder="Tell us about your location or partnership plans"></textarea></div>
          </div>
          <div id="partnerFormMessage" class="form-message"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-brand" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-brand" type="submit">Send Enquiry <i class="bi bi-send ms-2"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>



<?php wp_footer(); ?>
</body>

</html>