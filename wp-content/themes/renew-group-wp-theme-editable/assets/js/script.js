$(function () {
  AOS.init({ once: true, duration: 750, easing: 'ease-out-cubic', offset: 60 });

  // Default theme is RGC (style-rgc.css); style.css is the secondary (purple) theme.
  const themeStorageKey = 'renew-theme';
  const $themeStylesheet = $('#renew-design-css');
  const $themeToggle = $('#themeToggle');

  function setTheme(theme) {
    const isOrange = theme !== 'purple'; // true = default RGC theme
    $themeStylesheet.attr('href', RenewTheme.assetUrl + 'css/' + (isOrange ? 'style-rgc.css' : 'style.css'));
    $themeToggle.attr({
      'aria-pressed': isOrange,
      'aria-label': isOrange ? 'Switch to purple theme' : 'Switch to default theme'
    });
    $themeToggle.find('span').text(isOrange ? 'Purple' : 'Default');
    $themeToggle.toggleClass('is-orange', isOrange);
    localStorage.setItem(themeStorageKey, isOrange ? 'rgc' : 'purple');
  }

  setTheme(localStorage.getItem(themeStorageKey) || 'rgc');

  $themeToggle.on('click', function () {
    setTheme($(this).hasClass('is-orange') ? 'purple' : 'rgc');
  });

  function getTopbarHeight() {
    const $topbar = $('.renew-topbar');
    return $topbar.length ? $topbar.outerHeight() : 0;
  }

  function syncTopbarOffset() {
    const topbarH = getTopbarHeight();
    document.querySelectorAll('.renew-nav').forEach(function (el) {
      el.style.setProperty('top', topbarH + 'px', 'important');
    });
  }

  syncTopbarOffset();
  $(window).on('resize load', syncTopbarOffset);

  function updateActiveNav() {
    const marker = $(window).scrollTop() + getTopbarHeight() + $('.renew-nav').outerHeight() + 80;
    let activeId = '#home';

    $('.nav-link[href^="#"]').each(function () {
      const target = $($(this).attr('href'));
      if (target.length && target.offset().top <= marker) {
        activeId = $(this).attr('href');
      }
    });

    $('.nav-link').removeClass('active');
    $(`.nav-link[href="${activeId}"]`).addClass('active');
  }

  // Navbar state + smooth scroll
  $(window).on('scroll', function () {
    $('.renew-nav').toggleClass('scrolled', $(this).scrollTop() > 20);
    $('.back-top').toggle($(this).scrollTop() > 500);
    updateActiveNav();
  });

  $(window).on('resize', function () {
    if ($(window).width() > 991) {
      $('.navbar-collapse').removeClass('show collapsing').removeAttr('style');
    }
  });

  updateActiveNav();

  $('.nav-link, .navbar-brand, .btn[href^="#"], .text-link').on('click', function (e) {
    const target = $(this).attr('href');
    if (target && target.startsWith('#') && $(target).length) {
      e.preventDefault();
      const offset = getTopbarHeight() + $('.renew-nav').outerHeight();
      $('html, body').animate({ scrollTop: $(target).offset().top - offset }, 650);
      $('.navbar-collapse').collapse('hide');
    }
  });

  $('.back-top').on('click', () => $('html, body').animate({scrollTop: 0}, 650));

  $('#partnerEnquiryModal').on('show.bs.modal', function (event) {
    const partner = $(event.relatedTarget).data('partner');
    const $modal = $(this);
    $modal.find('[name="partner_brand"]').val(partner || '');
    $modal.find('[name="business"]').val($(event.relatedTarget).data('business') || 'Partner Enquiry');
    $modal.find('.modal-title').text(`Partner with ${partner}`);
    $modal.find('.partner-enquiry-intro').text(`Share your interest in partnering with ${partner}.`);
    $modal.find('#partnerFormMessage').text('');
  });

  // Mobile menu: close when clicking/tapping outside it, or pressing Escape
  (function () {
    const nav = document.getElementById('mainNav');
    if (!nav || typeof bootstrap === 'undefined') return;
    function closeMenu() {
      if (nav.classList.contains('show')) bootstrap.Collapse.getOrCreateInstance(nav).hide();
    }
    document.addEventListener('click', function (e) {
      if (!nav.classList.contains('show')) return;
      if (e.target.closest('#mainNav, .navbar-toggler')) return;
      closeMenu();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeMenu();
    });
  })();

  // Eyebrow tags: split text into letters for the wave effect
  $('.eyebrow').each(function () {
    const $e = $(this);
    if ($e.closest('.hero-section').length) return; // no wave on the header/hero section
    if ($e.data('waved')) return;
    $e.data('waved', true);
    const label = $e.text().replace(/\s+/g, ' ').trim();
    $e.attr('aria-label', label);
    let i = 0;
    this.childNodes.forEach(function (node) {
      if (node.nodeType !== 3 || !node.textContent.trim()) return;
      const frag = document.createDocumentFragment();
      Array.from(node.textContent.replace(/\s+/g, ' ').trim()).forEach(function (ch) {
        const s = document.createElement('span');
        s.className = 'wv';
        s.setAttribute('aria-hidden', 'true');
        s.style.setProperty('--i', i++);
        s.textContent = ch === ' ' ? ' ' : ch;
        frag.appendChild(s);
      });
      node.parentNode.replaceChild(frag, node);
    });
  });

  // Section headings: letter wave, played once when the heading scrolls into view
  (function () {
    const heads = document.querySelectorAll('.section-pad h2:not(.accordion-header), .contact-section h2');
    if (!heads.length) return;
    const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let idx;
    function wrap(node) {
      Array.from(node.childNodes).forEach(function (child) {
        if (child.nodeType === 3) {
          const frag = document.createDocumentFragment();
          child.textContent.split(/(\s+)/).forEach(function (part) {
            if (!part) return;
            if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(' ')); return; }
            const word = document.createElement('span');
            word.className = 'wd';
            Array.from(part).forEach(function (ch) {
              const l = document.createElement('span');
              l.className = 'hw';
              l.setAttribute('aria-hidden', 'true');
              l.style.setProperty('--i', idx++);
              l.textContent = ch;
              word.appendChild(l);
            });
            frag.appendChild(word);
          });
          node.replaceChild(frag, child);
        } else if (child.nodeType === 1 && child.tagName !== 'BR') {
          wrap(child);
        }
      });
    }
    heads.forEach(function (h) {
      idx = 0;
      h.setAttribute('aria-label', h.textContent.replace(/\s+/g, ' ').trim());
      h.classList.add('has-wave');
      wrap(h);
    });
    if (reduce) return;
    if (!('IntersectionObserver' in window)) { heads.forEach(function (h) { h.classList.add('is-waving'); }); return; }
    const io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('is-waving'); io.unobserve(en.target); }
      });
    }, { threshold: 0.5 });
    heads.forEach(function (h) { io.observe(h); });
  })();

  // Animated counters
  let countersDone = false;
  function animateCounters() {
    if (countersDone) return;
    const $feat = $('.hero-features');
    if ($feat.length && $(window).scrollTop() + window.innerHeight > $feat.offset().top + 40) {
      countersDone = true;
      $('[data-count]').each(function () {
        const $this = $(this), end = parseInt($this.data('count'), 10), suffix = $this.data('suffix') || '';
        const isYear = $this.data('year');
        const format = (value) => isYear ? `${value}` : `${value.toLocaleString()}`;
        $({value: 0}).animate({value: end}, {
          duration: 1300, easing: 'swing',
          step: function () { $this.text(`${format(Math.floor(this.value))}${suffix}`); },
          complete: function () { $this.text(`${format(end)}${suffix}`); }
        });
      });
    }
  }
  $(window).on('scroll', animateCounters);
  animateCounters();

  // Lightweight pointer tilt for desktop; touch devices remain native
  if (window.matchMedia('(pointer:fine)').matches) {
    $('.tilt-card').on('mousemove', function (e) {
      const rect = this.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width - .5;
      const y = (e.clientY - rect.top) / rect.height - .5;
      $(this).css('transform', `perspective(900px) rotateX(${(-y * 3).toFixed(2)}deg) rotateY(${(x * 4).toFixed(2)}deg) translateY(-7px)`);
    }).on('mouseleave', function () {
      $(this).css('transform', '');
    });

    $('.parallax-section').on('mousemove', function (e) {
      const rect = this.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width - .5) * 10;
      const y = ((e.clientY - rect.top) / rect.height - .5) * 10;
      $(this).css({ '--parallax-x': `${x.toFixed(2)}px`, '--parallax-y': `${y.toFixed(2)}px` });
    }).on('mouseleave', function () {
      $(this).css({ '--parallax-x': '0px', '--parallax-y': '0px' });
    });

    $(document).on('mousemove', function(e){
      $('.cursor-glow').css({left:e.clientX, top:e.clientY});
    });
  }

  function submitRenewEnquiry(form, formType, messageSelector) {
    const $form = $(form);
    const $msg = $(messageSelector);
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    $msg.removeClass('is-error').text('Sending...');

    const data = $form.serializeArray();
    data.push({name: 'action', value: 'renew_submit_enquiry'});
    data.push({name: 'form_type', value: formType});
    data.push({name: 'nonce', value: RenewTheme.nonce});

    $.ajax({
      url: RenewTheme.ajaxUrl,
      method: 'POST',
      data: $.param(data),
      dataType: 'json'
    }).done(function(response) {
      if (response.success) {
        $msg.removeClass('is-error').text(response.data.message);
        form.reset();
        if (formType === 'partner') {
          setTimeout(function () {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('partnerEnquiryModal')).hide();
            $msg.text('');
          }, 1500);
        }
      } else {
        $msg.addClass('is-error').text(response.data && response.data.message ? response.data.message : 'Something went wrong.');
      }
    }).fail(function(xhr) {
      const message = xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message
        ? xhr.responseJSON.data.message
        : 'Something went wrong. Please try again.';
      $msg.addClass('is-error').text(message);
    });
  }

  $('#contactForm').on('submit', function (e) {
    e.preventDefault();
    submitRenewEnquiry(this, 'contact', '#formMessage');
  });

  $('input[type="tel"]').on('input', function () {
    const digits = this.value.replace(/\D/g, '');
    const isValidMobile = /^(?:91)?[6-9][0-9]{9}$/.test(digits);
    this.setCustomValidity(this.value && !isValidMobile ? 'Enter a valid 10-digit mobile number.' : '');
  });

  $('#partnerEnquiryForm').on('submit', function (e) {
    e.preventDefault();
    submitRenewEnquiry(this, 'partner', '#partnerFormMessage');
  });
});

