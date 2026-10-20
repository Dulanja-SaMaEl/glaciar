/**
 * GLACIAR — Real-Time Interactive Glacial Water Source Engine
 * Features luminous refractive water ripple rings, ambient spring pulses,
 * flowing glacial caustics, and interactive cursor waves.
 */

export function initWaterCanvas() {
  const canvas = document.getElementById('glaciar-water-canvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  let width = 0;
  let height = 0;

  function resize() {
    const parent = canvas.parentElement;
    width = canvas.width = parent && parent.clientWidth > 0 ? parent.clientWidth : window.innerWidth;
    height = canvas.height = parent && parent.clientHeight > 0 ? parent.clientHeight : window.innerHeight;
  }
  resize();

  // Active water ripples array
  const ripples = [];
  const MAX_RIPPLES = 40;

  function spawnRipple(x, y, maxRadius = 180, strength = 1.0) {
    if (ripples.length >= MAX_RIPPLES) ripples.shift();
    ripples.push({
      x,
      y,
      radius: 2,
      maxRadius,
      speed: 1.8 + Math.random() * 0.8,
      strength,
      alpha: 0.95 * strength,
      rings: 3, // Multi-ring concentric wave
    });
  }

  // Spawn initial aesthetic ripples immediately beneath bottles
  spawnRipple(width * 0.65, height * 0.48, 220, 1.0);
  spawnRipple(width * 0.58, height * 0.52, 160, 0.8);
  spawnRipple(width * 0.72, height * 0.42, 250, 0.9);

  // Periodic ambient spring pulses (originating near the center/bottles)
  let lastSpringPulse = 0;
  function triggerAmbientSpring(now) {
    if (now - lastSpringPulse > 1600) {
      lastSpringPulse = now;
      // Emit pulse from beneath the bottles (right side on desktop, center on mobile)
      const isMobile = width < 1024;
      const originX = isMobile ? width * 0.5 : width * 0.65 + (Math.random() - 0.5) * 80;
      const originY = height * 0.48 + (Math.random() - 0.5) * 60;
      spawnRipple(originX, originY, 260 + Math.random() * 80, 0.95);
    }
  }

  // Interactive mouse/touch listener across the hero section
  const heroSection = document.getElementById('hero-section') || window;
  let lastPointerMove = 0;

  heroSection.addEventListener('pointermove', (e) => {
    const now = performance.now();
    if (now - lastPointerMove > 55) {
      lastPointerMove = now;
      const rect = canvas.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      if (x >= 0 && x <= width && y >= 0 && y <= height) {
        spawnRipple(x, y, 140, 0.75);
      }
    }
  }, { passive: true });

  heroSection.addEventListener('pointerdown', (e) => {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    if (x >= 0 && x <= width && y >= 0 && y <= height) {
      spawnRipple(x, y, 240, 1.3);
    }
  }, { passive: true });

  let isRunning = true;
  let animId = null;

  function render(timestamp) {
    if (!isRunning) return;

    ctx.clearRect(0, 0, width, height);

    // 1. Ambient Glacial Spring Pulse
    triggerAmbientSpring(timestamp);

    // 2. Render & Update Water Ripples
    for (let i = ripples.length - 1; i >= 0; i--) {
      const r = ripples[i];
      r.radius += r.speed;
      r.alpha = Math.max(0, (1 - (r.radius / r.maxRadius)) * r.strength);

      if (r.alpha <= 0.01 || r.radius >= r.maxRadius) {
        ripples.splice(i, 1);
        continue;
      }

      // Draw concentric crystalline wave rings
      for (let ring = 0; ring < r.rings; ring++) {
        const ringOffset = ring * 14;
        const currentRadius = r.radius - ringOffset;
        if (currentRadius <= 0) continue;

        const ringAlpha = r.alpha * (1 - ring * 0.28);
        ctx.beginPath();
        ctx.arc(r.x, r.y, currentRadius, 0, Math.PI * 2);

        // High-contrast luminous cyan and crystalline white
        ctx.strokeStyle = ring === 0 
          ? `rgba(255, 255, 255, ${ringAlpha * 0.95})` 
          : `rgba(56, 189, 248, ${ringAlpha * 0.75})`;
        ctx.lineWidth = Math.max(1, (2.4 - ring * 0.6));
        ctx.stroke();

        // Soft outer caustic glow on lead ring
        if (ring === 0 && ringAlpha > 0.15) {
          ctx.beginPath();
          ctx.arc(r.x, r.y, currentRadius + 2, 0, Math.PI * 2);
          ctx.strokeStyle = `rgba(56, 189, 248, ${ringAlpha * 0.35})`;
          ctx.lineWidth = 4;
          ctx.stroke();
        }
      }
    }

    // 3. Subtle Ambient Glacial Horizon Flowing Waves at the base
    const waveY = height * 0.88;
    ctx.beginPath();
    ctx.moveTo(0, height);
    ctx.lineTo(0, waveY);
    for (let x = 0; x <= width; x += 40) {
      const sinOffset = Math.sin((x * 0.008) + (timestamp * 0.0015)) * 12;
      const cosOffset = Math.cos((x * 0.012) + (timestamp * 0.002)) * 6;
      ctx.lineTo(x, waveY + sinOffset + cosOffset);
    }
    ctx.lineTo(width, height);
    ctx.closePath();
    ctx.fillStyle = 'rgba(56, 189, 248, 0.06)';
    ctx.fill();

    animId = requestAnimationFrame(render);
  }

  // Handle Resize
  window.addEventListener('resize', resize, { passive: true });
  if (window.ResizeObserver && canvas.parentElement) {
    new ResizeObserver(resize).observe(canvas.parentElement);
  }

  // IntersectionObserver to pause when off-screen
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        if (!isRunning) {
          isRunning = true;
          animId = requestAnimationFrame(render);
        }
      } else {
        isRunning = false;
        if (animId) cancelAnimationFrame(animId);
      }
    });
  }, { threshold: 0.05 });

  observer.observe(canvas);

  // Start animation loop
  animId = requestAnimationFrame(render);
}