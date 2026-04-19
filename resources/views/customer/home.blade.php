@extends('layouts.customer')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap');

:root {
  --ice: #e8f4f8;
  --glacial: #cce8f0;
  --deep: #0a1628;
  --mist: #6b8fa3;
  --frost: #a8d4e0;
  --white: #ffffff;
  --offwhite: #f7fbfd;
  --accent: #4aa8c8;
}

* { box-sizing: border-box; }

body {
  font-family: 'Montserrat', sans-serif;
  background: var(--white);
  overflow-x: hidden;
}

/* ─── HERO ──────────────────────────────────────── */
.hero {
  position: relative;
  height: 100vh;
  min-height: 700px;
  background: var(--deep);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

/* Animated aurora blobs */
.aurora {
  position: absolute;
  inset: 0;
  pointer-events: none;
}
.aurora-blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(90px);
  opacity: 0;
  animation: auroraIn 2s forwards, auroraDrift 12s ease-in-out infinite;
}
.aurora-blob:nth-child(1) {
  width: 700px; height: 700px;
  background: radial-gradient(circle, #1a4a6e 0%, transparent 70%);
  top: -20%; left: -15%;
  animation-delay: 0.2s, 2.2s;
  animation-duration: 2s, 16s;
}
.aurora-blob:nth-child(2) {
  width: 600px; height: 600px;
  background: radial-gradient(circle, #0d3550 0%, transparent 70%);
  bottom: -20%; right: -10%;
  animation-delay: 0.6s, 2.6s;
  animation-duration: 2s, 14s;
}
.aurora-blob:nth-child(3) {
  width: 500px; height: 500px;
  background: radial-gradient(circle, #2a7090 0%, transparent 70%);
  top: 30%; left: 40%;
  animation-delay: 1s, 3s;
  animation-duration: 2s, 18s;
}

@keyframes auroraIn {
  to { opacity: 1; }
}
@keyframes auroraDrift {
  0%, 100% { transform: translate(0, 0) scale(1); }
  25%  { transform: translate(40px, -30px) scale(1.05); }
  50%  { transform: translate(-20px, 50px) scale(0.97); }
  75%  { transform: translate(-50px, -20px) scale(1.03); }
}

/* Ripple circles */
.ripple-container {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
}
.ripple {
  position: absolute;
  border: 1px solid rgba(74, 168, 200, 0.15);
  border-radius: 50%;
  animation: rippleOut 8s ease-out infinite;
}
.ripple:nth-child(1) { width: 300px; height: 300px; animation-delay: 0s; }
.ripple:nth-child(2) { width: 500px; height: 500px; animation-delay: 2s; }
.ripple:nth-child(3) { width: 700px; height: 700px; animation-delay: 4s; }
.ripple:nth-child(4) { width: 900px; height: 900px; animation-delay: 6s; }

@keyframes rippleOut {
  0%   { transform: scale(0.5); opacity: 0; }
  20%  { opacity: 1; }
  100% { transform: scale(1.3); opacity: 0; }
}

/* Hero content */
.hero-content {
  position: relative;
  z-index: 10;
  text-align: center;
  padding: 0 1.5rem;
}

.hero-eyebrow {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.7rem;
  font-weight: 600;
  letter-spacing: 0.45em;
  color: var(--accent);
  text-transform: uppercase;
  opacity: 0;
  transform: translateY(20px);
  animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.4s forwards;
}

.hero-drop {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 64px;
  height: 64px;
  margin: 1.5rem auto;
  opacity: 0;
  transform: translateY(-30px) scale(0.8);
  animation: dropFall 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.8s forwards;
}

.hero-drop svg {
  width: 100%;
  height: 100%;
  filter: drop-shadow(0 0 20px rgba(74, 168, 200, 0.6));
}

@keyframes dropFall {
  to { opacity: 1; transform: translateY(0) scale(1); }
}

.hero-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(5rem, 15vw, 12rem);
  font-weight: 300;
  letter-spacing: 0.3em;
  color: var(--white);
  line-height: 0.9;
  margin: 0;
  opacity: 0;
  transform: translateY(40px);
  animation: fadeUp 1.1s cubic-bezier(0.16, 1, 0.3, 1) 1.1s forwards;
  text-shadow: 0 0 80px rgba(74, 168, 200, 0.3);
}

.hero-sub {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic;
  font-size: clamp(1.1rem, 2.5vw, 1.5rem);
  font-weight: 300;
  color: rgba(200, 230, 240, 0.7);
  letter-spacing: 0.15em;
  margin: 1.5rem 0 3.5rem;
  opacity: 0;
  transform: translateY(30px);
  animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 1.5s forwards;
}

.hero-cta {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  justify-content: center;
  opacity: 0;
  transform: translateY(30px);
  animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 1.8s forwards;
}

.btn-primary {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  text-decoration: none;
  padding: 1.1rem 2.8rem;
  background: var(--white);
  color: var(--deep);
  border: none;
  position: relative;
  overflow: hidden;
  transition: color 0.35s;
  clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
}
.btn-primary::before {
  content: '';
  position: absolute;
  inset: 0;
  background: var(--accent);
  transform: translateX(-101%);
  transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-primary:hover { color: var(--white); }
.btn-primary:hover::before { transform: translateX(0); }
.btn-primary span { position: relative; z-index: 1; }

.btn-ghost {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  text-decoration: none;
  padding: 1.1rem 2.8rem;
  background: transparent;
  color: var(--white);
  border: 1px solid rgba(255,255,255,0.3);
  transition: border-color 0.3s, background 0.3s, color 0.3s;
  clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
}
.btn-ghost:hover {
  background: rgba(255,255,255,0.08);
  border-color: rgba(255,255,255,0.6);
}

/* Scroll indicator */
.scroll-hint {
  position: absolute;
  bottom: 0.5rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 10;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  opacity: 0;
  animation: fadeIn 1s ease 2.5s forwards;
}
.scroll-hint span {
  font-size: 0.6rem;
  letter-spacing: 0.3em;
  color: rgba(255,255,255,0.35);
  text-transform: uppercase;
}
.scroll-line {
  width: 1px;
  height: 60px;
  background: linear-gradient(to bottom, rgba(74,168,200,0.8), transparent);
  animation: scrollLine 2s ease-in-out infinite 2.5s;
}
@keyframes scrollLine {
  0%   { transform: scaleY(0); transform-origin: top; opacity: 1; }
  50%  { transform: scaleY(1); transform-origin: top; opacity: 1; }
  51%  { transform: scaleY(1); transform-origin: bottom; opacity: 1; }
  100% { transform: scaleY(0); transform-origin: bottom; opacity: 0; }
}

@keyframes fadeUp {
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
  to { opacity: 1; }
}

/* ─── MARQUEE BAND ───────────────────────────────── */
.marquee-band {
  background: var(--deep);
  border-top: 1px solid rgba(74,168,200,0.15);
  border-bottom: 1px solid rgba(74,168,200,0.15);
  padding: 1rem 0;
  overflow: hidden;
  display: flex;
}
.marquee-track {
  display: flex;
  gap: 0;
  animation: marqueeScroll 25s linear infinite;
  white-space: nowrap;
  will-change: transform;
}
.marquee-item {
  display: inline-flex;
  align-items: center;
  gap: 1.5rem;
  padding: 0 2rem;
  font-size: 0.65rem;
  font-weight: 600;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: rgba(200,230,240,0.45);
}
.marquee-dot {
  width: 4px; height: 4px;
  border-radius: 50%;
  background: var(--accent);
  opacity: 0.6;
  flex-shrink: 0;
}
@keyframes marqueeScroll {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}

/* ─── SECTION BASE ───────────────────────────────── */
.section-reveal {
  opacity: 0;
  transform: translateY(50px);
  transition: opacity 0.9s cubic-bezier(0.16,1,0.3,1), transform 0.9s cubic-bezier(0.16,1,0.3,1);
}
.section-reveal.visible {
  opacity: 1;
  transform: translateY(0);
}
.section-reveal-left {
  opacity: 0;
  transform: translateX(-50px);
  transition: opacity 0.9s cubic-bezier(0.16,1,0.3,1), transform 0.9s cubic-bezier(0.16,1,0.3,1);
}
.section-reveal-left.visible {
  opacity: 1;
  transform: translateX(0);
}

/* ─── WHY GLACIAR ────────────────────────────────── */
.why-section {
  background: var(--offwhite);
  padding: 8rem 0;
  position: relative;
  overflow: hidden;
}
.why-section::before {
  content: 'PURE';
  position: absolute;
  top: 50%;
  left: -1rem;
  transform: translateY(-50%) rotate(-90deg);
  font-family: 'Cormorant Garamond', serif;
  font-size: 10rem;
  font-weight: 300;
  color: var(--glacial);
  opacity: 0.35;
  letter-spacing: 0.3em;
  pointer-events: none;
  white-space: nowrap;
}

.section-label {
  font-size: 0.65rem;
  font-weight: 600;
  letter-spacing: 0.45em;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 1rem;
}
.section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 300;
  color: var(--deep);
  line-height: 1.1;
  margin: 0 0 4rem;
}
.section-title em {
  font-style: italic;
  color: var(--accent);
}

.feature-cards {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2px;
}
@media (max-width: 768px) {
  .feature-cards { grid-template-columns: 1fr; }
}

.feature-card {
  background: var(--white);
  padding: 3.5rem 2.5rem;
  position: relative;
  overflow: hidden;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.feature-card::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0;
  width: 0; height: 2px;
  background: linear-gradient(to right, var(--accent), var(--frost));
  transition: width 0.5s cubic-bezier(0.16,1,0.3,1);
}
.feature-card:hover { transform: translateY(-6px); }
.feature-card:hover::after { width: 100%; }

.feature-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 5rem;
  font-weight: 300;
  color: var(--ice);
  line-height: 1;
  margin-bottom: 1.5rem;
  display: block;
}
.feature-icon {
  width: 48px; height: 48px;
  color: var(--accent);
  margin-bottom: 1.5rem;
}
.feature-title {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--deep);
  margin-bottom: 1rem;
}
.feature-desc {
  font-size: 0.88rem;
  line-height: 1.8;
  color: var(--mist);
}

