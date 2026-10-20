import './bootstrap';
import Alpine from 'alpinejs';

import { initLenis } from './motion/lenis';
import { initMagnetic } from './motion/magnetic';
import { initHeroMotion } from './motion/hero';
import { initScrollStory } from './motion/scroll-story';
import { initInteractions } from './motion/interactions';
import { initWaterCanvas } from './motion/water-canvas';
import { init3DScrollEngine } from './motion/3d-scroll-engine';

window.Alpine = Alpine;
Alpine.start();

// Initialize Glaciar Motion Engine on DOMContentLoaded (Customer Portal & Marketing Only)
document.addEventListener('DOMContentLoaded', () => {
  // Never hijack cursor, scroll, or canvas in the admin dashboard
  if (window.location.pathname.startsWith('/admin')) {
    return;
  }

  // Smooth scroll
  initLenis();

  // Magnetic CTA buttons
  initMagnetic();

  // Real-time interactive water ripple & caustic engine
  initWaterCanvas();

  // Real-time 3D Apple-grade scroll journey & subterranean camera flight
  init3DScrollEngine();

  // Hero cinematic sequence and scroll transformation
  initHeroMotion();

  // Scroll storytelling, reveals, and sticky technical showcase
  initScrollStory();

  // Micro-interactions (3D card depth, gallery switch, cart pulse)
  initInteractions();
});