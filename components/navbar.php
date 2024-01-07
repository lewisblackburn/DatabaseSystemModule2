<div class="navbar-light bg-light p-2 mb-5">
    <nav class="navbar navbar-expand-lg nav">
        <div class="container-fluid align-items-center">
            <a class="navbar-brand" href="index.php">Media Database System</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="films.php">Films</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="songs.php">Songs</a>
                    </li>
                    <?php
                    if (isset($_SESSION["user"])) {
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="profile.php">Profile</a>';
                        echo '</li>';
                    }
                    ?>
                    <?php
                    if (isset($_SESSION["user"])) {
                        if ($_SESSION["user"]["role"] == 1) {
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="dashboard.php">Dashboard</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="d-flex gap-3 align-items-center">
                <?php
                if (isset($_SESSION["user"])) {
                    echo '<div class="dropdown">';
                    echo '<button class="btn btn-secondary btn-sm" type="button" id="addDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo '<i class="bi bi-plus"></i>';
                    echo '</button>';
                    echo '<ul class="dropdown-menu" aria-labelledby="addDropdown">';
                    echo '<li><a class="dropdown-item" href="add-film.php">Add Film</a></li>';
                    echo '<li><a class="dropdown-item" href="add-song.php">Add Song</a></li>';
                    echo '<li><a class="dropdown-item" href="add-director.php">Add Director</a></li>';
                    echo '</ul>';
                    echo '</div>';
                    echo '<a href="logout.php" class="btn btn-warning btn-sm">Logout</a>';
                } else {
                    echo '<a href="login.php" class="btn btn-primary btn-sm">Login</a>';
                }
                ?>
            </div>
        </div>
    </nav>
</div>