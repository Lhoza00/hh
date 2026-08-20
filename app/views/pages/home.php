<?php
session_start();
if(empty($_SESSION['userID'])) {
    header("Location: index");
    exit;
}
require_once __DIR__ . '/../../../Classes/SettingClass.php';
require_once __DIR__ . '/../../../Classes/PostClass.php';
print_r($_SESSION);
$postObj = new Post();
$setting = new Setting();
$userPosts = $postObj->getPost($_SESSION['userID']);
?>
<!DOCTYPE html>
<html lang="en" id="home">
<?php require_once __DIR__ . '/../layout/head.php';?>
<style>
    :root {
    --Main: #FF6E00;
    --Primary: #FFFFFF;
    --Secondary: #EAE6e0;
    --Substitute: #FFA74F;
    --Tertiary: #FFFFFF;
    --ink: black;
    --muted: #7a6a55;
    --border: rgba(255,110,0,0.15);
    --border-hover: rgba(255,110,0,0.4);
    --radius: 14px;
    --radius-sm: 8px;
    --sidebar-w: 64px;
    --sidebar-w-open: 220px;
    --header-h: 60px;
    }

    
    /* ── MAIN LAYOUT ── */
    main {
        margin-top: 2rem;
        margin-left: 0;
        min-height: calc(100vh - var(--header-h));
        
        display: flex;
        width: 100%;
    }

    
    
    .right-column {
        width: 300px;
        padding: 1.5rem 1rem 1.5rem 0;
        flex-shrink: 0;
        display: none;
    }

    

    /* ── FEED TABS ── */
    .feed-tabs {
        display: flex;
        gap: 0;
        border-bottom: 1px solid var(--border);
        
        margin-bottom: 1.25rem;
    }
    .feed-tab {
        padding: 0.6rem 1.25rem;
        font-family: 'Syne', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: color 0.2s, border-color 0.2s;
    }
    .feed-tab:hover { color: var(--ink); }
    .feed-tab.active {
        color: var(--Main);
        border-bottom-color: var(--Main);
    }

    /* ── COMMENT INPUT ── */
    

    /* ── RIGHT COLUMN WIDGETS ── */
    .widget {
        background: var(--Primary);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .widget-title {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.75rem;
    }

    /* Trending */
    .trend-item {
        display: flex;
        flex-direction: column;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--border);
        cursor: pointer;
        transition: padding-left 0.2s;
    }
    .trend-item:last-child { border-bottom: none; }
    .trend-item:hover { padding-left: 0.3rem; }
    .trend-tag {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--ink);
    }
    .trend-count {
        font-size: 0.78rem;
        color: var(--muted);
        margin-top: 0.15rem;
    }

    /* Suggested users */
    .suggested-user {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.45rem 0;
    }
    .sug-avatar {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: var(--Secondary);
        border: 2px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .sug-avatar i { color: var(--muted); font-size: 0.95rem; }
    .sug-info { flex: 1; min-width: 0; }
    .sug-name {
        font-family: 'Syne', sans-serif;
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sug-handle { font-size: 0.77rem; color: var(--muted); }
    .btn-follow {
        background: transparent;
        border: 1px solid var(--Main);
        color: var(--Main);
        border-radius: 99px;
        padding: 0.25rem 0.75rem;
        font-family: 'Syne', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
        flex-shrink: 0;
    }
    .btn-follow:hover, .btn-follow.following {
        background: var(--Main);
        color: var(--Primary);
    }

    /* Streak widget */
    .streak-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .streak-num {
        font-family: 'Syne', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--Main);
        line-height: 1;
    }
    .streak-label { font-size: 0.82rem; color: var(--muted); margin-top: 0.2rem; }
    .streak-flame { font-size: 2.5rem; }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--muted);
    }
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        display: block;
        color: var(--Secondary);
    }
    .empty-state p { font-size: 0.95rem; }

    /* ── FOOTER ── */
    footer {
        margin-left: var(--sidebar-w);
        padding: 1.5rem;
        border-top: 1px solid var(--border);
        text-align: center;
        font-size: 0.8rem;
        color: var(--muted);
        transition: margin-left 0.3s ease;
    }

    

    /* ── TOAST ── */
    .toast {
        position: fixed;
        bottom: 1.5rem;
        left: 50%;
        transform: translateX(-50%) translateY(80px);
        background: var(--Secondary);
        border: 1px solid var(--border);
        border-radius: 99px;
        padding: 0.6rem 1.25rem;
        font-size: 0.88rem;
        color: var(--ink);
        z-index: 999;
        transition: transform 0.3s cubic-bezier(.4,0,.2,1), opacity 0.3s;
        opacity: 0;
        white-space: nowrap;
    }
    .toast.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

</style>
<body style="background: <?php echo $setting->get('background-color');?>;">

