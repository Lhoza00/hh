<style>
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
</style>

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