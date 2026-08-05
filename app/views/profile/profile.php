<?php
if(!empty($_GET['username'])){
        $target_username = isset($_GET['username']) ? htmlspecialchars($_GET['username'], ENT_QUOTES) : NULL;
        $get_profile = $profile->getProfile(htmlspecialchars($target_username, ENT_QUOTES));
        $profile_data = $profile->xpLevel($get_profile[0]['userID']);
    }
    $profile->refreshDayStreak($_SESSION['myuserId']);
    $queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    $queryString = explode('=', $queryString);
    $_SESSION['queryString'] = $queryString[1] ?? '';
    //print_r(count($string));
?>
<html lang="en" id="Profile_Page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkSpam | User Profile</title>
    <link rel="stylesheet" href="styles/client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php require __DIR__ . '/../layout/header.php';?>
    <main> 
        <?php if(isset($_GET['deleteId'])){require __DIR__ . '/../../delete.php';}?>
        <section class="Profile_Wrap">
            <div class="container">
                    <div class="BioContainer">
                        <!--Figure out to make a cover page link up with the profile image-->
                        <!--<div class="pfCoverBox">
                            <img name="userCover" src="Images/97899c8479596a9fede11d2b50f05a1a.jpg" alt="Cover Image">
                        </div>-->
                        <div class="pfpBox">
                            <?php
                                $image = "Images/default.png";
                                if(file_exists($profile_data["userPfp"])){
                                    $image = $imageClass->getThumbProfile($profile_data["userPfp"]);
                                }
                             ?>
                            <img src="<?php echo htmlspecialchars($image) ?>" alt="ProfilePicture">
                        </div>    
                        <div class="BioCard">
                            <div>
                                <span id="userNameWrap">
                                    <p class="atUsername"><?php echo htmlspecialchars($profile_data['userName']);?></p>
                                    <?php if(substr($_SESSION['myuserId'],0,4) == 'busi'):;?>
                                        <i title="Business Certified" class="fa-regular fa-gem"></i>                                    
                                    <?php endif;?>
                                </span>
                                <p id="pfSkill" class="pfInfo"><?php echo htmlspecialchars($profile_data['jobSkill']);?></p>        
                                <p id="pfEmail" class="pfInfo"><?php echo htmlspecialchars($profile_data['Gender']);?></p>
                            </div>
                            <div class="ClashedDIV">
                                <div class="AboutUserContainer">
                                    <div class="FollowContainer">
                                        <div class="FollowCard">
                                            <b class="value of following"><?php echo htmlspecialchars($profile_data['affiliationCount']);?></b>
                                            <p>Affilaition</p>
                                        </div>
                                        <div class="FollowCard">
                                            <b class="value of following"><?php echo htmlspecialchars(count(json_decode($profile_data['followings'],true)));?></b>
                                            <p>Following</p>
                                        </div>
                                        <div class="FollowCard">
                                            <b class="value of followers" id="followers"><?php echo htmlspecialchars(count(json_decode($profile_data['followers'],true)));?></b>
                                            <p>Followers</p>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="BioStatement">
                                        <?php echo htmlspecialchars($profile_data['bioStatement']);?>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="btnTrack">
                                <?php if($_SESSION["myuserId"] == $profile_data['userID']):?>
                                    <a href="editProfile.php"><button name="editProfile">Edit</button></a>
                                <?php else:?>
                                    <?php if(!empty($string)):?>
                                        <?php if(in_array($_SESSION['myuserId'],$string)):?>
                                            <a onclick="follow(event)" data-follow="followship.php?id=<?php echo $profile_data['userID'] ?>"><button name="Follow">Unfollow</button></a>
                                        <?php elseif(!in_array($_SESSION['myuserId'], $string)):?>
                                            <a onclick="follow(event)" data-follow="followship.php?id=<?php echo $profile_data['userID'] ?>"><button name="Follow">Follow</button></a>
                                        <?php endif;?>
                                    <?php else:?>
                                        <a onclick="follow(event)" data-follow="followship.php?id=<?php echo $profile_data['userID'] ?>"><button name="Follow">Follow</button></a>
                                    <?php endif;?>   
                                <?php endif;?>

                            </div>
                        </div>
                    </div>
                    <div class="ProgressContainer">
                        
                        <div class="SettingLast">
                            <div class="Tabs_Option">
                                <button name="linkPost" class="loadbutton" id="loadPostBtn">Post</button>
                                <button name="linkStats" class="loadbutton" id="loadStatsBtn">Stats</button>
                            </div>
                            <div class="Setting">
                                <i onclick="copyLink(this)" class="fa-solid fa-share-from-square" data-username="<?php
                                    $target_username = isset($_GET['userName']) ? htmlspecialchars($_GET['userName'], ENT_QUOTES) : NULL;
                                    echo urldecode($target_username); ?>">
                                </i>

                                <?php if($_SESSION["myuserId"] == $profile_data['userID']):?>
                                    <i class="fa-solid fa-gear"></i>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="progressday">
                            <div class="Streakday">
                                <i class="fa-solid fa-fire"></i>
                                <h3><?php echo $profile->dayStreak($profile_data['userID']) ?> Day<?php if($profile->dayStreak($profile_data['userID']) > 1){echo 's';}?> Streak</h3>
                            </div>
                            <div class="Reward_Gift">
                                <i class="fa-solid fa-gift"></i>
                                <p>Reward Gift</p>
                            </div>
                        </div>
                        <hr color=" black";>
                            <!--Change what is displace inbetween CentrehubContainer-->
                        <div id="centrehubContainer">
                            <!-- Content from Stats.php will appear here -->
                            <?php
                                
                                if(isset($_GET['deleteId'])){
                                    require __DIR__ . '/../pages/post.php';
                                }else{
                                    if(!empty($user_post)){
                                        foreach ($user_post as $row_post) {
                                            if(htmlspecialchars($profile_data['userID']) == htmlspecialchars($row_post['userID'])){
                                                require __DIR__ . '/../pages/post.php';
                                            }
                                        }
                                    }
                                }
                                
                            ?>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php require __DIR__ . '/../layout/footer.php';?>
