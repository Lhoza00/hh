
<html lang="en" id="index">
<?php require_once __DIR__ . '/../layout/head.php';?>
<style>
  /* ── HERO ── */
  .hero{background:var(--Primary);border-bottom:1px solid var(--border)}
  .hero .container{display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;min-height:calc(100vh - 110px);padding:4rem 2.5rem}
  .hero-tag{display:inline-flex;align-items:center;gap:8px;background:rgba(255,110,0,.1);color:var(--Main);font-size:.72rem;font-weight:500;letter-spacing:.8px;text-transform:uppercase;padding:5px 16px;border-radius:100px;margin-bottom:2rem}
  .hero-tag::before{content:'';width:7px;height:7px;background:var(--Main);border-radius:50%;animation:blink 1.8s ease infinite}
  @keyframes blink{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.3;transform:scale(.6)}}
  .hero h1{font-family:'Syne',sans-serif;font-weight:800;font-size:clamp(3rem,7vw,5.5rem);line-height:.95;letter-spacing:-3px;color:var(--ink);margin-bottom:1.5rem;max-width:800px}
  .hero h1 em{font-style:normal;color:var(--Main)}
  .hero p{font-size:1.05rem;color:var(--muted);line-height:1.75;max-width:480px;margin-bottom:2.5rem;font-weight:300}
  .hero-btns{display:flex;gap:.875rem;flex-wrap:wrap;justify-content:center}
  .btn-dark{padding:.9rem 2.4rem;border-radius:100px;border:none;background:var(--ink);color:#fff;font-family:'DM Sans',sans-serif;font-size:.95rem;cursor:pointer;text-decoration:none;transition:opacity .2s;display:inline-block}
  .btn-dark:hover{opacity:.82}
  .btn-orange{padding:.9rem 2.4rem;border-radius:100px;border:1.5px solid var(--Main);background:transparent;color:var(--Main);font-family:'DM Sans',sans-serif;font-size:.95rem;cursor:pointer;text-decoration:none;transition:all .2s;display:inline-block}
  .btn-orange:hover{background:var(--Main);color:#fff} 

  /* ── SERVICES ── */
  .section_services{padding:4rem 0;background:var(--Secondary)}
  .section_services .container{padding:0 2.5rem}
  .section-eyebrow{font-size:.72rem;font-weight:500;color:var(--Main);letter-spacing:1px;text-transform:uppercase;margin-bottom:.5rem}
  .section-title{font-family:'Syne',sans-serif;font-weight:800;font-size:clamp(1.8rem,3vw,2.4rem);letter-spacing:-1px;color:var(--ink);margin-bottom:.75rem}
  .section-sub{font-size:.95rem;color:var(--muted);margin-bottom:2.5rem;font-weight:300;max-width:480px;line-height:1.7}
  .servicesContainer{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem}
  .DivServices{background:var(--Primary);border:1px solid var(--border);border-radius:16px;padding:1.5rem;transition:box-shadow .2s,border-color .2s}
  .DivServices:hover{border-color:var(--Main)}
  .service-icon{width:40px;height:40px;background:rgba(255,110,0,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:1rem;color:var(--Main)}
  .serviceSubTitle{font-family:'Syne',sans-serif;font-weight:700;font-size:1rem;color:var(--ink);margin-bottom:.5rem}
  .DivServices p{font-size:.85rem;color:var(--muted);line-height:1.65}

  /* ── BENEFITS ── */
  .benefits_section{padding:1rem 0 0;background:var(--Primary)}
  .benefits_section .container{padding:0 2.5rem}
  #UMB{text-align:center;padding:3rem 0 1.5rem}
  #UMB h1{font-family:'Syne',sans-serif;font-weight:800;font-size:clamp(1.8rem,3vw,2.4rem);letter-spacing:-1px;color:var(--ink)}
  .BenefitContainer{border-top:1px solid var(--border);padding:3rem 0}
  .BenefitContainer .container{display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;padding:0 2.5rem}
  #secondBenefitContainer{background:var(--Secondary)}
  .benefit-visual{background:var(--Secondary);border:1px solid var(--border);border-radius:20px;aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.5rem;font-size:3.5rem}
  #secondBenefitContainer .benefit-visual{background:var(--Primary)}
  .benefit-tag{display:inline-block;background:rgba(255,110,0,.1);color:var(--Main);font-size:.68rem;font-weight:500;letter-spacing:.8px;text-transform:uppercase;padding:4px 12px;border-radius:100px;margin-bottom:1rem}
  .text_container h1{font-family:'Syne',sans-serif;font-weight:800;font-size:1.6rem;letter-spacing:-.5px;color:var(--ink);margin-bottom:.875rem}
  .text_container p{font-size:.9rem;color:var(--muted);line-height:1.75;margin-bottom:1rem;font-weight:300}
  .text_container ul{list-style:none;display:flex;flex-direction:column;gap:.75rem}
  .text_container ul li{display:flex;gap:.875rem;font-size:.875rem;color:var(--muted);line-height:1.6}
  .li-dot{width:20px;height:20px;border-radius:50%;background:rgba(255,110,0,.12);flex-shrink:0;display:flex;align-items:center;justify-content:center;margin-top:2px}
  .li-dot::after{content:'';width:6px;height:6px;background:var(--Main);border-radius:50%}

  /* ── NEWS ── */
  .News{background:var(--Primary);padding:3.5rem 0}
  .News .container{padding:0 2.5rem}
  .news-inner{max-width:540px;margin:0 auto;text-align:center}
  .news-inner h2{font-family:'Syne',sans-serif;font-weight:800;font-size:1.75rem;letter-spacing:-.5px;color:var(--ink);margin-bottom:.5rem}
  .news-inner p{font-size:.9rem;color:var(--ink);margin-bottom:1.75rem;line-height:1.7}
  .news-form{display:flex;gap:.5rem;justify-content:center;flex-wrap:wrap}
  #NewsEmail{padding:.75rem 1.2rem;border-radius:100px;border:none;background:var(--Substitute);color:var(--ink);font-family:'DM Sans',sans-serif;font-size:.9rem;width:260px;outline:none;backdrop-filter:blur(4px)}
  #NewsEmail::placeholder{color:var(--ink)}
  #NewsEmail:focus{background:rgba(255,255,255,.3)}
  .news-form button{padding:.75rem 1.5rem;border-radius:100px;border:none;background:var(--Substitute);color:var(--ink);font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:500;cursor:pointer;transition:opacity .2s}
  .news-form button:hover{opacity:.9}

  /* ── RESPONSIVE ── */
  @media(max-width:1280px){
    .BenefitContainer .container{grid-template-columns:1fr;gap:2rem;padding:0 1.5rem}
      .benefit-visual{max-width:200px}
      .section_services .container{padding:0 1.5rem}
      .benefits_section .container{padding:0 1.5rem}
      .News .container{padding:0 1.5rem}
  }
  @media(max-width:475px){
    .servicesContainer{grid-template-columns:1fr}
    .comm-grid{grid-template-columns:1fr}
    .news-form{flex-direction:column;align-items:center}
    #NewsEmail{width:100%;max-width:300px}
    .news-form button{width:100%;max-width:300px}
    
    .section_services .container,.News .container,footer .container{padding:0 1rem}
    .BenefitContainer .container{padding:0 1rem}
    .benefits_section .container{padding:0 1rem}
  }
</style>
<body>
<?php require_once __DIR__ . '/../layout/header.php';?>
<main>
<section class="hero">
  <div class="container">
    
    <h1>Advertise with<br><em>unlimited</em> potential.</h1>
    <p>Join <?php echo APP_NAME; ?> and build your affiliate network across social media, blogs, and beyond. Real results, real rewards.</p>
    <div class="hero-btns">
      <a href="sign-up" class="btn-orange">Get started free</a>
      <a href="#OurServices" class="btn-orange">See services</a>
    </div>
  </div>
</section>

<section class="section_services" id="OurServices">
  <div class="container">
    <div class="section-eyebrow">What we offer</div>
    <div class="section-title" >Our services</div>
    <div class="section-sub">Everything you need to grow your affiliate network and run campaigns that actually convert.</div>
    <div class="servicesContainer">
      <div class="DivServices">
        <div class="service-icon"><i class="fas fa-users"></i></div>
        <h3 class="serviceSubTitle">Influence marketing</h3>
        <p>Grow your following across platforms through sponsored posts, stories, and shared content — all managed for you.</p>
      </div>
      <div class="DivServices">
        <div class="service-icon"><i class="fas fa-crosshairs"></i></div>
        <h3 class="serviceSubTitle">Targeted campaigns</h3>
        <p>Run campaigns that convert clicks into customers with real-time tracking and clear performance metrics.</p>
      </div>
      <div class="DivServices">
        <div class="service-icon"><i class="fas fa-link"></i></div>
        <h3 class="serviceSubTitle">Affiliate management</h3>
        <p>Custom referral links, tools, and resources to promote any business — local or global audience targeting included.</p>
      </div>
      <div class="DivServices">
        <div class="service-icon"><i class="fas fa-trophy"></i></div>
        <h3 class="serviceSubTitle">Level-up rewards</h3>
        <p>Earn higher commissions, early access, and bonuses as you climb the ranks and grow your trusted community.</p>
      </div>
    </div>
  </div>
</section>

<section class="benefits_section" id="aboutSection">
  <div class="container">
    <div id="UMB"><h1>User membership benefits</h1></div>
  </div>
  <div class="BenefitContainer" id="firstBenefitContainer">
    <div class="container">
      <div class="benefit-visual">
        <span>🚀</span>
        <span style="font-size:1rem;color:var(--Main);font-family:'Syne',sans-serif;font-weight:700">Join free</span>
      </div>
      <div class="text_container">
        <span class="benefit-tag">For affiliates</span>
        <h1>Earn while you grow</h1>
        <p>Join <?php echo APP_NAME; ?> for free and start building passive income. Choose what to promote, share anywhere, and earn through clicks, sales, and referrals — on your terms, 24/7.</p>
        <ul>
          <li><div class="li-dot"></div><span><strong>Level = Trust = Monetization.</strong> Every level earns you higher commission rates, early feature access, bonuses, and milestone payouts.</span></li>
          <li><div class="li-dot"></div><span>Get custom referral links, marketing tools, and real-time tracking — with a guided path so you always know your next step.</span></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="BenefitContainer" id="secondBenefitContainer">
    <div class="container">
      <div class="text_container">
        <span class="benefit-tag">For businesses</span>
        <h1>Put your brand in front of new audiences</h1>
        <p>Partner with affiliates to promote your business through blogs, social media, email, and more. Be discovered locally or globally — ideal for startups ready to scale.</p>
        <ul>
          <li><div class="li-dot"></div><span>Analytics and insight tools show which affiliates drive the most value, so you can refine your marketing with real data.</span></li>
          <li><div class="li-dot"></div><span>Cross-promotion through giveaways, joint campaigns, and shoutouts generates authentic user-generated content at scale.</span></li>
        </ul>
      </div>
      <div class="benefit-visual">
        <span>📈</span>
        <span style="font-size:1rem;color:var(--Main);font-family:'Syne',sans-serif;font-weight:700">Grow your reach</span>
      </div>
    </div>
  </div>
</section>

<section class="News" id="News">
  <div class="container">
    <div class="news-inner">
      <h2>Stay in the loop</h2>
      <p>Get <?php echo APP_NAME; ?> updates, new features, and affiliate tips delivered straight to your inbox.</p>
      <div class="news-form">
        <input type="email" placeholder="your@email.com" id="NewsEmail">
        <button type="button" onclick="NewsEmailFunction()">Subscribe</button>
      </div>
    </div>
  </div>
</section>
</main>
<?php require_once __DIR__ . '/../layout/footer.php';?>
<script src="public/js/email_validate.js" defer></script>
</body>
</html>
