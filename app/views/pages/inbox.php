<?php
if (basename($_SERVER['PHP_SELF']) === 'inbox.php') {
    header("Location: home");
    exit;
}
?>
<html lang="en" id="Home_Page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkSpam | Inbox</title>
    <link rel="stylesheet" href="styles/client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php require __DIR__ . '/../layout/header.php';?>
    <main>
        <?php require __DIR__ . '/../components/sidebar.php'; ?>
        <?php require __DIR__ . '/../components/postBox.php'; ?>
        <section class="InboxSection">
            <div class="container">
                <div class="InboxContainer">
                    <h1>Inbox: <?php if(empty($inbox)){echo 'None';}?></h1>
                    <?php 
                        foreach($inbox as $userInbox): ?>
                        <?php if(!empty($userInbox['bioStatement'])): ?>
                            <div id="InboxMessage">
                                <div class="InboxTop">
                                    <a href="Profile.php?search=<?php echo $userInbox['userName']; ?>"><p id="InboxName"><?php echo $userInbox['userName']; ?></p></a>
                                    <p id="InboxDate"><?php echo $userInbox['xpLevel']; ?></p> <!--dateInbox-->
                                </div>
                                <div class="InboxContent">
                                    <p id="messageContent"><?php echo $userInbox['bioStatement']; ?></p>
                                </div>
                                <div class="InboxBottom">
                                    <a href="Inbox.php?delete=<?php echo $userInbox['userID']; ?>">Delete</a>
                                    <a href="Inbox.php?active=true">Accept</a>
                                </div>
                            </div>
                        <?php else: false; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
    <?php require __DIR__ . '/../layout/footer.php'; ?>
</body>
<script>
        const btnPost = document.querySelector('.btnPost');
        const sectionPost = document.querySelector('.SectionPost');

        btnPost.addEventListener('click', () => {
            sectionPost.classList.toggle('active');
        });
</script>
</html>