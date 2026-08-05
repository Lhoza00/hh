<html lang="en" id="ContactPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linkspam | Contact</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <?php require __DIR__ . '/../layout/header.php';?>
    <main>
    <section class="section_contact">
        <div class="container">
            <form class="cardcontact" action="send-mail.php" method="POST">
                <div class="cardpadding">
                    <p class="contactTitle">Submit question</p>
                </div>
                    <hr size="3" color="black"/>
                <div class="cardpadding">
                    <p class="wording">Please fill out the form below to contact us.</p>
                    <input type="text" placeholder="Enter your full name" name="userName" class="contacter">
                    <input type="email" placeholder="Enter your e-mail" name="userEmail" class="contacter">
                    <input placeholder="Enter subject" name="mainsubject" class="contacter">
                    <textarea placeholder="Enter your message" name="mainmessage" class="contactermessage"></textarea>
                    <button class="btn Contactbtn">Send</button>
                </div>
                    <hr size="3" color="black"/>
                <div class="cardpadding">    
                    <p class="helpHeader">Need help?</p>
                    <div class="Divhelp">
                        <div class="HelpDiv1">
                            <p class="HelpPar">Get help instruction to problem:</p>
                            <button class="btn Contactbtn">Help</button>
                        </div>
                        
                            <img src="Images/question.png" class="Imgquestion">
                    </div>
                </div>
                    <hr size="3" color="black"/>
                <div class="cardpadding">
                    <p class="ContactAddress">Can personally contact us @ <i>infolinkspam@gmail.com</i></p>
                </div>
            </form>
        </div>   
    </section>
    </main>
    <?php require __DIR__ . '/../layout/footer.php';?>
</body>
</html>