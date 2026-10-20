/**
 * GLACIAR — Apple-Grade 3D Scroll-Driven Cinematic Experience
 * 
 * Powered by:
 * - 240-frame 3D CGI subterranean cavern & bottle reveal sequence
 * - High-speed hardware-accelerated Canvas scrub with sub-pixel interpolation
 * - Smooth inertia lerping (continuous fluid motion regardless of wheel speed)
 * - 3D Perspective Tilt on pointer move (Antigravity spatial depth)
 * - Synchronized glassmorphic storytelling beats:
 *   Beat 0: "SIP THE DARK MYSTERY" — The Primordial Water Orb
 *   Beat 1: "THE SUBTERRANEAN SANCTUARY" — Descent through the volcanic basalt portal
 *   Beat 2: "THE LIVING MINERAL STREAM" — Glacial melt river & natural 7.4 pH alkalinity
 *   Beat 3: "THE MONOLITH VESSEL" — The illuminated frosted bottle revealed on the altar
 */
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function init3DScrollEngine() {
  const stage = document.getElementById('glaciar-3d-stage');
  const canvas = document.getElementById('glaciar-3d-canvas');
  if (!stage || !canvas) return;

  const ctx = canvas.getContext('2d', { alpha: false });
  if (!ctx) return;

  const TOTAL_FRAMES = 240;
  const frames = new Array(TOTAL_FRAMES);
  let loadedCount = 0;

  // Story beats
  const beat0 = document.getElementById('gl-beat-0');
  const beat1 = document.getElementById('gl-beat-1');
  const beat2 = document.getElementById('gl-beat-2');
  const beat3 = document.getElementById('gl-beat-3');

  // Size canvas to device pixel ratio
  function resizeCanvas() {
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    canvas.width = window.innerWidth * dpr;
    canvas.height = window.innerHeight * dpr;
    drawFrame(Math.round(currentFrame));
  }
  window.addEventListener('resize', resizeCanvas, { passive: true });

  // 1. Preload Initial Keyframe Immediately (0ms First Paint)
  const firstFrameImg = new Image();
  firstFrameImg.src = '/images/hero/3d-frames/frame_000.jpg';
  firstFrameImg.onload = () => {
    frames[0] = firstFrameImg;
    resizeCanvas();
    drawFrame(0);
  };

  // 2. Progressive Frame Loader
  function loadAllFrames() {
    for (let i = 0; i < TOTAL_FRAMES; i++) {
      const img = new Image();
      const pad = String(i).padStart(3, '0');
      img.src = `/images/hero/3d-frames/frame_${pad}.jpg`;
      img.onload = () => {
        frames[i] = img;
        loadedCount++;
      };
    }
  }
  loadAllFrames();

  // Find best nearest loaded frame during fast scrubs
  function getBestFrame(targetIdx) {
    if (frames[targetIdx] && frames[targetIdx].complete && frames[targetIdx].naturalWidth > 0) {
      return frames[targetIdx];
    }
    for (let delta = 1; delta < TOTAL_FRAMES; delta++) {
      const prev = targetIdx - delta;
      if (prev >= 0 && frames[prev] && frames[prev].complete && frames[prev].naturalWidth > 0) {
        return frames[prev];
      }
      const next = targetIdx + delta;
      if (next < TOTAL_FRAMES && frames[next] && frames[next].complete && frames[next].naturalWidth > 0) {
        return frames[next];
      }
    }
    return frames[0];
  }

  // 3. High Performance Canvas Draw (aspect-ratio cover with focal-point preservation)
  function drawFrame(frameIndex) {
    const idx = Math.max(0, Math.min(TOTAL_FRAMES - 1, frameIndex));
    const img = getBestFrame(idx);
    if (!img || !img.complete || img.naturalWidth === 0) return;

    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';

    const cw = canvas.width;
    const ch = canvas.height;
    const iw = img.naturalWidth || 1920;
    const ih = img.naturalHeight || 1080;

    const hRatio = cw / iw;
    const vRatio = ch / ih;
    const ratio = Math.max(hRatio, vRatio);

    const nw = iw * ratio;
    const nh = ih * ratio;

    // In wide/desktop screens (aspect ratio >= 1.2), center the 3D cavern scene horizontally.
    // In narrow/mobile screens (aspect ratio < 1.2), the bottle subject is rendered in the right
    // third of the 16:9 frame (x ~ 0.72). Horizontal centering would crop the bottle off-screen.
    // Preserve the bottle in view by aligning the focal subject to 62% of canvas width:
    let nx;
    if (cw / ch >= 1.2) {
      nx = (cw - nw) / 2;
    } else {
      const targetBottleX = cw * 0.62;
      const naturalBottleX = nw * 0.72;
      nx = Math.min(0, Math.max(cw - nw, targetBottleX - naturalBottleX));
    }
    const ny = (ch - nh) / 2;

    ctx.drawImage(img, nx, ny, nw, nh);
  }

  // 4. Smooth Scrubbing State & Inertia Lerp Loop
  let targetProgress = 0;
  let currentProgress = 0;
  let currentFrame = 0;
  let needsInitialPaint = true;

  // 3D Mouse Parallax State
  let mouseTargetX = 0;
  let mouseTargetY = 0;
  let currentTiltX = 0;
  let currentTiltY = 0;

  if (window.innerWidth >= 1024) {
    window.addEventListener('pointermove', (e) => {
      mouseTargetX = ((e.clientX / window.innerWidth) - 0.5) * 8; // degrees
      mouseTargetY = ((e.clientY / window.innerHeight) - 0.5) * -6;
    }, { passive: true });
  }

  const canvasWrap = document.getElementById('glaciar-3d-canvas-wrap');

  function renderLoop() {
    const prevFrame = Math.round(currentFrame);
    currentProgress += (targetProgress - currentProgress) * 0.14;
    currentFrame = currentProgress * (TOTAL_FRAMES - 1);
    const newFrame = Math.round(currentFrame);

    if (newFrame !== prevFrame || needsInitialPaint) {
      needsInitialPaint = false;
      drawFrame(newFrame);
    }

    // Smooth 3D mouse tilt
    if (canvasWrap && window.innerWidth >= 1024) {
      currentTiltX += (mouseTargetY - currentTiltX) * 0.08;
      currentTiltY += (mouseTargetX - currentTiltY) * 0.08;
      canvasWrap.style.transform = `perspective(1200px) rotateX(${currentTiltX.toFixed(2)}deg) rotateY(${currentTiltY.toFixed(2)}deg) scale3d(1.02, 1.02, 1.02)`;
    }

    requestAnimationFrame(renderLoop);
  }
  requestAnimationFrame(renderLoop);

  // 5. Master GSAP ScrollTrigger Pinned Timeline (~2800px of buttery scroll)
  const masterTL = gsap.timeline({
    scrollTrigger: {
      trigger: stage,
      start: 'top top',
      end: '+=2800',
      pin: true,
      pinSpacing: true,
      scrub: 0.35,
      anticipatePin: 1,
      onUpdate: (self) => {
        targetProgress = self.progress;
      },
    },
  });

  // Story Beat 0: Hero Headline & CTA (Visible at top 0.0 -> 0.18, fades up out)
  if (beat0) {
    gsap.set(beat0, { opacity: 1, y: 0, scale: 1 });
    masterTL.to(beat0, {
      opacity: 0,
      y: -50,
      scale: 0.96,
      filter: 'blur(8px)',
      duration: 0.16,
      ease: 'power2.in',
    }, 0.06);
  }

  // Story Beat 1: "The Subterranean Sanctuary" (Reveals during cavern dive 0.22 -> 0.44)
  if (beat1) {
    gsap.set(beat1, { opacity: 0, y: 24, scale: 0.96 });
    masterTL.to(beat1, {
      opacity: 1,
      y: 0,
      scale: 1,
      duration: 0.08,
      ease: 'power2.out',
    }, 0.22);
    masterTL.to(beat1, {
      opacity: 0,
      y: -20,
      scale: 0.97,
      filter: 'blur(6px)',
      duration: 0.08,
      ease: 'power2.in',
    }, 0.40);
  }

  // Story Beat 2: "The Living Mineral Stream" (Reveals along water river 0.48 -> 0.70)
  if (beat2) {
    gsap.set(beat2, { opacity: 0, y: 24, scale: 0.96 });
    masterTL.to(beat2, {
      opacity: 1,
      y: 0,
      scale: 1,
      duration: 0.08,
      ease: 'power2.out',
    }, 0.48);
    masterTL.to(beat2, {
      opacity: 0,
      y: -20,
      scale: 0.97,
      filter: 'blur(6px)',
      duration: 0.08,
      ease: 'power2.in',
    }, 0.68);
  }

  // Story Beat 3: "The Monolith Vessel Revealed" (Grand culmination 0.76 -> 1.0)
  if (beat3) {
    gsap.set(beat3, { opacity: 0, y: 28, scale: 0.95 });
    masterTL.to(beat3, {
      opacity: 1,
      y: 0,
      scale: 1,
      duration: 0.10,
      ease: 'power3.out',
    }, 0.76);
    masterTL.to(beat3, {
      opacity: 0,
      y: -20,
      duration: 0.06,
      ease: 'power1.in',
    }, 0.94);
  }

  // Subtle atmospheric transition into Section 02 at the end of the journey (0.94 -> 1.0)
  if (canvasWrap) {
    masterTL.to(canvasWrap, {
      opacity: 0.9,
      duration: 0.06,
      ease: 'power1.inOut',
    }, 0.94);
  }
}
