<?php
    // $error is set by AuthController::register() before rendering this view.
?>
<html lang="en" id="SignUpPage"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Linkspam | Sign-in</title>
</head>
<body class="SignBg">
    <?php require __DIR__ . '/../layout/header.php';?>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <section class="SignSection">
                <div class="container">
                    <div class="MemOptionContainer">
                        <ul class="OfferPrice">
                            <li>
                                <input type="radio" id="membership" name="subType" value="Free" required onclick="changeLabel('Full name')">
                                <div class="itemPrice">
                                    <div class="memPrice">
                                        <div>
                                            <h2>Free User</h2>
                                            <h3> $0</h3>
                                        </div>
                                        <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                    <div class="memData" id="memFreeUser">
                                        <p>Access basic feature to fulfill quota to advance</p>
                                        <hr/>
                                        <p>Free networking with new members near you</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <input type="radio" id="memberships" value="Business" name="subType" required onclick="changeLabel('Business name')">
                                <div class="itemPrice">
                                    <div class="memPrice">
                                        <div>
                                            <h2>Client</h2>
                                            <h3>$25</h3>
                                        </div>
                                        <i class="fa-solid fa-angle-down"></i>
                                    </div>
                                    <div class="memData" id="memClient">
                                        <p>Free 30 days trial to try our service</p>
                                        <hr/>
                                        <p><b>Guaranteed 2000</b> members near your business</p>
                                        <hr/>
                                        <p>Get a trained professional to assist with basic step to step</p>
                                        <hr/>
                                        <p>Collaboration with other businesses</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="PaymentCard" id="PaymentCard">
                            <a href="https://www.paypal.com/ncp/payment/RSP4E7HAYXNXC" required>
                                <input type="button" value="Pay now"></a>
                        </div>
                    </div>
                    <div class="DetailsDivContainer">
                        <div class="card">
                            <div class="form">
                                <h4 class="signinHeader">Create a Linkspam Account</h4>
                                <div class="UserForm">
                                    <div class="UserDetails">
                                        <label id="userLabel">Username</label>
                                        <input type="text" class="input" name="userName" id="userName" maxlength="25" required>
                                    </div>
                                    <div class="UserDetails">
                                        <label id="nameLabel">Full name</label>
                                        <input type="name" class="input" name="fullName" id="FullName" maxlength="50" required>
                                    </div>
                                    <div class="UserDetails">
                                        <label id="emailLabel">Email</label>
                                        <input type="email" name="userEmail" class="input" id="UserEmail" maxlength="254"required>
                                        
                                    </div>
                                    <div class="UserDetails">
                                        <label id="password">Password</label>
                                        <input type="password" name="userPassword" class="input inputPassword" id="password" maxlength="255" required>
                                    </div>
                                    <div class="UserDetails">
                                        <label id="confirmpassword">Reconfirm Password</label>
                                        <input type="password" name="confirmPassword" class="input inputPassword" id="confirmPassword" maxlength="255" required>
                                    </div>
                                    <?php if (!empty($error)): ?>
                                        <p class="error"> 
                                            <?php echo htmlspecialchars($error); ?>
                                        </p>  
                                    <?php endif; ?>
                                    <p class="errorpassword"> </p>
                                   
                                    <div class="divButton" >
                                        <button type="submit" name="btnSignIn" id="SignButton" class="SignButton">Sign in</button>
                                    </div>
                                    <p align="center"><i>By signing up you accept our <a href="TermsCondition.php" style="color: blue;">Terms & Conditions</a></i></p>
                                </div>    
                                <div class="SocialsLoginOption">
                                    <a href="Profile.php"><div class="btnLoginOption FacebookLogin">
                                        <i href="#" class="fab fa-facebook-f"></i>
                                        <p color="black">Facebook</p>
                                    </div></a>
                                    <a href="Profile.php"><div class="btnLoginOption GoogleLogin">
                                        <i href="#" class="fab fa-google"></i>
                                        <p>Google</p>
                                    </div></a>
                                </div>
                                <div class="AlreadyLogged">
                                    <p id="Login"><i>Already have an account? <a href="Login.php">Sign in</a></i></p>
                                </div>
                                
                            </div> 
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </main>
   <?php require __DIR__ . '/../layout/footer.php';?>
</body>
<script>
    

    function changeLabel(newLabel) {
        document.getElementById("nameLabel").textContent = newLabel;
        const card = document.querySelector(".paymentCard");
        //alert(newLabel);
        if(newLabel == "Business name") {
            card.style = "display: flex"; 
        }else{
            card.style = "display: none"; 
        }
    }
    function formatCardNumber(input) {
        // Remove all non-digit characters
        let value = input.value.replace(/\D/g, '');
        
        // Add a space every 4 digits
        value = value.match(/.{1,4}/g);
        if (value) {
            input.value = value.join(' ');
        } else {
            input.value = '';
        }
    }
    function togglePassword() {
        const passwordInput = document.getElementById('sgUserPassword');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>

</html>

