<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['send'])){
        $profile->feedback($_SESSION['myuserId'], htmlspecialchars($_POST['rate']), htmlspecialchars($_POST['feedback']));
    }
?>
<html lang="en" id="Feedback_Page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkSpam | Feedback</title>
    <link rel="stylesheet" href="styles/client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php require __DIR__ . '/../layout/header.php';?>
    <main>
        <?php require __DIR__ . '/../components/sidebar.php'; ?>
       <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <section class="FeedbackSection">
                <div class="container">
                    <div class="feedbackCard">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                            <div class="cardpadding" >
                                <p class="contactTitle" title="Reviewed at HelloPeter">Submit Feedback</p>
                                
                            </div>
                                <hr size="3" color="black"/>
                            <div class="fdInput">
                                <textarea placeholder="Enter your feedback" name="feedback" class="contactermessage"></textarea>
                                <div id="fbstore">
                                    <input name="rate" placeholder="Rate website" type="number" inputmode="numeric" pattern=[0-9]+ min="1" max="5" oninput="javascript: if (this.value > this.max) this.value = this.value.min;">
                                    <button name="send" class="btn Contactbtn">Send</button>
                                </div>
                            </div>
                                <hr size="3" color="black"/>
                            <div class="fdInput">    
                                <p class="helpHeader">Need help?</p>
                                <div class="Divhelp">
                                    <div class="HelpDiv1">
                                        <p class="HelpPar">Get help instruction to problem:</p>
                                        <a href="Contact.php"><input type="button" class="btn Contactbtn" value="Help"></a>
                                    </div>
                                        <img src="Images/question.png" class="Imgquestion">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </form>
    </main>
    <?php require __DIR__ . '/../layout/footer.php';?>
</body>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    const btnPost = document.querySelector('.btnPost');
    const sectionPost = document.querySelector('.SectionPost');

    btnPost.addEventListener('click', () => {
        sectionPost.classList.toggle('active');
    });
    
</script>
</html>