<!-- HEADER -->
<?php require_once __DIR__ . '/../layout/header.php';?>
<?php require_once __DIR__ . '/../components/sidebar.php';?>
<!-- MAIN -->
<main>
    <div class="feed-column">
        <!-- Post Composer -->
        <?php require_once __DIR__ . '/../components/postComposer.php'; ?>

        <!-- Feed Tabs -->
        <div class="feed-tabs">
            <div class="feed-tab active" onclick="setTab(this)">For You</div>
            <div class="feed-tab" onclick="setTab(this)">Following</div>
            <div class="feed-tab" onclick="setTab(this)">Partners</div>
        </div>
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
        <?php require_once "post.php"?>
        <!-- Demo Posts -->
        <div class="post-card">
            <div class="post-header">
                <div class="post-user">
                    <div class="post-avatar"><i class="fa fa-user"></i></div>
                    <div class="post-user-info">
                        <a class="post-username" href="Profile.php?username=alex_dev">alex_dev</a>
                        <div class="post-meta">
                            <span>2h ago</span>
                            <span class="post-tag">#webdev</span>
                        </div>
                    </div>
                </div>
                <div class="post-options"><i class="fa fa-ellipsis"></i></div>
            </div>
            <div class="post-body">
                Just shipped a new feature that reduced load time by 60% 🚀 The trick was lazy loading combined with smart caching. <span class="hashtag">#performance</span> <span class="hashtag">#webdev</span> <span class="mention">@linkspam</span>
            </div>
            <div class="post-actions">
                <button class="action-btn" onclick="toggleLike(this)"><i class="fa-regular fa-heart"></i> <span>142</span></button>
                <button class="action-btn" onclick="toggleComment(this)"><i class="fa-regular fa-comment"></i> <span>24</span></button>
                <button class="action-btn"><i class="fa-solid fa-retweet"></i> <span>18</span></button>
                <div class="action-spacer"></div>
                <button class="action-btn" onclick="copyLink()"><i class="fa-regular fa-share-from-square"></i></button>
            </div>
            <div class="comment-section" style="display:none;">
                <input type="text" class="comment-input" placeholder="Write a comment…">
                <button class="comment-submit"><i class="fa fa-arrow-right"></i></button>
            </div>
        </div>

        <div class="post-card">
            <div class="post-header">
                <div class="post-user">
                    <div class="post-avatar"><i class="fa fa-user"></i></div>
                    <div class="post-user-info">
                        <a class="post-username" href="Profile.php?username=sara_ui">sara_ui</a>
                        <div class="post-meta">
                            <span>5h ago</span>
                            <span class="post-tag">#design</span>
                        </div>
                    </div>
                </div>
                <div class="post-options"><i class="fa fa-ellipsis"></i></div>
            </div>
            <div class="post-body">
                Dark mode isn't a trend anymore — it's the default. Designing for it first makes your light theme better too. Here's why… <span class="hashtag">#uxdesign</span> <span class="hashtag">#darkmode</span>
            </div>
            <div class="post-actions">
                <button class="action-btn liked" onclick="toggleLike(this)"><i class="fa-solid fa-heart"></i> <span>289</span></button>
                <button class="action-btn" onclick="toggleComment(this)"><i class="fa-regular fa-comment"></i> <span>51</span></button>
                <button class="action-btn"><i class="fa-solid fa-retweet"></i> <span>33</span></button>
                <div class="action-spacer"></div>
                <button class="action-btn" onclick="copyLink()"><i class="fa-regular fa-share-from-square"></i></button>
            </div>
            <div class="comment-section" style="display:none;">
                <input type="text" class="comment-input" placeholder="Write a comment…">
                <button class="comment-submit"><i class="fa fa-arrow-right"></i></button>
            </div>
        </div>

        <div class="post-card">
            <div class="post-header">
                <div class="post-user">
                    <div class="post-avatar"><i class="fa fa-user"></i></div>
                    <div class="post-user-info">
                        <a class="post-username" href="Profile.php?username=j_codes">j_codes</a>
                        <div class="post-meta">
                            <span>Yesterday</span>
                            <span class="post-tag">#tips</span>
                        </div>
                    </div>
                </div>
                <div class="post-options"><i class="fa fa-ellipsis"></i></div>
            </div>
            <div class="post-body">
                Hot take: CSS Grid is underused. Most developers reach for Flexbox for everything, but Grid handles 2D layouts so elegantly. A thread 🧵 <span class="hashtag">#css</span> <span class="hashtag">#frontend</span>
            </div>
            <div class="post-actions">
                <button class="action-btn" onclick="toggleLike(this)"><i class="fa-regular fa-heart"></i> <span>97</span></button>
                <button class="action-btn" onclick="toggleComment(this)"><i class="fa-regular fa-comment"></i> <span>12</span></button>
                <button class="action-btn"><i class="fa-solid fa-retweet"></i> <span>8</span></button>
                <div class="action-spacer"></div>
                <button class="action-btn" onclick="copyLink()"><i class="fa-regular fa-share-from-square"></i></button>
            </div>
            <div class="comment-section" style="display:none;">
                <input type="text" class="comment-input" placeholder="Write a comment…">
                <button class="comment-submit"><i class="fa fa-arrow-right"></i></button>
            </div>
        </div>

    </div>
</main>
<?php require_once __DIR__ . '/../components/bottom-navbar.php';?>


