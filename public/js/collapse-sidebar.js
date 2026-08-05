 /* ── Sidebar ── */

    const sidebar = document.getElementById('sidebar');
    function toggleSidebar() {
        sidebar.classList.toggle('open');
    }
    let isCollapsed = true;

    function collapseSidebar() {
        const sidebar = document.getElementById("sidebar");
        const paragraphs = sidebar.querySelectorAll("aside p");
        const toggleIcon = document.getElementById("toggleBtn");

        if (!isCollapsed) {
            sidebar.style.width = "3.2rem"; // collapsed size
            paragraphs.forEach(p => p.style.display = "none");
            toggleIcon.classList.remove("fa-angle-left");
            toggleIcon.classList.add("fa-angle-right");
        } else {
            sidebar.style.width = "12.2rem"; // original size
            paragraphs.forEach(p => p.style.display = "block");
            toggleIcon.classList.remove("fa-angle-right");
            toggleIcon.classList.add("fa-angle-left");
        }

        isCollapsed = !isCollapsed;
    }