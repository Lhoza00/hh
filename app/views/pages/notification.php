<?php
session_start();
if(empty($_SESSION['userID'])) {
    header("Location: index");
    exit;
}
print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en" id="notification">
<?php require_once __DIR__ . '/../layout/head.php';?>
<style>
    :root {
    --Main: #FF6E00;
    --Primary: #FFFFFF;
    --Secondary: #EAE6e0;
    --Substitute: #FFA74F;
    --Tertiary: #FFFFFF;
    
    }
    main {
    --Main-soft: #EEF1FF;
    --notif-ink: #1A1D29;
    --notif-muted: #6B7080;
    --notif-line: #E7E8EE;
    --notif-bg-read: #FAFAFC;
 
    max-width: 720px;
    margin: 2rem auto;
    padding: 2rem 1.25rem 3rem;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Inter, sans-serif;
    color: var(--notif-ink);
  }
  
    
  .notif-toolbar {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 1.25rem;
  }
 
  .notif-title {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: -0.02em;
    margin: 0;
  }
 
  .notif-count {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--Main);
    background: var(--Main-soft);
    padding: 0.3rem 0.65rem;
    border-radius: 999px;
    white-space: nowrap;
  }
 
  .notif-list {
    list-style: none;
    margin: 0;
    padding: 0;
    border: 1px solid var(--notif-line);
    border-radius: 12px;
    overflow: hidden;
  }
 
  .notif-item {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    padding: 1rem 1.1rem;
    border-bottom: 1px solid var(--notif-line);
    background: #fff;
    transition: background-color 0.25s ease;
  }
 
  .notif-item:last-child {
    border-bottom: none;
  }
 
  .notif-item[data-read="true"] {
    background: var(--notif-bg-read);
  }
 
  .notif-dot {
    flex-shrink: 0;
    width: 8px;
    height: 8px;
    margin-top: 0.4rem;
    border-radius: 50%;
    background: var(--Main);
    transition: background-color 0.25s ease, transform 0.25s ease;
  }
 
  .notif-item[data-read="true"] .notif-dot {
    background: transparent;
    transform: scale(0);
  }
 
  .notif-body {
    flex: 1;
    min-width: 0;
  }
 
  .notif-text {
    margin: 0 0 0.2rem;
    font-size: 0.95rem;
    line-height: 1.4;
  }
 
  .notif-item[data-read="true"] .notif-text {
    color: var(--notif-muted);
  }
 
  .notif-item[data-read="true"] .notif-text strong {
    color: var(--notif-muted);
  }
 
  .notif-time {
    font-size: 0.8rem;
    color: var(--notif-muted);
  }
 
  .notif-mark-btn {
    flex-shrink: 0;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--Main);
    background: none;
    border: 1px solid var(--Main);
    border-radius: 8px;
    padding: 0.4rem 0.7rem;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease, opacity 0.2s ease;
  }
 
  .notif-mark-btn:hover {
    background: var(--Main);
    color: #fff;
  }
 
  .notif-mark-btn:focus-visible {
    outline: 2px solid var(--Main);
    outline-offset: 2px;
  }
 
  .notif-item[data-read="true"] .notif-mark-btn {
    opacity: 0;
    pointer-events: none;
    width: 0;
    padding: 0;
    border: none;
    overflow: hidden;
  }
 
  .notif-empty {
    text-align: center;
    color: var(--notif-muted);
    font-size: 0.95rem;
    padding: 2rem 0 0;
  }
 
  @media (max-width: 480px) {
    .notif-item {
      padding: 0.85rem;
    }
    .notif-mark-btn {
      font-size: 0.75rem;
      padding: 0.35rem 0.55rem;
    }
  }
</style>
<body>
<?php require_once __DIR__ . '/../layout/header.php';?>
<?php require_once __DIR__ . '/../components/sidebar.php';?>
<main>
  <div class="notif-toolbar">
    <h1 class="notif-title">Notifications</h1>
    <span class="notif-count" data-unread-count>4 unread</span>
  </div>
 
  <ul class="notif-list" data-notif-list>
 
    <li class="notif-item" data-notif data-read="false">
      <span class="notif-dot" aria-hidden="true"></span>
      <div class="notif-body">
        <p class="notif-text"><strong>Maya Chen</strong> commented on your pull request</p>
        <span class="notif-time">2 minutes ago</span>
      </div>
      <button class="notif-mark-btn" data-mark-read>Mark as read</button>
    </li>
 
    <li class="notif-item" data-notif data-read="false">
      <span class="notif-dot" aria-hidden="true"></span>
      <div class="notif-body">
        <p class="notif-text">Your deploy to <strong>production</strong> succeeded</p>
        <span class="notif-time">1 hour ago</span>
      </div>
      <button class="notif-mark-btn" data-mark-read>Mark as read</button>
    </li>
 
    <li class="notif-item" data-notif data-read="false">
      <span class="notif-dot" aria-hidden="true"></span>
      <div class="notif-body">
        <p class="notif-text"><strong>Theo Park</strong> mentioned you in #design-review</p>
        <span class="notif-time">3 hours ago</span>
      </div>
      <button class="notif-mark-btn" data-mark-read>Mark as read</button>
    </li>
 
    <li class="notif-item" data-notif data-read="false">
      <span class="notif-dot" aria-hidden="true"></span>
      <div class="notif-body">
        <p class="notif-text">Weekly usage report is ready to view</p>
        <span class="notif-time">Yesterday</span>
      </div>
      <button class="notif-mark-btn" data-mark-read>Mark as read</button>
    </li>
 
    <li class="notif-item" data-notif data-read="true">
      <span class="notif-dot" aria-hidden="true"></span>
      <div class="notif-body">
        <p class="notif-text"><strong>Aria Wells</strong> approved your merge request</p>
        <span class="notif-time">2 days ago</span>
      </div>
      <button class="notif-mark-btn" data-mark-read>Mark as read</button>
    </li>
 
  </ul>
 
  <p class="notif-empty" data-notif-empty hidden>You're all caught up.</p>
</main>
<?php require_once __DIR__ . '/../layout/footer.php';?>
<?php require_once __DIR__ . '/../components/bottom-navbar.php';?>
<?php require_once __DIR__ . '/../components/hashTag-Dialog.php';?>
</body>
</html>