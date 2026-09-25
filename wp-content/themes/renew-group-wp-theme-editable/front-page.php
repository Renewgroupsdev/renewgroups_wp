<?php
/**
 * Renew Group — editable homepage.
 * Content: Appearance > Customize > Renew Homepage Content
 */
get_header();
$hero_title = explode('|', renew_mod('hero_title', 'One parent company.|Four focused brands.|Built to grow.'));
$business_title = explode('|', renew_mod('business_title', 'Four brands.|from One root.'));
$about_title = explode('|', renew_mod('about_title', 'Independent brands,|shared standards.'));
$values_title = renew_mod('values_title', 'What holds the group together');
$team_title = renew_mod('team_title', 'The people accountable for our direction.');
$partner_title = renew_mod('partner_title', 'Grow with Renew Group');
$faq_title = renew_mod('faq_title', 'Frequently asked questions');
?>
<main id="primary" class="site-main">

  <header id="home" class="hero-section parallax-section">
    <div class="hero-grid"></div>
    <div class="orb orb-one"></div>
    <div class="orb orb-two"></div>
    <div class="container position-relative">
      <div class="row align-items-center hero-row py-5">
        <div class="col-lg-6 pt-5" data-aos="fade-right" data-aos-duration="900">
          <div class="eyebrow"><span></span>
            <?php echo esc_html(renew_mod('hero_eyebrow', 'RENEW GROUP OF COMPANIES')); ?></div>
          <h1>
            <?php echo esc_html($hero_title[0] ?? ''); ?><br><em><?php echo esc_html($hero_title[1] ?? ''); ?></em><br><?php echo esc_html($hero_title[2] ?? ''); ?>
          </h1>
          <p class="hero-copy"><?php echo esc_html(renew_mod('hero_copy')); ?></p>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="<?php echo esc_url(renew_url('hero_primary_url', '#businesses')); ?>"
              class="btn btn-brand btn-lg"><?php echo esc_html(renew_mod('hero_primary', 'Explore Our Businesses')); ?>
              <i class="bi bi-arrow-down-right ms-2"></i></a>
            <a href="<?php echo esc_url(renew_url('hero_secondary_url', '#contact')); ?>"
              class="btn btn-outline-brand btn-lg"><?php echo esc_html(renew_mod('hero_secondary', 'Talk to Us')); ?></a>
          </div>
          <div class="hero-notes mt-4">
            <div><i class="bi bi-check2-circle"></i> <?php echo esc_html(renew_mod('hero_note1')); ?></div>
            <div><i class="bi bi-stars"></i> <?php echo esc_html(renew_mod('hero_note2')); ?></div>
            <div><i class="bi bi-geo-alt"></i> <?php echo esc_html(renew_mod('hero_note3')); ?></div>
          </div>
        </div>
        <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
          <div class="group-orbit-wrap">
            <div class="orbit orbit-a"></div>
            <div class="orbit orbit-b"></div>
            <div class="orbit-dot dot-1"></div>
            <div class="orbit-dot dot-2"></div>
            <div class="orbit-dot dot-3"></div>
            <div class="orbit-center">
              <span class="mini-label">EST. <?php echo esc_html(renew_mod('hero_year', '2000')); ?></span>
              <div class="center-icon"><img
                  src="<?php echo esc_url((renew_mod('orbit_group_logo') ? wp_get_attachment_image_url(renew_mod('orbit_group_logo'), 'full') : renew_asset('images/renew-group-logo.png'))); ?>"
                  alt="Renew Group logo"></div>
              <strong>RENEW</strong><small>GROUP</small>
            </div>
            <div class="business-node node-p"><span class="node-icon"><img
                  src="<?php echo esc_url((renew_mod('orbit_renewplus_logo') ? wp_get_attachment_image_url(renew_mod('orbit_renewplus_logo'), 'full') : renew_asset('images/renew-plus-hair-skin-mark.png'))); ?>"
                  alt="Renew Plus logo"></span><strong>RENEW PLUS</strong><small>HAIR &amp; SKIN CARE</small></div>
            <div class="business-node node-z"><span class="node-icon"><img
                  src="<?php echo esc_url((renew_mod('orbit_zelora_logo') ? wp_get_attachment_image_url(renew_mod('orbit_zelora_logo'), 'full') : renew_asset('images/zelora-logo.png'))); ?>"
                  alt="Zelora Infotech logo"></span><strong>ZELORA</strong><small>INFOTECH</small></div>
            <div class="business-node node-r"><span class="node-icon"><img class="orbit-rivan-logo"
                  src="<?php echo esc_url((renew_mod('orbit_rivan_logo') ? wp_get_attachment_image_url(renew_mod('orbit_rivan_logo'), 'full') : renew_asset('images/rivan-institute-mark.png'))); ?>"
                  alt="Rivan Institute logo"></span><strong>RIVAN</strong><small>INSTITUTE OF AESTHETIC SCIENCE</small>
            </div>
            <div class="business-node node-m"><span class="node-icon"><img class="orbit-mars-logo"
                  src="<?php echo esc_url((renew_mod('orbit_mars_logo') ? wp_get_attachment_image_url(renew_mod('orbit_mars_logo'), 'full') : renew_asset('images/mars-builders-mark.png'))); ?>"
                  alt="The New Mars Properties logo"></span><strong>THE NEW MARS</strong><small>PROPERTIES</small></div>
            <div class="orbit-caption">MARS · PARENT COMPANY</div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <section class="stats-strip parallax-section">
    <div class="container">
      <div class="row g-0">
        <?php
        $stats = array(
          array('diagram-3', 'stat1_label', 'stat1_value', ''),
          array('calendar2-check', 'stat2_label', 'stat2_value', ''),
          array('people', 'stat3_label', 'stat3_value', 'stat3_suffix'),
          array('buildings', 'stat4_label', 'stat4_value', 'stat4_suffix'),
        );
        foreach ($stats as $s): ?>
          <div class="col-6 col-lg-3 stat-cell"><i
              class="bi bi-<?php echo esc_attr($s[0]); ?>"></i><span><?php echo esc_html(renew_mod($s[1])); ?></span><strong><span
                data-count="<?php echo esc_attr(renew_mod($s[2])); ?>" <?php if ($s[2] === 'stat2_value'): ?>
                  data-year="true" <?php endif; ?>>0</span><b><?php echo $s[3] ? esc_html(renew_mod($s[3])) : ''; ?><?php if ($s[2] === 'stat3_value' || $s[2] === 'stat4_value'): ?><?php echo $s[2] === 'stat3_value' ? '+' : ''; ?><?php endif; ?></b></strong>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="businesses" class="section-pad businesses-section parallax-section">
    <div class="container">
      <div class="section-heading text-center" data-aos="fade-up">
        <div class="eyebrow justify-content-center"><span></span>
          <?php echo esc_html(renew_mod('business_eyebrow', 'OUR BUSINESSES')); ?></div>
        <h2><?php echo esc_html($business_title[0] ?? ''); ?> <em><?php echo esc_html($business_title[1] ?? ''); ?></em>
        </h2>
        <p><?php echo esc_html(renew_mod('business_intro')); ?></p>
      </div>
      <div class="row g-4 mt-4">
        <?php
        $business_classes = array('card-teal', 'card-purple', 'card-violet', 'card-mars');
        $business_icons = array('heart-pulse', 'cpu', 'magic', 'buildings');
        for ($i = 1; $i <= 4; $i++): ?>
          <div class="col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo esc_attr($i * 50); ?>">
            <article class="business-card <?php echo esc_attr($business_classes[$i - 1]); ?> tilt-card">
              <div class="card-top"><span class="round-icon"><i
                    class="bi bi-<?php echo esc_attr($business_icons[$i - 1]); ?>"></i></span><span
                  class="category"><?php echo esc_html(renew_mod("biz{$i}_category")); ?></span></div>
              <h3><?php echo esc_html(renew_mod("biz{$i}_name")); ?></h3>
              <p><?php echo esc_html(renew_mod("biz{$i}_description")); ?></p>
              <div class="chips">
                <?php foreach (explode(',', renew_mod("biz{$i}_chips")) as $chip): ?><span><?php echo esc_html(trim($chip)); ?></span><?php endforeach; ?>
              </div>
              <a href="<?php echo esc_url(renew_url("biz{$i}_url", '#contact')); ?>" class="text-link"><?php echo esc_html(renew_mod("biz{$i}_link")); ?> <i
                  class="bi bi-arrow-right"></i></a>
            </article>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <section id="about" class="section-pad about-section parallax-section">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="eyebrow"><span></span> <?php echo esc_html(renew_mod('about_eyebrow')); ?></div>
          <h2><?php echo esc_html($about_title[0] ?? ''); ?><br><em><?php echo esc_html($about_title[1] ?? ''); ?></em>
          </h2>
          <p class="lead"><?php echo esc_html(renew_mod('about_lead')); ?></p>
          <ul class="standard-list"><?php for ($i = 1; $i <= 4; $i++): ?>
              <li><i class="bi bi-check-circle-fill"></i><span><?php echo esc_html(renew_mod("about_item{$i}")); ?></span>
              </li><?php endfor; ?>
          </ul>
          <a href="<?php echo esc_url(renew_url('about_button_url', '#values')); ?>" class="btn btn-dark-brand"><?php echo esc_html(renew_mod('about_button')); ?> <i
              class="bi bi-arrow-right ms-2"></i></a>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="group-map">
            <div class="map-glow"></div>
            <div class="map-line line-h"></div>
            <div class="map-line line-v"></div>
            <div class="map-node map-root"><img class="map-root-logo"
                src="<?php echo esc_url((renew_mod('orbit_group_logo') ? wp_get_attachment_image_url(renew_mod('orbit_group_logo'), 'full') : renew_asset('images/renew-group-logo.png'))); ?>"
                alt="Renew Group logo"><strong>RENEW</strong><small>GROUPS</small></div>
            <div class="map-node map-z"><i class="bi bi-heart-pulse"></i><strong>RENEW PLUS</strong><small>HAIR &amp;
                SKIN CARE</small></div>
            <div class="map-node map-r"><i class="bi bi-cpu"></i><strong>ZELORA INFOTECH</strong><small>SOFTWARE ·
                AI</small></div>
            <div class="map-node map-p"><i class="bi bi-magic"></i><strong>RIVAN INSTITUTE OF AESTHETIC
                SCIENCE</strong><small>BEAUTY TRAINING</small></div>
            <div class="map-node map-mars"><i class="bi bi-buildings"></i><strong>THE NEW MARS
                PROPERTIES</strong><small>BUILDERS &amp; LAND PROMOTERS</small></div>
            <div class="map-footer">RENEW · ONE FAMILY · FOUR BRANDS</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="values" class="section-pad values-section parallax-section">
    <div class="container">
      <div class="section-heading text-center" data-aos="fade-up">
        <div class="eyebrow justify-content-center"><span></span> <?php echo esc_html(renew_mod('values_eyebrow')); ?>
        </div>
        <h2><?php echo esc_html($values_title); ?></h2>
      </div>
      <div class="row g-4 mt-4">
        <?php $vi = array('diagram-3', 'people', 'shield-check', 'graph-up-arrow');
        for ($i = 1; $i <= 4; $i++): ?>
          <div class="col-md-6 col-lg-3" data-aos="zoom-in">
            <div class="value-card"><span><i class="bi bi-<?php echo esc_attr($vi[$i - 1]); ?>"></i></span>
              <h4><?php echo esc_html(renew_mod("value{$i}_title")); ?></h4>
              <p><?php echo esc_html(renew_mod("value{$i}_text")); ?></p>
            </div>
          </div><?php endfor; ?>
      </div>
    </div>
  </section>

  <section id="team" class="section-pad leadership-section parallax-section">
    <div class="container">
      <div class="section-heading text-center" data-aos="fade-up">
        <div class="eyebrow justify-content-center"><span></span> <?php echo esc_html(renew_mod('team_eyebrow')); ?>
        </div>
        <h2><?php echo esc_html($team_title); ?></h2>
        <p><?php echo esc_html(renew_mod('team_intro')); ?></p>
      </div>
      <div class="leadership-grid mt-5" data-aos="fade-up">
        <?php for ($i = 1; $i <= 5; $i++):
          $vacant = $i > 2;
          $team_img = renew_mod("team{$i}_image");
          $portrait_class = $team_img ? '' : ($vacant ? 'empty' : 'ph'); ?>
          <article class="person <?php echo $portrait_class; ?>">
            <div class="portrait <?php echo $portrait_class; ?>">
              <?php if ($team_img): ?>
                <img src="<?php echo esc_url(wp_get_attachment_image_url($team_img, 'large')); ?>" alt="<?php echo esc_attr(renew_mod("team{$i}_name")); ?>">
              <?php endif; ?>
            </div>
            <h3><?php echo esc_html(renew_mod("team{$i}_name")); ?></h3>
            <p class="role"><?php echo esc_html(renew_mod("team{$i}_role")); ?></p>
            <p class="bio"><?php echo esc_html(renew_mod("team{$i}_bio")); ?></p>
          </article>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <section id="partner" class="section-pad partner-section parallax-section">
    <div class="container">
      <div class="section-heading text-center" data-aos="fade-up">
        <div class="eyebrow justify-content-center"><span></span> <?php echo esc_html(renew_mod('partner_eyebrow')); ?>
        </div>
        <h2><?php echo esc_html($partner_title); ?></h2>
        <p><?php echo esc_html(renew_mod('partner_intro')); ?></p>
      </div>
      <div class="row g-4 mt-4">
        <?php $pc = array('partner-p', 'partner-z', 'partner-r');
        $pi = array('heart-pulse', 'cpu', 'magic');
        for ($i = 1; $i <= 3; $i++): ?>
          <div class="col-lg-4" data-aos="fade-up">
            <div class="partner-card <?php echo esc_attr($pc[$i - 1]); ?>">
              <div class="partner-brand"><i
                  class="bi bi-<?php echo esc_attr($pi[$i - 1]); ?>"></i><span><?php echo esc_html(renew_mod("partner{$i}_brand")); ?></span>
              </div>
              <h3><?php echo esc_html(renew_mod("partner{$i}_title")); ?></h3>
              <p><?php echo esc_html(renew_mod("partner{$i}_text")); ?></p>
              <?php $tags = trim(renew_mod("partner{$i}_tags"));
              if ($tags): ?>
                <div class="partner-tags">
                  <?php foreach (explode(',', $tags) as $tag): ?><span><?php echo esc_html(trim($tag)); ?></span><?php endforeach; ?>
                </div><?php endif; ?>                  
                <?php
                  $partner_url = renew_url("partner{$i}_url", '#partnerEnquiryModal');
                  $is_modal = ($partner_url === '#partnerEnquiryModal');
                ?>
              <a class="partner-enquiry-btn" href="<?php echo esc_url($partner_url); ?>" 
              <?php if ($is_modal): ?>
                  data-bs-toggle="modal"
                  data-partner="<?php echo esc_attr(renew_mod("partner{$i}_brand")); ?>"
              <?php endif; ?>><?php echo esc_html(renew_mod("partner{$i}_button")); ?>
                <i class="bi bi-arrow-up-right"></i></a>
            </div>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <section id="faq" class="section-pad faq-section parallax-section">
    <div class="container">
      <div class="section-heading text-center" data-aos="fade-up">
        <div class="eyebrow justify-content-center"><span></span> <?php echo esc_html(renew_mod('faq_eyebrow')); ?>
        </div>
        <h2><?php echo esc_html($faq_title); ?></h2>
      </div>
      <div class="accordion faq-accordion mx-auto mt-5" id="faqAccordion" data-aos="fade-up">
        <?php for ($i = 1; $i <= 6; $i++): ?>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button <?php echo $i > 1 ? 'collapsed' : ''; ?>"
                data-bs-toggle="collapse"
                data-bs-target="#q<?php echo $i; ?>"><?php echo esc_html(renew_mod("faq{$i}_question")); ?></button></h2>
            <div id="q<?php echo $i; ?>" class="accordion-collapse collapse <?php echo $i === 1 ? 'show' : ''; ?>"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body"><?php echo esc_html(renew_mod("faq{$i}_answer")); ?></div>
            </div>
          </div><?php endfor; ?>
      </div>
    </div>
  </section>

  <section id="contact" class="contact-section parallax-section">
    <div class="container">
      <div class="row g-4 align-items-stretch">
        <div class="col-lg-5" data-aos="fade-right">
          <div class="contact-intro">
            <div class="eyebrow"><span></span> <?php echo esc_html(renew_mod('contact_eyebrow')); ?></div>
            <h2><?php echo esc_html(renew_mod('contact_title')); ?></h2>
            <p><?php echo esc_html(renew_mod('contact_intro')); ?></p>
            <div class="reach-list">
              <?php $contact_items = array(
                array('heart-pulse', 'Renew Plus Hair And Skin Care', 'Hair transplant & skin care', 'contact_email1'),
                array('cpu', 'Zelora Infotech', 'ERP, mobile apps & AI integration', 'contact_email2'),
                array('magic', 'Rivan Institute of Aesthetic Science', 'Beauty & cosmetology training', 'contact_email3'),
                array('buildings', 'The New Mars Properties', 'Construction & land promotion', 'contact_email4'),
              );
              foreach ($contact_items as $c): ?>
                <div><i
                    class="bi bi-<?php echo esc_attr($c[0]); ?>"></i><span><strong><?php echo esc_html($c[1]); ?></strong><small><?php echo esc_html($c[2]); ?></small><b><?php echo esc_html(renew_mod($c[3])); ?></b></span>
                </div><?php endforeach; ?>
            </div>
            <div class="contact-meta"><i class="bi bi-telephone"></i>
              <?php echo esc_html(renew_mod('contact_phone')); ?> &nbsp;&nbsp; <i class="bi bi-geo-alt"></i>
              <?php echo esc_html(renew_mod('contact_location')); ?></div>
          </div>
        </div>
        <div class="col-lg-7" data-aos="fade-left">
          <form class="contact-form" id="contactForm">
            <div class="row g-3">
              <div class="col-md-6"><label>Full Name</label><input type="text" class="form-control" name="name"
                  placeholder="Your name" minlength="2" maxlength="80" autocomplete="name" required></div>
              <div class="col-md-6"><label>Phone Number</label><input type="tel" class="form-control" name="phone"
                  placeholder="10-digit mobile number" pattern="(?:\+91[\s-]?)?[6-9][0-9]{9}" minlength="10"
                  maxlength="14" autocomplete="tel" required></div>
              <div class="col-md-6"><label>Email <small>(optional)</small></label><input type="email"
                  class="form-control" name="email" placeholder="you@example.com" maxlength="120" autocomplete="email">
              </div>
              <div class="col-md-6"><label>Which business?</label><select class="form-select" name="business" required>
                  <option>Renew Plus Hair And Skin Care</option>
                  <option>The New Mars Properties</option>
                  <option>Zelora Infotech</option>
                  <option>Rivan Institute of Aesthetic Science</option>
                  <option>Group Partnership</option>
                </select></div>
              <div class="col-12"><label>Message <small>(optional)</small></label><textarea class="form-control"
                  name="message" rows="5" maxlength="1000"
                  placeholder="Tell us a little about what you need"></textarea></div>
              <div class="col-12"><button class="btn btn-brand w-100 py-3" type="submit">Send Enquiry <i
                    class="bi bi-send ms-2"></i></button></div>
            </div>
            <div id="formMessage" class="form-message"></div>
          </form>
        </div>
      </div>
    </div>
  </section>

</main>
<?php get_footer(); ?>