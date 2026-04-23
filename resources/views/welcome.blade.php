<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EasyPark – Smart Intelligence Parking System</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #0b0e13;
    --bg2: #10141c;
    --bg3: #151a25;
    --accent: #22d47e;
    --accent2: #1bb868;
    --text: #e8eaf2;
    --muted: #7a8196;
    --border: rgba(255,255,255,0.07);
    --card: rgba(255,255,255,0.04);
    --glow: rgba(34,212,126,0.18);
  }
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }
  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    line-height: 1.6;
    overflow-x: hidden;
  }

  /* ── NOISE TEXTURE OVERLAY ── */
  body::before {
    content: '';
    position: fixed; inset: 0; z-index: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
    opacity: 0.4;
  }
  body > * { position: relative; z-index: 1; }

  /* ── NAVBAR ── */
  nav {
    position: sticky; top: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 5%;
    height: 64px;
    background: rgba(11,14,19,0.85);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
  }
  .nav-logo {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: 1.4rem;
    color: var(--accent);
    letter-spacing: -0.03em;
    display: flex; align-items: center; gap: 8px;
  }
  .nav-logo svg { width: 28px; height: 28px; }
  .nav-links { display: flex; gap: 2rem; list-style: none; }
  .nav-links a {
    text-decoration: none;
    color: var(--muted);
    font-size: 0.88rem;
    font-weight: 500;
    transition: color .2s;
  }
  .nav-links a:hover { color: var(--text); }
  .nav-actions { display: flex; gap: 12px; align-items: center; }
  .btn-ghost {
    background: none; border: 1px solid var(--border);
    color: var(--text); padding: 7px 18px; border-radius: 8px;
    font-size: 0.85rem; cursor: pointer; font-family: inherit;
    transition: border-color .2s, color .2s;
  }
  .btn-ghost:hover { border-color: var(--accent); color: var(--accent); }
  .btn-primary {
    background: var(--accent); border: none;
    color: #0b0e13; padding: 8px 20px; border-radius: 8px;
    font-size: 0.85rem; font-weight: 700; cursor: pointer; font-family: inherit;
    transition: background .2s, transform .15s;
  }
  .btn-primary:hover { background: #1eee8a; transform: translateY(-1px); }

  /* ── TOP BANNER ── */
  .top-banner {
    background: rgba(34,212,126,0.08);
    border-bottom: 1px solid rgba(34,212,126,0.15);
    text-align: center; padding: 10px;
    font-size: 0.8rem; color: var(--accent);
  }
  .top-banner span { opacity: .7; color: var(--text); margin-right: 6px; }

  /* ── HERO ── */
  .hero {
    position: relative;
    min-height: 90vh;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    text-align: center;
    padding: 80px 5% 60px;
    overflow: hidden;
  }
  .hero-grid {
    position: absolute; inset: 0; z-index: 0;
    background-image:
      linear-gradient(rgba(34,212,126,0.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(34,212,126,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
    mask-image: radial-gradient(ellipse 70% 60% at 50% 50%, black, transparent);
  }
  .hero-glow {
    position: absolute; top: 0; left: 50%; transform: translateX(-50%);
    width: 600px; height: 600px; border-radius: 50%;
    background: radial-gradient(circle, rgba(34,212,126,0.12) 0%, transparent 70%);
    pointer-events: none;
  }
  .hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(34,212,126,0.1);
    border: 1px solid rgba(34,212,126,0.25);
    border-radius: 100px; padding: 6px 16px;
    font-size: 0.75rem; color: var(--accent); margin-bottom: 28px;
    animation: fadeUp .6s ease both;
  }
  .hero-badge::before {
    content: ''; width: 6px; height: 6px; border-radius: 50%;
    background: var(--accent); box-shadow: 0 0 8px var(--accent);
    animation: pulse 1.8s ease infinite;
  }
  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }
  .hero h1 {
    font-family: 'Syne', sans-serif;
    font-size: clamp(2.6rem, 6vw, 5.2rem);
    font-weight: 800;
    line-height: 1.08;
    letter-spacing: -0.04em;
    margin-bottom: 22px;
    animation: fadeUp .7s .1s ease both;
  }
  .hero h1 em { font-style: italic; color: var(--accent); }
  .hero p {
    max-width: 540px; color: var(--muted);
    font-size: 1.05rem; margin-bottom: 36px;
    animation: fadeUp .7s .2s ease both;
  }
  .hero-cta {
    display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;
    animation: fadeUp .7s .3s ease both;
  }
  .btn-lg {
    background: var(--accent); color: #0b0e13;
    border: none; padding: 14px 36px; border-radius: 10px;
    font-size: 1rem; font-weight: 700; cursor: pointer; font-family: inherit;
    box-shadow: 0 0 32px rgba(34,212,126,0.35);
    transition: transform .15s, box-shadow .2s;
  }
  .btn-lg:hover { transform: translateY(-2px); box-shadow: 0 0 48px rgba(34,212,126,0.5); }
  .hero-links {
    display: flex; gap: 24px; margin-top: 20px;
    animation: fadeUp .7s .4s ease both;
  }
  .hero-links a {
    color: var(--muted); text-decoration: none; font-size: 0.9rem;
    border-bottom: 1px solid var(--border); padding-bottom: 2px;
    transition: color .2s, border-color .2s;
  }
  .hero-links a:hover { color: var(--accent); border-color: var(--accent); }

  /* Dashboard mockup */
  .hero-mockup {
    position: relative; margin-top: 64px; width: 100%; max-width: 780px;
    animation: fadeUp .8s .5s ease both;
  }
  .mockup-window {
    background: var(--bg2);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 40px 120px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.05);
  }
  .mockup-bar {
    background: rgba(255,255,255,0.04);
    padding: 10px 16px;
    display: flex; align-items: center; gap: 8px;
    border-bottom: 1px solid var(--border);
  }
  .dot { width: 10px; height: 10px; border-radius: 50%; }
  .dot.r { background: #ff5f56; }
  .dot.y { background: #ffbd2e; }
  .dot.g { background: #27c93f; }
  .mockup-url {
    flex: 1; background: rgba(255,255,255,0.05);
    border-radius: 6px; padding: 4px 12px;
    font-size: 0.72rem; color: var(--muted);
    text-align: center;
  }
  .mockup-body { padding: 24px; }
  .dash-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px;
  }
  .dash-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.1rem; }
  .dash-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
  .dash-card {
    background: var(--bg3); border: 1px solid var(--border);
    border-radius: 10px; padding: 14px;
  }
  .dash-card-label { font-size: 0.68rem; color: var(--muted); margin-bottom: 6px; }
  .dash-card-val { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.6rem; }
  .dash-card-val.green { color: var(--accent); }
  .dash-card-val.yellow { color: #f5c842; }
  .dash-card-val.red { color: #f06060; }
  .dash-table {
    background: var(--bg3); border: 1px solid var(--border);
    border-radius: 10px; overflow: hidden;
  }
  .dash-table-header {
    display: grid; grid-template-columns: 2fr 1.5fr 1fr 1fr;
    padding: 10px 16px;
    font-size: 0.68rem; color: var(--muted); text-transform: uppercase;
    letter-spacing: .06em; border-bottom: 1px solid var(--border);
  }
  .dash-table-row {
    display: grid; grid-template-columns: 2fr 1.5fr 1fr 1fr;
    padding: 10px 16px; font-size: 0.78rem;
    border-bottom: 1px solid var(--border);
    transition: background .15s;
  }
  .dash-table-row:last-child { border-bottom: none; }
  .dash-table-row:hover { background: rgba(255,255,255,0.03); }
  .badge {
    display: inline-block; padding: 2px 10px; border-radius: 100px;
    font-size: 0.68rem; font-weight: 600;
  }
  .badge.in { background: rgba(34,212,126,0.15); color: var(--accent); }
  .badge.out { background: rgba(240,96,96,0.15); color: #f06060; }

  @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }

  /* ── SECTION GENERIC ── */
  section { padding: 96px 5%; }
  .section-label {
    font-size: 0.75rem; letter-spacing: .12em; text-transform: uppercase;
    color: var(--accent); margin-bottom: 14px; font-weight: 600;
  }
  .section-title {
    font-family: 'Syne', sans-serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800; letter-spacing: -0.03em;
    line-height: 1.1; margin-bottom: 18px;
  }
  .section-sub { color: var(--muted); max-width: 520px; line-height: 1.7; }

  /* ── ABOUT ── */
  .about { background: var(--bg2); }
  .about-inner {
    display: grid; grid-template-columns: 1fr 1fr; gap: 64px;
    align-items: center;
  }
  .about-text p { color: var(--muted); margin-bottom: 16px; line-height: 1.75; font-size: 0.95rem; }
  .btn-outline {
    display: inline-flex; align-items: center; gap: 8px;
    border: 1px solid var(--border); color: var(--text);
    padding: 10px 22px; border-radius: 9px; text-decoration: none;
    font-size: 0.88rem; font-weight: 500; transition: border-color .2s, color .2s;
  }
  .btn-outline:hover { border-color: var(--accent); color: var(--accent); }
  .about-visual {
    background: var(--bg3);
    border: 1px solid var(--border);
    border-radius: 14px; padding: 28px;
    position: relative; overflow: hidden;
  }
  .about-visual::before {
    content: ''; position: absolute; top: -40px; right: -40px;
    width: 200px; height: 200px; border-radius: 50%;
    background: radial-gradient(circle, rgba(34,212,126,0.08) 0%, transparent 70%);
  }
  .doc-stack { display: flex; flex-direction: column; gap: 10px; }
  .doc-item {
    background: rgba(255,255,255,0.05); border: 1px solid var(--border);
    border-radius: 9px; padding: 12px 16px;
    display: flex; align-items: center; gap: 12px; font-size: 0.85rem;
    transition: transform .2s, border-color .2s;
    cursor: pointer;
  }
  .doc-item:hover { transform: translateX(4px); border-color: rgba(34,212,126,0.3); }
  .doc-icon { width: 32px; height: 32px; border-radius: 6px; display: grid; place-items: center; flex-shrink: 0; }
  .doc-icon.blue { background: rgba(96,160,255,0.15); color: #60a0ff; }
  .doc-icon.green { background: rgba(34,212,126,0.15); color: var(--accent); }
  .doc-icon.yellow { background: rgba(245,200,66,0.15); color: #f5c842; }
  .doc-icon.red { background: rgba(240,96,96,0.15); color: #f06060; }
  .doc-name { font-weight: 500; }
  .doc-meta { font-size: 0.72rem; color: var(--muted); }

  /* ── FEATURES ── */
  .features-inner {
    display: grid; grid-template-columns: 1fr 1fr; gap: 64px;
    align-items: center;
  }
  .feature-visual {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 10px;
  }
  .soc-badge {
    background: var(--bg3); border: 1px solid var(--border);
    border-radius: 10px; padding: 12px 8px;
    text-align: center; font-size: 0.68rem; color: var(--muted);
    font-weight: 600; letter-spacing: .05em;
    transition: border-color .2s, transform .2s;
    cursor: default;
  }
  .soc-badge:hover { border-color: rgba(34,212,126,0.35); transform: scale(1.04); color: var(--accent); }
  .feature-list { display: flex; flex-direction: column; gap: 24px; }
  .feature-item { display: flex; gap: 16px; }
  .feature-icon {
    width: 42px; height: 42px; border-radius: 10px; flex-shrink: 0;
    background: rgba(34,212,126,0.1); border: 1px solid rgba(34,212,126,0.2);
    display: grid; place-items: center; color: var(--accent); font-size: 1.1rem;
  }
  .feature-item h4 { font-family: 'Syne', sans-serif; font-weight: 700; margin-bottom: 5px; font-size: 0.95rem; }
  .feature-item p { font-size: 0.85rem; color: var(--muted); line-height: 1.65; }

  /* ── CTA STRIP ── */
  .cta-strip {
    background: var(--bg2);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 56px 5%;
    text-align: center;
  }
  .cta-strip p { color: var(--muted); font-size: 0.88rem; margin-bottom: 6px; }
  .cta-strip h2 {
    font-family: 'Syne', sans-serif;
    font-size: clamp(1.6rem, 3.5vw, 2.6rem);
    font-weight: 800; letter-spacing: -0.03em;
    line-height: 1.15; margin-bottom: 32px;
  }
  .cta-form { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
  .cta-input {
    background: var(--bg3); border: 1px solid var(--border);
    color: var(--text); padding: 12px 20px; border-radius: 10px;
    font-family: inherit; font-size: 0.9rem; width: 280px;
    transition: border-color .2s;
  }
  .cta-input:focus { outline: none; border-color: var(--accent); }
  .cta-input::placeholder { color: var(--muted); }
  .meta-row {
    display: flex; gap: 32px; justify-content: center;
    margin-top: 20px; font-size: 0.78rem; color: var(--muted);
  }
  .meta-row span { display: flex; align-items: center; gap: 6px; }
  .meta-row .dot2 { width: 6px; height: 6px; border-radius: 50%; background: var(--accent); }

  /* ── LOGOS ── */
  .logos { text-align: center; padding: 56px 5%; }
  .logos p { font-size: 0.8rem; color: var(--muted); margin-bottom: 24px; letter-spacing: .08em; text-transform: uppercase; }
  .logo-row { display: flex; justify-content: center; align-items: center; gap: 48px; flex-wrap: wrap; }
  .logo-placeholder {
    background: var(--bg3); border: 1px solid var(--border);
    border-radius: 10px; padding: 16px 24px;
    display: flex; align-items: center; gap: 10px;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.9rem;
    color: var(--muted);
    transition: border-color .2s, color .2s;
  }
  .logo-placeholder:hover { border-color: rgba(34,212,126,0.3); color: var(--text); }
  .logo-circle { width: 28px; height: 28px; border-radius: 50%; background: var(--accent); }

  /* ── FOOTER ── */
  footer {
    background: var(--bg2);
    border-top: 1px solid var(--border);
    padding: 56px 5% 32px;
  }
  .footer-top {
    display: grid;
    grid-template-columns: 1.6fr 1fr 1fr 1fr 1fr;
    gap: 40px; margin-bottom: 48px;
  }
  .footer-brand .nav-logo { margin-bottom: 14px; }
  .footer-brand p { font-size: 0.83rem; color: var(--muted); line-height: 1.7; }
  .footer-col h5 {
    font-family: 'Syne', sans-serif; font-weight: 700;
    font-size: 0.8rem; text-transform: uppercase; letter-spacing: .1em;
    margin-bottom: 16px; color: var(--text);
  }
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
  .footer-col ul a { text-decoration: none; color: var(--muted); font-size: 0.82rem; transition: color .2s; }
  .footer-col ul a:hover { color: var(--accent); }
  .footer-bottom {
    border-top: 1px solid var(--border);
    padding-top: 24px;
    display: flex; justify-content: space-between; align-items: center;
    font-size: 0.78rem; color: var(--muted); flex-wrap: wrap; gap: 12px;
  }
  .footer-bottom a { color: var(--muted); text-decoration: none; }
  .footer-bottom a:hover { color: var(--accent); }
  .social-row { display: flex; gap: 12px; }
  .social-icon {
    width: 32px; height: 32px; border-radius: 7px;
    background: var(--bg3); border: 1px solid var(--border);
    display: grid; place-items: center; font-size: 0.85rem;
    color: var(--muted); text-decoration: none;
    transition: border-color .2s, color .2s;
  }
  .social-icon:hover { border-color: var(--accent); color: var(--accent); }

  /* ── RESPONSIVE ── */
  @media(max-width:900px) {
    .about-inner, .features-inner { grid-template-columns: 1fr; gap: 40px; }
    .dash-cards { grid-template-columns: repeat(2,1fr); }
    .footer-top { grid-template-columns: 1fr 1fr; }
    .nav-links { display: none; }
    .feature-visual { grid-template-columns: repeat(3,1fr); }
  }
  @media(max-width:540px) {
    .dash-cards { grid-template-columns: 1fr 1fr; }
    .footer-top { grid-template-columns: 1fr; }
    .cta-form { flex-direction: column; align-items: center; }
    .cta-input { width: 100%; max-width: 340px; }
  }

  /* ── SCROLL REVEAL ── */
  .reveal {
    opacity: 0; transform: translateY(28px);
    transition: opacity .65s ease, transform .65s ease;
  }
  .reveal.visible { opacity: 1; transform: none; }
</style>
</head>
<body>

<!-- TOP BANNER -->
<div class="top-banner">
  <span>🛡️</span> Keamanan Parkir Cerdas dengan Teknologi Masa Depan — 
  <strong style="color:var(--accent)">Face Recognition + OCR Plate Detection</strong>
</div>

<!-- NAVBAR -->
<nav>
  <div class="nav-logo">
    <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect width="32" height="32" rx="8" fill="rgba(34,212,126,0.15)"/>
      <path d="M8 20L12 10L16 18L20 13L24 20" stroke="#22d47e" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
      <circle cx="16" cy="10" r="2" fill="#22d47e"/>
    </svg>
    EasyPark
  </div>
  <ul class="nav-links">
    <li><a href="#about">Beranda</a></li>
    <li><a href="#about">Tentang Kami</a></li>
    <li><a href="#features">Keunggulan</a></li>
    <li><a href="#contact">Hubungi Kami</a></li>
  </ul>
  <div class="nav-actions">
    <button class="btn-ghost">Login</button>
    <button class="btn-primary">Request Demo</button>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-grid"></div>
  <div class="hero-glow"></div>

  <div class="hero-badge">Sistem Parkir Cerdas Generasi Berikutnya</div>

  <h1>The <em>future</em> of trust.<br>Powered by EasyPark.</h1>
  <p>Gak perlu ribet cari tiket atau antri lama di gerbang parkir. Dengan teknologi Face Recognition dan Plate Detection, kamu bisa masuk parkir kampus dalam hitungan detik.</p>

  <div class="hero-cta">
    <button class="btn-lg">Get Started</button>
  </div>

  <div class="hero-links">
    <a href="#">Cek Status Kendaraan</a>
    <a href="#">Daftar Kendaraan</a>
  </div>

  <!-- Dashboard Mockup -->
  <div class="hero-mockup">
    <div class="mockup-window">
      <div class="mockup-bar">
        <div class="dot r"></div><div class="dot y"></div><div class="dot g"></div>
        <div class="mockup-url">parklandal.my.id/dashboard</div>
      </div>
      <div class="mockup-body">
        <div class="dash-header">
          <div class="dash-title">Dashboard</div>
          <div style="font-size:0.75rem;color:var(--muted)">Parkir Pintar v1.2</div>
        </div>
        <div class="dash-cards">
          <div class="dash-card">
            <div class="dash-card-label">Mahasiswa</div>
            <div class="dash-card-val green">11</div>
            <div style="font-size:.68rem;color:var(--muted)">Aktif Terdaftar</div>
          </div>
          <div class="dash-card">
            <div class="dash-card-label">Kendaraan</div>
            <div class="dash-card-val" style="color:#60a0ff">6</div>
            <div style="font-size:.68rem;color:var(--muted)">Total Kendaraan</div>
          </div>
          <div class="dash-card">
            <div class="dash-card-label">Parkir Mahasiswa</div>
            <div class="dash-card-val yellow">0</div>
            <div style="font-size:.68rem;color:var(--muted)">Sedang Parkir</div>
          </div>
          <div class="dash-card">
            <div class="dash-card-label">Parkir Tamu</div>
            <div class="dash-card-val red">0</div>
            <div style="font-size:.68rem;color:var(--muted)">Tamu Aktif</div>
          </div>
        </div>
        <div class="dash-table">
          <div class="dash-table-header">
            <div>NIM</div><div>Nama</div><div>Plat Nomor</div><div>Status</div>
          </div>
          <div class="dash-table-row">
            <div>221010201</div><div>Arif Santoso</div><div>N 4521 ZA</div>
            <div><span class="badge in">Masuk</span></div>
          </div>
          <div class="dash-table-row">
            <div>221010178</div><div>Dewi Rahayu</div><div>P 8832 BS</div>
            <div><span class="badge out">Keluar</span></div>
          </div>
          <div class="dash-table-row">
            <div>221010093</div><div>Budi Permana</div><div>N 1120 AC</div>
            <div><span class="badge in">Masuk</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="about" id="about">
  <div class="about-inner reveal">
    <div class="about-text">
      <div class="section-label">Tentang Kami</div>
      <h2 class="section-title">EasyPark: Smart Intelligence Parking System</h2>
      <p>EasyPark hadir sebagai solusi parkir kampus yang menggabungkan keamanan, efisiensi, dan teknologi cerdas dalam satu sistem terintegrasi. Kami mengembangkan platform berbasis kecerdasan buatan dengan memanfaatkan Face Recognition dan Deteksi Plat Nomor untuk mengenal serta memverifikasi setiap kendaraan secara otomatis dan akurat.</p>
      <p>Dengan menggantikan metode parkir konvensional, EasyPark mampu mengurangi antrian, meningkatkan keselamatan manusia, serta meningkatkan kenyamanan bagi seluruh civitas akademika. Sistem kami dirancang bekerja secara real-time, mulai dari akses masuk hingga keluar area parkir.</p>
      <p>Kami percaya bahwa lingkungan kampus modern membutuhkan sistem yang tidak hanya cepat, tetapi juga aman dan dapat diandalkan. Oleh karena itu, EasyPark dibangun untuk memberikan kontrol akses yang terbaik, pencatatan data yang terstruktur, serta pengalaman parkir yang lebih praktis, tanpa tiket dan tanpa kontak.</p>
      <a href="#features" class="btn-outline" style="margin-top:8px">
        Lihat Lebih Rinci
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 4l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
    <div class="about-visual">
      <div style="font-size:.72rem;color:var(--muted);margin-bottom:16px;text-transform:uppercase;letter-spacing:.08em">Dokumen & Laporan</div>
      <div class="doc-stack">
        <div class="doc-item">
          <div class="doc-icon blue">📋</div>
          <div>
            <div class="doc-name">Forms — Pendaftaran Kendaraan</div>
            <div class="doc-meta">Terakhir diperbarui 2 jam lalu</div>
          </div>
        </div>
        <div class="doc-item">
          <div class="doc-icon green">📊</div>
          <div>
            <div class="doc-name">Reports — Aktivitas Parkir Harian</div>
            <div class="doc-meta">48 entri · April 2025</div>
          </div>
        </div>
        <div class="doc-item">
          <div class="doc-icon yellow">📄</div>
          <div>
            <div class="doc-name">Documents — SOP Keamanan Parkir</div>
            <div class="doc-meta">Versi 3.1 · Aktif</div>
          </div>
        </div>
        <div class="doc-item">
          <div class="doc-icon red">📬</div>
          <div>
            <div class="doc-name">Requests — Akses Tamu & Pengunjung</div>
            <div class="doc-meta">12 permintaan menunggu</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section id="features" style="background:var(--bg)">
  <div class="features-inner reveal">
    <div class="feature-visual">
      <!-- SOC Badge Grid -->
      <div class="soc-badge">FFIEC</div>
      <div class="soc-badge">SOC 1</div>
      <div class="soc-badge">ESG</div>
      <div class="soc-badge">HITRUST</div>
      <div class="soc-badge">NIST CSF</div>
      <div class="soc-badge">COSC</div>
      <div class="soc-badge">PCI DSS</div>
      <div class="soc-badge">SOC 2</div>
      <div class="soc-badge">HIPAA</div>
      <div class="soc-badge">FedRAMP</div>
      <div class="soc-badge">NIST CSF</div>
      <div class="soc-badge">SOC 2</div>
      <div class="soc-badge">SOC 1</div>
      <div class="soc-badge">PCI DSS</div>
      <div class="soc-badge">CMMC</div>
      <div class="soc-badge">FFIEC</div>
      <div class="soc-badge">HITRUST</div>
      <div class="soc-badge">ESG</div>
    </div>
    <div>
      <div class="section-label">Fitur Unggulan</div>
      <h2 class="section-title">Fitur unggulan yang mengintegrasikan keamanan, efisiensi, dan otomatisasi dalam satu sistem parkir modern.</h2>
      <div class="feature-list">
        <div class="feature-item">
          <div class="feature-icon">👤</div>
          <div>
            <h4>Face Recognition (Konfirmasi Pemilik)</h4>
            <p>Keamanan ekstra bagi mahasiswa. Sistem akan meminimasi wajah pengendara untuk memastikan bahwa orang yang membawa kendaraan adalah pemilik sah atau pengguna yang terdaftar di sistem.</p>
          </div>
        </div>
        <div class="feature-item">
          <div class="feature-icon">🚗</div>
          <div>
            <h4>OCR Plate Detection: Sistem Tiket Nirkabel</h4>
            <p>Kamera kami secara otomatis mendeteksi dan mengenali plat nomor kendaraan (OCR) untuk membuka palang pintu dan mencatat waktu masuk secara real-time.</p>
          </div>
        </div>
        <div class="feature-item">
          <div class="feature-icon">🔒</div>
          <div>
            <h4>Verifikasi Ganda Terintegrasi</h4>
            <p>Sistem mencocokkan data wajah pengendara dengan nomor plat kendaraan dalam satu proses identifikasi, meminimalkan risiko pencurian dan alih kendaraan.</p>
          </div>
        </div>
        <div class="feature-item">
          <div class="feature-icon">⚡</div>
          <div>
            <h4>Efisiensi Alur Parkir</h4>
            <p>Mengurangi antrian di gerbang parkir karena proses identifikasi berlangsung cepat dalam hitungan detik.</p>
          </div>
        </div>
      </div>
      <a href="#" class="btn-outline" style="margin-top:24px">
        Lihat Selengkapnya
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 4l3 3-3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- TRUST STRIP -->
<div style="background:var(--bg2);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:32px 5%;text-align:center;">
  <p style="font-family:'Syne',sans-serif;font-size:clamp(1rem,2.5vw,1.4rem);font-weight:700;color:var(--muted);letter-spacing:-.02em">
    Jangan pertanyakan metode kami. Patuhi protokolnya, atau tetaplah di luar.
  </p>
  <p style="font-size:.82rem;color:var(--muted);margin-top:8px">
    EasyPark adalah platform modern dan inovatif yang menggerakkan keamanan terdepan di kampus Anda.
  </p>
</div>

<!-- CTA STRIP -->
<div class="cta-strip reveal" id="contact">
  <p>Jangan Biarkan Keamanan Anda Menjadi Spekulasi.</p>
  <h2>Jangan Biarkan Keamanan Anda Menjadi Spekulasi.<br>Masuklah ke dalam ekosistem perlindungan kami<br>sebelum terlambat.</h2>

  <div class="meta-row" style="margin-bottom:20px;justify-content:center">
    <span><div class="dot2"></div> Jangan Biarkan Keamanan Anda Menjadi Spekulasi.</span>
    <span>Direct Line: <strong style="color:var(--accent)">support@easypark.id</strong></span>
    <span>Status: <strong style="color:var(--accent)">System Active | Monitoring 24/7</strong></span>
  </div>

  <div class="cta-form">
    <input type="email" class="cta-input" placeholder="Your E-mail">
    <button class="btn-lg" style="padding:12px 32px;font-size:.9rem">Get Started</button>
  </div>

  <!-- Partner logos -->
  <div class="logos" style="padding:40px 0 0">
    <div class="logo-row">
      <div class="logo-placeholder">
        <div class="logo-circle" style="background:linear-gradient(135deg,#22d47e,#1bb868)"></div>
        Politeknik Negeri Jember
      </div>
      <div class="logo-placeholder">
        <div class="logo-circle" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8)"></div>
        BLU
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <div class="nav-logo">
        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="32" height="32" rx="8" fill="rgba(34,212,126,0.15)"/>
          <path d="M8 20L12 10L16 18L20 13L24 20" stroke="#22d47e" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="16" cy="10" r="2" fill="#22d47e"/>
        </svg>
        EasyPark
      </div>
      <p>Kami adalah tim pengembang yang berfokus menghadirkan sistem parkir cerdas berbasis QR-Code di lingkungan kampus. Tanpa antri, tanpa tiket. Cukup dengan aplikasi ini, parkir menjadi lebih praktis dan efisien.</p>
    </div>
    <div class="footer-col">
      <h5>About Us</h5>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Menu</a></li>
        <li><a href="#">Gallery</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h5>Navigation</h5>
      <ul>
        <li><a href="#">Beranda</a></li>
        <li><a href="#">Tentang Kami</a></li>
        <li><a href="#">Keunggulan</a></li>
        <li><a href="#">Hubungi Kami</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h5>Service</h5>
      <ul>
        <li><a href="#">Login Admin</a></li>
        <li><a href="#">Login Mahasiswa</a></li>
        <li><a href="#">Riwayat Parkir</a></li>
        <li><a href="#">Menggunakan QR Code</a></li>
        <li><a href="#">Untuk Masuk dan Keluar</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h5>Contact Us</h5>
      <ul>
        <li><a href="#">Alif Chandra Darmawan</a></li>
        <li><a href="#">Jl. Raya Stubondo, Sumbersari</li>
        <li><a href="#">Bondowoso, Kabupaten Bondowoso, Jawa Timur 68211</a></li>
        <li><a href="#">+62 859-6441-8174</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <div>
      🌐 English &nbsp;·&nbsp;
      <a href="#">Terms &amp; privacy</a> &nbsp;·&nbsp;
      <a href="#">Keamanan</a> &nbsp;·&nbsp;
      <a href="#">Status</a> &nbsp;·&nbsp;
      © 2025 Kelompok 4
    </div>
    <div class="social-row">
      <a class="social-icon" href="#" title="Facebook">f</a>
      <a class="social-icon" href="#" title="Twitter">𝕏</a>
      <a class="social-icon" href="#" title="LinkedIn">in</a>
      <a class="social-icon" href="#" title="Instagram">ig</a>
    </div>
  </div>
</footer>

<script>
  // Scroll reveal
  const reveals = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
  }, { threshold: 0.12 });
  reveals.forEach(r => io.observe(r));

  // Stagger hero animations
  document.querySelectorAll('.hero > *:not(.hero-grid):not(.hero-glow)').forEach((el, i) => {
    el.style.animationDelay = (i * 0.1) + 's';
  });
</script>
</body>
</html>