/* ─── PRODUCTS ───────────────────────────────────── */
.products-section {
  background: var(--deep);
  padding: 8rem 0;
  position: relative;
  overflow: hidden;
}
.products-section::after {
  content: '';
  position: absolute;
  top: 0; right: -200px;
  width: 700px; height: 700px;
  background: radial-gradient(circle, rgba(74,168,200,0.06) 0%, transparent 70%);
  pointer-events: none;
}

.products-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  margin-bottom: 4rem;
  gap: 2rem;
}
@media (max-width: 640px) {
  .products-header { flex-direction: column; align-items: flex-start; }
}

.view-all-link {
  font-size: 0.7rem;
  font-weight: 600;
  letter-spacing: 0.3em;
  text-transform: uppercase;
  color: var(--accent);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  border-bottom: 1px solid rgba(74,168,200,0.3);
  padding-bottom: 0.25rem;
  transition: gap 0.3s, border-color 0.3s;
  white-space: nowrap;
}
.view-all-link:hover { gap: 1.25rem; border-color: var(--accent); }

.product-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5px;
}
@media (max-width: 1024px) { .product-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .product-grid { grid-template-columns: 1fr; } }

.product-tile {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.06);
  padding: 3rem 2rem;
  text-align: center;
  position: relative;
  overflow: hidden;
  transition: background 0.4s, border-color 0.4s;
  cursor: pointer;
}
.product-tile::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(74,168,200,0.08) 0%, transparent 100%);
  opacity: 0;
  transition: opacity 0.4s;
}
.product-tile:hover { background: rgba(74,168,200,0.06); border-color: rgba(74,168,200,0.25); }
.product-tile:hover::before { opacity: 1; }

