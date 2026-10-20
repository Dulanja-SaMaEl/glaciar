import { gsap } from 'gsap';

export function initInteractions() {
  const isDesktop = window.matchMedia('(pointer: fine)').matches && window.innerWidth >= 1024;

  // 1. Product Card 3D Depth on Hover (Desktop Only)
  if (isDesktop) {
    const cards = document.querySelectorAll('.gl-card-3d');
    cards.forEach(card => {
      const image = card.querySelector('.product-card-image');

      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;

        const rotX = (y / (rect.height / 2)) * -4; // Subtle max 4 deg
        const rotY = (x / (rect.width / 2)) * 4;

        gsap.to(card, {
          rotateX: rotX,
          rotateY: rotY,
          transformPerspective: 900,
          duration: 0.3,
          ease: 'power1.out',
          overwrite: 'auto',
        });

        if (image) {
          gsap.to(image, {
            scale: 1.05,
            x: (x / rect.width) * 8,
            y: (y / rect.height) * 8,
            duration: 0.4,
            ease: 'power1.out',
            overwrite: 'auto',
          });
        }
      });

      card.addEventListener('mouseleave', () => {
        gsap.to(card, {
          rotateX: 0,
          rotateY: 0,
          duration: 0.6,
          ease: 'cubic-bezier(0.16, 1, 0.3, 1)',
          overwrite: 'auto',
        });
        if (image) {
          gsap.to(image, {
            scale: 1.0,
            x: 0,
            y: 0,
            duration: 0.6,
            ease: 'cubic-bezier(0.16, 1, 0.3, 1)',
            overwrite: 'auto',
          });
        }
      });
    });
  }

  // 2. Add-to-Cart Feedback & Navbar Counter Pulse
  const addForms = document.querySelectorAll('form[action*="cart/add"]');
  addForms.forEach(form => {
    form.addEventListener('submit', function() {
      const submitBtn = form.querySelector('button[type="submit"]');
      const cartBadge = document.querySelector('#nav-cart-badge');

      if (submitBtn) {
        const originalHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
          <span class="inline-flex items-center gap-2">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Adding...
          </span>
        `;

        setTimeout(() => {
          if (cartBadge) {
            cartBadge.classList.add('scale-125', 'bg-glaciar-ice', 'text-glaciar-obsidian');
            setTimeout(() => {
              cartBadge.classList.remove('scale-125');
            }, 400);
          }
        }, 300);
      }
    });
  });

  // 3. Single Product Gallery Thumbnail Smooth Switch
  const thumbnails = document.querySelectorAll('[data-gallery-thumb]');
  const mainImage = document.querySelector('#main-product-image');
  if (thumbnails.length > 0 && mainImage) {
    thumbnails.forEach(thumb => {
      thumb.addEventListener('click', () => {
        const newSrc = thumb.getAttribute('data-src');
        if (newSrc && mainImage.src !== newSrc) {
          gsap.to(mainImage, {
            opacity: 0,
            scale: 0.98,
            duration: 0.2,
            onComplete: () => {
              mainImage.src = newSrc;
              gsap.to(mainImage, {
                opacity: 1,
                scale: 1,
                duration: 0.35,
                ease: 'power2.out',
              });
            }
          });
          thumbnails.forEach(t => t.classList.remove('border-glaciar-ice', 'opacity-100'));
          thumb.classList.add('border-glaciar-ice', 'opacity-100');
        }
      });
    });
  }
}