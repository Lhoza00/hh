<style>
    .post-card {
        background: var(--Primary);
        border: 1px solid black;
        border-radius: var(--radius);
        margin-bottom: 1rem;
        
        transition: border-color 0.2s, transform 0.2s;
        animation: fadeUp 0.4s ease both;
    }

    .post-card:hover {
        border-color: var(--border-hover);
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

    .post-card:nth-child(1) {
        animation-delay: 0.05s;
    }

    .post-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .post-card:nth-child(3) {
        animation-delay: 0.15s;
    }

    .post-card:nth-child(4) {
        animation-delay: 0.2s;
    }

    .post-card:nth-child(5) {
        animation-delay: 0.25s;
    }

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
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--Secondary);
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .post-avatar i {
        color: var(--muted);
        font-size: 1.1rem;
    }

    .post-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .post-user-info {
        display: flex;
        flex-direction: column;
    }

    .post-user-meta {
        display: flex;
    }

    .post-user-meta a {
        display: inline-flex;
    }

    .post-author {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--ink);
        text-decoration: none;
    }

    .post-tagged-user {
        font-size: 0.9rem;
        color: var(--ink);
        text-decoration: none;
        display: inline;
    }

    .post-author:hover,
    .post-tagged-user:hover {
        color: var(--Main);
    }

    .post-meta {
        display: flex;
        align-items: center;
        gap: 0rem;
        font-size: 0.77rem;
        color: var(--muted);
    }

    .post-tag {
        background: rgba(255, 110, 0, 0.1);
        color: var(--Main);
        border-radius: 99px;
        padding: 0.1rem 0.5rem;
        font-size: 0.72rem;
        font-weight: 500;
    }

    .post-options {
        color: var(--muted);
        cursor: pointer;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-sm);
        transition: color 0.2s, background 0.2s;
    }

    .post-options:hover {
        color: var(--ink);
        background: var(--Secondary);
    }

    .post-body {
        padding: 0 1rem 0.75rem;
        font-size: 0.97rem;
        line-height: 1.65;
        color: var(--muted);
    }

    .post-body .mention {
        color: var(--Main);
        font-weight: 500;
    }

    .post-body .hashtag {
        color: var(--Substitute);
    }

    .post-image {
        position: relative;
        width: 100%;
        
        overflow: visible;
        border-radius: .75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .post-image::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.2);
        z-index: 0;
        pointer-events: none;
    }

    .post-image img {
        
        width: 100%;
        height: auto;
        object-fit: contain;
        display: block;
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

    .action-btn:hover {
        color: var(--ink);
        background: var(--Secondary);
    }

    .action-btn.liked {
        color: var(--Main);
    }

    .action-btn.liked i {
        color: var(--Main);
    }

    .action-btn i {
        font-size: 0.95rem;
        transition: transform 0.15s;
    }

    .action-btn:hover i {
        transform: scale(1.15);
    }

    .action-spacer {
        flex: 1;
    }

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
</style>
<div class="post-card">
    <div class="post-header">
        <div class="post-user">
            <div class="post-avatar">
                <i class="fa fa-user"></i>
            </div>

            <div class="post-user-info">
                <div class="post-user-line">
                    <a class="post-author" href="profile?userName=<?= urlencode($name); ?>">
                        <?= htmlspecialchars($name); ?>
                    </a>

                    <?php if (!empty($userTags)): ?>
                        <span class="post-with">with</span>

                        <?php foreach ($userTags as $index => $userTag): ?>
                            <?php
                            $userTag = trim($userTag);

                            if ($index > 0) {
                                echo ', ';
                            }
                            ?>

                            <a class="post-tagged-user" href="profile?userName=<?= urlencode($userTag); ?>">
                                @<?= htmlspecialchars($userTag); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="post-meta">
                    <span><?= htmlspecialchars($created_at); ?></span>

                    <?php foreach ($hashTags as $hashTag): ?>
                        <?php $hashTag = trim($hashTag); ?>
                        <?php if (!empty($hashTag)): ?>
                            <span class="post-tag">
                                <?= htmlspecialchars($hashTag); ?>
                            </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="post-options">
            <i class="fa fa-ellipsis"></i>
        </div>
    </div>

    <div class="post-body">
        <?= nl2br(htmlspecialchars($content)); ?>
    </div>

    <?php if (!empty($image)): ?>
        <div class="post-image">
            <img src="<?= htmlspecialchars($image); ?>" alt="Post Image">
        </div>
    <?php endif; ?>

    <div class="post-actions">
        <button class="action-btn" onclick="toggleLike(this)">
            <i class="fa-regular fa-heart"></i>
            <span><?= (int)$promotes; ?></span>
        </button>

        <button class="action-btn" onclick="toggleComment(this)">
            <i class="fa-regular fa-comment"></i>
            <span><?= (int)$comments; ?></span>
        </button>

        <button class="action-btn">
            <i class="fa-solid fa-retweet"></i>
            <span><?= (int)$shares; ?></span>
        </button>

        <div class="action-spacer"></div>

        <button class="action-btn" onclick="copyLink(<?= (int)$postId; ?>)">
            <i class="fa-regular fa-share-from-square"></i>
        </button>
    </div>

    <div class="comment-section" style="display:none;">
        <input type="text" class="comment-input" placeholder="Write a comment...">
        <button class="comment-submit">
            <i class="fa fa-arrow-right"></i>
        </button>
    </div>
</div>
<script>
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
</script>