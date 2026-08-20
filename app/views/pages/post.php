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
    <div class="comment-body">
        HEllow bye bye
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
