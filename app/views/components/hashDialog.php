<dialog class="hashTagDialog">
    <div class="dialogHeader">
        <h2>Enter Hashtag:</h2>
        <i onclick="closesDialog()" id="cancel">x</i>
    </div>
    <hr>
    <div class="dialogSubmit">
        <form id="hashSearchForm">
            <input type="text" id="hashInput" name="term" placeholder="Enter Hashtag...">
            <button type="submit" id="submitBtn">Submit</button>
        </form>
    </div>
</dialog>

<script>
    // Open dialog
    document.querySelector('#tagHashBtn')?.addEventListener('click', function () {
        document.querySelector('.hashTagDialog').showModal();
    });

    // Close dialog
    function closesDialog() {
        document.querySelector('.hashTagDialog').close();
    }

    // Escape key to close
    document.addEventListener('keydown', function (e) {
        if (e.key === "Escape") {
            const dialog = document.querySelector('.hashTagDialog');
            if (dialog.open) dialog.close();
        }
    });

    // Handle form submit
    document.getElementById('hashSearchForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let input = document.getElementById('hashInput').value.trim();
        if (!input) return;

        // Ensure it starts with '#'
        if (!input.startsWith('#')) {
            input = '#' + input;
        }

        // Get existing hashtags from cookie
        let hashtags = getCookie('hashtags');
        hashtags = hashtags ? JSON.parse(hashtags) : [];

        // Add new hashtag if not already present
        if (!hashtags.includes(input)) {
            hashtags.unshift(input); // Add to start
        }

        // Limit to 8 hashtags
        hashtags = hashtags.slice(0, 8);

        // Set cookie (expires in 2 minutes)
        setCookie('hashtags', JSON.stringify(hashtags), 8);

        console.log('Stored hashtags:', hashtags);

        // Close dialog and clear input
        closesDialog();
        document.getElementById('hashInput').value = '';
    });

    // Helper: Set cookie
    function setCookie(name, value, minutes) {
        const d = new Date();
        d.setTime(d.getTime() + (minutes * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = `${name}=${value};${expires};path=/`;
    }

    // Helper: Get cookie
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let c of ca) {
            while (c.charAt(0) === ' ') c = c.substring(1);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
</script>
