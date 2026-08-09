<?php if(empty($_SESSION['userID'])): ?>
    <header class="global-header">
    <div class="container">
        <a href="index" class="Logo"><?php echo APP_NAME; ?></a>
        <nav class="navbar">
        <a href="#aboutSection">About</a>
        <a href="#News">News</a>
        <a href="#OurServices">Services</a>
        </nav>
        <div class="nav-cta">
        <a href="login" class="btn-nav-ghost">Log in</a>
        <a href="sign-up" class="btn-nav-solid">Sign up</a>
        </div>
        <button class="menu-btn" id="menu-btn" aria-label="Open menu" aria-expanded="false">
        <i class="fas fa-bars"></i>
        </button>
    </div>
    <nav class="mini-navbar" id="mini-navbar" aria-hidden="true">
        <a href="#aboutSection">About</a>
        <a href="#News">News</a>
        <a href="#OurServices">Services</a>
        <a href="login">Log in</a>
        <a href="sign-up" style="color:var(--Main);font-weight:500">Sign up</a>
    </nav>
    </header>
<?php elseif(
    isset($_SESSION['userID']) &&
    $_SERVER['PHP_SELF'] != '/profile' &&
    $_SERVER['PHP_SELF'] != '/dashboard' &&
    $_SERVER['PHP_SELF'] != '/feedback' &&
    $_SERVER['PHP_SELF'] != '/editProfile' &&
    $_SERVER['PHP_SELF'] != '/changeImage' &&
    $_SERVER['PHP_SELF'] != 'leaderboard'
): ?>


<header class="client-header">
    <a class="logo" href="home"><?php echo APP_NAME; ?></a>
    <div class="header-center">
        <div class="search-wrap">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="Search people, tags, posts…">
        </div>
    </div>
    <div class="header-right">
        <button class="btn-post-header" onclick="toggleComposer()">
            <i class="fa fa-plus"></i> Post
        </button>
        <a class="avatar-btn" href="profile" onclick="toggleUserMenu()">
            <i class="fa fa-user"></i>
        </a>
        <a class="avatar-btn-notification" href="notification">
            <i class="fa fa-bell"></i>
        </a>
    </div>
</header>
    
<?php elseif(!empty($_SESSION['myuserId']) && !empty($profile_data)): ?>
    <header>
        <div class="container">
            <a href="home.php" class="Logo">LinkSpam</a> 
            <div class="LevelStats">
                <p>Level <?php echo htmlspecialchars($profile_data['userLevel']);?></p>
                    <?php if($_SESSION["myuserId"] == $profile_data['userID']):?>
                        <progress min="0" max="100" value=<?php
                        echo htmlspecialchars(ceil(($profile_data['xpLevel'] * 100))) / htmlspecialchars($profile_data['quota']);
                        ?>>
                        Xp Level</progress>
                        <p id="quota"><?php echo htmlspecialchars($profile_data['xpLevel']);?>/<?php echo htmlspecialchars($profile_data['quota']);?> xp</p>
                    <?php endif;?>
                </div>
            </div>
        </header>
<?php endif; ?>