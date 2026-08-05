<?php
session_start();
if(empty($_SESSION['userID'])) {
    header("Location: index");
    exit;
}
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
        margin-top: var(--header-h);
        margin-left: var(--sidebar-w);
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

    /* ── POST COMPOSER ── */
    .post-composer {
        background: var(--Secondary);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem;
        margin-bottom: 1.25rem;
        display: none;
        animation: slideDown 0.3s ease;
    }
    .post-composer.active { display: block; }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .composer-top {
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }
    .composer-avatar {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--Primary);
        border: 2px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .composer-avatar i { color: var(--muted); }
    .composer-textarea {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
        font-size: 1rem;
        resize: none;
        min-height: 72px;
        line-height: 1.6;
    }
    .composer-textarea::placeholder { color: var(--muted); }

    .composer-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border);
        margin-top: 0.75rem;
    }
    .composer-tools {
        display: flex;
        gap: 0.25rem;
    }
    .tool-btn {
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        border: none;
        background: transparent;
        color: var(--muted);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        transition: color 0.2s, background 0.2s;
    }
    .tool-btn:hover { color: var(--Main); background: rgba(255,110,0,0.08); }
    .tool-btn label { cursor: pointer; display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; }
    .tool-btn input[type=file] { display: none; }

    .char-count {
        font-size: 0.78rem;
        color: var(--muted);
    }

    .btn-submit-post {
        background: var(--Main);
        color: var(--Primary);
        border: none;
        border-radius: 99px;
        padding: 0.45rem 1.25rem;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
    }
    .btn-submit-post:hover {
        background: var(--Substitute);
        transform: translateY(-1px);
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

    /* ── POST CARD ── */
    .post-card {
        background: var(--Primary);
        border: 1px solid black;
        border-radius: var(--radius);
        margin-bottom: 1rem;
        overflow: hidden;
        transition: border-color 0.2s, transform 0.2s;
        animation: fadeUp 0.4s ease both;
    }
    .post-card:hover { border-color: var(--border-hover); }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .post-card:nth-child(1) { animation-delay: 0.05s; }
    .post-card:nth-child(2) { animation-delay: 0.1s; }
    .post-card:nth-child(3) { animation-delay: 0.15s; }
    .post-card:nth-child(4) { animation-delay: 0.2s; }
    .post-card:nth-child(5) { animation-delay: 0.25s; }

    .post-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.9rem 1rem 0.6rem;
    }
    .post-user {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }
    .post-avatar {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--Secondary);
        border: 2px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }
    .post-avatar i { color: var(--muted); font-size: 1.1rem; }
    .post-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .post-user-info { display: flex; flex-direction: column; }
    .post-username {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--ink);
        text-decoration: none;
    }
    .post-username:hover { color: var(--Main); }
    .post-meta {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.77rem;
        color: var(--muted);
    }
    .post-tag {
        background: rgba(255,110,0,0.1);
        color: var(--Main);
        border-radius: 99px;
        padding: 0.1rem 0.5rem;
        font-size: 0.72rem;
        font-weight: 500;
    }

    .post-options {
        color: var(--muted);
        cursor: pointer;
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        border-radius: var(--radius-sm);
        transition: color 0.2s, background 0.2s;
    }
    .post-options:hover { color: var(--ink); background: var(--Secondary); }

    .post-body {
        padding: 0 1rem 0.75rem;
        font-size: 0.97rem;
        line-height: 1.65;
        color: var(--muted);
    }
    .post-body .mention { color: var(--Main); font-weight: 500; }
    .post-body .hashtag { color: var(--Substitute); }

    .post-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        display: block;
        background: var(--Secondary);
    }

    .post-actions {
        display: flex;
        align-items: center;
        border-top: 1px solid var(--border);
        padding: 0.5rem 0.75rem;
        gap: 0.25rem;
    }
    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.6rem;
        border-radius: var(--radius-sm);
        border: none;
        background: transparent;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem;
        cursor: pointer;
        transition: color 0.2s, background 0.2s;
    }
    .action-btn:hover { color: var(--ink); background: var(--Secondary); }
    .action-btn.liked { color: var(--Main); }
    .action-btn.liked i { color: var(--Main); }
    .action-btn i { font-size: 0.95rem; transition: transform 0.15s; }
    .action-btn:hover i { transform: scale(1.15); }
    .action-spacer { flex: 1; }

    /* ── COMMENT INPUT ── */
    .comment-section {
        padding: 0.6rem 1rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }
    .comment-input {
        flex: 1;
        background: var(--Secondary);
        border: 1px solid var(--border);
        border-radius: 99px;
        padding: 0.4rem 1rem;
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .comment-input::placeholder { color: var(--muted); }
    .comment-input:focus { border-color: var(--Main); }
    .comment-submit {
        width: 32px; height: 32px;
        background: var(--Main);
        border: none;
        border-radius: 50%;
        color: var(--Primary);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        transition: background 0.2s, transform 0.15s;
        flex-shrink: 0;
    }
    .comment-submit:hover { background: var(--Substitute); transform: scale(1.08); }

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

    /* ── DIALOG ── */
    .dialog-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(4px);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .dialog-overlay.active { display: flex; }
    .dialog-box {
        background: var(--Primary);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        width: 90%;
        max-width: 380px;
        padding: 1.25rem;
        animation: slideDown 0.25s ease;
    }
    .dialog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    .dialog-header h3 {
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink);
    }
    .dialog-close {
        background: none;
        border: none;
        color: var(--muted);
        cursor: pointer;
        font-size: 1.1rem;
        transition: color 0.2s;
    }
    .dialog-close:hover { color: var(--Main); }
    .dialog-search input {
        width: 100%;
        background: var(--Secondary);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0.5rem 0.8rem;
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        outline: none;
        margin-bottom: 0.5rem;
    }
    .dialog-search input:focus { border-color: var(--Main); }
    .dialog-list-item {
        padding: 0.5rem 0.4rem;
        font-size: 0.95rem;
        cursor: pointer;
        border-radius: var(--radius-sm);
        transition: background 0.15s;
        color: var(--ink);
    }
    .dialog-list-item:hover { background: var(--Secondary); color: var(--Main); }

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

    /* ── SCROLLBAR ── */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: var(--Secondary); }
    ::-webkit-scrollbar-thumb { background: var(--Substitute); border-radius: 99px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--Main); }


    .bottom-nav {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(20px);
        border-top: 0px solid limegreen;
        justify-content: space-around;

        z-index: 98;
        padding: 0.5rem 0 calc(0.5rem + env(safe-area-inset-bottom));
    }
    .bottom-nav ul {
        list-style: none;
        display: flex;
        width: 100%;
        border: 0px solid red;
        justify-content: space-around;
        align-items: center;
    }
    .bottom-nav ul li a {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.2rem;
        color: var(--muted);
        text-decoration: none;
        font-size: 0.65rem;
        padding: 0.3rem 0.8rem;
        border-radius: var(--radius-sm);
        transition: color 0.2s;
    }
    .bottom-nav ul li a i { font-size: 1.2rem; }
    .bottom-nav ul li a.active, .bottom-nav ul li a:hover { color: var(--Main); }
