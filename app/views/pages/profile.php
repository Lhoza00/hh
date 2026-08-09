<?php
//ini_set('display_errors', '0');         // Stop displaying errors to the screen
//ini_set('display_startup_errors', '0'); // Stop displaying startup/engine errors
//ini_set('log_errors', '1');             // Enable background error logging
//ini_set('error_log', '/path/to/private/php_errors.log'); // Path to your secret log file

session_start();
if (empty($_SESSION['userID'])) {
    header("Location: index");
    exit;
}
require_once __DIR__ . '/../../../Classes/ProfileClass.php';
require_once __DIR__ . '/../../../Classes/PostClass.php';

$profile_user = new Profile();
$postObj = new Post();
$user = $profile_user->getProfile($_SESSION["userID"]);


if (!empty($_GET["userName"])) {
    require_once __DIR__ . '/../../../Classes/ProfileClass.php';
    $get_user = $_GET["userName"];
    $profile_user = new Profile();
    $user = $profile_user->getProfile($get_user);
    
}


$userPosts = $postObj->getProfilePost($user["userName"]);
?>

<html lang="en" id="profile">
<?php require_once __DIR__ . '/../layout/head.php'; ?>
<style>
    #profile main {
        display: flex;
        justify-content: center;
        padding: 1.5rem 1rem 3rem;
    }


    #profile main .container {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        width: 100%;
        max-width: 640px;
        margin: 3rem auto;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ── BIO CARD ── */
    .profile-card {
        background: var(--Primary);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.75rem 1.5rem 1.25rem;
        transition: border-color 0.2s;
        animation: fadeUp 0.4s ease both;
    }

    .profile-card:hover {
        border-color: var(--border-hover);
    }

    .profile-avatar {
        display: flex;
        justify-content: center;
    }

    .profile-avatar img {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        object-fit: cover;
        background: var(--Secondary);
        border: 3px solid var(--Primary);
        box-shadow: 0 0 0 2px var(--border);
    }

    .profile-details {
        text-align: center;
        margin-top: 0.85rem;
    }

    #userNameWrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }

    .profile-username {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--ink);
        margin: 0;
    }

    #userNameWrap i {
        color: var(--Main);
        font-size: 0.95rem;
    }

    .profile-info {
        font-size: 0.85rem;
        color: var(--muted);
        margin: 0.15rem 0;
    }

    .profile-content {
        margin-top: 1.1rem;
    }

    .profile-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        padding: 0.5rem 0 0.75rem;
    }

    .profile-stat {
        text-align: center;
    }

    .profile-stat b {
        display: block;
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--Main);
    }

    .profile-stat p {
        font-size: 0.72rem;
        color: var(--muted);
        margin: 0.15rem 0 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .profile-content hr {
        border: none;
        border-top: 1px solid var(--border);
        margin: 0.25rem 0 1rem;
    }

    .profile-bio {
        font-size: 0.92rem;
        line-height: 1.6;
        color: var(--muted);
        text-align: center;
        padding: 0 0.5rem;
    }

    .profile-action {
        display: flex;
        justify-content: center;
        margin-top: 1.35rem;
    }

    .profile-action a {
        text-decoration: none;
    }

    .profile-action button {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: 99px;
        padding: 0.5rem 1.85rem;
        cursor: pointer;
        border: none;
        background: var(--Main);
        color: var(--Primary);
        transition: background 0.2s, transform 0.15s;
    }

    .profile-action button:hover {
        background: var(--Substitute);
        transform: translateY(-1px);
    }

    /* ── POSTS / STATS CARD ── */
    .profile-progress {
        background: var(--Primary);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        animation: fadeUp 0.4s ease 0.08s both;
    }

    .profile-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.4rem 1rem 0;
    }

    .profile-tabs {
        display: flex;
        gap: 0;
    }

    .profile-tab {
        background: none;
        border: none;
        cursor: pointer;
        font-family: 'Syne', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--muted);
        padding: 0.65rem 1rem;
        border-bottom: 2px solid transparent;
        transition: color 0.2s, border-color 0.2s;
    }

    .profile-tab:hover {
        color: var(--Main);
    }

    .profile-tab:first-child {
        color: var(--Main);
        border-bottom-color: var(--Main);
    }

    .profile-share {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .profile-share i {
        color: var(--muted);
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        transition: color 0.2s, background 0.2s;
    }

    .profile-share i:hover {
        color: var(--Main);
        background: var(--Secondary);
    }

    .profile-share i.fa-check {
        color: var(--Main);
    }

    .profile-rewards {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
    }

    .profile-streak {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .profile-streak i {
        font-size: 1.5rem;
        color: var(--Main);
    }

    .profile-streak h3 {
        font-family: 'Syne', sans-serif;
        font-size: 0.95rem;
        color: var(--ink);
        margin: 0;
    }

    .profile-reward {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255, 110, 0, 0.08);
        color: var(--Main);
        padding: 0.4rem 0.9rem;
        border-radius: 99px;
        font-family: 'Syne', sans-serif;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .profile-reward:hover {
        background: rgba(255, 110, 0, 0.16);
    }

    .profile-reward i {
        font-size: 0.9rem;
    }

    .profile-progress hr {
        border: none;
        border-top: 1px solid var(--border);
        margin: 0;
    }

    #profile-post {
        padding: 1rem 1.25rem 1.25rem;
        display: flex;
        flex-direction: column;
        min-height: 350px;
        max-height: 600px;
        overflow-y: auto;
        gap: 1rem;
    }

    
</style>

<body>
    <?php require_once __DIR__ . '/../layout/header.php'; ?>
    <?php require_once __DIR__ . '/../components/sidebar.php'; ?>
    <main>
        
        <section class="container">
            <?php require_once __DIR__ . '/../components/postComposer.php'; ?>
            <?php 
                echo "<pre>";

                //var_dump($userPosts);
                echo "</pre>";
            ?>
            <div class="profile-card">
                
                <div class="profile-avatar">
                    <img src="<?= $user["profile-picture"] ?>" alt="profile-picture">
                </div>
                <div class="profile-details">
                    <div>
                        <span id="userNameWrap">
                            <p class="profile-username"><?= $user["userName"] ?></p>
                        </span>
                        <p id="profile-skill" class="profile-info"><?= $user["skill"] ?></p>
                        <p id="profile-pronouns" class="profile-info">He/Him</p>
                    </div>
                    <div class="profile-content">
                        <div class="profile-about">
                            <div class="profile-stats">
                                <div class="profile-stat">
                                    <b class="profile-stat-value"><?= $user["affiliationCount"] ?></b>
                                    <p>Affilaition</p>
                                </div>
                                <div class="profile-stat">
                                    <b class="profile-stat-value"><?= $user["followingCount"] ?></b>
                                    <p>Following</p>
                                </div>
                                <div class="profile-stat">
                                    <b class="profile-stat-value" id="followers"><?= $user["followerCount"] ?></b>
                                    <p>Followers</p>
                                </div>
                            </div>
                            <hr />
                            <div class="profile-bio">
                                <?= $user["profile-bio"] ?>
                            </div>
                        </div>
                    </div>
                    <div class="profile-action">
                        <a onclick="follow(event)" data-follow="Followship.php?id=1"><button name="Follow">Follow</button></a>
                    </div>
                </div>
            </div>
            <?php if(!$user){
                
                echo "<script>document.querySelector('.profile-card').remove();</script>";
                echo "<div class='profile-card'>
                <h1>USER DOES NOT EXIST</h1></div>";
                echo "<style>.profile-card{border: 1px solid black; text-align: center}.profile-progress{display:none;}</style>";
                echo "";
             }?>
            <div class="profile-progress">
                <div class="profile-toolbar">
                    <div class="profile-tabs">
                        <button name="linkPost" class="profile-tab" id="postTab">Post</button>
                        <button name="linkStats" class="profile-tab" id="statsTab">Stats</button>
                    </div>
                    <div class="profile-share">
                        <i onclick="copyLink(this)" class="fa-solid fa-share-from-square" data-username="alex_dev"></i>
                    </div>
                </div>
                <div class="profile-rewards">
                    <div class="profile-streak">
                        <i class="fa-solid fa-fire"></i>
                        <h3>7 Days Streak</h3>
                    </div>
                    <div class="profile-reward">
                        <i class="fa-solid fa-gift"></i>
                        <p>Reward Gift</p>
                    </div>
                </div>
                <hr color=" black" ;>
                <div id="profile-post">
                    <?php if($userPosts):?>
                        <?php foreach ($userPosts as $row_post):?><?php
                            $postId       = $row_post["postId"];
                            $name         = $row_post["userName"];
                            $hashTags     = $row_post["hashTags"];
                            $userTags     = $row_post["userTags"];
                            $content         = $row_post["content"];
                            $image        = $row_post["image"];
                            $comments     = $row_post["comments"];
                            $promotes     = $row_post["promotes"];
                            $shares       = $row_post["shares"];
                            $created_at = $row_post["created_at"];
                            
                            $hashTags = !empty($hashTags) ? explode(",", $hashTags) : [];
                            $userTags = !empty($userTags) ? explode(",", $userTags) : [];
                        ?>
                        <?php require "post.php"?>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>

        </section>
    </main>
    <?php require_once __DIR__ . '/../components/sidebar.php';?>
    <?php require_once __DIR__ . '/../components/bottom-navbar.php';?>
    <?php require_once __DIR__ . '/../layout/footer.php'; ?>
</body>
<script type="text/javascript">
    (function FollowModule() {
        function ajax_send(data, element) {
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

        function response(result, element) {
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
                        if (res.follows == null || res.follows == undefined) {
                            res.follows = 0; // Default to 0 if no follows
                        } else {
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
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    function copyLink(elements) {
        const username = elements.getAttribute('data-username');
        const fullUrl = `${window.location.origin}/Linkspam/Profile.php?userName=${(username)}`;

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
    document.getElementById('statsTab').addEventListener('click', (e) => {
        e.preventDefault();
        fetchContent('Stats.php', 'linkStats=1');
    });

    document.getElementById('postTab').addEventListener('click', (e) => {
        e.preventDefault();
        fetch('PostView.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('profile-post').innerHTML = data;
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
                document.getElementById('profile-post').innerHTML = data;
            })
            .catch(error => {
                console('Error fetching content:', error);
            });
    }
</script>

</html>