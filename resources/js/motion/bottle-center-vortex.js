/**
 * GLACIAR — Center-Gliding Bottle & Realistic 3D Wrapping Water Engine
 * 
 * Choreography:
 * 1. Hero Top: Bottle sits fully visible on the right side of the hero without cutoff.
 * 2. On Scroll:
 *    - Hero content layer (text, CTAs, badges, telemetry) cleanly fades up & out (0 overlap).
 *    - Bottle glides smoothly from right side to dead center (x: 0, scale: 1.18).
 * 3. 3D Water Splash Stream (matching user's reference image):
 *    - Layer Z-35: Helical 3D water splash stream encircles and rotates in 3D (rotateY: 360°, rotateZ: 25°)
 *      around the bottle, with base collar, waist curl, and crown splash!
 *    - Surface Contact: Real-time caustic reflection sheen brushes the glass cylinder,
 *      and waist + base contact rings hug the bottle contours.
 *    - Dynamic Orbit: 14 luminous water droplets orbit the cylinder in 3D space.
 * 4. Storytelling Cards: Stagger-reveal on far left and far right flanks (0 center collision).
 * 5. Desktop Cursor Parallax: 3D perspective tilt on pointer movement.
 */
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initBottleCenterVortex() {
  const stage = document.getElementById('glaciar-vortex-stage');
  const track = document.getElementById('glaciar-vortex-track');
  const bottle = document.getElementById('gl-crystal-bottle');
  const heroContentLayer = document.getElementById('gl-hero-content-layer');

  const splash3DWrap = document.getElementById('gl-3d-splash-wrap');
  const splash3DImg = document.getElementById('gl-3d-splash-img');
  const vortexWrap = document.getElementById('gl-vortex-wrap');
  const vortexImg = document.getElementById('gl-vortex-img');

  const causticSheen = document.getElementById('gl-bottle-caustic-sheen');
  const waistRing = document.getElementById('gl-waist-contact-ring');
  const baseRing = document.getElementById('gl-base-contact-ring');
  const dropletsWrap = document.getElementById('gl-orbital-droplets-wrap');

  const card1 = document.getElementById('gl-vortex-card-1');
  const card2 = document.getElementById('gl-vortex-card-2');
  const card3 = document.getElementById('gl-vortex-card-3');

  if (!stage || !track || !bottle) return;

  const isMobile = window.innerWidth < 1024;

  // 1. Initial State: Bottle fully in view on the right side at top of scroll
  // Desktop: Centered on right half (x: ~320px), vertically centered (y: -24px)
  // so the entire bottle (cap to faceted starburst base) is 100% visible with generous margin!
  const initX = isMobile ? 0 : Math.min(360, Math.max(280, window.innerWidth * 0.25));
  const initY = isMobile ? -10 : -24;
  const initScale = isMobile ? 0.85 : 0.95;

  gsap.set(bottle, {
    x: initX,
    y: initY,
    scale: initScale,
    rotateZ: 0,
    opacity: 1,
    transformPerspective: 1200,
  });

  if (heroContentLayer) {
    gsap.set(heroContentLayer, { opacity: 1, y: 0 });
  }

  // 3D Helical Splash Stream starts hidden and ready for 3D rotation
  if (splash3DWrap) {
    gsap.set(splash3DWrap, {
      opacity: 0,
      scale: 0.75,
      rotateY: -45,
      rotateZ: -10,
      transformPerspective: 1400,
    });
  }

  // Background vortex halo starts hidden
  if (vortexWrap) {
    gsap.set(vortexWrap, {
      opacity: 0,
      scale: 0.6,
      rotateZ: 0,
    });
  }

  // Surface contact elements start hidden
  if (causticSheen) gsap.set(causticSheen, { opacity: 0, x: -80 });
  if (waistRing) gsap.set(waistRing, { opacity: 0, scale: 0.8, rotateZ: -6 });
  if (baseRing) gsap.set(baseRing, { opacity: 0, scale: 0.8, rotateZ: 3 });

  // Storytelling cards start hidden
  [card1, card2, card3].forEach(card => {
    if (card) gsap.set(card, { opacity: 0, y: 30, scale: 0.95 });
  });

  // 2. Spawn Dynamic 3D Orbiting Droplets
  const droplets = [];
  if (dropletsWrap) {
    dropletsWrap.innerHTML = '';
    const dropletCount = 14;
    for (let i = 0; i < dropletCount; i++) {
      const drop = document.createElement('div');
      const size = 5 + (i % 4) * 3;
      drop.className = 'absolute rounded-full pointer-events-none will-change-transform';
      drop.style.width = `${size}px`;
      drop.style.height = `${size}px`;
      drop.style.background = 'radial-gradient(circle at 35% 35%, #ffffff 0%, #38bdf8 65%, rgba(2,132,199,0.9) 100%)';
      drop.style.boxShadow = '0 0 12px rgba(56,189,248,0.95), 0 0 4px #ffffff';
      drop.style.opacity = '0';
      dropletsWrap.appendChild(drop);

      droplets.push({
        el: drop,
        angleOffset: (i / dropletCount) * Math.PI * 2,
        radiusX: isMobile ? 120 : (170 + (i % 3) * 35),
        radiusY: isMobile ? 80 : (115 + (i % 2) * 25),
        yOffset: (i - dropletCount / 2) * 20,
      });
    }
  }

  function updateDroplets(progress) {
    if (!droplets.length) return;
    const isVisible = progress > 0.05 && progress < 0.90;
    const globalAngle = progress * Math.PI * 4;

    droplets.forEach(d => {
      if (!isVisible) {
        d.el.style.opacity = '0';
        return;
      }
      const angle = d.angleOffset + globalAngle;
      const x = Math.cos(angle) * d.radiusX;
      const y = Math.sin(angle) * d.radiusY + d.yOffset;
      const z = Math.sin(angle); // z > 0: foreground, z < 0: background

      const scale = 0.85 + (z + 1) * 0.25;
      d.el.style.transform = `translate3d(${x}px, ${y}px, 0) scale(${scale})`;
      d.el.style.zIndex = z > 0 ? 40 : 12;
      d.el.style.opacity = z > 0 ? '0.95' : '0.55';
    });
  }

  // 3. Track Visibility Manager
  ScrollTrigger.create({
    trigger: track,
    start: 'top top',
    end: 'bottom top+=10%',
    onEnter: () => gsap.to(stage, { opacity: 1, visibility: 'visible', duration: 0.3 }),
    onLeave: () => gsap.to(stage, { opacity: 0, duration: 0.35, onComplete: () => { stage.style.visibility = 'hidden'; } }),
    onEnterBack: () => {
      stage.style.visibility = 'visible';
      gsap.to(stage, { opacity: 1, duration: 0.3 });
    },
    onLeaveBack: () => gsap.to(stage, { opacity: 1, visibility: 'visible', duration: 0.3 }),
  });

  // 4. Master Scroll Scrub Timeline
  const vortexTL = gsap.timeline({
    scrollTrigger: {
      trigger: track,
      start: 'top top',
      end: 'bottom bottom',
      scrub: 0.7,
      invalidateOnRefresh: true,
      onUpdate: (self) => {
        updateDroplets(self.progress);
      }
    }
  });

  // ─── PHASE 1 (0.0 -> 0.38): Hero Exit, Centering Glide & 3D Helical Splash Wrap ───
  // A. Clean Hero Content Exit (Fades up & out, leaving stage pristine with 0 clutter)
  if (heroContentLayer) {
    vortexTL.to(heroContentLayer, {
      opacity: 0,
      y: -50,
      ease: 'power2.out',
    }, 0);
  }

  // B. Bottle glides from right side to dead center!
  vortexTL.to(bottle, {
    x: 0,
    y: isMobile ? 0 : -10,
    scale: isMobile ? 1.05 : 1.18,
    ease: 'power2.inOut',
  }, 0);

  // C. 3D Helical Water Splash Spiral (Layer Z-35, matching user's Reference Image 2!)
  // Encircles the bottle with base collar, waist curl, and crown splash, rotating in 3D!
  if (splash3DWrap) {
    vortexTL.to(splash3DWrap, {
      opacity: 1,
      scale: isMobile ? 0.95 : 1.10,
      ease: 'power1.out',
    }, 0.05);

    // Continuous 3D Y-axis and Z-axis rotation around the vertical bottle center
    vortexTL.to(splash3DWrap, {
      rotateY: 360,
      rotateZ: 25,
      ease: 'none',
    }, 0);
  }

  if (splash3DImg) {
    vortexTL.to(splash3DImg, {
      scale: 1.08,
      y: -15,
      ease: 'power1.inOut',
    }, 0);
  }

  // D. Background Vortex Halo (Layer Z-10)
  if (vortexWrap) {
    vortexTL.to(vortexWrap, {
      opacity: 0.85,
      scale: isMobile ? 0.90 : 1.10,
      ease: 'power1.out',
    }, 0.08);

    vortexTL.to(vortexWrap, {
      rotateZ: 360,
      ease: 'none',
    }, 0);
  }

  if (vortexImg) {
    vortexTL.to(vortexImg, {
      rotateZ: -180,
      ease: 'none',
    }, 0);
  }

  // E. Real-Time Water Touching Elements on the Bottle Glass Surface:
  // Caustic sheen sweeps across the cylinder as the water rotates
  if (causticSheen) {
    vortexTL.to(causticSheen, {
      opacity: 0.85,
      x: 70,
      ease: 'power1.inOut',
    }, 0.08);
  }

  // Waist fluid contact ring hugs the cylinder
  if (waistRing) {
    vortexTL.to(waistRing, {
      opacity: 0.95,
      scale: 1,
      rotateZ: 12,
      ease: 'power1.out',
    }, 0.10);
  }

  // Base diamond facet contact collar hugs the bottom starburst facets
  if (baseRing) {
    vortexTL.to(baseRing, {
      opacity: 1,
      scale: 1,
      rotateZ: -8,
      ease: 'power1.out',
    }, 0.10);
  }

  // ─── PHASE 2 (0.32 -> 0.82): Sequential Flank Storytelling (Zero Overlap) ───
  // Card 1 (Left Flank): 10,000-Year Glacier Source
  if (card1) {
    vortexTL.to(card1, { opacity: 1, y: 0, scale: 1, ease: 'power2.out' }, 0.28);
    vortexTL.to(card1, { opacity: 0, y: -20, scale: 0.96, ease: 'power2.in' }, 0.44);
  }

  // Card 2 (Right Flank): Diamond-Cut Flint Glass Architecture
  if (card2) {
    vortexTL.to(card2, { opacity: 1, y: 0, scale: 1, ease: 'power2.out' }, 0.48);
    vortexTL.to(card2, { opacity: 0, y: -20, scale: 0.96, ease: 'power2.in' }, 0.64);
  }

  // Card 3 (Left Flank): Living Alkaline Mineral Architecture
  if (card3) {
    vortexTL.to(card3, { opacity: 1, y: 0, scale: 1, ease: 'power2.out' }, 0.68);
    vortexTL.to(card3, { opacity: 0, y: -20, scale: 0.96, ease: 'power2.in' }, 0.84);
  }

  // ─── PHASE 3 (0.86 -> 1.0): Graceful Exit as Page Enters Section 02 ───
  vortexTL.to(bottle, {
    y: 60,
    scale: isMobile ? 0.85 : 0.95,
    opacity: 0,
    ease: 'power2.in',
  }, 0.88);

  if (splash3DWrap) {
    vortexTL.to(splash3DWrap, {
      opacity: 0,
      scale: 0.7,
      ease: 'power2.in',
    }, 0.88);
  }

  if (vortexWrap) {
    vortexTL.to(vortexWrap, {
      opacity: 0,
      scale: 0.7,
      ease: 'power2.in',
    }, 0.88);
  }

  if (causticSheen) {
    vortexTL.to(causticSheen, { opacity: 0, ease: 'power2.in' }, 0.88);
  }
  if (waistRing) {
    vortexTL.to(waistRing, { opacity: 0, ease: 'power2.in' }, 0.88);
  }
  if (baseRing) {
    vortexTL.to(baseRing, { opacity: 0, ease: 'power2.in' }, 0.88);
  }

  // 5. Desktop Weightless Cursor Parallax Tilt
  if (!isMobile) {
    window.addEventListener('pointermove', (e) => {
      const mouseX = (e.clientX / window.innerWidth) - 0.5;
      const mouseY = (e.clientY / window.innerHeight) - 0.5;

      gsap.to(stage, {
        rotateY: mouseX * 5,
        rotateX: -mouseY * 3.5,
        transformPerspective: 1200,
        duration: 0.8,
        ease: 'power1.out',
        overwrite: 'auto',
      });
    }, { passive: true });
  }
}
