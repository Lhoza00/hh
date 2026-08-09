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
<style>
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