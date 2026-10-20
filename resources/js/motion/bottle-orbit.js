/**
 * GLACIAR — Dual-Bottle 3D Orbital Scroll Engine
 * Choreographs two bottles rotating around each other in 3D depth on scroll
 */
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initBottleOrbit() {
  const orbitStage = document.getElementById('glaciar-orbit-stage');
  const scrollTrack = document.getElementById('glaciar-scroll-track');
  const bottleAlpha = document.getElementById('gl-bottle-alpha');
  const bottleBeta = document.getElementById('gl-bottle-beta');

  if (!orbitStage || !scrollTrack || !bottleAlpha || !bottleBeta) return;

  const isMobile = window.innerWidth < 1024;

  // 1. Initial Position (Exact match to reference image)
  // On desktop, bottles sit on the right half of the hero (x: +120px to +300px)
  // On mobile, centered with comfortable spacing
  const initAlpha = {
    x: isMobile ? -30 : 120,
    y: isMobile ? 15 : 20,
    scale: isMobile ? 0.88 : 1.0,
    rotateZ: -16,
    rotateX: 4,
    rotateY: -10,
    zIndex: 30,
    opacity: 1,
  };

  const initBeta = {
    x: isMobile ? 65 : 300,
    y: isMobile ? -30 : -45,
    scale: isMobile ? 0.64 : 0.73,
    rotateZ: -10,
    rotateX: 2,
    rotateY: 8,
    zIndex: 15,
    opacity: 1,
  };

  gsap.set(bottleAlpha, initAlpha);
  gsap.set(bottleBeta, initBeta);
  gsap.set(orbitStage, { opacity: 1, visibility: 'visible' });

  // 2. Track Visibility Controller: Show orbit stage only during scrollTrack
  ScrollTrigger.create({
    trigger: scrollTrack,
    start: 'top top',
    end: 'bottom top+=15%',
    onEnter: () => {
      gsap.to(orbitStage, { opacity: 1, visibility: 'visible', duration: 0.35 });
    },
    onLeave: () => {
      gsap.to(orbitStage, { opacity: 0, duration: 0.35, onComplete: () => {
        orbitStage.style.visibility = 'hidden';
      }});
    },
    onEnterBack: () => {
      orbitStage.style.visibility = 'visible';
      gsap.to(orbitStage, { opacity: 1, duration: 0.35 });
    },
    onLeaveBack: () => {
      gsap.to(orbitStage, { opacity: 1, visibility: 'visible', duration: 0.35 });
    },
  });

  // 3. Continuous 3D Orbital Revolution Timeline scrubbed by ScrollTrigger
  const orbitTimeline = gsap.timeline({
    scrollTrigger: {
      trigger: scrollTrack,
      start: 'top top',
      end: 'bottom top+=15%',
      scrub: 0.6,
      invalidateOnRefresh: true,
    }
  });

  // ─── PHASE 1 (Scroll 0.0 -> 0.42): First Orbital Half-Turn ───
  // Bottles swap positions & depth!
  // Bottle Alpha sweeps backward and to the right
  orbitTimeline.to(bottleAlpha, {
    x: isMobile ? 55 : 300,
    y: isMobile ? -25 : -40,
    scale: isMobile ? 0.65 : 0.74,
    rotateZ: -6,
    rotateY: 14,
    ease: 'power1.inOut',
  }, 0);

  // Bottle Beta swings forward across the front to the left!
  orbitTimeline.to(bottleBeta, {
    x: isMobile ? -45 : 105,
    y: isMobile ? 25 : 35,
    scale: isMobile ? 0.92 : 1.08,
    rotateZ: -18,
    rotateY: -14,
    ease: 'power1.inOut',
  }, 0);

  // Swap depth: Alpha goes behind Beta
  orbitTimeline.set(bottleAlpha, { zIndex: 15 }, 0.22);
  orbitTimeline.set(bottleBeta, { zIndex: 30 }, 0.22);

  // ─── PHASE 2 (Scroll 0.42 -> 0.88): Alpine Nature Sanctuary Gliding ───
  // Both bottles arc across the rushing glacial river backdrop
  orbitTimeline.to(bottleAlpha, {
    x: isMobile ? -45 : 60,
    y: isMobile ? 35 : 65,
    scale: isMobile ? 0.86 : 0.96,
    rotateZ: -12,
    rotateY: -6,
    ease: 'power1.inOut',
  }, 0.42);

  orbitTimeline.to(bottleBeta, {
    x: isMobile ? 60 : 270,
    y: isMobile ? -40 : -60,
    scale: isMobile ? 0.70 : 0.78,
    rotateZ: 8,
    rotateY: 12,
    ease: 'power1.inOut',
  }, 0.42);

  // Swap depth: Alpha swings forward again
  orbitTimeline.set(bottleAlpha, { zIndex: 30 }, 0.62);
  orbitTimeline.set(bottleBeta, { zIndex: 15 }, 0.62);

  // ─── PHASE 3 (Scroll 0.88 -> 1.0): Gentle Fade Landing as Technology Enters ───
  orbitTimeline.to(bottleAlpha, {
    x: isMobile ? 0 : 150,
    y: isMobile ? 20 : 40,
    scale: isMobile ? 0.78 : 0.88,
    rotateZ: 0,
    rotateY: 0,
    opacity: 0,
    ease: 'power2.out',
  }, 0.88);

  orbitTimeline.to(bottleBeta, {
    x: isMobile ? 65 : 280,
    y: isMobile ? -20 : -30,
    scale: isMobile ? 0.58 : 0.68,
    rotateZ: 4,
    rotateY: 5,
    opacity: 0,
    ease: 'power2.out',
  }, 0.88);

  // 4. Desktop Interactive Weightless Cursor Parallax
  if (!isMobile) {
    const stageContainer = document.getElementById('glaciar-orbit-stage');
    if (stageContainer) {
      window.addEventListener('pointermove', (e) => {
        const mouseX = (e.clientX / window.innerWidth) - 0.5;
        const mouseY = (e.clientY / window.innerHeight) - 0.5;

        gsap.to(stageContainer, {
          rotateY: mouseX * 8,
          rotateX: -mouseY * 5,
          transformPerspective: 1200,
          duration: 0.7,
          ease: 'power1.out',
          overwrite: 'auto',
        });
      }, { passive: true });
    }
  }
}