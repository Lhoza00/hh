
<html lang="en" id="leaderboard">
<?php require __DIR__ . '/../layout/head.php';?>
<body>
    <?php require __DIR__ . '/../layout/header.php';?>
    <main>
        <?php require __DIR__ . '/../components/sidebar.php'; ?>
        <section class="LeaderboardSection">
            <div class="container">
                <h1>Leaderboard:</h1>
                <div class="leaderboard-content">
                    <?php 
                        $leaderboard = [];
                        $pos=1;
                        foreach($leaderboard as $user): 
                            $pos++;
                            $image = "Images/default.png";
                            if(file_exists($user["userPfp"])){
                                $image = "";
                            }
                            $userName = htmlspecialchars($user['userName']);
                            $userLevel = htmlspecialchars($user['userLevel']);
                        ?>
                        <div id="leaderboardUser">
                            <div class="UserInfo">
                                <h2><?php echo $pos?></h2>
                                <div class="leaderboardPic">
                                    <img src="<?php echo htmlspecialchars($image); ?>" alt="ProfilePicture">
                                </div>
                                <div class="leaderboardUserInfo">
                                    <p class=""><?php echo $userName; ?></p>
                                    <p class="">Level: <?php echo $userLevel; ?></p>
                                </div>
                            </div>
                            <div class="leaderboardBtn">
                                <a href="Profile.php?search=<?php echo urlencode($userName); ?>">
                                    <button class="btnViewProfile">View Profile</button>
                                </a>
                            </div>
                        </div>
                        
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