.product-drop-wrap {
  width: 90px; height: 90px;
  margin: 0 auto 2rem;
  position: relative;
}
.product-drop-svg {
  width: 100%;
  height: 100%;
  transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1), filter 0.4s;
  filter: drop-shadow(0 4px 12px rgba(74,168,200,0.2));
}
.product-tile:hover .product-drop-svg {
  transform: scale(1.1) translateY(-4px);
  filter: drop-shadow(0 12px 24px rgba(74,168,200,0.45));
}

.product-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.5rem;
  font-weight: 300;
  color: var(--white);
  letter-spacing: 0.08em;
  margin-bottom: 0.4rem;
}
.product-size {
  font-size: 0.65rem;
  font-weight: 600;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: var(--mist);
  margin-bottom: 1.5rem;
}
.product-price {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2rem;
  font-weight: 400;
  color: var(--accent);
}
.product-currency {
  font-size: 1rem;
  vertical-align: super;
  font-weight: 300;
  margin-right: 2px;
}

/* ─── HOW IT WORKS ───────────────────────────────── */
.how-section {
  background: var(--offwhite);
  padding: 8rem 0;
  position: relative;
}

.steps-grid {
  display: grid;
  grid-template-columns: 1fr 80px 1fr 80px 1fr;
  align-items: center;
  gap: 0;
  margin-top: 5rem;
}
@media (max-width: 1024px) {
  .steps-grid {
    grid-template-columns: 1fr;
    gap: 3rem;
  }
  .step-connector { display: none; }
}

