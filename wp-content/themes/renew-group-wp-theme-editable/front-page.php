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
              class="btn btn-outline-brand btn-lg"><i class="bi bi-play-circle me-2"></i><?php echo esc_html(renew_mod('hero_secondary', 'Talk to Us')); ?></a>
          </div>
          <div class="hero-notes mt-4">
            <div><i class="bi bi-check2-circle"></i> <?php echo esc_html(renew_mod('hero_note1')); ?></div>
            <div><i class="bi bi-stars"></i> <?php echo esc_html(renew_mod('hero_note2')); ?></div>
            <div><i class="bi bi-geo-alt"></i> <?php echo esc_html(renew_mod('hero_note3')); ?></div>
          </div>
        </div>
        <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-duration="900" data-aos-delay="150">
          <?php $hero_img = renew_mod('hero_image') ? wp_get_attachment_image_url(renew_mod('hero_image'), 'full') : renew_asset('images/rgc_homepage-full.webp'); ?>
          <div class="hero-visual" style="--hv-img: url('<?php echo esc_url($hero_img); ?>')">
            <span class="hv-glow" aria-hidden="true"></span>
            <svg class="hv-net" viewBox="0 0 700 400" preserveAspectRatio="none" aria-hidden="true">
              <g class="net-lines">
                <path d="M30 60 L120 30 L210 80 L300 40 L380 90"/>
                <path d="M120 30 L140 130 L210 80"/>
                <path d="M300 40 L330 140 L380 90"/>
                <path d="M20 250 L110 300 L200 260 L260 340"/>
                <path d="M110 300 L90 380"/>
                <path d="M440 50 L520 20 L600 70 L680 30"/>
                <path d="M520 20 L540 120 L600 70"/>
                <path d="M600 70 L660 160 L610 240 L690 300"/>
                <path d="M440 330 L520 370 L610 240"/>
                <path d="M380 90 L440 50"/>
              </g>
              <g class="net-nodes">
                <circle cx="30" cy="60" r="3"/><circle cx="120" cy="30" r="3.5"/><circle cx="210" cy="80" r="3"/><circle cx="300" cy="40" r="3.5"/><circle cx="380" cy="90" r="3"/>
                <circle cx="140" cy="130" r="3"/><circle cx="330" cy="140" r="3"/><circle cx="20" cy="250" r="3"/><circle cx="110" cy="300" r="3.5"/><circle cx="200" cy="260" r="3"/>
                <circle cx="260" cy="340" r="3"/><circle cx="440" cy="50" r="3"/><circle cx="520" cy="20" r="3.5"/><circle cx="600" cy="70" r="3.5"/><circle cx="680" cy="30" r="3"/>
                <circle cx="660" cy="160" r="3"/><circle cx="610" cy="240" r="3.5"/><circle cx="690" cy="300" r="3"/><circle cx="520" cy="370" r="3"/><circle cx="440" cy="330" r="3"/>
              </g>
            </svg>
            <span class="hv-ring" aria-hidden="true"></span><span class="hv-ring hv-ring-2" aria-hidden="true"></span>
            <b class="hv-spark" style="--x:14%;--y:22%;--s:16px;--d:2.8s;--t:-.4s" aria-hidden="true"></b><b class="hv-spark" style="--x:84%;--y:14%;--s:20px;--d:3.4s;--t:-1.6s" aria-hidden="true"></b><b class="hv-spark" style="--x:92%;--y:58%;--s:14px;--d:2.4s;--t:-.9s" aria-hidden="true"></b><b class="hv-spark" style="--x:72%;--y:92%;--s:18px;--d:3.1s;--t:-2.1s" aria-hidden="true"></b><b class="hv-spark" style="--x:8%;--y:68%;--s:14px;--d:2.9s;--t:-1.2s" aria-hidden="true"></b><b class="hv-spark" style="--x:46%;--y:4%;--s:12px;--d:3.2s;--t:-.2s" aria-hidden="true"></b>
            <div class="hv-stage">
              <img class="hv-img" src="<?php echo esc_url($hero_img); ?>" width="1600" height="893" decoding="async" fetchpriority="high" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
              <span class="hv-shine" aria-hidden="true"></span>

            </div>
          </div>
          <!-- <p class="hero-tagline">DIFFERENT EXPERTISES.<br>A STRONGER TOMORROW.</p> -->
        </div>
      </div>
      <div class="hero-features">
        <?php
        $stats = array(
          array('stat1_icon', 'stat1_label', 'stat1_value', ''),
          array('stat2_icon', 'stat2_label', 'stat2_value', ''),
          array('stat3_icon', 'stat3_label', 'stat3_value', 'stat3_suffix'),
          array('stat4_icon', 'stat4_label', 'stat4_value', 'stat4_suffix'),
        );
        foreach ($stats as $s): ?>
          <div>
            <i class="bi bi-<?php echo esc_attr(renew_mod($s[0])); ?>"></i>
            <span class="hf-text">
              <strong><span data-count="<?php echo esc_attr(renew_mod($s[2])); ?>"<?php if ($s[2] === 'stat2_value'): ?> data-year="true"<?php endif; ?>>0</span><b><?php echo $s[3] ? esc_html(renew_mod($s[3])) : ''; ?></b></strong>
              <small><?php echo esc_html(renew_mod($s[1])); ?></small>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </header>

  <section id="businesses" class="section-pad businesses-section section-light parallax-section">
    <div class="container">
      <div class="section-heading" data-aos="fade-up">
        <div class="eyebrow"><span></span>
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
              <?php $biz_img = renew_mod("biz{$i}_image") ? wp_get_attachment_image_url(renew_mod("biz{$i}_image"), 'large') : ''; ?>
              <div class="biz-media"<?php if ($biz_img): ?> style="background-image:url('<?php echo esc_url($biz_img); ?>')"<?php endif; ?>>
              </div>
              <div class="biz-body">
                <?php $biz_logo_keys = array('orbit_renewplus_logo', 'orbit_zelora_logo', 'orbit_rivan_logo', 'orbit_mars_logo');
                $biz_logo_defaults = array('renew-plus-hair-skin-mark.png', 'zelora-logo.png', 'rivan-institute-mark.png', 'mars-builders-mark.png');
                $biz_logo = renew_mod($biz_logo_keys[$i - 1]) ? wp_get_attachment_image_url(renew_mod($biz_logo_keys[$i - 1]), 'full') : renew_asset('images/' . $biz_logo_defaults[$i - 1]); ?>
                <div class="biz-head">
                  <div class="biz-logo"><img src="<?php echo esc_url($biz_logo); ?>" alt="<?php echo esc_attr(renew_mod("biz{$i}_name")); ?> logo"></div>
                  <div class="biz-title">
                    <h3><?php echo esc_html(renew_mod("biz{$i}_name")); ?></h3>
                    <small class="category"><?php echo esc_html(renew_mod("biz{$i}_category")); ?></small>
                  </div>
                </div>
                <p><?php echo esc_html(renew_mod("biz{$i}_description")); ?></p>
                <div class="chips">
                  <?php foreach (explode(',', renew_mod("biz{$i}_chips")) as $chip): ?><span><?php echo esc_html(trim($chip)); ?></span><?php endforeach; ?>
                </div>
                <a href="<?php echo esc_url(renew_url("biz{$i}_url", '#contact')); ?>" class="text-link"><?php echo esc_html(renew_mod("biz{$i}_link")); ?> <i
                    class="bi bi-arrow-right"></i></a>
              </div>
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
          <div class="approach-orbit" aria-hidden="false">
            <span class="ao-galaxy" aria-hidden="true"><i class="ag-stars"></i><i class="ag-stars ag-stars-2"></i><b class="ag-star" style="--x:10%;--y:30%;--s:14px;--d:2.6s;--t:-.4s"></b><b class="ag-star" style="--x:86%;--y:18%;--s:18px;--d:3.4s;--t:-1.6s"></b><b class="ag-star" style="--x:94%;--y:62%;--s:12px;--d:2.2s;--t:-.9s"></b><b class="ag-star" style="--x:70%;--y:94%;--s:16px;--d:3s;--t:-2.1s"></b><b class="ag-star" style="--x:22%;--y:88%;--s:12px;--d:2.8s;--t:-1.2s"></b><b class="ag-star" style="--x:46%;--y:4%;--s:13px;--d:3.2s;--t:-.2s"></b><b class="ag-star" style="--x:3%;--y:58%;--s:10px;--d:2.4s;--t:-1.9s"></b></span>
            <span class="ao-ring ao-ring-1"></span>
            <span class="ao-ring ao-ring-2"></span>
            <div class="ao-center"><img src="<?php echo esc_url((renew_mod('orbit_group_logo') ? wp_get_attachment_image_url(renew_mod('orbit_group_logo'), 'full') : renew_asset('images/renew-group-logo.png'))); ?>" alt="Renew Group logo"><strong>RENEW</strong><small>GROUP</small></div>
            <div class="ao-spin">
              <div class="ao-logo" style="--a:0deg"><div class="ao-tile"><img src="<?php echo esc_url((renew_mod('orbit_renewplus_logo') ? wp_get_attachment_image_url(renew_mod('orbit_renewplus_logo'), 'full') : renew_asset('images/renew-plus-hair-skin-mark.png'))); ?>" alt="<?php echo esc_attr(renew_mod('orbit_title_1', 'RENEW PLUS')); ?> logo"><strong><?php echo esc_html(renew_mod('orbit_title_1', 'RENEW PLUS')); ?></strong></div></div>
              <div class="ao-logo" style="--a:90deg"><div class="ao-tile"><img src="<?php echo esc_url((renew_mod('orbit_zelora_logo') ? wp_get_attachment_image_url(renew_mod('orbit_zelora_logo'), 'full') : renew_asset('images/zelora-logo.png'))); ?>" alt="<?php echo esc_attr(renew_mod('orbit_title_2', 'ZELORA')); ?> logo"><strong><?php echo esc_html(renew_mod('orbit_title_2', 'ZELORA')); ?></strong></div></div>
              <div class="ao-logo" style="--a:180deg"><div class="ao-tile"><img src="<?php echo esc_url((renew_mod('orbit_rivan_logo') ? wp_get_attachment_image_url(renew_mod('orbit_rivan_logo'), 'full') : renew_asset('images/rivan-institute-mark.png'))); ?>" alt="<?php echo esc_attr(renew_mod('orbit_title_3', 'RIVAN')); ?> logo"><strong><?php echo esc_html(renew_mod('orbit_title_3', 'RIVAN')); ?></strong></div></div>
              <div class="ao-logo" style="--a:270deg"><div class="ao-tile"><img src="<?php echo esc_url((renew_mod('orbit_mars_logo') ? wp_get_attachment_image_url(renew_mod('orbit_mars_logo'), 'full') : renew_asset('images/mars-builders-mark.png'))); ?>" alt="<?php echo esc_attr(renew_mod('orbit_title_4', 'THE NEW MARS')); ?> logo"><strong><?php echo esc_html(renew_mod('orbit_title_4', 'THE NEW MARS')); ?></strong></div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="values" class="section-pad values-section section-light parallax-section">
    <div class="container">
      <div class="section-heading" data-aos="fade-up">
        <div class="eyebrow"><span></span> <?php echo esc_html(renew_mod('values_eyebrow')); ?>
        </div>
        <h2><?php echo esc_html($values_title); ?></h2>
        <p><?php echo esc_html(renew_mod('values_intro')); ?></p>
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
      <div class="leadership-grid mt-5">
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
            <p class="role"><?php echo implode('<br>', array_map('esc_html', array_map('trim', preg_split('/\s*[|&]\s*/', renew_mod("team{$i}_role"))))); ?></p>
            <p class="bio"><?php echo esc_html(renew_mod("team{$i}_bio")); ?></p>
          </article>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <section id="partner" class="section-pad partner-section section-light parallax-section">
    <div class="container">
      <div class="row g-5 align-items-center partner-row">
      <div class="col-lg-4" data-aos="fade-right">
      <div class="section-heading partner-heading">
        <div class="eyebrow justify-content-center"><span></span> <?php echo esc_html(renew_mod('partner_eyebrow')); ?>
        </div>
        <h2><?php echo esc_html($partner_title); ?></h2>
        <p><?php echo esc_html(renew_mod('partner_intro')); ?></p>
      <a href="#contact" class="btn btn-brand mt-3">Partnership Opportunities <i class="bi bi-arrow-right ms-2"></i></a>
      </div>
      </div>
      <div class="col-lg-8">
      <div class="row g-3 partner-cards">
        <?php $pc = array('partner-p', 'partner-z', 'partner-r');
        $pi = array('heart-pulse', 'cpu', 'magic');
        for ($i = 1; $i <= 3; $i++): ?>
          <div class="col-md-4" data-aos="fade-up">
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
                  data-business="<?php echo esc_attr(array('Renew Plus Hair And Skin Care', 'Zelora Infotech', 'Rivan Institute of Aesthetic Science')[$i - 1]); ?>"
              <?php endif; ?>><?php echo esc_html(renew_mod("partner{$i}_button")); ?>
                <i class="bi bi-arrow-up-right"></i></a>
            </div>
          </div>
        <?php endfor; ?>
      </div>
      </div>
      </div>
    </div>
  </section>

  <section id="faq" class="section-pad faq-section parallax-section">
    <div class="container">
      <div class="section-heading faq-heading" data-aos="fade-up">
        <div class="eyebrow justify-content-center"><span></span> <?php echo esc_html(renew_mod('faq_eyebrow')); ?>
        </div>
        <h2><?php echo esc_html($faq_title); ?></h2>
      </div>
      <div class="row g-4 mt-2 align-items-start">
      <div class="col-lg-8">
      <div class="accordion faq-accordion" id="faqAccordion" data-aos="fade-up">
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
      <div class="col-lg-4" data-aos="fade-left">
        <div class="faq-help">
          <div class="eyebrow"><span></span> STILL HAVE QUESTIONS?</div>
          <h3>We&rsquo;re here to help.</h3>
          <p>Contact our team for more information.</p>
          <a href="#contact" class="btn btn-brand">Contact Us <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
      </div>
      </div>
    </div>
  </section>

  <section id="contact" class="contact-section section-light parallax-section">
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