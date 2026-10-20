import Lenis from 'lenis';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

let lenisInstance = null;

export function initLenis() {
  const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

  // Initialize Lenis with natural, responsive inertia
  lenisInstance = new Lenis({
    duration: 1.05,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Apple-style smooth decay
    orientation: 'vertical',
    gestureOrientation: 'vertical',
    smoothWheel: true,
    wheelMultiplier: 0.95,
    touchMultiplier: 1.0,
    syncTouch: true,
    syncTouchLerp: 0.1,
    infinite: false,
  });

  // Synchronize Lenis scroll with GSAP ScrollTrigger
  lenisInstance.on('scroll', ScrollTrigger.update);
  window.addEventListener('scroll', () => ScrollTrigger.update(), { passive: true });

  // Drive Lenis RAF through GSAP's optimized ticker
  gsap.ticker.add((time) => {
    lenisInstance.raf(time * 1000);
  });

  // Clamps large delta leaps on device stutter (prevents violent frame skips)
  gsap.ticker.lagSmoothing(500, 33);

  window.__lenis = lenisInstance;
  window.ScrollTrigger = ScrollTrigger;

  return lenisInstance;
}

export function getLenis() {
  return lenisInstance;
}