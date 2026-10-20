import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initScrollStory() {
  // 1. Top Scroll Progress Indicator
  const progressBar = document.querySelector('.gl-scroll-progress');
  if (progressBar) {
    window.addEventListener('scroll', () => {
      const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = height > 0 ? winScroll / height : 0;
      progressBar.style.transform = `scaleX(${scrolled})`;
    }, { passive: true });
  }

  // 2. Navigation Scroll Behavior (Solid on scroll, hide on fast down, show on up)
  const nav = document.querySelector('#customer-nav');
  if (nav) {
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
      const currentScroll = window.scrollY;
      if (currentScroll > 40) {
        nav.classList.add('nav-scrolled');
      } else {
        nav.classList.remove('nav-scrolled');
      }

      if (currentScroll > 400 && currentScroll > lastScroll + 10) {
        nav.classList.add('nav-hidden');
      } else if (currentScroll < lastScroll - 5) {
        nav.classList.remove('nav-hidden');
      }
      lastScroll = currentScroll;
    }, { passive: true });
  }

  // 3. Fast Page Load Veil Dismissal (<600ms)
  const veil = document.querySelector('.gl-page-veil');
  if (veil) {
    const dismissVeil = () => {
      veil.classList.add('veil-hidden');
      setTimeout(() => veil.remove(), 700);
    };
    if (document.readyState === 'complete') {
      setTimeout(dismissVeil, 200);
    } else {
      window.addEventListener('load', () => setTimeout(dismissVeil, 200));
      setTimeout(dismissVeil, 800);
    }
  }

  // 4. Guaranteed IntersectionObserver Reveal System (gym_1 Proven Architecture)
  const sections = Array.from(document.querySelectorAll('.gl-section-reveal'));
  const standaloneItems = Array.from(document.querySelectorAll(
    '.gl-reveal-item:not(.gl-section-reveal .gl-reveal-item), .gl-reveal-up, .gl-ice-reveal'
  ));

  if (!sections.length && !standaloneItems.length) return;

  // Uses IntersectionObserver with threshold: 0 and rootMargin: '0px 0px -10% 0px' (identically matching gym_1).
  // Elements are primed hidden with gentle transform, and smoothly cascade as the user scrolls them 10% into view.
  sections.forEach(sec => {
    const header = sec.querySelector('.gl-section-header');
    const items = Array.from(sec.querySelectorAll('.gl-reveal-item'));
    const elementsToAnimate = [sec, header, ...items].filter(Boolean);

    // Initial hidden state
    gsap.set(sec, { autoAlpha: 0, y: 36 });
    if (header) gsap.set(header, { autoAlpha: 0, y: 24 });
    if (items.length) gsap.set(items, { autoAlpha: 0, y: 28 });

    const playSectionAnimation = () => {
      if (sec.dataset.glRevealed === 'true') return;
      sec.dataset.glRevealed = 'true';
      sec.classList.add('is-inview', 'revealed');

      const tl = gsap.timeline({
        defaults: { ease: 'power2.out' },
        onComplete: () => {
          gsap.set(elementsToAnimate, { clearProps: 'transform,willChange' });
        }
      });

      tl.to(sec, { autoAlpha: 1, y: 0, duration: 1.0, overwrite: 'auto' });
      if (header) {
        tl.to(header, { autoAlpha: 1, y: 0, duration: 0.9 }, '-=0.75');
      }
      if (items.length) {
        tl.to(items, { autoAlpha: 1, y: 0, duration: 0.85, stagger: 0.1 }, header ? '-=0.65' : '-=0.75');
      }
    };

    if (typeof IntersectionObserver !== 'undefined') {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            playSectionAnimation();
            observer.unobserve(entry.target);
          }
        });
      }, {
        root: null,
        rootMargin: '0px 0px -10% 0px',
        threshold: 0,
      });

      observer.observe(sec);
    } else {
      playSectionAnimation();
    }
  });

  standaloneItems.forEach(el => {
    gsap.set(el, { autoAlpha: 0, y: 28 });

    const playStandaloneAnimation = () => {
      if (el.dataset.glRevealed === 'true') return;
      el.dataset.glRevealed = 'true';
      el.classList.add('is-inview', 'revealed');

      gsap.to(el, {
        autoAlpha: 1,
        y: 0,
        duration: 0.9,
        ease: 'power2.out',
        overwrite: 'auto',
        onComplete: () => gsap.set(el, { clearProps: 'transform,willChange' })
      });
    };

    if (typeof IntersectionObserver !== 'undefined') {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            playStandaloneAnimation();
            observer.unobserve(entry.target);
          }
        });
      }, {
        root: null,
        rootMargin: '0px 0px -10% 0px',
        threshold: 0,
      });

      observer.observe(el);
    } else {
      playStandaloneAnimation();
    }
  });

  // 5. Signature Bottle Specular Shimmer Sweep on Scroll
  const shimmerTriggers = document.querySelectorAll('.gl-shimmer-trigger');
  if (shimmerTriggers.length > 0 && typeof IntersectionObserver !== 'undefined') {
    const shimmerObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const sweepTargets = entry.target.querySelectorAll('.gl-shimmer-sweep');
          sweepTargets.forEach(target => {
            target.classList.remove('shimmer-active');
            void target.offsetWidth;
            target.classList.add('shimmer-active');
          });
        }
      });
    }, { rootMargin: '0px 0px -15% 0px', threshold: 0 });

    shimmerTriggers.forEach(t => shimmerObserver.observe(t));
  }

  // 6. Sticky Technology Storytelling Section (Section 4: "ENGINEERED FOR EVERY DROP")
  const techSection = document.querySelector('#technology');
  if (techSection && window.innerWidth >= 1024) {
    const pinnedStage = techSection.querySelector('.tech-pinned-stage');
    const specItems = techSection.querySelectorAll('.tech-spec-item');

    if (pinnedStage && specItems.length > 0) {
      specItems.forEach((item, index) => {
        ScrollTrigger.create({
          trigger: item,
          start: 'top 55%',
          end: 'bottom 45%',
          onEnter: () => activateSpecItem(item, index, pinnedStage),
          onEnterBack: () => activateSpecItem(item, index, pinnedStage),
        });
      });
    }
  }

  function activateSpecItem(item, index, pinnedStage) {
    const allItems = item.parentElement.querySelectorAll('.tech-spec-item');
    allItems.forEach(el => el.classList.remove('border-cyan-400', 'bg-white/[0.08]', 'shadow-[0_0_30px_rgba(56,189,248,0.15)]'));
    item.classList.add('border-cyan-400', 'bg-white/[0.08]', 'shadow-[0_0_30px_rgba(56,189,248,0.15)]');

    const bottle = pinnedStage.querySelector('.tech-pinned-bottle');
    if (bottle) {
      gsap.to(bottle, {
        scale: 1.03,
        duration: 0.4,
        ease: 'power2.out',
        yoyo: true,
        repeat: 1,
      });
      const shimmer = pinnedStage.querySelector('.gl-shimmer-sweep');
      if (shimmer) {
        shimmer.classList.remove('shimmer-active');
        void shimmer.offsetWidth;
        shimmer.classList.add('shimmer-active');
      }
    }
  }

  // 7. Parallax Floating Elements
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const parallaxLayers = document.querySelectorAll('[data-parallax]');
  if (parallaxLayers.length > 0 && !prefersReduced) {
    parallaxLayers.forEach(layer => {
      const speed = parseFloat(layer.getAttribute('data-parallax')) || 0.1;
      gsap.to(layer, {
        y: () => -window.innerHeight * speed,
        ease: 'none',
        scrollTrigger: {
          trigger: layer,
          start: 'top bottom',
          end: 'bottom top',
          scrub: true,
          invalidateOnRefresh: true,
        }
      });
    });
  }
}