</body>
<script type="text/javascript">
(function FollowModule() {
    function ajax_send(data, element){
        var ajax = new XMLHttpRequest();
        ajax.addEventListener("readystatechange", function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                response(ajax.responseText, element);
            }
        });

        data = JSON.stringify(data);
        //ajax.setRequestHeader("Content-Type", "application/json");
        ajax.open("POST", "ajax.php", true);
        ajax.send(data); 
    }

    function response(result, element){
        /*if(result) {
            const res = JSON.parse(result);
            alert(res.follows);
            return;
        }*/
        try {
            const res = JSON.parse(result);
            if (res.status == "success") {
                const btn = element.querySelector("button[name='Follow']");
                const follower = document.getElementById("followers");
                if (btn.innerText == "Follow") {
                    btn.innerText = "Unfollow";
                    follower.innerText = res.follows;    
                } else {
                    btn.innerText = "Follow";
                    if(res.follows == null || res.follows == undefined) {
                        res.follows = 0; // Default to 0 if no follows
                    }else{
                        follower.innerText = res.follows;
                    }
                }
            } else {
                alert("Failed to follow user.");
            }
        } catch (e) {
            alert("Error processing response: " + e.message);
        }
    }

    window.follow = function(e) {
        e.preventDefault();
        const link = e.currentTarget.getAttribute("data-follow");
        const data = { 
            action: "follow",
            link: link
        };
        ajax_send(data, e.currentTarget);
    };
})();
</script>
<script type="text/javascript">
if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

   function copyLink(elements) {
    const username = elements.getAttribute('data-username');
    const fullUrl = `${window.location.origin}/profile.php?userName=${(username)}`;

    navigator.clipboard.writeText(fullUrl).then(() => {
        const icon = elements.querySelector('.fa-share-from-square') || elements;
        icon.classList.add('fa-check');
        
        setTimeout(() => {
            icon.classList.remove('fa-check');
        }, 3000);
    }).catch(err => {
        alert("Failed to copy link: " + err);
    });
}

</script>
<script>
document.getElementById('loadStatsBtn').addEventListener('click', (e) => {
    e.preventDefault();
    fetchContent('Stats.php', 'linkStats=1');
});

document.getElementById('loadPostBtn').addEventListener('click', (e) => {
    e.preventDefault();
    fetch('PostView.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('centrehubContainer').innerHTML = data;
        })
        .catch(err => console.error('Error loading posts:', err));
});

function fetchContent(url, postData) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: postData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('centrehubContainer').innerHTML = data;
    })
    .catch(error => {
        console('Error fetching content:', error);
    });
}


</script>
</html>