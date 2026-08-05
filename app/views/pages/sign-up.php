<?php
  if (isset($_SESSION['userID'])) {
      header("Location: home");
      exit;
  }
  /*if ($_SERVER["REQUEST_METHOD"] === "POST") {
      require_once __DIR__ . '/../../../Classes/SignupClass.php';

      $register = new Signup();
      $regerror = $register->evaluate($_POST);
  }**/
  $regerror = "";
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once __DIR__ . '/../../../Classes/SignupClass.php';

      $register = new Signup();
      $regerror = $register->evaluate($_POST);
      echo "<pre>";
      print_r($regerror);
      echo "</pre>";
  }
  ?>
<!DOCTYPE html>
<html lang="en" id="indexPage">
<?php require_once __DIR__ . '/../layout/head.php';?>
<style>
    .signup-main{
  min-height:calc(100vh - 64px);
  display:grid;
  grid-template-columns:1fr 1fr;
  }
  
  /* ── LEFT PANEL ── */
  .signup-left{
    background:var(--ink);
    padding:3.5rem 3rem;
    display:flex;
    flex-direction:column;
    justify-content:center;
    position:relative;
    overflow:hidden;
  }

  .signup-left::before{
    content:'';
    position:absolute;
    width:400px;height:400px;
    border-radius:50%;
    background:rgba(255,110,0,0.08);
    top:-100px;left:-100px;
    pointer-events:none;
  }
  .signup-left::after{
    content:'';
    position:absolute;
    width:300px;height:300px;
    border-radius:50%;
    background:rgba(255,110,0,0.05);
    bottom:-80px;right:-80px;
    pointer-events:none;
  }
  .left-eyebrow{
    font-size:.7rem;font-weight:500;letter-spacing:1.5px;text-transform:uppercase;
    color:var(--Substitute);margin-bottom:1.5rem;
    display:flex;align-items:center;gap:.6rem;
  }
  .left-eyebrow::before{content:'';width:24px;height:1px;background:var(--Substitute)}
  .left-title{
    font-family:'Syne',sans-serif;font-weight:800;
    font-size:clamp(2.2rem,3.5vw,3.2rem);
    line-height:.95;letter-spacing:-2px;
    color:#fff;margin-bottom:1.5rem;
  }
  .left-title em{font-style:normal;color:var(--Main)}
  .left-sub{
    font-size:.9rem;color:rgba(255,255,255,.5);
    line-height:1.75;font-weight:300;max-width:340px;margin-bottom:2.5rem;
  }
  .plan-cards{display:flex;flex-direction:column;gap:.875rem;position:relative;z-index:1}
  .plan-card{
    border:1px solid rgba(255,255,255,.08);
    border-radius:14px;padding:1.25rem 1.5rem;
    cursor:pointer;transition:all .25s;
    background:rgba(255,255,255,.03);
    position:relative;
  }
  .plan-card:hover{border-color:rgba(255,110,0,.4);background:rgba(255,110,0,.06)}
  .plan-card.selected{border-color:var(--Main);background:rgba(255,110,0,.1)}
  .plan-card.selected .plan-check{opacity:1;transform:scale(1)}
  .plan-top{display:flex;justify-content:space-between;align-items:flex-start}
  .plan-name{font-family:'Syne',sans-serif;font-weight:700;font-size:1rem;color:#fff;margin-bottom:.2rem}
  .plan-price{font-family:'Syne',sans-serif;font-weight:800;font-size:1.4rem;color:var(--Main)}
  .plan-price span{font-size:.75rem;font-weight:400;color:rgba(255,255,255,.4);font-family:'DM Sans',sans-serif}
  .plan-check{
    width:22px;height:22px;border-radius:50%;
    background:var(--Main);display:flex;align-items:center;justify-content:center;
    font-size:.65rem;color:#fff;
    opacity:0;transform:scale(.6);transition:all .25s;flex-shrink:0;
  }
  .plan-features{margin-top:.875rem;display:flex;flex-direction:column;gap:.4rem}
  .plan-feat{font-size:.78rem;color:rgba(255,255,255,.45);display:flex;align-items:flex-start;gap:.5rem;line-height:1.5}
  .plan-feat::before{content:'—';color:var(--Substitute);flex-shrink:0;font-size:.7rem;margin-top:1px}
  .plan-badge{
    font-size:.6rem;letter-spacing:.8px;text-transform:uppercase;font-weight:500;
    padding:2px 8px;border-radius:100px;background:var(--Main);color:#fff;
    position:absolute;top:-.7rem;left:1.2rem;
  }
  
  /* ── RIGHT PANEL ── */
  .signup-right{
    background:var(--Primary);
    padding:3.5rem 3rem;
    display:flex;flex-direction:column;justify-content:center;
    border-left:1px solid var(--border);
  }
  .form-head{margin-bottom:2rem}
  .form-title{
    font-family:'Syne',sans-serif;font-weight:800;font-size:1.75rem;
    letter-spacing:-.5px;color:var(--ink);margin-bottom:.4rem;
  }
  .form-sub{font-size:.85rem;color:var(--muted);font-weight:300}
  .form-sub a{color:var(--Main);text-decoration:none}
  
  .field{margin-bottom:1.1rem}
  .field label{
    display:block;font-size:.75rem;font-weight:500;letter-spacing:.3px;
    color:var(--muted);margin-bottom:.4rem;text-transform:uppercase;
  }
  .field input{
    width:100%;height:46px;
    border:1px solid var(--border-dark);
    border-radius:10px;
    background:var(--Secondary);
    color:var(--ink);
    font-family:'DM Sans',sans-serif;font-size:.9rem;
    padding:0 1rem;
    outline:none;
    transition:border-color .2s,background .2s;
  }
  .field input:focus{border-color:var(--Main);background:var(--Primary)}
  .field input::placeholder{color:rgba(122,106,85,.5)}
  
  .field-row{display:grid;grid-template-columns:1fr 1fr;gap:.875rem}
  
  .pw-wrap{position:relative}
  .pw-wrap input{padding-right:3rem}
  .pw-toggle{
    position:absolute;right:.875rem;top:50%;transform:translateY(-50%);
    background:none;border:none;cursor:pointer;
    color:var(--muted);font-size:.95rem;padding:4px;
    transition:color .2s;
  }
  .pw-toggle:hover{color:var(--Main)}
  
  .error-msg{
    background:rgba(220,50,30,.08);border:1px solid rgba(220,50,30,.2);
    border-radius:8px;padding:.6rem .875rem;
    font-size:.8rem;color:#c0392b;margin-bottom:1rem;
    display:flex;
  }
  .error-msg.show{display:block}
  
  .btn-submit{
    width:100%;height:48px;
    background:var(--Main);color:#fff;
    border:none;border-radius:10px;
    font-family:'Syne',sans-serif;font-weight:700;font-size:.95rem;
    letter-spacing:.3px;cursor:pointer;
    transition:opacity .2s,transform .1s;
    margin-top:.5rem;
  }
  .btn-submit:hover{opacity:.9}
  .btn-submit:active{transform:scale(.99)}
  
  .divider{
    display:flex;align-items:center;gap:.875rem;
    margin:1.25rem 0;font-size:.75rem;color:var(--muted);
  }
  .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border-dark)}
  
  .socials-row{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
  .btn-social{
    display:flex;align-items:center;justify-content:center;gap:.6rem;
    height:44px;border-radius:10px;
    border:1px solid var(--border-dark);background:var(--Secondary);
    font-family:'DM Sans',sans-serif;font-size:.85rem;color:var(--ink);
    cursor:pointer;text-decoration:none;transition:border-color .2s,background .2s;
  }
  .btn-social:hover{border-color:var(--Main);background:var(--Primary)}
  .btn-social .fa-facebook-f{color:#1877f2}
  .btn-social .fa-google{color:#ea4335}
  
  .terms{font-size:.72rem;color:var(--muted);text-align:center;margin-top:1rem;line-height:1.6}
  .terms a{color:var(--Main);text-decoration:none}
  
  /* ── PAYMENT NOTICE ── */
  .payment-notice{
    display:none;
    margin-top:1.25rem;
    background:rgba(255,110,0,.07);
    border:1px solid var(--border-dark);
    border-radius:10px;padding:.875rem 1rem;
    font-size:.8rem;color:var(--muted);line-height:1.6;
  }
  .payment-notice.show{display:block}
  .payment-notice strong{color:var(--Main)}
  .btn-pay{
    display:inline-block;margin-top:.6rem;
    padding:.5rem 1.4rem;border-radius:100px;
    background:var(--Main);color:#fff;font-size:.8rem;font-weight:500;
    text-decoration:none;font-family:'DM Sans',sans-serif;
    transition:opacity .2s;
  }
  .btn-pay:hover{opacity:.88}
  
  /* ── RESPONSIVE ── */
  @media(max-width:768px){
    .signup-main{grid-template-columns:1fr}
    .signup-left{padding:2.5rem 1.5rem}
    .signup-right{padding:2.5rem 1.5rem;border-left:none;border-top:1px solid var(--border)}
  }
  @media(max-width:475px){
    .field-row{grid-template-columns:1fr}
    .socials-row{grid-template-columns:1fr}
    .signup-left,.signup-right{padding:2rem 1rem}
  }
  #planBusiness, .divider, .socials-row{
    filter: blur(5px);
    display: none;
  }
</style> 
<body>
<?php require_once __DIR__ . '/../layout/header.php';?> 
<main>
  <form id="formSign-up" method="post" action="sign-up">
  <div class="signup-main">
    <!--input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
-->
    <!-- LEFT: plan picker -->
    <div class="signup-left">
      <div class="left-eyebrow">Choose your plan</div>
      <h1 class="left-title">Join<br><em><?php echo APP_NAME; ?></em><br>today.</h1>
      <p class="left-sub">Pick the membership that fits your goals. You can always upgrade later.</p>
 
      <div class="plan-cards">
        
        <div class="plan-card" id="planFree" onclick="selectPlan('Free')"><div class="plan-badge">Most popular</div>
          <div class="plan-top">
            <div>
              <div class="plan-name">Free affiliate</div>
              <div class="plan-price">$0 <span>/ forever</span></div>
            </div>
            <div class="plan-check"><i class="fas fa-check"></i></div>
          </div>
          <div class="plan-features">
            <div class="plan-feat">Access basic features and grow your affiliate rank</div>
            <div class="plan-feat">Free networking with members near you</div>
            <div class="plan-feat">Custom referral links and real-time tracking</div>
          </div>
          <input type="radio" name="subType" value="Free" id="radioFree" style="position:absolute;opacity:0;pointer-events:none" required>
        </div>
        <div class="plan-card" id="planTemplate" onclick="selectPlan('Template')">
          <div class="plan-top">
            <div>
              <div class="plan-name">Tremplate</div>
              <div class="plan-price">R85<span> / month</span></div>
            </div>
            <div class="plan-check"><i class="fas fa-check"></i></div>
          </div>
          <div class="plan-features">
            <div class="plan-feat">Access basic modify feature</div>
            <div class="plan-feat">Free website template</div>
            <div class="plan-feat">Custom referral links and real-time tracking</div>
          </div>
          <input type="radio" name="subType" value="Template" id="radioTemplate" style="position:absolute;opacity:0;pointer-events:none" required>
        </div>
        <div class="plan-card" id="planBusiness" onclick="selectPlan('Business')">
          
          <div class="plan-top">
            <div>
              <div class="plan-name">Business client</div>
              <div class="plan-price">R450 <span>/ month</span></div>
            </div>
            <div class="plan-check"><i class="fas fa-check"></i></div>
          </div>
          <div class="plan-features">
            <div class="plan-feat">Free 30-day trial — no card needed to start</div>
            <div class="plan-feat">Networking advertisement </div>
            <div class="plan-feat">Dedicated professional onboarding support</div>
            <div class="plan-feat">Cross-business collaboration tools</div>
            <div class="plan-feat">Access to dashboard and health system</div>
          </div>
          <input type="radio" name="subType" value="Business" id="radioBusiness" style="position:absolute;opacity:0;pointer-events:none">
        </div>
 
      </div>
    </div>
 
    <!-- RIGHT: form -->
    <div class="signup-right">
      <div class="form-head">
        <div class="form-title">Create your account</div>
        <div class="form-sub">Already have one? <a href="login">Sign in</a></div>
      </div>
 
      <div class="field-row">
        <div class="field">
          <label id="nameLabel" for="userName">User Name</label>
          <input type="text" name="userName" id="userName" maxlength="25" placeholder="e.g. linkmaster" required>
        </div>
        <div class="field">
          <label  for="FullName">Full name</label>
          <input type="text" name="fullName" id="FullName" maxlength="50" placeholder="Your name" required>
        </div>
      </div>
 
      <div class="field">
        <label for="UserEmail">Email address</label>
        <input type="email" name="userEmail" id="UserEmail" maxlength="254" placeholder="you@email.com" required>
      </div>
 
      <div class="field">
        <label for="password">Password</label>
        <div class="pw-wrap">
          <input type="password" name="userPassword" id="password" maxlength="255" placeholder="Min. 8 characters" required>
          <button type="button" class="pw-toggle" id="eyeA" onclick="togglePw('password','eyeA')" aria-label="Toggle password">
            Show
          </button>
        </div>
      </div>
 
      <div class="field">
        <label for="confirmPassword">Confirm password</label>
        <div class="pw-wrap">
          <input type="password" name="userPassword" id="confirmPassword" maxlength="255" placeholder="Repeat password" required>
          <button type="button" class="pw-toggle" id="eyeB" onclick="togglePw('confirmPassword','eyeB')" aria-label="Toggle password">
            Show
          </button>
        </div>
      </div>
     
      <div class="error-msg" id="pwError"><?php echo $regerror; ?></div>
 
      <div class="payment-notice" id="paymentNotice">
        <strong>Business plan selected.</strong> After signing up you'll be redirected to complete your $25/month payment via PayPal to activate your account.
        <br><a class="btn-pay" href="https://www.paypal.com/ncp/payment/RSP4E7HAYXNXC" target="_blank">Pay with PayPal</a>
      </div>
      
 
      <button type="submit" name="btnSignIn" class="btn-submit">Create account</button>
 
      <div class="divider">or continue with</div>
 
      <div class="socials-row">
        <a href=" #" class="btn-social">
          <i class="fab fa-facebook-f"></i> Facebook
        </a>
        <a href="#" class="btn-social">
          <i class="fab fa-google"></i> Google
        </a>
      </div>
 
      <p class="terms">By signing up you accept our <a href="termsCondition">Terms & Conditions</a> and <a href="privacyPolicy.php">Privacy Policy</a></p>
    </div>
 
  </div>
  </form>
</main>
 
<?php require_once __DIR__ . '/../layout/footer.php';?>
<script src="public/js/account_plan.js"></script>
<script src="public/js/toggle_password.js"></script>
<script src="public/js/email_validate.js"></script>
<script src="public/js/clear_submission.js"></script>
<script src="public/js/matching_password.js"></script>
</body>

</html>