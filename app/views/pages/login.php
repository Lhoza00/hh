<?php
  if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
}
  if (isset($_SESSION['userID'])) {
      header("Location: home");
      exit;
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      require_once __DIR__ . '/../../../Classes/LoginClass.php';

      $login = new Login();
      $logerror = $login->evaluate($_POST);
      
  }
?>
<!DOCTYPE html>
<html lang="en" id="login">
<?php require_once __DIR__ . '/../layout/head.php';?>
<style>
  
  /* ── MAIN ── */
  main{flex:1;display:grid;grid-template-columns:1fr 1fr;min-height:calc(100vh - 64px - 72px)}
  
  /* ── LEFT BRAND PANEL ── */
  .login-left{
    background:var(--ink);
    padding:4rem 3.5rem;
    display:flex;flex-direction:column;justify-content:center;
    position:relative;overflow:hidden;
  }
  .login-left::before{
    content:'';position:absolute;
    width:480px;height:480px;border-radius:50%;
    background:rgba(255,110,0,0.07);
    top:-140px;left:-140px;pointer-events:none;
  }
  .login-left::after{
    content:'';position:absolute;
    width:320px;height:320px;border-radius:50%;
    background:rgba(255,110,0,0.04);
    bottom:-100px;right:-60px;pointer-events:none;
  }
  .brand-eyebrow{
    font-size:.68rem;font-weight:500;letter-spacing:1.8px;text-transform:uppercase;
    color:var(--Substitute);margin-bottom:1.75rem;
    display:flex;align-items:center;gap:.75rem;
  }
  .brand-eyebrow::before{content:'';width:28px;height:1px;background:var(--Substitute)}
  .brand-title{
    font-family:'Syne',sans-serif;font-weight:800;
    font-size:clamp(2.5rem,4vw,3.8rem);
    line-height:.92;letter-spacing:-2.5px;
    color:#fff;margin-bottom:1.75rem;
  }
  .brand-title em{font-style:normal;color:var(--Main)}
  .brand-sub{
    font-size:.9rem;color:rgba(255,255,255,.45);
    line-height:1.8;font-weight:300;max-width:320px;margin-bottom:3rem;
  }
  .brand-perks{display:flex;flex-direction:column;gap:.875rem;position:relative;z-index:1}
  .perk{display:flex;align-items:flex-start;gap:.875rem}
  .perk-icon{
    width:32px;height:32px;flex-shrink:0;
    border-radius:8px;background:rgba(255,110,0,.15);
    display:flex;align-items:center;justify-content:center;
    color:var(--Main);font-size:.8rem;margin-top:1px;
  }
  .perk-text{font-size:.82rem;color:rgba(255,255,255,.5);line-height:1.6}
  .perk-text strong{color:rgba(255,255,255,.85);font-weight:500;display:block;margin-bottom:1px}
  
  /* ── RIGHT FORM PANEL ── */
  .login-right{
    background:var(--Primary);
    display:flex;align-items:center;justify-content:center;
    padding:3rem 2.5rem;
    border-left:1px solid var(--border);
  }
  .form-wrap{width:100%;max-width:380px}
  
  .form-title{
    font-family:'Syne',sans-serif;font-weight:800;
    font-size:1.9rem;letter-spacing:-.75px;color:var(--ink);
    margin-bottom:.4rem;
  }
  .form-sub{font-size:.85rem;color:var(--muted);font-weight:300;margin-bottom:2.25rem}
  .form-sub a{color:var(--Main);text-decoration:none;font-weight:500}
  
  .field{margin-bottom:1.1rem}
  .field-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:.4rem}
  .field label{font-size:.72rem;font-weight:500;letter-spacing:.3px;color:var(--muted);text-transform:uppercase}
  .forgot-link{font-size:.72rem;color:var(--Main);text-decoration:none;font-weight:500;transition:opacity .2s}
  .forgot-link:hover{opacity:.75}
  
  .field input{
    width:100%;height:48px;
    border:1px solid var(--border-dark);border-radius:10px;
    background:var(--Secondary);color:var(--ink);
    font-family:'DM Sans',sans-serif;font-size:.9rem;
    padding:0 1rem;outline:none;
    transition:border-color .2s,background .2s;
  }
  .field input:focus{border-color:var(--Main);background:var(--Primary);box-shadow:0 0 0 3px rgba(255,110,0,.08)}
  .field input::placeholder{color:rgba(122,106,85,.45)}
  
  .pw-wrap{position:relative}
  .pw-wrap input{padding-right:3rem}
  .pw-toggle{
    position:absolute;right:.875rem;top:50%;transform:translateY(-50%);
    background:none;border:none;cursor:pointer;
    color:var(--muted);font-size:.9rem;padding:4px;transition:color .2s;
  }
  .pw-toggle:hover{color:var(--Main)}
  
  .error-msg{
    background:rgba(220,50,30,.08);border:1px solid rgba(220,50,30,.2);
    border-radius:8px;padding:.65rem .875rem;
    font-size:.8rem;color:#c0392b;margin-bottom:1rem;
    display:flex;align-items:center;gap:.5rem;
  }
  .error-msg i{font-size:.85rem;flex-shrink:0}
  
  .btn-login{
    width:100%;height:50px;
    background:var(--Main);color:#fff;
    border:none;border-radius:10px;
    font-family:'Syne',sans-serif;font-weight:700;font-size:.95rem;
    letter-spacing:.3px;cursor:pointer;
    transition:opacity .2s,transform .1s;
    margin-top:.25rem;
  }
  .btn-login:hover{opacity:.9}
  .btn-login:active{transform:scale(.99)}
  
  .divider{
    display:flex;align-items:center;gap:.875rem;
    margin:1.5rem 0;font-size:.72rem;color:var(--muted);letter-spacing:.3px;text-transform:uppercase;
  }
  .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border-dark)}
  
  .socials-row{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
  .btn-social{
    display:flex;align-items:center;justify-content:center;gap:.6rem;
    height:46px;border-radius:10px;
    border:1px solid var(--border-dark);background:var(--Secondary);
    font-family:'DM Sans',sans-serif;font-size:.85rem;color:var(--ink);
    cursor:pointer;text-decoration:none;transition:border-color .2s,background .2s;
  }
  .btn-social:hover{border-color:var(--Main);background:var(--Primary)}
  .btn-social .fa-facebook-f{color:#1877f2}
  .btn-social .fa-google{color:#ea4335}
  
  .create-acct{text-align:center;margin-top:1.5rem;font-size:.82rem;color:var(--muted)}
  .create-acct a{color:var(--Main);text-decoration:none;font-weight:500}
  
  @media(max-width:475px){
    .login-left,.login-right{padding:2rem 1rem}
    .socials-row{grid-template-columns:1fr}
  }
</style>
<body>
<?php require_once __DIR__ . '/../layout/header.php';?>
<main>
 
  <!-- LEFT: brand panel -->
  <div class="login-left">
    <div class="brand-eyebrow">Welcome back</div>
    <h1 class="brand-title">Sign in<br>to <em><?php echo APP_NAME; ?></em></h1>
    <p class="brand-sub">Your affiliate network is waiting. Log back in and pick up right where you left off.</p>
    <div class="brand-perks">
      <div class="perk">
        <div class="perk-icon"><i class="fas fa-chart-line"></i></div>
        <div class="perk-text">
          <strong>Real-time tracking</strong>
          Monitor your clicks, conversions, and earnings live.
        </div>
      </div>
      <div class="perk">
        <div class="perk-icon"><i class="fas fa-trophy"></i></div>
        <div class="perk-text">
          <strong>Level-up rewards</strong>
          Climb the ranks for higher commissions and bonuses.
        </div>
      </div>
      <div class="perk">
        <div class="perk-icon"><i class="fas fa-link"></i></div>
        <div class="perk-text">
          <strong>Your referral links</strong>
          All your custom links and campaigns in one place.
        </div>
      </div>
    </div>
  </div>
 
  <!-- RIGHT: login form -->
  <div class="login-right">
    <div class="form-wrap">
 
      <div class="form-title">Welcome back</div>
      <div class="form-sub">New here? <a href="sign-up">Create a free account</a></div>
 
      <form id='formLogin' action="login" method="POST">
 
        <div class="field">
          <div class="field-top"><label for="userName">Username</label></div>
          <input type="text" name="userName" id="userName" maxlength="25"
            placeholder="Your username"
            value="" required>
        </div>
 
        <div class="field">
          <div class="field-top">
            <label for="userPassword">Password</label>
            <a href="forgotpage.php" class="forgot-link">Forgot password?</a>
          </div>
          <div class="pw-wrap">
            <input type="password" name="userPassword" id="userPassword"
              minlength="8" maxlength="255" placeholder="Min. 8 characters" required>
            <button type="button" class="pw-toggle" id="eyeA" onclick="togglePw('userPassword', 'eyeA')" aria-label="Toggle password visibility">
              Show
            </button>
          </div>
        </div>
 
        <?php if (!empty($logerror)): ?>
          <div class="error-msg">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($logerror); ?>
          </div>
        <?php endif; ?>
 
        <button type="submit" name="loggin" class="btn-login">Log in</button>
 
      </form>
 
      <div class="divider">or</div>
 
      <div class="socials-row">
        <a href="Profile.php" class="btn-social">
          <i class="fab fa-facebook-f"></i> Facebook
        </a>
        <a href="Profile.php" class="btn-social">
          <i class="fab fa-google"></i> Google
        </a>
      </div>
 
      <p class="create-acct">Don't have an account? <a href="sign-up">Sign up free</a></p>
 
    </div>
  </div>
 
</main>
<?php require_once __DIR__ . '/../layout/footer.php';?>
<script src="public/js/toggle_password.js"></script>
<script src="public/js/email_validate.js"></script>
<script src="public/js/clear_submission.js"></script>
</body>

</html>