</style>
<body>

<!-- HEADER -->
<?php require_once __DIR__ . '/../layout/header.php';?>
<?php require_once __DIR__ . '/../components/sidebar.php';?>

<!-- MAIN -->
<main>
    <div class="feed-column">
       
        <!-- Post Composer -->
        <form method="POST" action="home.php" enctype="multipart/form-data">
            <div class="post-composer" id="postComposer">
                <div class="composer-top">
                    <div class="composer-avatar"><i class="fa fa-user"></i></div>
                    <textarea
                        class="composer-textarea"
                        name="post"
                        maxlength="255"
                        placeholder="What's on your mind?"
                        rows="3"
                        oninput="updateCharCount(this)"></textarea>
                </div>
                <div class="composer-footer">
                    <div class="composer-tools">
                        <button type="button" class="tool-btn" onclick="openDialog('hashTagDialog')" title="Add hashtag">
                            <i class="fa-solid fa-hashtag"></i>
                        </button>
                        <button type="button" class="tool-btn" onclick="openDialog('userTagDialog')" title="Tag user">
                            <i class="fa-solid fa-user-tag"></i>
                        </button>
                        <button type="button" class="tool-btn" title="Add image">
                            <label><input type="file" name="file" accept="image/*"><i class="fa-solid fa-image"></i></label>
                        </button>
                    </div>
                    <span class="char-count" id="charCount">255</span>
                    <button type="submit" name="btnSavePost" class="btn-submit-post">Publish</button>
                </div>
            </div>
        </form>

        <!-- Feed Tabs -->
        <div class="feed-tabs">
            <div class="feed-tab active" onclick="setTab(this)">For You</div>
            <div class="feed-tab" onclick="setTab(this)">Following</div>
            <div class="feed-tab" onclick="setTab(this)">Partners</div>
        </div>

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

    <!-- RIGHT COLUMN --
    <div class="right-column">

        <!-- Streak --
        <div class="widget">
            <div class="widget-title">Your Streak</div>
            <div class="streak-row">
                <div>
                    <div class="streak-num">7</div>
                    <div class="streak-label">days in a row</div>
                </div>
                <div class="streak-flame">🔥</div>
            </div>
        </div>

        <!-- Trending --
        <div class="widget">
            <div class="widget-title">Trending Tags</div>
            <div class="trend-item">
                <span class="trend-tag">#webdev</span>
                <span class="trend-count">1.2k posts today</span>
            </div>
            <div class="trend-item">
                <span class="trend-tag">#opensource</span>
                <span class="trend-count">847 posts today</span>
            </div>
            <div class="trend-item">
                <span class="trend-tag">#uxdesign</span>
                <span class="trend-count">631 posts today</span>
            </div>
            <div class="trend-item">
                <span class="trend-tag">#css</span>
                <span class="trend-count">512 posts today</span>
            </div>
        </div>

        <!-- Suggested --
        <div class="widget">
            <div class="widget-title">People to Follow</div>
            <div class="suggested-user">
                <div class="sug-avatar"><i class="fa fa-user"></i></div>
                <div class="sug-info">
                    <div class="sug-name">Mike Chen</div>
                    <div class="sug-handle">@mike_builds</div>
                </div>
                <button class="btn-follow" onclick="toggleFollow(this)">Follow</button>
            </div>
            <div class="suggested-user">
                <div class="sug-avatar"><i class="fa fa-user"></i></div>
                <div class="sug-info">
                    <div class="sug-name">Priya Sharma</div>
                    <div class="sug-handle">@priya_ux</div>
                </div>
                <button class="btn-follow" onclick="toggleFollow(this)">Follow</button>
            </div>
            <div class="suggested-user">
                <div class="sug-avatar"><i class="fa fa-user"></i></div>
                <div class="sug-info">
                    <div class="sug-name">David Lee</div>
                    <div class="sug-handle">@dlee_dev</div>
                </div>
                <button class="btn-follow" onclick="toggleFollow(this)">Follow</button>
            </div>
        </div>

    </div-->
