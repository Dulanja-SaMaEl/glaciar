export function initCursor() {
  // Desktop only: check for pointer: fine and screen > 1024px
  if (!window.matchMedia('(pointer: fine)').matches || window.innerWidth < 1024) {
    return;
  }

  // Ensure DOM elements exist
  let dot = document.querySelector('.gl-cursor-dot');
  let ring = document.querySelector('.gl-cursor-ring');

  if (!dot || !ring) {
    dot = document.createElement('div');
    dot.className = 'gl-cursor-dot';
    ring = document.createElement('div');
    ring.className = 'gl-cursor-ring';
    document.body.appendChild(dot);
    document.body.appendChild(ring);
  }

  let mouseX = window.innerWidth / 2;
  let mouseY = window.innerHeight / 2;
  let ringX = mouseX;
  let ringY = mouseY;
  let isHovering = false;
  let isVisible = false;

  window.addEventListener('pointermove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    if (!isVisible) {
      isVisible = true;
      dot.style.opacity = '1';
      ring.style.opacity = '1';
    }
    // Instant dot movement
    dot.style.transform = `translate3d(${mouseX}px, ${mouseY}px, 0) translate(-50%, -50%)`;
  }, { passive: true });

  // Smooth RAF interpolation for ring follower
  function updateRing() {
    ringX += (mouseX - ringX) * 0.18;
    ringY += (mouseY - ringY) * 0.18;
    ring.style.transform = `translate3d(${ringX}px, ${ringY}px, 0) translate(-50%, -50%)`;
    requestAnimationFrame(updateRing);
  }
  requestAnimationFrame(updateRing);

  // Listen for hover states across all interactive elements
  const hoverSelectors = 'a, button, [role="button"], input, select, textarea, .gl-product-card, .gl-magnetic, .gl-card-3d';
  
  document.addEventListener('mouseover', (e) => {
    const target = e.target.closest(hoverSelectors);
    if (target && !isHovering) {
      isHovering = true;
      document.body.classList.add('cursor-hover');
    }
  }, { passive: true });

  document.addEventListener('mouseout', (e) => {
    const target = e.target.closest(hoverSelectors);
    if (target && isHovering) {
      isHovering = false;
      document.body.classList.remove('cursor-hover');
    }
  }, { passive: true });

  document.addEventListener('mouseleave', () => {
    isVisible = false;
    dot.style.opacity = '0';
    ring.style.opacity = '0';
  });
}