// Hero: full-width animated network (connect links) behind the content
(function () {
  const hero = document.querySelector('.hero-section');
  if (!hero) return;
  const NS = 'http://www.w3.org/2000/svg', W = 1440, H = 760;
  let seed = 7;
  const rnd = () => (seed = (seed * 16807) % 2147483647) / 2147483647;
  const nodes = [];
  const cols = 9, rows = 5;
  for (let r = 0; r < rows; r++) for (let c = 0; c < cols; c++) {
    nodes.push({ x: (c + .15 + rnd() * .7) * W / cols, y: (r + .15 + rnd() * .7) * H / rows });
  }
  const svg = document.createElementNS(NS, 'svg');
  svg.setAttribute('class', 'hero-net');
  svg.setAttribute('viewBox', '0 0 ' + W + ' ' + H);
  svg.setAttribute('preserveAspectRatio', 'xMidYMid slice');
  svg.setAttribute('aria-hidden', 'true');
  const lines = document.createElementNS(NS, 'g'), dots = document.createElementNS(NS, 'g');
  lines.setAttribute('class', 'net-lines'); dots.setAttribute('class', 'net-nodes');
  const seen = {};
  nodes.forEach(function (a, i) {
    nodes.map(function (b, j) { return { j: j, d: Math.hypot(a.x - b.x, a.y - b.y) }; })
      .filter(function (o) { return o.j !== i && o.d < 260; })
      .sort(function (p, q) { return p.d - q.d; }).slice(0, 2)
      .forEach(function (o) {
        const k = Math.min(i, o.j) + '-' + Math.max(i, o.j);
        if (seen[k]) return; seen[k] = 1;
        const p = document.createElementNS(NS, 'path');
        p.setAttribute('d', 'M' + a.x.toFixed(0) + ' ' + a.y.toFixed(0) + ' L' + nodes[o.j].x.toFixed(0) + ' ' + nodes[o.j].y.toFixed(0));
        lines.appendChild(p);
      });
    const c = document.createElementNS(NS, 'circle');
    c.setAttribute('cx', a.x.toFixed(0)); c.setAttribute('cy', a.y.toFixed(0)); c.setAttribute('r', (2 + rnd() * 1.6).toFixed(1));
    c.style.animationDelay = (-rnd() * 2.6).toFixed(2) + 's';
    dots.appendChild(c);
  });
  svg.appendChild(lines); svg.appendChild(dots);
  hero.insertBefore(svg, hero.firstChild);
})();

