<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = isset($_SESSION["user"]);

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar" aria-label="Main navigation">

    <a href="index.php" class="logo">
        <img src="assets/images/find-book-icon.svg" alt="BookFinder logo">
        <span class="logo-text">BookFinder</span>
    </a>

    <!-- DESKTOP NAV -->
    <ul class="desktop-nav">
        <li><a href="index.php" class="<?= $currentPage == 'index.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="results.php" class="<?= $currentPage == 'results.php' ? 'active' : '' ?>">Books</a></li>

        <?php if ($loggedIn) { ?>
            <li><a href="orders.php" class="<?= $currentPage == 'orders.php' ? 'active' : '' ?>">My Orders</a></li>
            <li><a href="logout.php" class="<?= $currentPage == 'logout.php' ? 'active' : '' ?>">Logout</a></li>
        <?php } else { ?>
            <li><a href="register.php" class="<?= $currentPage == 'register.php' ? 'active' : '' ?>">Register</a></li>
            <li><a href="login.php" class="<?= $currentPage == 'login.php' ? 'active' : '' ?>">Login</a></li>
        <?php } ?>
    </ul>

    <!-- MOBILE NAV -->
    <div class="mobile-nav">
        <button class="menu-btn" aria-label="Toggle menu"></button>

        <ul class="mobile-nav-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="results.php">Books</a></li>

            <?php if ($loggedIn) { ?>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php } else { ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
        </ul>
    </div>

</nav>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const menuBtn = document.querySelector('.menu-btn');
        const mobileNav = document.querySelector('.mobile-nav');

        menuBtn.addEventListener('click', () => {
            mobileNav.classList.toggle('active');
        });
    });
</script>