<!-- DIALOGS -->
<div class="dialog-overlay" id="hashTagDialog" onclick="closeDialogOnOverlay(event, 'hashTagDialog')">
    <div class="dialog-box">
        <div class="dialog-header">
            <h3><i class="fa-solid fa-hashtag" style="color:var(--main);margin-right:.4rem"></i>Add Hashtag</h3>
            <button class="dialog-close" onclick="closeDialog('hashTagDialog')"><i class="fa fa-xmark"></i></button>
        </div>
        <hr style="border-color:var(--border);margin-bottom:.75rem">
        <div class="dialog-search">
            <input type="text" placeholder="Search or type a hashtag…" oninput="filterTags(this)">
        </div>
        <div id="tagList">
            <div class="dialog-list-item" onclick="insertTag('#webdev')">#webdev</div>
            <div class="dialog-list-item" onclick="insertTag('#design')">#design</div>
            <div class="dialog-list-item" onclick="insertTag('#css')">#css</div>
            <div class="dialog-list-item" onclick="insertTag('#javascript')">#javascript</div>
            <div class="dialog-list-item" onclick="insertTag('#opensource')">#opensource</div>
        </div>
    </div>
</div>

<div class="dialog-overlay" id="userTagDialog" onclick="closeDialogOnOverlay(event, 'userTagDialog')">
    <div class="dialog-box">
        <div class="dialog-header">
            <h3><i class="fa-solid fa-user-tag" style="color:var(--main);margin-right:.4rem"></i>Tag a User</h3>
            <button class="dialog-close" onclick="closeDialog('userTagDialog')"><i class="fa fa-xmark"></i></button>
        </div>
        <hr style="border-color:var(--border);margin-bottom:.75rem">
        <div class="dialog-search">
            <input type="text" placeholder="Search users…" oninput="filterUsers(this)">
        </div>
        <div id="userList">
            <div class="dialog-list-item" onclick="insertTag('@alex_dev')">@alex_dev</div>
            <div class="dialog-list-item" onclick="insertTag('@sara_ui')">@sara_ui</div>
            <div class="dialog-list-item" onclick="insertTag('@j_codes')">@j_codes</div>
            <div class="dialog-list-item" onclick="insertTag('@mike_builds')">@mike_builds</div>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<footer>
    © 2025 LinkSpam · <a href="feedback.php" style="color:var(--text-dim);text-decoration:none">Feedback</a> · <a href="#" style="color:var(--text-dim);text-decoration:none">Privacy</a>
</footer>
<script src="public/js/toggle_comment.js"></script>
<script src="public/js/copy_link.js"></script>
<script>

    /* ── Feed Tabs ── */
    function setTab(el) {
        document.querySelectorAll('.feed-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }

    /* ── Like ── */
    function toggleLike(btn) {
        const isLiked = btn.classList.toggle('liked');
        const icon = btn.querySelector('i');
        const count = btn.querySelector('span');
        const n = parseInt(count.textContent);
        if (isLiked) {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            count.textContent = n + 1;
        } else {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
            count.textContent = n - 1;
        }
    }

    /* ── Comment Toggle ── */
    

    /* ── Follow ── */
    function toggleFollow(btn) {
        const isFollowing = btn.classList.toggle('following');
        btn.textContent = isFollowing ? 'Following' : 'Follow';
        showToast(isFollowing ? 'You are now following them!' : 'Unfollowed.');
    }

    /* ── Dialogs ── */
    function openDialog(id) { document.getElementById(id).classList.add('active'); }
    function closeDialog(id) { document.getElementById(id).classList.remove('active'); }
    function closeDialogOnOverlay(e, id) {
        if (e.target === e.currentTarget) closeDialog(id);
    }

    function insertTag(tag) {
        const ta = document.querySelector('.composer-textarea');
        const pos = ta.selectionStart;
        const before = ta.value.substring(0, pos);
        const after  = ta.value.substring(pos);
        ta.value = before + tag + ' ' + after;
        ta.focus();
        ta.selectionStart = ta.selectionEnd = pos + tag.length + 1;
        updateCharCount(ta);
        // close all dialogs
        document.querySelectorAll('.dialog-overlay').forEach(d => d.classList.remove('active'));
        if (!composer.classList.contains('active')) toggleComposer();
    }

    function filterTags(input) {
        const q = input.value.toLowerCase();
        document.querySelectorAll('#tagList .dialog-list-item').forEach(el => {
            el.style.display = el.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    }
    function filterUsers(input) {
        const q = input.value.toLowerCase();
        document.querySelectorAll('#userList .dialog-list-item').forEach(el => {
            el.style.display = el.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    /* ── User Menu placeholder ── */
    function toggleUserMenu() {
        showToast('Profile menu coming soon!');
    }

    /* ── Toast ── */
    let toastTimer;
    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => t.classList.remove('show'), 2500);
    }

    /* ── Keyboard shortcuts ── */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dialog-overlay').forEach(d => d.classList.remove('active'));
            composer.classList.remove('active');
        }
    });
</script>

</body>
</html>