.step-card {
  background: var(--white);
  padding: 3.5rem 2.5rem;
  position: relative;
  text-align: left;
}
.step-number {
  font-family: 'Cormorant Garamond', serif;
  font-size: 6rem;
  font-weight: 300;
  color: var(--ice);
  line-height: 1;
  display: block;
  margin-bottom: 1.5rem;
  transition: color 0.3s;
}
.step-card:hover .step-number { color: var(--glacial); }
.step-icon {
  width: 36px; height: 36px;
  color: var(--accent);
  margin-bottom: 1.25rem;
}
.step-title {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: var(--deep);
  margin-bottom: 1rem;
}
.step-desc {
  font-size: 0.88rem;
  line-height: 1.8;
  color: var(--mist);
}
.step-connector {
  display: flex;
  align-items: center;
  justify-content: center;
}
.step-connector svg {
  width: 32px; height: 32px;
  color: var(--frost);
  opacity: 0.7;
}

/* ─── CTA BAND ───────────────────────────────────── */
.cta-section {
  background: var(--deep);
  padding: 8rem 0;
  position: relative;
  overflow: hidden;
}

.cta-bg-text {
  position: absolute;
  bottom: -2rem;
  left: 0;
  right: 0;
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(6rem, 18vw, 14rem);
  font-weight: 300;
  color: rgba(255,255,255,0.03);
  letter-spacing: 0.25em;
  text-align: center;
  pointer-events: none;
  white-space: nowrap;
  overflow: hidden;
}

.cta-inner {
  position: relative;
  z-index: 2;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6rem;
  align-items: center;
}
@media (max-width: 900px) {
  .cta-inner { grid-template-columns: 1fr; gap: 3rem; }
}

.cta-badge {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 0.65rem;
  font-weight: 600;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: var(--accent);
  background: rgba(74,168,200,0.08);
  border: 1px solid rgba(74,168,200,0.2);
  padding: 0.5rem 1.25rem;
  margin-bottom: 2rem;
  display: inline-flex;
}
.cta-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent); animation: pulse 2s infinite; }
@keyframes pulse { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.4); } }

.cta-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.5rem, 5vw, 4.5rem);
  font-weight: 300;
  color: var(--white);
  line-height: 1.1;
  margin-bottom: 1.5rem;
}
.cta-title em { font-style: italic; color: var(--accent); }

.cta-desc {
  font-size: 0.9rem;
  line-height: 1.9;
  color: rgba(200,230,240,0.6);
  margin-bottom: 2.5rem;
  max-width: 440px;
}

