$(function () {
  AOS.init({ once: true, duration: 750, easing: 'ease-out-cubic', offset: 60 });

  const themeStorageKey = 'renew-theme';
  const $themeStylesheet = $('#renew-design-css');
  const $themeToggle = $('#themeToggle');

  function setTheme(theme) {
    const isOrange = theme === 'orange';
    $themeStylesheet.attr('href', RenewTheme.assetUrl + 'css/' + (isOrange ? 'style-orange.css' : 'style.css'));
    $themeToggle.attr({
      'aria-pressed': isOrange,
      'aria-label': isOrange ? 'Switch to purple theme' : 'Switch to orange theme'
    });
    $themeToggle.find('span').text(isOrange ? 'Purple' : 'Orange');
    $themeToggle.toggleClass('is-orange', isOrange);
    localStorage.setItem(themeStorageKey, isOrange ? 'orange' : 'purple');
  }

  setTheme(localStorage.getItem(themeStorageKey) || 'purple');

  $themeToggle.on('click', function () {
    setTheme($(this).hasClass('is-orange') ? 'purple' : 'orange');
  });

  function updateActiveNav() {
    const marker = $(window).scrollTop() + $('.renew-nav').outerHeight() + 80;
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
      $('html, body').animate({ scrollTop: $(target).offset().top - 72 }, 650);
      $('.navbar-collapse').collapse('hide');
    }
  });

  $('.back-top').on('click', () => $('html, body').animate({scrollTop: 0}, 650));

  $('#partnerEnquiryModal').on('show.bs.modal', function (event) {
    const partner = $(event.relatedTarget).data('partner');
    const $modal = $(this);
    $modal.find('[name="business"]').val(partner);
    $modal.find('.modal-title').text(`Partner with ${partner}`);
    $modal.find('.partner-enquiry-intro').text(`Share your interest in partnering with ${partner}.`);
    $modal.find('#partnerFormMessage').text('');
  });

  // Animated counters
  let countersDone = false;
  function animateCounters() {
    if (countersDone) return;
    const statsTop = $('.stats-strip').offset().top - window.innerHeight + 100;
    if ($(window).scrollTop() > statsTop) {
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
