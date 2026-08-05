<?php

    if(!empty($_GET['userName'])){
        $target_username = isset($_GET['userName']) ? htmlspecialchars($_GET['userName'], ENT_QUOTES) : NULL;
        $get_profile = $profile->getProfile(htmlspecialchars($target_username, ENT_QUOTES));
        if ($get_profile && isset($get_profile[0]['userID'])) {
            header("Location: profile.php?userName=" . htmlspecialchars($get_profile[0]['userName'], ENT_QUOTES));
            exit();
        }
    }
    
    
    
?>
<aside id="sidebar">
    <div class="sidebar-inner">
        <a href="home"   class="nav-item active"><i class="fa fa-house"></i><span>Home</span></a>
        <a href="notifcation"  class="nav-item"><i class="fa fa-bell"></i><span>Notification</span></a>
        <a href="leaderboard" class="nav-item"><i class="fa fa-trophy"></i><span>Leaderboard</span></a>
        <!--a href="dashboard"   class="nav-item"><i class="fa-solid fa-chart-simple"></i><span>Dashboard</span></a-->
        <a href="affiliate"   class="nav-item"><i class="fa-solid fa-star"></i><span>Partners</span></a>
        <a href="feedback"    class="nav-item"><i class="fa-solid fa-circle-info"></i><span>Feedback</span></a>
        <div class="sidebar-spacer"></div>
        <a href="Profile"     class="nav-item"><i class="fa fa-user"></i><span>Profile</span></a>
        <a href="#" class="nav-item" ><i class="fa fa-gear"></i><span>Settings</span></a>
        <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle sidebar">
            <i class="fa fa-angle-right"></i>
        </button>
    </div>
</aside>
<script src="public/js/collapse-sidebar.js" defer></script>
<?php 
    if($_SERVER['PHP_SELF'] === '/sidebar.php'){
        session_start();
        if(empty($_SESSION['myuserId'])){
            session_destroy();
            header('Location: /index.php');
            exit;
        }else{
            header('Location: /home.php');
            exit;
        }
    }
?>
