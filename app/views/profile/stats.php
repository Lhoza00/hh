<?php 
    require_once("autoLoader.php");
    
    $profile = new Profile();
    if(!empty($_SESSION['queryString'])){
        $target_username = htmlspecialchars($_SESSION['queryString']);
        $get_profile = $profile->getProfile($target_username);
        $profile_data = $profile->xpLevel($get_profile[0]['userID']);
    }
    
    
    //print_r(count($string));
?>
<?php if(!empty($profile_data)): ?>
<div class="CentrehubContainer">
    <div class="ProgressData">
        <div class="ProgressMiniCard">
            <p>Highest Level</p>
            <p><?php echo htmlspecialchars($profile_data['userLevel'])?></p>
        </div>
        <div class="ProgressMiniCard">
            <p>Total experience points</p>
            <p><?php echo htmlspecialchars($profile_data['totalXP'])?></p>
        </div>
        <div class="ProgressMiniCard">
            <p>Affiliate Codes</p>
            <p><?php echo htmlspecialchars($profile_data['TotalAffiliateCode'])?></p>
        </div>
        <div class="ProgressMiniCard">
            <p>Highest Day Streak</p>
            <p><?php echo htmlspecialchars($profile_data['dayStreak'])?></p>
        </div>
        <div class="ProgressMiniCard">
            <p>Total Shared to</p>
            <p><?php echo htmlspecialchars($profile_data['totalSharedTo'])?></p>
        </div>
        <div class="ProgressMiniCard">
            <p>Total Shout Outs</p>
            <p><?php echo htmlspecialchars($profile_data['shoutOuts'])?></p>
        </div>
    </div>
    <div class="CourseSection">
        
    </div>
</div>
<?php else: ?>
<div class="CentrehubContainer">
    <h1 style="text-align:center;font-size: 2rem;">No profile data found.</h1>
    <p>Please check the username or try again later.</p>
</div>
<?php endif; ?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>