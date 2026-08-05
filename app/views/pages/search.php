<?php
$profile = new Profile();
    // Default to logged-in user
        $profile_data = $profile->xpLevel($_SESSION['myuserId']);
        $target_username = !empty($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES) : htmlspecialchars($profile_data['userName'], ENT_QUOTES);
        $get_profile = $profile->getProfile(htmlspecialchars($target_username, ENT_QUOTES));
        if ($get_profile && isset($get_profile['userID'])) {
            $profile_data = $profile->xpLevel($get_profile['userID']);

            // Fetch posts for this profile
            $post = new Post($DB);
            $user_post = $post->getPost($get_profile['userID']);
        } else {
            // Show error or fallback
            $profile_data = $profile->xpLevel($_SESSION['myuserId']);
            $checkData['Gender'] = " ";
            $user_post = [];
        }
?>
<html lang="en" id="Profile_Page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkSpam | Home</title>
    <link rel="stylesheet" href="styles/client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php require __DIR__ . '/../layout/header.php';?>
    <main>
        <?php require __DIR__ . '/../components/postBox.php';?>
        <section id="sectionSearchClient">
            <div class="container">
                <h1>Search Result: <?php echo $target_username;?></h1>
                <?php if(!empty($get_profile)):?>
                    
                <?php foreach($get_profile as $client):?>
                    <?php $string = json_decode($client['followers'],true);?>
                    <div class="getClient">
                        <div class="nvTop">
                            <div class="searchPic">
                                <?php
                                    $image = "Images/default.png";
                                    if(file_exists($client["userPfp"])){
                                        $image = $imageClass->getThumbProfile($client["userPfp"]);
                                    }
                                ?>
                                <img src="<?php echo htmlspecialchars($image) ?>" alt="ProfilePicture">
                            </div> 
                            <div class="ClientMiddle">
                                <a href="Profile.php?userName=<?php echo urlencode($client['userName']); ?>">
                                <label><?php echo htmlspecialchars($client['userName']); ?></label>
                                <div class="slocation">
                                    <?php if(!empty($client['townCity']) || !empty($client['Province'])): ?>
                                    <i class="fa-solid fa-location-dot"></i>
                                    <p><?php echo $client['townCity']?></p>
                                    <p><?php echo $client['Province']?></p>
                                    <?php endif; ?>
                                </div>
                                <hr color="black">
                                <div class="bioStatement"><p><?php echo $client['bioStatement']?></p></div>
                                
                            </a></div>
                        </div>
                        <div id="btnFFSearch">
                            <?php if($_SESSION["myuserId"] == $client['userID']):?>
                                <a href="Profile.php?userName=<?php echo urlencode($client['userName']); ?>"><button name="EditProfile">Profile</button></a>
                            <?php else:?>
                                <?php if(!empty($string)):?>
                                    <?php if(in_array($_SESSION['myuserId'],$string)):?>
                                        <a onclick="follow(event)" data-follow="Followship.php?id=<?php echo $client['userID'] ?>"><button name="Follow">Unfollow</button></a>
                                    <?php elseif(!in_array($_SESSION['myuserId'], $string)):?>
                                        <a onclick="follow(event)" data-follow="Followship.php?id=<?php echo $client['userID'] ?>"><button name="Follow">Follow</button></a>
                                    <?php endif;?>
                                <?php else:?>
                                    <a onclick="follow(event)" data-follow="Followship.php?id=<?php echo $client['userID'] ?>"><button name="Follow">Follow</button></a>
                                <?php endif;?> 
                            <?php endif;?>  
                        </div>
                    </div>
                <?php endforeach;?>
                <?php else: ?>
                    <p>No results found for "<?php echo $target_username; ?>"</p>
                <?php endif; ?>
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
        ajax.open("post", "ajax.php", true);
        ajax.send(data); 
    }

    function response(result, element){
        try {
            const res = JSON.parse(result);
            if (res.status === "success") {
                const btn = element.querySelector("button[name='Follow']");
                if (btn.innerText === "Follow") {
                    btn.innerText = "Unfollow";
                } else {
                    btn.innerText = "Follow";
                }
            } else {
                alert("Failed to follow user.");
            }
        } catch (e) {
            alert("Unexpected error occurred.");
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

<script>
    const btnPost = document.querySelector('.btnPost');
    const sectionPost = document.querySelector('.SectionPost');

    btnPost.addEventListener('click', () => {
        sectionPost.classList.toggle('active');
    });
</script>
</html>