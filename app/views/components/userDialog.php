<dialog class="userTagDialog">
    <div class="dialogHeader">
        <h2>Search Users:</h2>
        <i onclick="closeDialog()" id="cancel">x</i>
    </div>
    <hr>
    <div class="usersWrap" id="userResults">
        <!-- Results will appear here -->
    </div>
    <hr>
    <div class="dialogSearch">
        <form id="userSearchForm">
            <input type="search" id="searchInput" name="term" placeholder="Search user...">
            <button id="searchBtn">Search</button>
        </form>
    </div>
</dialog>

<script>
    // Open dialog
    document.querySelector('#tagUserBtn')?.addEventListener('click', function () {
        document.querySelector('.userTagDialog').showModal();
    });

    // Close dialog
    function closeDialog() {
        document.querySelector('.userTagDialog').close();
    }

    // Escape key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            const dialog = document.querySelector('.userTagDialog');
            if (dialog.open) dialog.close();
        }
    });

    // Use button click (form submission)
    document.getElementById('userSearchForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent page reload

        const query = document.getElementById('searchInput').value;

        if (query.trim() === '') {
            document.getElementById('userResults').innerHTML = '<p>Please enter a search term.</p>';
            return;
        }

        fetch('fetch_users.php?term=' + encodeURIComponent(query))
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
            .then(data => {
                const resultContainer = document.getElementById('userResults');
                resultContainer.innerHTML = ''; // Clear previous results

                if (data.length === 0) {
                    resultContainer.innerHTML = '<p>No users found</p>';
                } else {
                    data.forEach(user => {
                        const p = document.createElement('p');
                        p.textContent = user.userName;
                        p.classList.add('user-result');
                        p.onclick = function () {
                            const selectedUsers = user.userName;

                            // Helper: Get cookie by name
                            function getCookie(name) {
                                const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                                return match ? decodeURIComponent(match[2]) : null;
                            }

                            // Helper: Set cookie
                            function setCookie(name, value) {
                                const maxAge = 8 * 60;
                                document.cookie = `${name}=${encodeURIComponent(value)}; path=/; max-age=${maxAge}`;
                            }

                            // Get current users from cookie or start new
                            let users = [];
                            const cookieValue = getCookie('selectedUsers');
                            if (cookieValue) {
                                try {
                                    users = JSON.parse(cookieValue);
                                } catch (e) {
                                    console.warn("Invalid cookie format. Resetting.");
                                    users = [];
                                }
                            }

                            // Check for duplicates
                            if (!users.includes('@' + selectedUsers)) {
                                if (users.length >= 3) {
                                    document.getElementById('searchInput').value = 'Maximum of 3 users';

                                } else {
                                    users.push('@' + selectedUsers);
                                    setCookie('selectedUsers', JSON.stringify(users));
                                    console.log("Updated user list:", users);
                                }
                            } else {
                                document.getElementById('searchInput').value = 'User Already Selected';
                            }

                            
                        };


                        resultContainer.appendChild(p);
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching users:', error);
                document.getElementById('userResults').innerHTML = '<p>Error loading users</p>';
            });
    });
</script>
<?php 
    if($_SERVER['PHP_SELF'] === '/Components/userDialog.php'){
        session_start();
        if(empty($_SESSION['myuserId'])){
            session_destroy();
            header('Location: /Index.php');
            exit;
        }else{
            header('Location: /Home.php');
            exit;
        }
    }
?>
