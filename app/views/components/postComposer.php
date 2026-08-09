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
<style>
    .post-composer {
    background: var(--Secondary);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 1rem;
    margin-bottom: 1.25rem;
    display: none;
    animation: slideDown 0.3s ease;

    &.active {
        display: block;
    }

    .composer-top {
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }

    .composer-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--Primary);
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;

        i {
            color: var(--muted);
        }
    }

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

        &::placeholder {
            color: var(--muted);
        }
    }

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
        width: 34px;
        height: 34px;
        border-radius: var(--radius-sm);
        border: none;
        background: transparent;
        color: var(--muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: color 0.2s, background 0.2s;

        &:hover {
            color: var(--Main);
            background: rgba(255, 110, 0, 0.08);
        }

        label {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        input[type="file"] {
            display: none;
        }
    }

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

        &:hover {
            background: var(--Substitute);
            transform: translateY(-1px);
        }
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
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
</script>