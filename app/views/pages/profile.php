<?php
session_start();
if(empty($_SESSION['userID'])) {
    header("Location: index");
    exit;
}
?>

<html lang="en" id="profile">
<?php require_once __DIR__ . '/../layout/head.php';?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkSpam | User Profile</title>
    <link rel="stylesheet" href="styles/client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        #Profile_Page main {
            display: flex;
            justify-content: center;
            padding: 1.5rem 1rem 3rem;
        }

        .Profile_Wrap { width: 100%; }
        .Profile_Wrap .container {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            width: 100%;
            max-width: 640px;
            margin: 3rem auto;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── BIO CARD ── */
        .BioContainer {
            background: var(--Primary);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.75rem 1.5rem 1.25rem;
            transition: border-color 0.2s;
            animation: fadeUp 0.4s ease both;
        }
        .BioContainer:hover { border-color: var(--border-hover); }

        .pfpBox { display: flex; justify-content: center; }
        .pfpBox img {
            width: 96px; height: 96px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--Secondary);
            border: 3px solid var(--Primary);
            box-shadow: 0 0 0 2px var(--border);
        }

        .BioCard { text-align: center; margin-top: 0.85rem; }
        #userNameWrap { display: flex; align-items: center; justify-content: center; gap: 0.4rem; }
        .atUsername {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--ink);
            margin: 0;
        }
        #userNameWrap i { color: var(--Main); font-size: 0.95rem; }
        .pfInfo { font-size: 0.85rem; color: var(--muted); margin: 0.15rem 0; }

        .ClashedDIV { margin-top: 1.1rem; }
        .FollowContainer {
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 0.5rem 0 0.75rem;
        }
        .FollowCard { text-align: center; }
        .FollowCard b {
            display: block;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--Main);
        }
        .FollowCard p {
            font-size: 0.72rem;
            color: var(--muted);
            margin: 0.15rem 0 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ClashedDIV hr { border: none; border-top: 1px solid var(--border); margin: 0.25rem 0 1rem; }

        .BioStatement {
            font-size: 0.92rem;
            line-height: 1.6;
            color: var(--muted);
            text-align: center;
            padding: 0 0.5rem;
        }

        .btnTrack { display: flex; justify-content: center; margin-top: 1.35rem; }
        .btnTrack a { text-decoration: none; }
        .btnTrack button {
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
        .btnTrack button:hover { background: var(--Substitute); transform: translateY(-1px); }

        /* ── POSTS / STATS CARD ── */
        .ProgressContainer {
            background: var(--Primary);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            animation: fadeUp 0.4s ease 0.08s both;
        }

        .SettingLast {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.4rem 1rem 0;
        }
        .Tabs_Option { display: flex; gap: 0; }
        .loadbutton {
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
        .loadbutton:hover { color: var(--Main); }
        .loadbutton:first-child { color: var(--Main); border-bottom-color: var(--Main); }

        .Setting { display: flex; align-items: center; gap: 0.65rem; }
        .Setting i {
            color: var(--muted);
            cursor: pointer;
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: var(--radius-sm);
            transition: color 0.2s, background 0.2s;
        }
        .Setting i:hover { color: var(--Main); background: var(--Secondary); }
        .Setting i.fa-check { color: var(--Main); }

        .progressday {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
        }
        .Streakday { display: flex; align-items: center; gap: 0.6rem; }
        .Streakday i { font-size: 1.5rem; color: var(--Main); }
        .Streakday h3 { font-family: 'Syne', sans-serif; font-size: 0.95rem; color: var(--ink); margin: 0; }

        .Reward_Gift {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(255,110,0,0.08);
            color: var(--Main);
            padding: 0.4rem 0.9rem;
            border-radius: 99px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .Reward_Gift:hover { background: rgba(255,110,0,0.16); }
        .Reward_Gift i { font-size: 0.9rem; }

        .ProgressContainer hr { border: none; border-top: 1px solid var(--border); margin: 0; }

        #centrehubContainer {
            padding: 1rem 1.25rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* ── DEFAULT DEMO POSTS ── */
        .post-card {
            background: var(--Primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
        }
        .post-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1rem 0.5rem;
        }
        .post-user { display: flex; align-items: center; gap: 0.65rem; }
        .post-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--Secondary);
            border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .post-avatar i { color: var(--muted); font-size: 1rem; }
        .post-username { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.9rem; color: var(--ink); }
        .post-meta { font-size: 0.75rem; color: var(--muted); margin-top: 0.1rem; }
        .post-body { padding: 0 1rem 0.75rem; font-size: 0.92rem; line-height: 1.6; color: var(--muted); }
        .post-actions {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            border-top: 1px solid var(--border);
            padding: 0.5rem 1rem;
            font-size: 0.82rem;
            color: var(--muted);
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../layout/header.php';?>
    <?php require_once __DIR__ . '/../components/sidebar.php';?>
    <main>
        <section class="Profile_Wrap">
            <div class="container">
                <div class="BioContainer">
                    <div class="pfpBox">
                        <img src="Images/default.png" alt="ProfilePicture">
                    </div>
                    <div class="BioCard">
                        <div>
                            <span id="userNameWrap">
                                <p class="atUsername">alex_dev</p>
                            </span>
                            <p id="pfSkill" class="pfInfo">Web Developer</p>
                            <p id="pfEmail" class="pfInfo">He/Him</p>
                        </div>
                        <div class="ClashedDIV">
                            <div class="AboutUserContainer">
                                <div class="FollowContainer">
                                    <div class="FollowCard">
                                        <b class="value of following">12</b>
                                        <p>Affilaition</p>
                                    </div>
                                    <div class="FollowCard">
                                        <b class="value of following">84</b>
                                        <p>Following</p>
                                    </div>
                                    <div class="FollowCard">
                                        <b class="value of followers" id="followers">213</b>
                                        <p>Followers</p>
                                    </div>
                                </div>
                                <hr/>
                                <div class="BioStatement">
                                    Building things on the web, one commit at a time. Coffee-powered and always shipping. ☕
                                </div>
                            </div>
                        </div>
                        <div class="btnTrack">
                            <a onclick="follow(event)" data-follow="Followship.php?id=1"><button name="Follow">Follow</button></a>
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
                            <i onclick="copyLink(this)" class="fa-solid fa-share-from-square" data-username="alex_dev"></i>
                        </div>
                    </div>
                    <div class="progressday">
                        <div class="Streakday">
                            <i class="fa-solid fa-fire"></i>
                            <h3>7 Days Streak</h3>
                        </div>
                        <div class="Reward_Gift">
                            <i class="fa-solid fa-gift"></i>
                            <p>Reward Gift</p>
                        </div>
                    </div>
                    <hr color=" black";>
                    <div id="centrehubContainer">
                        <div class="post-card">
                            <div class="post-header">
                                <div class="post-user">
                                    <div class="post-avatar"><i class="fa fa-user"></i></div>
                                    <div>
                                        <div class="post-username">alex_dev</div>
                                        <div class="post-meta">2h ago</div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-body">
                                Just shipped a new feature that reduced load time by 60% 🚀
                            </div>
                            <div class="post-actions">
                                <span><i class="fa-regular fa-heart"></i> 142</span>
                                <span><i class="fa-regular fa-comment"></i> 24</span>
                                <span><i class="fa-solid fa-retweet"></i> 18</span>
                            </div>
                        </div>
                        <div class="post-card">
                            <div class="post-header">
                                <div class="post-user">
                                    <div class="post-avatar"><i class="fa fa-user"></i></div>
                                    <div>
                                        <div class="post-username">alex_dev</div>
                                        <div class="post-meta">Yesterday</div>
                                    </div>
                                </div>
                            </div>
                            <div class="post-body">
                                Hot take: CSS Grid is underused. Most devs reach for Flexbox for everything.
                            </div>
                            <div class="post-actions">
                                <span><i class="fa-regular fa-heart"></i> 97</span>
                                <span><i class="fa-regular fa-comment"></i> 12</span>
                                <span><i class="fa-solid fa-retweet"></i> 8</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php require_once __DIR__ . '/../layout/footer.php';?>
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