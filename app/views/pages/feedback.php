<html lang="en" id="feedback">
<?php require __DIR__ . '/../layout/head.php'; ?>
<style>
    :root{
    --bg: #F5F4F0;
    --card: #FFFFFF;
    --border: #E4E2DC;
    --text: #1C1E1F;
    --text-soft: #6B6F76;
    --accent: #3D5A50;
    --accent-light: #E9EFEA;
}

.section_contact{
    padding: 60px 20px;
}

.container{
    max-width: 560px;
    margin: 0 auto;
}

.cardcontact{
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 14px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.06);
    overflow: hidden;
}

.cardpadding{
    padding: 28px 32px;
}

.divider{
    border: none;
    border-top: 1px solid var(--border);
    margin: 0;
}

.contactTitle{
    font-size: 22px;
    font-weight: 700;
    margin: 0;
    color: var(--text);
}

.wording{
    font-size: 14px;
    color: var(--text-soft);
    margin: 0 0 20px;
}

.contacter,
.contactermessage{
    display: block;
    width: 100%;
    box-sizing: border-box;
    font-family: inherit;
    font-size: 14px;
    color: var(--text);
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 11px 14px;
    margin-bottom: 14px;
    outline: none;
    transition: border-color .15s ease, box-shadow .15s ease;
}

.contacter:focus,
.contactermessage:focus{
    border-color: var(--Main);
    box-shadow: 0 0 0 3px var(--accent-light);
}

.contactermessage{
    min-height: 120px;
    resize: vertical;
}

.btn{
    font-family: inherit;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    border-radius: 8px;
    transition: opacity .15s ease, transform .05s ease;
}

.btn:active{
    transform: translateY(1px);
}

.Contactbtn{
    background: var(--Main);
    color: #fff;
    padding: 11px 22px;
}

.Contactbtn:hover{
    opacity: .88;
}

/* Send button spans the form width; Help button stays compact */
form > .cardpadding > .Contactbtn{
    width: 100%;
}

.helpHeader{
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 12px;
    color: var(--text);
}

.Divhelp{
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    background: var(--accent-light);
    border-radius: 10px;
    padding: 16px 20px;
}

.HelpDiv1{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}

.HelpPar{
    font-size: 13.5px;
    color: var(--text-soft);
    margin: 0;
}

.HelpDiv1 .Contactbtn{
    padding: 8px 16px;
    font-size: 13px;
}

.Imgquestion{
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: var(--Main);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}

.Imgquestion svg{
    width: 26px;
    height: 26px;
}

.ContactAddress{
    font-size: 13px;
    color: var(--text-soft);
    margin: 0;
    text-align: center;
}

.ContactAddress a{
    color: var(--Main);
    font-style: normal;
    text-decoration: none;
}

.ContactAddress a:hover{
    text-decoration: underline;
}

.visually-hidden{
    position: absolute;
    width: 1px;
    height: 1px;
    overflow: hidden;
    clip: rect(0,0,0,0);
    white-space: nowrap;
}

@media (max-width: 480px){
    .cardpadding{ padding: 22px 20px; }
    .Divhelp{ flex-direction: column; align-items: flex-start; }
}
</style>
<body style="background: <?= htmlspecialchars($userSettings->get('backgroundColor')); ?>;">
    <?php require __DIR__ . '/../layout/header.php';?>
    <?php require_once __DIR__ . '/../components/sidebar.php';?>
    <main>
    <section class="section_contact">
            <form class="cardcontact" action="send-mail.php" method="POST">
                <div class="cardpadding">
                    <p class="contactTitle">Submit feedback</p>
                </div>
                <hr class="divider" />
                <div class="cardpadding">
                    <p class="wording">Please fill out the form below to contact us.</p>

                    <label for="userName" class="visually-hidden">Full name</label>
                    <input type="text" id="userName" placeholder="Enter your full name" name="userName" class="contacter" required>

                    <label for="userEmail" class="visually-hidden">Email</label>
                    <input type="email" id="userEmail" placeholder="Enter your e-mail" name="userEmail" class="contacter" required>

                    <label for="mainsubject" class="visually-hidden">Subject</label>
                    <input type="text" id="mainsubject" placeholder="Enter subject" name="mainsubject" class="contacter" required>

                    <label for="mainmessage" class="visually-hidden">Message</label>
                    <textarea id="mainmessage" placeholder="Enter your message" name="mainmessage" class="contactermessage" required></textarea>

                    <button type="submit" class="btn Contactbtn">Send</button>
                </div>
                <hr class="divider" />
                <div class="cardpadding">
                    <p class="helpHeader">Need help?</p>
                    <div class="Divhelp">
                        <div class="HelpDiv1">
                            <p class="HelpPar">Get help instruction to problem:</p>
                            <button type="button" class="btn Contactbtn" onclick="location.href='help.php'">Help</button>
                        </div>
                        <div class="Imgquestion" role="img" aria-label="Help icon">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                <path d="M9.5 9a2.5 2.5 0 013.94-2.05c.66.47 1.06 1.24 1.06 2.05 0 1.6-1 2-2 2.5-.6.3-1 .8-1 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="17.5" r="1.1" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <hr class="divider" />
                <div class="cardpadding">
                    <p class="ContactAddress">Can personally contact us @ <a href="mailto:infolinkspam@gmail.com">infolinkspam@gmail.com</a></p>
                </div>
            </form>
    </section>
</main>
    <?php require __DIR__ . '/../layout/footer.php';?>
</body>
</html>