.savings-card {
  background: rgba(74,168,200,0.05);
  border: 1px solid rgba(74,168,200,0.15);
  padding: 3rem;
  position: relative;
  overflow: hidden;
}
.savings-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0;
  width: 3px; height: 100%;
  background: linear-gradient(to bottom, var(--accent), transparent);
}
.savings-pct {
  font-family: 'Cormorant Garamond', serif;
  font-size: 5rem;
  font-weight: 300;
  color: var(--accent);
  line-height: 1;
  display: block;
}
.savings-label {
  font-size: 0.65rem;
  font-weight: 700;
  letter-spacing: 0.35em;
  text-transform: uppercase;
  color: rgba(200,230,240,0.5);
  margin-top: 0.5rem;
  display: block;
}
.savings-list {
  list-style: none;
  padding: 0; margin: 2rem 0 0;
}
.savings-list li {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 0.82rem;
  color: rgba(200,230,240,0.65);
  padding: 0.6rem 0;
  border-bottom: 1px solid rgba(255,255,255,0.05);
}
.savings-list li svg { width: 14px; height: 14px; color: var(--accent); flex-shrink: 0; }

/* ─── TESTIMONIALS ───────────────────────────────── */
.testimonials-section {
  background: var(--white);
  padding: 8rem 0;
  overflow: hidden;
}

.testimonials-track-wrap {
  overflow: hidden;
  margin-top: 4rem;
  -webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
  mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
}
.testimonials-track {
  display: flex;
  gap: 1.5rem;
  animation: testimonialSlide 35s linear infinite;
  width: max-content;
}
.testimonials-track:hover { animation-play-state: paused; }
@keyframes testimonialSlide {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}

.testi-card {
  background: var(--offwhite);
  border: 1px solid var(--ice);
  padding: 2.5rem;
  width: 380px;
  flex-shrink: 0;
  position: relative;
  transition: border-color 0.3s, transform 0.3s;
}
.testi-card:hover {
  border-color: var(--frost);
  transform: translateY(-4px);
}
.testi-stars {
  display: flex;
  gap: 3px;
  margin-bottom: 1.5rem;
}
.testi-stars svg { width: 14px; height: 14px; color: #f5c842; }

.testi-quote {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic;
  font-size: 1.05rem;
  line-height: 1.7;
  color: #2a3a4a;
  margin-bottom: 2rem;
}

.testi-author {
  display: flex;
  align-items: center;
  gap: 1rem;
}
.testi-avatar {
  width: 42px; height: 42px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--glacial), var(--frost));
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--deep);
  flex-shrink: 0;
}
.testi-name {
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  color: var(--deep);
  text-transform: uppercase;
}
.testi-role {
  font-size: 0.72rem;
  color: var(--mist);
  margin-top: 0.15rem;
}

.testi-bg-quote {
  position: absolute;
  bottom: 1.5rem; right: 1.5rem;
  width: 40px; height: 40px;
  color: var(--ice);
}

/* ─── FOOTER CTA ──────────────────────────────────── */
.footer-cta {
  background: linear-gradient(135deg, #0d1f35 0%, #0a1628 50%, #081322 100%);
  padding: 7rem 0;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.footer-cta::before {
  content: '';
  position: absolute;
  inset: 0;
  background: repeating-linear-gradient(
    -45deg,
    transparent,
    transparent 40px,
    rgba(255,255,255,0.012) 40px,
    rgba(255,255,255,0.012) 41px
  );
  pointer-events: none;
}
.footer-cta-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.5rem, 6vw, 5rem);
  font-weight: 300;
  color: var(--white);
  margin-bottom: 1.5rem;
  line-height: 1.1;
  position: relative;
}
.footer-cta-desc {
  font-size: 0.9rem;
  color: rgba(200,230,240,0.5);
  max-width: 480px;
  margin: 0 auto 3rem;
  line-height: 1.9;
  position: relative;
}

/* ─── CONTAINERS ─────────────────────────────────── */
.container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 2rem;
}
@media (max-width: 640px) { .container { padding: 0 1.25rem; } }

/* ─── STAGGER DELAYS ──────────────────────────────── */
.delay-1 { transition-delay: 0.1s !important; }
.delay-2 { transition-delay: 0.2s !important; }
.delay-3 { transition-delay: 0.3s !important; }
.delay-4 { transition-delay: 0.4s !important; }
</style>

