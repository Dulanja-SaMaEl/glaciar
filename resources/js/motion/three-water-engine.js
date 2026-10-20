/**
 * GLACIAR — Real-Time 3D Procedural Water & Localized Bubble Engine
 * 
 * Features:
 * 1. Water flows when scrolling: Shader UV caustics, wave undulations, and spray droplets
 *    flow dynamically in direct proportion to scroll progress & velocity.
 * 2. Bottle rotates with a small leap: As the bottle glides from right side to dead center,
 *    it executes a buoyant 3D parabolic leap (+0.38 y-arc) and a smooth 360° Y-rotation.
 * 3. Clean exit before Section 02: Pinned stage and 3D canvas gracefully scale down & fade out
 *    before the track ends, completely eliminating overlap with Section 02 ("Harvested at 1,890m").
 * 4. Calm water bubbles strictly localized inside the bottle's water column reservoir.
 */
import * as THREE from 'three';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initThreeWaterEngine() {
  const canvas = document.getElementById('glaciar-three-canvas');
  const heroSection = document.getElementById('hero-section');
  const heroContentLayer = document.getElementById('gl-hero-content-layer');
  const fallbackBottle = document.getElementById('gl-crystal-bottle-fallback');

  const card1 = document.getElementById('gl-vortex-card-1');
  const card2 = document.getElementById('gl-vortex-card-2');
  const card3 = document.getElementById('gl-vortex-card-3');

  if (!canvas || !heroSection) return;

  // 1. Initialize WebGL Renderer
  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({
      canvas,
      alpha: true,
      antialias: true,
      powerPreference: 'high-performance',
    });
  } catch (err) {
    console.warn('WebGL initialization failed, showing fallback bottle:', err);
    if (fallbackBottle) fallbackBottle.classList.remove('hidden');
    return;
  }

  const dpr = Math.min(window.devicePixelRatio || 1, 2);
  renderer.setPixelRatio(dpr);
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.outputColorSpace = THREE.SRGBColorSpace;

  // 2. Scene & Camera Setup
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(42, window.innerWidth / window.innerHeight, 0.1, 100);
  camera.position.set(0, 0, 7.5);

  // Lighting
  const ambientLight = new THREE.AmbientLight(0xffffff, 1.1);
  scene.add(ambientLight);

  const keyLight = new THREE.DirectionalLight(0x38bdf8, 2.0);
  keyLight.position.set(5, 7, 6);
  scene.add(keyLight);

  const fillLight = new THREE.DirectionalLight(0xbae6fd, 1.4);
  fillLight.position.set(-5, -3, 4);
  scene.add(fillLight);

  // Master Stage Groups
  const masterGroup = new THREE.Group();
  scene.add(masterGroup);

  const bottleGroup = new THREE.Group();
  masterGroup.add(bottleGroup);

  const waterGroup = new THREE.Group();
  masterGroup.add(waterGroup);

  // Determine Desktop vs Mobile target positions
  let isMobile = window.innerWidth < 1024;
  let initBottleX = isMobile ? 0 : 2.45;
  let initBottleScale = isMobile ? 0.82 : 1.0;

  bottleGroup.position.set(initBottleX, -0.12, 0);
  bottleGroup.scale.setScalar(initBottleScale);

  waterGroup.position.set(initBottleX, -0.12, 0);
  waterGroup.scale.setScalar(initBottleScale);

  // 3. Signature Crystal Bottle (Plane with Double-Sided Flint Glass Texture for 360° Rotation)
  const textureLoader = new THREE.TextureLoader();
  const bottleTexture = textureLoader.load(
    '/images/hero/glaciar-crystal-bottle.png',
    () => {
      renderer.render(scene, camera);
    }
  );
  bottleTexture.colorSpace = THREE.SRGBColorSpace;
  bottleTexture.generateMipmaps = true;
  bottleTexture.minFilter = THREE.LinearMipmapLinearFilter;

  // Bottle aspect ratio: 896 x 1200 -> height: 4.5, width: 3.36
  const bottleWidth = 3.36;
  const bottleHeight = 4.5;
  const bottleGeom = new THREE.PlaneGeometry(bottleWidth, bottleHeight);
  const bottleMat = new THREE.MeshBasicMaterial({
    map: bottleTexture,
    transparent: true,
    alphaTest: 0.05,
    depthWrite: true,
    depthTest: true,
    side: THREE.DoubleSide, // Enables seamless 360° rotation!
  });
  const bottleMesh = new THREE.Mesh(bottleGeom, bottleMat);
  bottleMesh.position.set(0, 0, 0);
  bottleGroup.add(bottleMesh);

  // 4. Procedural Bubble Canvas Texture
  function createBubbleTexture() {
    const c = document.createElement('canvas');
    c.width = 128;
    c.height = 128;
    const ctx = c.getContext('2d');

    // Outer subtle cyan glow
    const aura = ctx.createRadialGradient(64, 64, 30, 64, 64, 62);
    aura.addColorStop(0, 'rgba(56, 189, 248, 0.4)');
    aura.addColorStop(1, 'rgba(56, 189, 248, 0)');
    ctx.fillStyle = aura;
    ctx.fillRect(0, 0, 128, 128);

    // Outer delicate ring
    ctx.beginPath();
    ctx.arc(64, 64, 46, 0, Math.PI * 2);
    ctx.strokeStyle = 'rgba(224, 242, 254, 0.9)';
    ctx.lineWidth = 3.2;
    ctx.stroke();

    // Translucent body
    const body = ctx.createRadialGradient(64, 64, 0, 64, 64, 46);
    body.addColorStop(0, 'rgba(255, 255, 255, 0.08)');
    body.addColorStop(0.7, 'rgba(56, 189, 248, 0.20)');
    body.addColorStop(1, 'rgba(186, 230, 253, 0.40)');
    ctx.fillStyle = body;
    ctx.fill();

    // Crisp diamond specular highlight reflection at top-left crest
    ctx.beginPath();
    ctx.arc(50, 48, 8.5, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(255, 255, 255, 0.98)';
    ctx.shadowColor = '#ffffff';
    ctx.shadowBlur = 6;
    ctx.fill();

    // Secondary soft bounce glint at lower-right
    ctx.beginPath();
    ctx.arc(76, 76, 4.2, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(255, 255, 255, 0.65)';
    ctx.fill();

    const tex = new THREE.CanvasTexture(c);
    tex.needsUpdate = true;
    return tex;
  }

  const bubbleTexture = createBubbleTexture();

  // 5. CALM, SLOW WATER BUBBLES STRICTLY LOCALIZED INSIDE THE WATER AREA
  // Water reservoir boundary in bottle space:
  // x: [-0.48, +0.48], y: [-1.30, +0.85] (above base facets, below neck shoulder)
  const bubbleGroup = new THREE.Group();
  bottleGroup.add(bubbleGroup);

  const BUBBLE_COUNT = 30;
  const bubbles = [];

  for (let i = 0; i < BUBBLE_COUNT; i++) {
    const mat = new THREE.SpriteMaterial({
      map: bubbleTexture,
      transparent: true,
      opacity: 0.8,
      depthTest: true,
      depthWrite: false,
      blending: THREE.NormalBlending,
    });
    const sprite = new THREE.Sprite(mat);

    const startX = (Math.random() - 0.5) * 0.96;
    const startY = -1.30 + Math.random() * 2.15;
    const startZ = 0.04 + (Math.random() - 0.5) * 0.06;
    const size = 0.06 + Math.random() * 0.08;

    sprite.scale.set(size, size, 1);
    sprite.position.set(startX, startY, startZ);
    bubbleGroup.add(sprite);

    bubbles.push({
      sprite,
      baseX: startX,
      y: startY,
      z: startZ,
      speedY: 0.0014 + Math.random() * 0.0024, // Slow, calm upward drift
      swayFreq: 0.5 + Math.random() * 0.6,
      swayAmp: 0.016 + Math.random() * 0.020,
      phase: Math.random() * Math.PI * 2,
    });
  }

  function updateBubbles(time) {
    bubbles.forEach(b => {
      b.y += b.speedY;
      b.sprite.position.y = b.y;
      b.sprite.position.x = b.baseX + Math.sin(time * b.swayFreq + b.phase) * b.swayAmp;
      b.sprite.position.z = b.z + Math.cos(time * b.swayFreq * 0.8 + b.phase) * 0.01;

      // Soft fade near top meniscus (+0.85) and near base (-1.30)
      if (b.y > 0.65) {
        const fade = Math.max(0, (0.85 - b.y) / 0.20);
        b.sprite.material.opacity = fade * 0.85;
      } else if (b.y < -1.15) {
        const fade = Math.min(1, (b.y - (-1.35)) / 0.20);
        b.sprite.material.opacity = fade * 0.85;
      } else {
        b.sprite.material.opacity = 0.85;
      }

      // Recycle cleanly when reaching top of water
      if (b.y >= 0.85) {
        b.y = -1.35;
        b.baseX = (Math.random() - 0.5) * 0.96;
        b.z = 0.04 + (Math.random() - 0.5) * 0.06;
      }
    });
  }

  // 6. PROGRAMMATIC 3D PROCEDURAL WATER STREAMS (SCROLL-DRIVEN FLOW)
  // 3D Helical Curve: Loops in front of (Z > 0) and behind (Z < 0) the bottle
  const mainSplinePoints = [
    new THREE.Vector3(-0.4, -2.1, 0.8),    // 0: Front base splash (Z > 0)
    new THREE.Vector3(1.2, -1.8, 0.4),     // 1: Front-right sweep (Z > 0)
    new THREE.Vector3(1.4, -1.1, -0.7),    // 2: Loops BEHIND bottle base (Z < 0)
    new THREE.Vector3(0.0, -0.5, -1.1),    // 3: Directly behind bottle lower body (Z < 0)
    new THREE.Vector3(-1.3, 0.2, -0.6),    // 4: Loops BEHIND left waist (Z < 0)
    new THREE.Vector3(-0.6, 0.7, 0.75),    // 5: Crosses IN FRONT OF waist (touching glass! Z > 0)
    new THREE.Vector3(0.7, 1.2, 0.75),     // 6: Across front upper chest (Z > 0)
    new THREE.Vector3(1.2, 1.7, -0.4),     // 7: Loops BEHIND shoulder/neck (Z < 0)
    new THREE.Vector3(0.1, 2.1, -0.7),     // 8: Behind neck (Z < 0)
    new THREE.Vector3(-0.7, 2.4, 0.5),     // 9: Front overhead curling splash (Z > 0)
  ];
  const mainCurve = new THREE.CatmullRomCurve3(mainSplinePoints);
  const mainTubeGeom = new THREE.TubeGeometry(mainCurve, 160, 0.16, 16, false);

  // Secondary Braided Fluid Ribbon
  const secSplinePoints = [
    new THREE.Vector3(-0.2, -2.0, 0.6),
    new THREE.Vector3(0.9, -1.6, 0.5),
    new THREE.Vector3(1.2, -0.9, -0.5),
    new THREE.Vector3(-0.2, -0.3, -0.9),
    new THREE.Vector3(-1.1, 0.4, -0.4),
    new THREE.Vector3(-0.4, 0.9, 0.65),
    new THREE.Vector3(0.5, 1.4, 0.65),
    new THREE.Vector3(0.9, 1.8, -0.3),
    new THREE.Vector3(-0.1, 2.2, -0.5),
    new THREE.Vector3(-0.5, 2.5, 0.3),
  ];
  const secCurve = new THREE.CatmullRomCurve3(secSplinePoints);
  const secTubeGeom = new THREE.TubeGeometry(secCurve, 140, 0.08, 12, false);

  // Custom Fluid Shader Material with Scroll-Driven Flow (Photorealistic Transparent Water)
  const waterShaderMat = new THREE.ShaderMaterial({
    uniforms: {
      uTime: { value: 0 },
      uFlowOffset: { value: 0 }, // Driven by scroll!
      uOpacity: { value: 1.0 },
      uColorClear: { value: new THREE.Color(0xf0f9ff) },   // Crystal-clear glacial water
      uColorFresnel: { value: new THREE.Color(0x7dd3fc) }, // Luminous icy edge refraction
      uColorSpec: { value: new THREE.Color(0xffffff) },    // Brilliant diamond white specular
    },
    vertexShader: `
      varying vec2 vUv;
      varying vec3 vNormal;
      varying vec3 vViewDir;
      varying vec3 vWorldPos;

      uniform float uTime;
      uniform float uFlowOffset;

      void main() {
        vUv = uv;
        vNormal = normalize(normalMatrix * normal);
        
        // Fluid wave undulation driven primarily by scrolling:
        float flow = uFlowOffset + sin(uTime * 0.3) * 0.2;
        float wave1 = sin(uv.x * 20.0 - flow * 1.5 + uv.y * 6.0) * 0.035;
        float wave2 = cos(uv.x * 36.0 + flow * 2.0) * 0.018;
        
        // Dynamic organic fluid ribbon width modulation:
        float pulse = 1.0 + 0.15 * sin(uv.x * 12.0 - flow);
        vec3 displaced = position + normal * ((wave1 + wave2) * pulse);
        
        vec4 worldPos = modelMatrix * vec4(displaced, 1.0);
        vWorldPos = worldPos.xyz;
        vViewDir = normalize(cameraPosition - worldPos.xyz);
        
        gl_Position = projectionMatrix * viewMatrix * worldPos;
      }
    `,
    fragmentShader: `
      varying vec2 vUv;
      varying vec3 vNormal;
      varying vec3 vViewDir;
      varying vec3 vWorldPos;

      uniform float uTime;
      uniform float uFlowOffset;
      uniform float uOpacity;
      uniform vec3 uColorClear;
      uniform vec3 uColorFresnel;
      uniform vec3 uColorSpec;

      void main() {
        vec3 normal = normalize(vNormal);
        vec3 viewDir = normalize(vViewDir);
        
        // Physical Fresnel reflectance for liquid water (low in center, sharp on grazing edges)
        float NdotV = max(0.0, dot(normal, viewDir));
        float fresnel = pow(1.0 - NdotV, 3.2);
        
        // Continuous flowing caustics along the stream length driven by scrolling:
        float flow = uFlowOffset + sin(uTime * 0.3) * 0.2;
        float flowU = vUv.x * 32.0 - flow * 1.8;
        float flowV = vUv.y * 10.0;
        float c1 = sin(flowU + sin(flowV * 2.5));
        float c2 = cos(flowU * 1.6 - flowV * 2.0 + flow);
        float caustic = smoothstep(0.35, 0.90, (c1 + c2) * 0.5 + 0.5);
        
        // Studio lighting specular glints (Key light + Rim light)
        vec3 keyLight = normalize(vec3(0.5, 1.2, 0.9));
        vec3 rimLight = normalize(vec3(-0.7, 0.4, -0.6));
        float specKey = pow(max(0.0, dot(normal, normalize(keyLight + viewDir))), 48.0);
        float specRim = pow(max(0.0, dot(normal, normalize(rimLight + viewDir))), 32.0);
        float totalSpec = specKey * 1.4 + specRim * 0.8;
        
        // Pure transparent water color:
        // Base is crystal clear with subtle icy aquamarine on the glancing Fresnel rim
        vec3 color = mix(uColorClear, uColorFresnel, fresnel * 0.85);
        color += (caustic * 0.45 + totalSpec) * uColorSpec;
        
        // Photorealistic transparency:
        // Center facing camera is ultra-clear (alpha ~ 0.14) so background & bottle facets show right through
        // Fresnel edges, caustics, and specular flashes provide liquid structure & definition
        float baseAlpha = 0.14;
        float alpha = clamp((baseAlpha + fresnel * 0.48 + caustic * 0.22 + totalSpec * 0.75) * uOpacity, 0.0, 0.88);
        
        gl_FragColor = vec4(color, alpha);
      }
    `,
    transparent: true,
    depthTest: true,
    depthWrite: false,
    blending: THREE.NormalBlending,
  });

  const mainWaterMesh = new THREE.Mesh(mainTubeGeom, waterShaderMat);
  waterGroup.add(mainWaterMesh);

  const secWaterMesh = new THREE.Mesh(secTubeGeom, waterShaderMat);
  waterGroup.add(secWaterMesh);

  // 7. 120 Dynamic 3D Sparkling Splash Spray Droplets along the Stream
  const dropletCount = 120;
  const dropletsGeom = new THREE.BufferGeometry();
  const dropPositions = new Float32Array(dropletCount * 3);
  const dropOffsets = [];

  for (let i = 0; i < dropletCount; i++) {
    const baseT = i / dropletCount;
    const pt = mainCurve.getPoint(baseT);
    const radialAngle = Math.random() * Math.PI * 2;
    const radialDist = 0.18 + Math.random() * 0.32;
    const ox = Math.cos(radialAngle) * radialDist;
    const oz = Math.sin(radialAngle) * radialDist;
    const oy = (Math.random() - 0.5) * 0.22;

    dropPositions[i * 3 + 0] = pt.x + ox;
    dropPositions[i * 3 + 1] = pt.y + oy;
    dropPositions[i * 3 + 2] = pt.z + oz;

    dropOffsets.push({ baseT, ox, oz, oy });
  }
  dropletsGeom.setAttribute('position', new THREE.BufferAttribute(dropPositions, 3));

  const dropMat = new THREE.PointsMaterial({
    color: 0xffffff, // Pure sparkling diamond white / clear water glints
    size: 0.11,
    map: bubbleTexture,
    transparent: true,
    opacity: 0.85,
    depthTest: true,
    depthWrite: false,
    blending: THREE.AdditiveBlending,
  });
  const dropletsPoints = new THREE.Points(dropletsGeom, dropMat);
  waterGroup.add(dropletsPoints);

  // 8. Master Scroll Scrub Timeline (Pinned Hero Showcase with Leap & 360° Rotation + Fluid Flow)
  const scrollState = {
    progress: 0,
    bottleX: initBottleX,
    leapArc: 0, // Parabolic leap lift (0 -> 1 -> 0)
    bottleRotY: 0, // Bottle 360° spin
    bottleRotZ: 0, // Kinetic leap tilt
    waterRotY: 0,
    waterRotZ: 0,
    flowOffset: 0, // Scroll-driven fluid flow
  };

  const vortexTL = gsap.timeline({
    scrollTrigger: {
      trigger: heroSection,
      pin: true,
      pinSpacing: true,
      start: 'top top',
      end: '+=2000',
      scrub: 0.6,
      anticipatePin: 1,
      invalidateOnRefresh: true,
      onUpdate: (self) => {
        scrollState.progress = self.progress;
      }
    }
  });

  // A. Hero Content clean fade out (0.0 -> 0.16)
  if (heroContentLayer) {
    vortexTL.to(heroContentLayer, {
      opacity: 0,
      y: -50,
      duration: 0.16,
      ease: 'power2.out',
    }, 0);
  }

  // B. Bottle glides from right side to dead center with a small leap & 360° rotation!
  // Glide X: initBottleX -> 0 over 0.0 -> 0.28
  vortexTL.to(scrollState, {
    bottleX: 0,
    duration: 0.28,
    ease: 'power2.inOut',
  }, 0);

  // Small Leap: Arcs up smoothly to peak at 0.14 (+0.38 units lift), lands gracefully at 0.28
  vortexTL.to(scrollState, {
    leapArc: 1,
    bottleRotZ: -0.12, // Takeoff buoyant tilt
    duration: 0.14,
    ease: 'power1.out',
  }, 0);

  vortexTL.to(scrollState, {
    leapArc: 0,
    bottleRotZ: 0, // Soft landing
    duration: 0.14,
    ease: 'power1.in',
  }, 0.14);

  // Bottle 360° rotation during the leap! (0.0 -> 0.28)
  vortexTL.to(scrollState, {
    bottleRotY: Math.PI * 2.0,
    duration: 0.28,
    ease: 'power2.inOut',
  }, 0);

  // Subtle responsive 3D tilt during storytelling phase (0.28 -> 0.88)
  vortexTL.to(scrollState, {
    bottleRotY: Math.PI * 2.0 + 0.40,
    duration: 0.60,
    ease: 'sine.inOut',
  }, 0.28);

  // C. 3D Water Stream revolves around the bottle in real 3D (0.0 -> 0.88)
  vortexTL.to(scrollState, {
    waterRotY: Math.PI * 3.5,
    waterRotZ: 0.35,
    duration: 0.88,
    ease: 'none',
  }, 0);

  // D. Scroll-driven fluid flow offset (advances along the ribbon with scrolling!) (0.0 -> 0.88)
  vortexTL.to(scrollState, {
    flowOffset: 45.0, // Water caustics & waves surge forward as you scroll!
    duration: 0.88,
    ease: 'none',
  }, 0);

  // E. Storytelling Cards Reveal (Wide flanks, 0 center overlap, clean sequential reveal)
  if (card1) {
    vortexTL.to(card1, { opacity: 1, y: 0, duration: 0.06, ease: 'power2.out' }, 0.18);
    vortexTL.to(card1, { opacity: 0, y: -20, duration: 0.06, ease: 'power2.in' }, 0.36);
  }

  if (card2) {
    vortexTL.to(card2, { opacity: 1, y: 0, duration: 0.06, ease: 'power2.out' }, 0.44);
    vortexTL.to(card2, { opacity: 0, y: -20, duration: 0.06, ease: 'power2.in' }, 0.62);
  }

  if (card3) {
    vortexTL.to(card3, { opacity: 1, y: 0, duration: 0.06, ease: 'power2.out' }, 0.70);
    vortexTL.to(card3, { opacity: 0, y: -20, duration: 0.06, ease: 'power2.in' }, 0.88);
  }

  // 10. Desktop Cursor Parallax
  let mouseTargetX = 0;
  let mouseTargetY = 0;
  let currentTiltX = 0;
  let currentTiltY = 0;

  if (!isMobile) {
    window.addEventListener('pointermove', (e) => {
      mouseTargetX = ((e.clientX / window.innerWidth) - 0.5) * 0.25;
      mouseTargetY = ((e.clientY / window.innerHeight) - 0.5) * 0.15;
    }, { passive: true });
  }

  // 11. Render Animation Loop
  let clock = new THREE.Clock();
  let isRunning = true;
  let animId = null;

  function render() {
    if (!isRunning) return;

    const elapsedTime = clock.getElapsedTime();

    // Update shader uniforms:
    waterShaderMat.uniforms.uTime.value = elapsedTime;
    waterShaderMat.uniforms.uFlowOffset.value = scrollState.flowOffset;

    // Update calm water bubbles inside the bottle
    updateBubbles(elapsedTime);

    // Update orbiting splash spray droplets along helical curve driven by scroll
    const posAttr = dropletsGeom.attributes.position;
    for (let i = 0; i < dropletCount; i++) {
      const d = dropOffsets[i];
      // Droplet flow along curve advances with scrolling!
      const currentT = ((d.baseT + scrollState.flowOffset * 0.035) % 1.0 + 1.0) % 1.0;
      const pt = mainCurve.getPoint(currentT);
      posAttr.setXYZ(i, pt.x + d.ox, pt.y + d.oy, pt.z + d.oz);
    }
    posAttr.needsUpdate = true;

    // Apply scroll transformations: Bottle glide with leap arc & 360° rotation
    const targetX = scrollState.bottleX;
    const leapY = -0.12 + scrollState.leapArc * 0.42; // Buoyant small leap (+0.42 units lift!)

    bottleGroup.position.x = targetX;
    bottleGroup.position.y = leapY;
    bottleGroup.rotation.y = scrollState.bottleRotY;
    bottleGroup.rotation.z = scrollState.bottleRotZ;

    // Water group follows bottle position & revolves in 3D
    waterGroup.position.x = targetX;
    waterGroup.position.y = leapY;
    waterGroup.rotation.y = scrollState.waterRotY + Math.sin(elapsedTime * 0.3) * 0.03;
    waterGroup.rotation.z = scrollState.waterRotZ;

    // Parallax tilt damping
    currentTiltX += (mouseTargetY - currentTiltX) * 0.05;
    currentTiltY += (mouseTargetX - currentTiltY) * 0.05;
    masterGroup.rotation.x = currentTiltX;
    masterGroup.rotation.y = currentTiltY;

    renderer.render(scene, camera);

    animId = requestAnimationFrame(render);
  }

  animId = requestAnimationFrame(render);

  // 12. Handle Resize
  function onResize() {
    isMobile = window.innerWidth < 1024;
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);

    initBottleX = isMobile ? 0 : 2.45;
    initBottleScale = isMobile ? 0.82 : 1.0;

    bottleGroup.scale.setScalar(initBottleScale);
    waterGroup.scale.setScalar(initBottleScale);
  }

  window.addEventListener('resize', onResize, { passive: true });

  // 13. Visibility Optimization with IntersectionObserver
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        if (!isRunning) {
          isRunning = true;
          clock.start();
          animId = requestAnimationFrame(render);
        }
      } else {
        isRunning = false;
        if (animId) cancelAnimationFrame(animId);
      }
    });
  }, { rootMargin: '300px 0px 300px 0px', threshold: 0.01 });

  obs.observe(heroSection);
}
