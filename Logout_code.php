<style>
    /* Container for the dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Three-dot button */
    .dropbtn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 5px;
    }

    /* Dropdown content (hidden by default) */
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 120px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        overflow: hidden;
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: black;
        text-align: center;
        font-size: 16px;
    }

    /* Hover effect */
    .dropdown-content a:hover {
        background-color: #f0f0f0;
    }

    /* Show the dropdown when active */
    .show {
        display: block;
    }
</style>
    <script>
        function toggleDropdown() {
            document.getElementById("dropdownMenu").classList.toggle("show");
        }

        // Close dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    if (dropdowns[i].classList.contains('show')) {
                        dropdowns[i].classList.remove('show');
                    }
                }
            }
        }
    </script>

    <div class="dropdown">
        <!-- Three-dot button -->
        <button class="dropbtn" onclick="toggleDropdown()">&#x22EE;</button>

        <!-- Dropdown content -->
        <div class="dropdown-content" id="dropdownMenu">
            <a href="Log_out.php">Log Out</a>
        </div>
    </div>