<!-- ═══════ HERO ═══════ -->
<section class="hero">
  <div class="aurora">
    <div class="aurora-blob"></div>
    <div class="aurora-blob"></div>
    <div class="aurora-blob"></div>
  </div>
  <div class="ripple-container">
    <div class="ripple"></div>
    <div class="ripple"></div>
    <div class="ripple"></div>
    <div class="ripple"></div>
  </div>
  
  <div class="hero-content">
    <p class="hero-eyebrow">Premium Mountain Water &nbsp;·&nbsp; Est. 2020</p>
    <div class="hero-drop">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z" fill="url(#dropGrad)" />
        <defs>
          <linearGradient id="dropGrad" x1="6" y1="4" x2="18" y2="22" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#a8d4e0"/>
            <stop offset="100%" stop-color="#4aa8c8"/>
          </linearGradient>
        </defs>
      </svg>
    </div>
    <h1 class="hero-title">GLACIAR</h1>
    <p class="hero-sub">Pure. Simple. Delivered.</p>
    <div class="hero-cta">
      <a href="{{ route('products.index') }}" class="btn-primary"><span>Order Now</span></a>
      <a href="{{ route('about') }}" class="btn-ghost">Discover More</a>
    </div>
  </div>

  <div class="scroll-hint">
    <span>Scroll</span>
    <div class="scroll-line"></div>
  </div>
</section>

<!-- ═══════ MARQUEE ═══════ -->
<div class="marquee-band">
  <div class="marquee-track">
    @php $items = ['Mountain Spring Source','100% Recyclable','Daily Delivery','Zero Waste','Premium Quality','Natural Filtration','Pure Minerals','Eco Packaging','Cold Chain Secured','Sri Lanka\'s Finest']; @endphp
    @foreach(array_merge($items, $items) as $item)
      <span class="marquee-item">
        <span class="marquee-dot"></span>
        {{ $item }}
      </span>
    @endforeach
  </div>
</div>

<!-- ═══════ WHY GLACIAR ═══════ -->
<section class="why-section">
  <div class="container">
    <div class="section-reveal">
      <p class="section-label">Our Promise</p>
      <h2 class="section-title">Why choose<br><em>Glaciar?</em></h2>
    </div>

    <div class="feature-cards section-reveal">
      <div class="feature-card">
        <span class="feature-num">01</span>
        <svg class="feature-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="feature-title">Mountain Source</p>
        <p class="feature-desc">Drawn from pristine alpine springs and naturally filtered through ancient rock strata, every drop carries untouched mineral purity.</p>
      </div>
      <div class="feature-card">
        <span class="feature-num">02</span>
        <svg class="feature-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="feature-title">Daily Delivery</p>
        <p class="feature-desc">Dependable, punctual delivery straight to your doorstep. Choose your schedule — we arrive when you need us, every single time.</p>
      </div>
      <div class="feature-card">
        <span class="feature-num">03</span>
        <svg class="feature-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        <p class="feature-title">Eco Packaging</p>
        <p class="feature-desc">100% recyclable bottles and a closed-loop return system means zero waste to landfill. Pure water, pure conscience.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════ PRODUCTS ═══════ -->
<section class="products-section">
  <div class="container">
    <div class="products-header section-reveal">
      <div>
        <p class="section-label" style="color:rgba(74,168,200,0.7)">Our Range</p>
        <h2 class="section-title" style="color:var(--white); margin-bottom:0">Choose<br><em style="color:var(--accent)">your size</em></h2>
      </div>
      <a href="{{ route('products.index') }}" class="view-all-link">
        View all products
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="product-grid section-reveal">
      @forelse($featuredProducts ?? [] as $product)
        <a href="{{ route('products.show', $product->id) }}" class="product-tile" style="text-decoration:none">
          <div class="product-drop-wrap">
            <svg class="product-drop-svg" viewBox="0 0 80 100" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M40 5 C40 5, 72 42, 72 60 C72 80, 57.6 92, 40 92 C22.4 92, 8 80, 8 60 C8 42, 40 5, 40 5Z" fill="url(#bottleGrad{{ $product->id }})" opacity="0.9"/>
              <path d="M28 58 C28 68, 33.5 74, 40 74" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" stroke-linecap="round"/>
              <defs>
                <linearGradient id="bottleGrad{{ $product->id }}" x1="8" y1="5" x2="72" y2="92" gradientUnits="userSpaceOnUse">
                  <stop offset="0%" stop-color="#a8d4e0"/>
                  <stop offset="100%" stop-color="#2a7090"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <p class="product-name">{{ $product->name }}</p>
          <p class="product-size">{{ number_format($product->size_ml >= 1000 ? $product->size_ml/1000 : $product->size_ml, $product->size_ml >= 1000 ? 1 : 0) }}{{ $product->size_ml >= 1000 ? 'L' : 'ml' }}</p>
          <p class="product-price"><span class="product-currency">Rs</span>{{ number_format($product->price) }}</p>
        </a>
      @empty
        @foreach([
          ['id'=>1,'name'=>'Glaciar Mini','size_ml'=>250,'price'=>50],
          ['id'=>2,'name'=>'Glaciar Standard','size_ml'=>500,'price'=>80],
          ['id'=>5,'name'=>'Glaciar Jug','size_ml'=>5000,'price'=>500],
          ['id'=>6,'name'=>'Glaciar Dispenser','size_ml'=>19000,'price'=>350],
        ] as $idx => $p)
        <a href="#" class="product-tile" style="text-decoration:none">
          <div class="product-drop-wrap">
            <svg class="product-drop-svg" viewBox="0 0 80 100" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M40 5 C40 5, 72 42, 72 60 C72 80, 57.6 92, 40 92 C22.4 92, 8 80, 8 60 C8 42, 40 5, 40 5Z" fill="url(#bg{{ $idx }})" opacity="0.9"/>
              <path d="M28 58 C28 68, 33.5 74, 40 74" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" stroke-linecap="round"/>
              <defs>
                <linearGradient id="bg{{ $idx }}" x1="8" y1="5" x2="72" y2="92" gradientUnits="userSpaceOnUse">
                  <stop offset="0%" stop-color="#a8d4e0"/>
                  <stop offset="100%" stop-color="#2a7090"/>
                </linearGradient>
              </defs>
            </svg>
          </div>
          <p class="product-name">{{ $p['name'] }}</p>
          <p class="product-size">{{ $p['size_ml'] >= 1000 ? ($p['size_ml']/1000).'L' : $p['size_ml'].'ml' }}</p>
          <p class="product-price"><span class="product-currency">Rs</span>{{ number_format($p['price']) }}</p>
        </a>
        @endforeach
      @endforelse
    </div>
  </div>
</section>

<!-- ═══════ HOW IT WORKS ═══════ -->
<section class="how-section">
  <div class="container">
    <div class="section-reveal" style="text-align:center">
      <p class="section-label">The Process</p>
      <h2 class="section-title" style="margin-bottom:0">Simple as<br><em>three steps</em></h2>
    </div>

    <div class="steps-grid">
      <div class="step-card section-reveal-left delay-1">
        <span class="step-number">01</span>
        <svg class="step-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <p class="step-title">Choose your bottles</p>
        <p class="step-desc">Select from our curated range — from personal 250ml bottles to 19L office dispenser jugs. Mix and match freely.</p>
      </div>
      
      <div class="step-connector section-reveal delay-2">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </div>

      <div class="step-card section-reveal delay-2">
        <span class="step-number">02</span>
        <svg class="step-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
        </svg>
        <p class="step-title">We deliver to you</p>
        <p class="step-desc">Our dedicated team brings fresh water straight to your home or office on your chosen schedule. No hassle, no delays.</p>
      </div>

      <div class="step-connector section-reveal delay-3">
        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </div>

      <div class="step-card section-reveal-left delay-4" style="transition-delay:0.4s">
        <span class="step-number">03</span>
        <svg class="step-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <p class="step-title">Pay on delivery</p>
        <p class="step-desc">Cash or card upon arrival. No hidden fees, no subscriptions required. Pure simplicity, just like our water.</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══════ CTA ═══════ -->
<section class="cta-section">
  <div class="cta-bg-text">SUBSCRIBE</div>
  <div class="container">
    <div class="cta-inner">
      <div class="section-reveal-left">
        <div class="cta-badge">
          <span class="cta-badge-dot"></span>
          Available Now
        </div>
        <h2 class="cta-title">Subscribe<br>& <em>Save More</em></h2>
        <p class="cta-desc">Never worry about running out again. Set up a weekly delivery and unlock exclusive subscriber savings with every order.</p>
        <a href="{{ route('products.index') }}" class="btn-primary"><span>Set Up Weekly Delivery</span></a>
      </div>
      <div class="section-reveal delay-2">
        <div class="savings-card">
          <span class="savings-pct">15%</span>
          <span class="savings-label">Subscriber Discount</span>
          <ul class="savings-list">
            <li>
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Guaranteed weekly delivery slot
            </li>
            <li>
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Priority customer support
            </li>
            <li>
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Free bottle exchange service
            </li>
            <li>
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              Cancel or pause anytime
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════ TESTIMONIALS ═══════ -->
<section class="testimonials-section">
  <div class="container">
    <div class="section-reveal" style="text-align:center">
      <p class="section-label">Social Proof</p>
      <h2 class="section-title">What our<br><em>customers say</em></h2>
    </div>
  </div>

  @php
  $testimonials = [
    ['quote'=>'Glaciar has been supplying our restaurant for over a year. Delivery is always on time and the 19L bottles are exceptional quality.','name'=>'Michael Fernando','role'=>'Restaurant Owner','init'=>'MF'],
    ['quote'=>'Set up a weekly subscription for home and it\'s been life-changing. Never having to carry heavy bottles from the supermarket again.','name'=>'Sarah Perera','role'=>'Home Customer','init'=>'SP'],
    ['quote'=>'The app makes ordering effortless, and the reps are always friendly. Perfect for our growing startup office.','name'=>'David Wijesinghe','role'=>'Office Manager','init'=>'DW'],
    ['quote'=>'Switched from a competitor six months ago and never looked back. The water quality difference is noticeable immediately.','name'=>'Priya Rajapaksa','role'=>'Wellness Coach','init'=>'PR'],
    ['quote'=>'Outstanding service. The delivery drivers are polite, punctual, and always handle the large jugs with care.','name'=>'James Nonis','role'=>'Hotel Manager','init'=>'JN'],
  ];
  @endphp

  <div class="testimonials-track-wrap">
    <div class="testimonials-track">
      @foreach(array_merge($testimonials, $testimonials) as $t)
      <div class="testi-card">
        <div class="testi-stars">
          @for($i=0;$i<5;$i++)
          <svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          @endfor
        </div>
        <p class="testi-quote">"{{ $t['quote'] }}"</p>
        <div class="testi-author">
          <div class="testi-avatar">{{ $t['init'] }}</div>
          <div>
            <p class="testi-name">{{ $t['name'] }}</p>
            <p class="testi-role">{{ $t['role'] }}</p>
          </div>
        </div>
        <svg class="testi-bg-quote" fill="currentColor" viewBox="0 0 24 24"><path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z"/></svg>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- ═══════ FOOTER CTA ═══════ -->
<section class="footer-cta">
  <div class="container">
    <p class="section-label" style="color:rgba(74,168,200,0.6); margin-bottom:1.5rem">Ready to start?</p>
    <h2 class="footer-cta-title section-reveal">Experience the<br><em style="font-style:italic; color:var(--accent)">Glaciar difference</em></h2>
    <p class="footer-cta-desc section-reveal">Join thousands of homes and businesses across Sri Lanka who trust Glaciar for their pure water needs.</p>
    <div class="section-reveal">
      <a href="{{ route('products.index') }}" class="btn-primary"><span>Start Ordering Today</span></a>
    </div>
  </div>
</section>

<script>
// Scroll reveal
const revealEls = document.querySelectorAll('.section-reveal, .section-reveal-left');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      observer.unobserve(e.target);
    }
  });
}, { threshold: 0.12 });
revealEls.forEach(el => observer.observe(el));
</script>

@endsection