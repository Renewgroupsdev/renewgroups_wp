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
          <p class="footer-copy mt-3">A group of four independent businesses — clinic care, software, construction and beauty training — built to serve standards of trust and follow-through.</p>
          <div class="footer-social">
            <a href="https://facebook.com/" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://instagram.com/" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="https://linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="col-6 col-lg-2">
          <h6>Quick Links</h6><a href="#about">About Us</a><a href="#businesses">Our Businesses</a><a
            href="#partner">Partner With Us</a><a href="#faq">FAQ</a><a href="#contact">Contact</a>
        </div>
        <div class="col-6 col-lg-2">
          <h6>Our Businesses</h6>
          <a href="#businesses">Renew Plus</a>
          <a href="#businesses">Zelora Infotech</a>
          <a href="#businesses">Rivan Institute of Aesthetic Science</a>
          <a href="#businesses">The New Mars Properties</a>
        </div>
        <div class="col-lg-3">
          <h6>Contact</h6><a href="tel:9150668660"><i class="bi bi-telephone me-2"></i>9150668660</a><a
            href="mailto:renewgroup@example.com"><i class="bi bi-envelope me-2"></i>renewgroup@example.com</a><a
            href="#contact"><i class="bi bi-geo-alt me-2"></i>Tamil Nadu, India</a>
        </div>
      </div>
      <div class="footer-bottom"><span>© 2026 Renew Group of Companies. All rights reserved.</span><span>One family.
          Four missions.</span></div>
    </div>
  </footer>

  <button class="back-top" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

  <div class="modal fade" id="partnerEnquiryModal" tabindex="-1" aria-labelledby="partnerEnquiryTitle"
    aria-hidden="true">
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
                    placeholder="10-digit mobile number" pattern="(?:\+91[\s-]?)?[6-9][0-9]{9}" minlength="10" maxlength="14"
                  autocomplete="tel" required></div>
              <div class="col-12"><label>Email <small>(optional)</small></label><input type="email"
                  class="form-control" name="email" placeholder="you@example.com" maxlength="120" autocomplete="email"></div>
              <div class="col-12"><label>Message <small>(optional)</small></label><textarea class="form-control"
                  name="message" rows="4" maxlength="1000" placeholder="Tell us about your location or partnership plans"></textarea></div>
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
