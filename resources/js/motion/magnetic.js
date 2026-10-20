import { gsap } from 'gsap';

export function initMagnetic() {
  if (!window.matchMedia('(pointer: fine)').matches || window.innerWidth < 1024) {
    return;
  }

  const magneticElements = document.querySelectorAll('.gl-magnetic');

  magneticElements.forEach((el) => {
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const relX = e.clientX - rect.left - rect.width / 2;
      const relY = e.clientY - rect.top - rect.height / 2;

      // Restrained magnetic attraction (max 8px)
      const moveX = relX * 0.22;
      const moveY = relY * 0.22;

      gsap.to(el, {
        x: moveX,
        y: moveY,
        duration: 0.3,
        ease: 'power2.out',
        overwrite: 'auto',
      });
    });

    el.addEventListener('mouseleave', () => {
      gsap.to(el, {
        x: 0,
        y: 0,
        duration: 0.6,
        ease: 'elastic.out(1, 0.4)',
        overwrite: 'auto',
      });
    });
  });
}