// Hero image: follows the pointer with a soft 3D tilt
(function () {
  const hero = document.querySelector('.hero-section');
  const stage = document.querySelector('.hero-visual .hv-stage');
  if (!hero || !stage || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  let raf = 0;
  hero.addEventListener('mousemove', function (e) {
    const r = hero.getBoundingClientRect();
    const x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
    cancelAnimationFrame(raf);
    raf = requestAnimationFrame(function () {
      stage.style.setProperty('--tx', (x * 26).toFixed(1) + 'px');
      stage.style.setProperty('--ty', (y * 18).toFixed(1) + 'px');
      stage.style.setProperty('--ry', (x * 14).toFixed(1) + 'deg');
      stage.style.setProperty('--rx', (-y * 10).toFixed(1) + 'deg');
    });
  });
  hero.addEventListener('mouseleave', function () {
    ['--tx', '--ty', '--ry', '--rx'].forEach(function (p) { stage.style.removeProperty(p); });
  });
})();

// Leadership: connect-link network behind the cards
(function () {
  const sec = document.querySelector('.leadership-section');
  if (!sec) return;
  const NS = 'http://www.w3.org/2000/svg', W = 1440, H = 620;
  let seed = 23;
  const rnd = () => (seed = (seed * 16807) % 2147483647) / 2147483647;
  const nodes = [];
  for (let r = 0; r < 4; r++) for (let c = 0; c < 10; c++) {
    nodes.push({ x: (c + .15 + rnd() * .7) * W / 10, y: (r + .15 + rnd() * .7) * H / 4 });
  }
  const svg = document.createElementNS(NS, 'svg');
  svg.setAttribute('class', 'hero-net lead-net');
  svg.setAttribute('viewBox', '0 0 ' + W + ' ' + H);
  svg.setAttribute('preserveAspectRatio', 'xMidYMid slice');
  svg.setAttribute('aria-hidden', 'true');
  const lines = document.createElementNS(NS, 'g'), dots = document.createElementNS(NS, 'g');
  lines.setAttribute('class', 'net-lines'); dots.setAttribute('class', 'net-nodes');
  const seen = {};
  nodes.forEach(function (a, i) {
    nodes.map(function (b, j) { return { j: j, d: Math.hypot(a.x - b.x, a.y - b.y) }; })
      .filter(function (o) { return o.j !== i && o.d < 240; })
      .sort(function (p, q) { return p.d - q.d; }).slice(0, 2)
      .forEach(function (o) {
        const k = Math.min(i, o.j) + '-' + Math.max(i, o.j);
        if (seen[k]) return; seen[k] = 1;
        const p = document.createElementNS(NS, 'path');
        p.setAttribute('d', 'M' + a.x.toFixed(0) + ' ' + a.y.toFixed(0) + ' L' + nodes[o.j].x.toFixed(0) + ' ' + nodes[o.j].y.toFixed(0));
        lines.appendChild(p);
      });
    const c = document.createElementNS(NS, 'circle');
    c.setAttribute('cx', a.x.toFixed(0)); c.setAttribute('cy', a.y.toFixed(0)); c.setAttribute('r', (2 + rnd() * 1.6).toFixed(1));
    c.style.animationDelay = (-rnd() * 2.6).toFixed(2) + 's';
    dots.appendChild(c);
  });
  svg.appendChild(lines); svg.appendChild(dots);
  sec.insertBefore(svg, sec.firstChild);
})();

// Leadership cards: appear one by one when the section scrolls into view
(function () {
  const grid = document.querySelector('.leadership-grid');
  if (!grid) return;
  const cards = grid.querySelectorAll('.person');
  cards.forEach(function (c, i) { c.style.setProperty('--n', i); });
  if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  grid.classList.add('stagger');
  const io = new IntersectionObserver(function (en) {
    if (en[0].isIntersecting) { grid.classList.add('in'); io.disconnect(); }
  }, { threshold: 0.15 });
  io.observe(grid);
})();