</main>

<!-- BOTTOM NAV (mobile) -->
<nav class="bottom-nav">
    <ul>
        <li><a href="home" class="active"><i class="fa fa-house"></i>Home</a></li>
        <li><a href="affiliate"><i class="fa-solid fa-star"></i>Partners</a></li>
        <li><a href="#" onclick="toggleComposer(); return false;"><i class="fa-solid fa-plus-circle"></i>Post</a></li>
        <li><a href="leaderboard"><i class="fa fa-trophy"></i>Top</a></li>
        <li><a href="profile"><i class="fa fa-user"></i>Profile</a></li>
    </ul>
</nav>

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
<script>

    /* ── Composer ── */
    const composer = document.getElementById('postComposer');
    function toggleComposer() {
        composer.classList.toggle('active');
        if (composer.classList.contains('active')) {
            composer.querySelector('textarea').focus();
        }
    }

    function updateCharCount(el) {
        document.getElementById('charCount').textContent = 255 - el.value.length;
    }

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
    function toggleComment(btn) {
        const card = btn.closest('.post-card');
        const section = card.querySelector('.comment-section');
        const isVisible = section.style.display !== 'none';
        section.style.display = isVisible ? 'none' : 'flex';
        if (!isVisible) section.querySelector('input').focus();
    }

    /* ── Copy Link / Share ── */
    function copyLink() {
        navigator.clipboard.writeText(window.location.href).catch(() => {});
        showToast('Link copied to clipboard!');
    }

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
