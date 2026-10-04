<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Home</a></li>

        <?php if (basename($_SERVER['PHP_SELF']) === 'login.php'): ?>
            <!-- Only show this About link on login.php -->
            <li><a href="about-us.php">About</a></li>
            <li><a href="features.php">Features</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="team.php">Team</a></li>
            <li><a href="contact.php">Contact</a></li>
        <?php else: ?>
            <!-- Show these links on all other pages -->
            <li><a href="#about">About</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#team">Team</a></li>
            <li><a href="#contact">Contact</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['loggedIn'])): ?>
            <?php if (basename($_SERVER['PHP_SELF']) !== 'logout.php'): ?>
                <li class="nav-item text-bold">
                    <a href="admin/index2.php" class="nav-link active" style="text-transform:uppercase;">
                        <?= $_SESSION['loggedInUser']['name']; ?>
                    </a>
                </li>
                <span>
                    <button class="btn btn-danger rounded-1">
                        <a href="logout.php" style="color: white; text-decoration: none;">Logout</a>
                    </button>
                </span>
            <?php endif; ?>
        <?php else: ?>
            <?php if (basename($_SERVER['PHP_SELF']) !== 'login.php'): ?>
                <span>
                    <button class="btn btn-primary rounded-1">
                        <a href="login.php" style="color: white; text-decoration: none;">Log in</a>
                    </button>
                </span>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
