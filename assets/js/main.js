/* ==========================================================================
   Deccan Malti Hospital — main.js
   Vanilla JS + Swiper + GSAP (ScrollTrigger) — progressive enhancement.
   ========================================================================== */
(function () {
  'use strict';

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const $ = (sel, ctx) => (ctx || document).querySelector(sel);
  const $$ = (sel, ctx) => Array.from((ctx || document).querySelectorAll(sel));

  /* ---------- Header scroll state ---------- */
  const header = $('#site-header');
  let scrollTick = false;
  const onScrollHeader = () => {
    if (!header || scrollTick) return;
    scrollTick = true;
    window.requestAnimationFrame(() => {
      header.classList.toggle('is-scrolled', window.scrollY > 8);
      scrollTick = false;
    });
  };
  onScrollHeader();
  window.addEventListener('scroll', onScrollHeader, { passive: true });

  /* ---------- Mega menus (hover + keyboard) ---------- */
  const megaWrap = $('#megaWrap');
  const megaTriggers = $$('[data-mega-trigger]');
  let megaHideTimer = null;

  function positionMega(trigger) {
    if (!megaWrap || !trigger || !header) return;
    const menuWidth = megaWrap.getBoundingClientRect().width;
    if (!menuWidth) return;
    const headerRect = header.getBoundingClientRect();
    const triggerRect = trigger.getBoundingClientRect();
    const minLeft = 16;
    const maxLeft = Math.max(minLeft, window.innerWidth - menuWidth - 16);
    const viewportLeft = Math.min(
      maxLeft,
      Math.max(minLeft, triggerRect.left + triggerRect.width / 2 - menuWidth / 2)
    );
    megaWrap.style.left = `${Math.round(viewportLeft - headerRect.left)}px`;
  }

  function openMega(name, trigger) {
    if (!megaWrap) return;
    clearTimeout(megaHideTimer);
    megaWrap.hidden = false;
    megaWrap.dataset.menu = name;
    $$('.mega', megaWrap).forEach(m => m.classList.toggle('is-active', m.dataset.mega === name));
    megaTriggers.forEach(t => {
      const on = t.dataset.megaTrigger === name;
      t.setAttribute('aria-expanded', on ? 'true' : 'false');
      t.closest('.has-mega') && t.closest('.has-mega').classList.toggle('is-open', on);
    });
    positionMega(trigger || megaTriggers.find(t => t.dataset.megaTrigger === name));
    requestAnimationFrame(() => megaWrap.classList.add('is-visible'));
  }
  function closeMega(delay) {
    if (!megaWrap) return;
    clearTimeout(megaHideTimer);
    megaHideTimer = setTimeout(() => {
      megaWrap.classList.remove('is-visible');
      megaTriggers.forEach(t => {
        t.setAttribute('aria-expanded', 'false');
        t.closest('.has-mega') && t.closest('.has-mega').classList.remove('is-open');
      });
      setTimeout(() => {
        if (!megaWrap.classList.contains('is-visible')) {
          megaWrap.hidden = true;
          megaWrap.style.left = '';
          delete megaWrap.dataset.menu;
        }
      }, 420);
    }, delay ?? 120);
  }
  megaTriggers.forEach(trigger => {
    const item = trigger.closest('.has-mega');
    if (!item) return;
    item.addEventListener('pointerenter', () => openMega(trigger.dataset.megaTrigger, trigger));
    item.addEventListener('pointerleave', () => closeMega());
    trigger.addEventListener('focus', () => openMega(trigger.dataset.megaTrigger, trigger));
    trigger.addEventListener('keydown', e => {
      if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openMega(trigger.dataset.megaTrigger, trigger);
        const firstLink = megaWrap && megaWrap.querySelector('.mega.is-active a');
        firstLink && firstLink.focus();
      }
    });
    trigger.addEventListener('click', e => {
      // Keyboard users: first click opens menu instead of navigating
      if (megaWrap && !megaWrap.classList.contains('is-visible')) {
        e.preventDefault();
        openMega(trigger.dataset.megaTrigger, trigger);
      }
    });
  });
  if (megaWrap) {
    megaWrap.addEventListener('pointerenter', () => clearTimeout(megaHideTimer));
    megaWrap.addEventListener('pointerleave', () => closeMega());
    document.addEventListener('click', e => {
      if (!megaWrap.contains(e.target) && !e.target.closest('.has-mega')) closeMega(0);
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMega(0); });
    window.addEventListener('resize', () => {
      if (megaWrap.hidden || !megaWrap.classList.contains('is-visible')) return;
      const activeTrigger = megaTriggers.find(t => t.getAttribute('aria-expanded') === 'true');
      positionMega(activeTrigger);
    });
    document.addEventListener('focusin', e => {
      if (!megaWrap.contains(e.target) && !e.target.closest('.has-mega')) closeMega(0);
    });
  }

  /* ---------- Hospital gallery filters and full-frame lightbox ---------- */
  const gallery = $('#hospitalGallery');
  const galleryDialog = $('#galleryLightbox');
  if (gallery && galleryDialog) {
    const galleryFigures = $$('[data-gallery-category]', gallery);
    const galleryFilterButtons = $$('[data-gallery-filter]');
    const lightboxImage = $('#galleryLightboxImage');
    const lightboxCaption = $('#galleryLightboxCaption');
    const lightboxPosition = $('#galleryLightboxPosition');
    let lightboxIndex = 0;
    const closeGalleryDialog = () => {
      if (typeof galleryDialog.close === 'function') galleryDialog.close();
      else galleryDialog.removeAttribute('open');
    };

    galleryFilterButtons.forEach(button => {
      button.addEventListener('click', () => {
        const category = button.dataset.galleryFilter;
        galleryFilterButtons.forEach(item => {
          const active = item === button;
          item.classList.toggle('is-active', active);
          item.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
        galleryFigures.forEach(figure => {
          figure.hidden = category !== 'all' && figure.dataset.galleryCategory !== category;
        });
      });
    });

    const visibleGalleryTriggers = () =>
      $$('[data-gallery-open]', gallery).filter(trigger => !trigger.closest('figure').hidden);

    const showGalleryImage = index => {
      const visible = visibleGalleryTriggers();
      if (!visible.length) return;
      lightboxIndex = (index + visible.length) % visible.length;
      const trigger = visible[lightboxIndex];
      lightboxImage.src = trigger.dataset.galleryFull;
      lightboxImage.alt = trigger.dataset.galleryAlt || '';
      lightboxCaption.textContent = trigger.dataset.galleryCaption || '';
      lightboxPosition.textContent = `${lightboxIndex + 1} of ${visible.length}`;
    };

    gallery.addEventListener('click', event => {
      const trigger = event.target.closest('[data-gallery-open]');
      if (!trigger) return;
      const visible = visibleGalleryTriggers();
      const index = visible.indexOf(trigger);
      if (index < 0) return;
      showGalleryImage(index);
      if (typeof galleryDialog.showModal === 'function') galleryDialog.showModal();
      else galleryDialog.setAttribute('open', '');
    });

    $('[data-gallery-close]', galleryDialog)?.addEventListener('click', closeGalleryDialog);
    $('[data-gallery-prev]', galleryDialog)?.addEventListener('click', () => showGalleryImage(lightboxIndex - 1));
    $('[data-gallery-next]', galleryDialog)?.addEventListener('click', () => showGalleryImage(lightboxIndex + 1));
    galleryDialog.addEventListener('click', event => {
      if (event.target === galleryDialog) closeGalleryDialog();
    });
    galleryDialog.addEventListener('keydown', event => {
      if (event.key === 'ArrowLeft') {
        event.preventDefault();
        showGalleryImage(lightboxIndex - 1);
      } else if (event.key === 'ArrowRight') {
        event.preventDefault();
        showGalleryImage(lightboxIndex + 1);
      }
    });
  }

  /* ---------- Mega menu image preview (departments) ---------- */
  const preview = $('#megaPreview');
  if (preview) {
    const pImg = $('#megaPreviewImg');
    const pTitle = $('#megaPreviewTitle');
    const pSummary = $('#megaPreviewSummary');
    const loader = {};
    $$('.mega__dept-link[data-preview-image]').forEach(link => {
      const show = () => {
        $$('.mega__dept-link').forEach(l => l.classList.remove('is-active'));
        link.classList.add('is-active');
        const { previewTitle, previewSummary, previewImage, previewUrl } = link.dataset;
        preview.href = previewUrl;
        preview.classList.add('is-fading');
        setTimeout(() => {
          pTitle.textContent = previewTitle;
          pSummary.textContent = previewSummary;
          if (loader[previewImage]) {
            pImg.src = previewImage;
            pImg.alt = previewTitle;
            preview.classList.remove('is-fading');
          } else {
            const tmp = new Image();
            tmp.onload = () => { loader[previewImage] = true; pImg.src = previewImage; pImg.alt = previewTitle; preview.classList.remove('is-fading'); };
            tmp.onerror = () => preview.classList.remove('is-fading');
            tmp.src = previewImage;
          }
        }, 160);
      };
      link.addEventListener('mouseenter', show);
      link.addEventListener('focus', show);
      link.addEventListener('touchstart', show, { passive: true });
    });
  }

  /* ---------- Mobile drawer ---------- */
  const drawer = $('#mobileDrawer');
  const menuToggle = $('#menuToggle');
  let drawerLastFocus = null;
  function setDrawer(open) {
    if (!drawer) return;
    if (open) drawerLastFocus = document.activeElement;
    drawer.classList.toggle('is-open', open);
    drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
    menuToggle && menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.style.overflow = open ? 'hidden' : '';
    if (open) {
      const focusTarget = drawer.querySelector('.drawer__close') || drawer.querySelector('a');
      window.setTimeout(() => focusTarget && focusTarget.focus(), 40);
    } else if (drawerLastFocus && typeof drawerLastFocus.focus === 'function') {
      drawerLastFocus.focus();
    }
  }
  menuToggle && menuToggle.addEventListener('click', () => setDrawer(true));
  $$('[data-drawer-close]').forEach(el => el.addEventListener('click', () => setDrawer(false)));
  $$('.drawer__nav a').forEach(link => link.addEventListener('click', () => setDrawer(false)));
  document.addEventListener('keydown', e => {
    if (!drawer || !drawer.classList.contains('is-open')) return;
    if (e.key === 'Escape') {
      setDrawer(false);
      return;
    }
    if (e.key !== 'Tab') return;
    const focusable = $$('a[href], button:not([disabled]), summary', drawer);
    if (!focusable.length) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus();
    }
  });

  /* Keep only one mobile disclosure open at a time, making long menus easier to scan. */
  $$('.drawer__group').forEach(group => {
    group.addEventListener('toggle', () => {
      if (!group.open) return;
      $$('.drawer__group').forEach(other => { if (other !== group) other.open = false; });
    });
  });

  /* ---------- Back to top ---------- */
  const btt = $('#backToTop');
  const onScrollBtt = () => {
    if (!btt) return;
    const scrolled = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight || 1);
    btt.classList.toggle('is-visible', scrolled > 0.4);
  };
  onScrollBtt();
  window.addEventListener('scroll', onScrollBtt, { passive: true });
  btt && btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: prefersReduced ? 'auto' : 'smooth' }));

  /* ---------- Hero video: pause when off-screen / tab hidden ---------- */
  const heroVideo = $('#heroVideo');
  const videoToggle = $('#videoToggle');
  function setVideoUI(playing) {
    if (videoToggle) {
      videoToggle.classList.toggle('is-playing', playing);
      videoToggle.setAttribute('aria-label', playing ? 'Pause background video' : 'Play background video');
    }
  }
  if (heroVideo) {
    setVideoUI(!heroVideo.paused);
    videoToggle && videoToggle.addEventListener('click', () => {
      if (heroVideo.paused) { heroVideo.play(); setVideoUI(true); }
      else { heroVideo.pause(); setVideoUI(false); }
    });
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(entries => {
        entries.forEach(en => {
          if (en.isIntersecting && !prefersReduced) heroVideo.play().catch(() => {});
          else heroVideo.pause();
          setVideoUI(!heroVideo.paused);
        });
      }, { threshold: 0.15 }).observe(heroVideo);
    }
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) heroVideo.pause();
      setVideoUI(!heroVideo.paused);
    });
    if (prefersReduced) { heroVideo.pause(); heroVideo.removeAttribute('autoplay'); setVideoUI(false); }
  }

  /* ---------- Swipers ---------- */
  function initSwipers() {
    if (typeof Swiper === 'undefined') return;

    if ($('.orbit-swiper')) {
      new Swiper('.orbit-swiper', {
        effect: 'fade',
        fadeEffect: { crossFade: true },
        loop: true,
        speed: 900,
        autoplay: prefersReduced ? false : { delay: 5000, disableOnInteraction: false },
        pagination: { el: '.orbit-dots', clickable: true },
        navigation: { nextEl: '.orbit-next', prevEl: '.orbit-prev' },
        a11y: { enabled: true },
      });
    }
    if ($('.doctors-swiper')) {
      new Swiper('.doctors-swiper', {
        slidesPerView: 1.1,
        spaceBetween: 20,
        breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
        pagination: { el: '.doctors-dots', clickable: true },
        navigation: { nextEl: '.doctors-next', prevEl: '.doctors-prev' },
        a11y: { enabled: true },
      });
    }
    if ($('.facilities-swiper')) {
      new Swiper('.facilities-swiper', {
        slidesPerView: 1.05,
        spaceBetween: 20,
        breakpoints: { 768: { slidesPerView: 1.6 }, 1100: { slidesPerView: 2.1 } },
        pagination: { el: '.facilities-dots', clickable: true },
        navigation: { nextEl: '.facilities-next', prevEl: '.facilities-prev' },
        a11y: { enabled: true },
      });
    }
    if ($('.testimonials-swiper')) {
      new Swiper('.testimonials-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        breakpoints: { 768: { slidesPerView: 2 } },
        autoplay: prefersReduced ? false : { delay: 6000 },
        pagination: { el: '.testimonials-dots', clickable: true },
        navigation: { nextEl: '.testimonials-next', prevEl: '.testimonials-prev' },
        a11y: { enabled: true },
      });
    }
  }
  if (document.readyState === 'complete') initSwipers();
  else window.addEventListener('load', initSwipers);

  /* ---------- Reveal on scroll ---------- */
  const revealEls = $$('.reveal');
  ['.quick-cards > .reveal', '.dept-grid > .reveal', '.bento > .reveal',
    '.insurance-steps > .reveal', '.journey__steps > .reveal'].forEach(selector => {
    $$(selector).forEach((el, index) => {
      if (!el.className.match(/reveal-delay-/)) {
        el.style.transitionDelay = `${Math.min(index, 5) * 0.08}s`;
      }
    });
  });
  if ('IntersectionObserver' in window && revealEls.length) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(en => {
        if (en.isIntersecting) { en.target.classList.add('is-revealed'); io.unobserve(en.target); }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => io.observe(el));
  } else {
    revealEls.forEach(el => el.classList.add('is-revealed'));
  }

  /* ---------- Counters ---------- */
  const counters = $$('[data-count]');
  if (counters.length && 'IntersectionObserver' in window) {
    const cio = new IntersectionObserver(entries => {
      entries.forEach(en => {
        if (!en.isIntersecting) return;
        cio.unobserve(en.target);
        const el = en.target;
        const target = parseInt(el.dataset.count, 10);
        if (prefersReduced) { el.textContent = target; return; }
        const dur = 1600, start = performance.now();
        (function tick(now) {
          const p = Math.min((now - start) / dur, 1);
          el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
          if (p < 1) requestAnimationFrame(tick);
        })(start);
      });
    }, { threshold: 0.5 });
    counters.forEach(el => cio.observe(el));
  }

  /* ---------- Journey line fill ---------- */
  const journeyFill = $('.journey__line-fill');
  if (journeyFill && 'IntersectionObserver' in window) {
    new IntersectionObserver((entries, obs) => {
      entries.forEach(en => {
        if (en.isIntersecting) { journeyFill.style.width = '100%'; obs.disconnect(); }
      });
    }, { threshold: 0.4 }).observe(journeyFill.closest('.journey'));
  } else if (journeyFill) {
    journeyFill.style.width = '100%';
  }

  /* ---------- GSAP flourishes (guarded) ---------- */
  if (typeof gsap !== 'undefined' && !prefersReduced) {
    if (typeof ScrollTrigger !== 'undefined') gsap.registerPlugin(ScrollTrigger);
    $$('.about-media__img, .neuro-visual, .page-hero__img').forEach(el => {
      gsap.fromTo(el, { clipPath: 'inset(8% 8% 8% 8% round 28px)', opacity: .4 }, {
        clipPath: 'inset(0% 0% 0% 0% round 28px)', opacity: 1, duration: 1.1, ease: 'power2.out',
        scrollTrigger: { trigger: el, start: 'top 82%' },
      });
    });
  }

  /* ---------- Department filter (home explorer) ---------- */
  const deptFilter = $('.dept-filter');
  const deptMarquee = $('[data-dept-marquee]');
  if (deptMarquee && !prefersReduced) {
    const track = $('.dept-marquee__track', deptMarquee);
    const original = $('.dept-marquee__group', deptMarquee);
    if (track && original) {
      const copy = original.cloneNode(true);
      copy.setAttribute('aria-hidden', 'true');
      copy.inert = true;
      copy.querySelectorAll('.dept-card').forEach(card => {
        card.classList.add('is-revealed');
        card.style.transitionDelay = '0s';
      });
      track.appendChild(copy);
      deptMarquee.classList.add('is-looping');
    }
  }

  if (deptFilter) {
    deptFilter.addEventListener('click', e => {
      const btn = e.target.closest('button[data-filter]');
      if (!btn) return;
      $$('button', deptFilter).forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');
      const f = btn.dataset.filter;
      $$('.dept-marquee .dept-card').forEach(card => {
        const show = f === 'all' || card.dataset.group === f;
        card.style.display = show ? '' : 'none';
      });
    });
  }

  /* ---------- Doctor directory search/filter ---------- */
  const doctorSearch = $('#doctorSearch');
  if (doctorSearch) {
    const deptSel = $('#doctorDeptFilter');
    const apply = () => {
      const q = doctorSearch.value.trim().toLowerCase();
      const dept = deptSel ? deptSel.value : 'all';
      $$('.doctor-directory .doctor-card-wrap').forEach(wrap => {
        const name = wrap.dataset.name || '';
        const spec = wrap.dataset.spec || '';
        const okQ = !q || name.includes(q) || spec.includes(q);
        const okD = dept === 'all' || wrap.dataset.dept === dept;
        wrap.style.display = okQ && okD ? '' : 'none';
      });
    };
    doctorSearch.addEventListener('input', apply);
    deptSel && deptSel.addEventListener('change', apply);
  }

  /* ---------- AJAX forms ---------- */
  $$('form[data-ajax]').forEach(form => {
    form.addEventListener('submit', async e => {
      e.preventDefault();
      const status = form.querySelector('.form-status') || $('#' + form.dataset.statusTarget);
      const btn = form.querySelector('button[type="submit"]');
      const original = btn ? btn.innerHTML : '';
      // client-side required check
      let valid = true;
      $$('[required]', form).forEach(field => {
        const wrap = field.closest('.form-field');
        const ok = field.type === 'checkbox' ? field.checked : field.value.trim() !== '';
        wrap && wrap.classList.toggle('has-error', !ok);
        if (!ok) valid = false;
      });
      if (!valid) {
        status && (status.className = 'form-status is-error', status.innerHTML = '<strong>Please check the form.</strong>Some required fields are missing.');
        return;
      }
      btn && (btn.disabled = true, btn.innerHTML = 'Sending…');
      try {
        const resp = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'fetch' } });
        const data = await resp.json();
        if (status) {
          status.className = 'form-status ' + (data.ok ? 'is-success' : 'is-error');
          status.innerHTML = data.message;
          status.scrollIntoView({ behavior: prefersReduced ? 'auto' : 'smooth', block: 'nearest' });
        }
        if (data.ok) form.reset();
      } catch (err) {
        status && (status.className = 'form-status is-error', status.innerHTML = '<strong>Something went wrong.</strong>Please try again or call us directly.');
      }
      btn && (btn.disabled = false, btn.innerHTML = original);
    });
  });

  /* ---------- Newsletter (footer) ---------- */
  const nlForm = $('#newsletterForm');
  if (nlForm) {
    nlForm.addEventListener('submit', async e => {
      e.preventDefault();
      const msg = $('#newsletterMsg');
      try {
        const resp = await fetch(nlForm.dataset.action || '/api/newsletter.php', { method: 'POST', body: new FormData(nlForm) });
        const data = await resp.json();
        msg.textContent = data.message.replace(/<[^>]*>/g, '');
        msg.className = 'footer__form-msg ' + (data.ok ? 'is-success' : 'is-error');
        if (data.ok) nlForm.reset();
      } catch (err) {
        msg.textContent = 'Something went wrong. Please try again.';
        msg.className = 'footer__form-msg is-error';
      }
    });
  }
})();
