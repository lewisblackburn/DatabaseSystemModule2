<?php
require_once('utils/requires-user.php');
$id = $_GET['id'];
require_once('utils/database.php');
$sql = "SELECT title, description, release_date, image, director_id FROM film WHERE id = $id";
$result = mysqli_query($conn, $sql);
$film = mysqli_fetch_assoc($result);
$pageTitle = "Edit - " . $film['title'];

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $releaseDate = $_POST['release_date'];
    $imageURL = $_POST['image'];
    $errors = array();

    if (empty($title))
        array_push($errors, "Title is required");

    if (empty($description))
        array_push($errors, "Description is required");

    if (empty($releaseDate))
        array_push($errors, "Release Date is required");

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        $sql = "UPDATE film SET title = ?, description = ?, release_date = ?, image = ? WHERE id = $id";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $title, $description, $releaseDate, $imageURL);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
                header("Location: film.php?id=$id");
                die();
            } else {
                die("Something went wrong");
            }
        } else {
            die("Something went wrong");
        }
    }
}
?>

<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>

    <div class="wrapper">
        <form action="edit-film.php?id=<?= $id ?>" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="title" placeholder="Title" value="<?= $film['title'] ?>">
            </div>
            <div class="form-group">
                <textarea class="form-control" name="description" placeholder="Description"><?= $film['description'] ?>
</textarea>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="release_date" placeholder="Release Date"
                    value="<?= $film['release_date'] ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="image" placeholder="Image URL"
                    value="<?= $film['image'] ?>">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Update" name="submit">
            </div>
        </form>

        <div class='d-flex align-items-center justify-content-between mt-5'>
            <h1>Director</h1>
            <form id="searchForm" onsubmit="return false;">

                <div class="input-group">
                    <input type="text" id="directorSearchTerm" class="form-control" name="Search" placeholder="Search">
                    <button type="button" class="btn btn-outline-secondary" onclick="searchDirectors()">Search</button>
                </div>
            </form>
        </div>

        <div id="directorResults"></div>

        <?php
        if ($film['director_id'] != null) {
            $sql = "SELECT id, name FROM director WHERE id = $film[director_id]";
            $result = mysqli_query($conn, $sql);
            $director = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (count($director) > 0) {
                ?>
                <div class="d-flex align-items-center gap-2" style="width:100%;">
                    <?php
                    if (isset($_SESSION['user'])) {
                        ?>
                        <form action="film/remove-director-from-film.php" method="post" class="mt-3">
                            <input type="hidden" name="director_id" value="<?= $director[0]['id'] ?>">
                            <input type="hidden" name="film_id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        <?php
                    }
                    ?>
                    <b>
                        <?= $director[0]['name'] ?>
                    </b>
                </div>
                <?php
            }
        }
        ?>

        <div class='d-flex align-items-center justify-content-between mt-5'>
            <h1>Soundtrack</h1>
            <form id="searchForm" onsubmit="return false;">

                <div class="input-group">
                    <input type="text" id="songSearchTerm" class="form-control" name="Search" placeholder="Search">
                    <button type="button" class="btn btn-outline-secondary" onclick="searchSongs()">Search</button>
                </div>
            </form>
        </div>

        <div id="songResults"></div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sql = "SELECT film_id, song_id FROM filmsoundtrack WHERE film_id = $id";
            $result = mysqli_query($conn, $sql);
            $soundtrack = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($soundtrack as $songOnFilm) {
                $song_id = $songOnFilm['song_id'];
                $sql = "SELECT id, name, image FROM song WHERE id = $song_id";
                $result = mysqli_query($conn, $sql);
                $song = mysqli_fetch_assoc($result);
                ?>
                <a href="song.php?id=<?= $song['id'] ?>" class="d-flex align-items-center gap-2" style="width:100%;">
                    <?php
                    if (isset($_SESSION['user'])) {
                        ?>
                        <form action="song/remove-song-from-film.php" method="post" class="mt-3">
                            <input type="hidden" name="song_id" value="<?= $song['id'] ?>">
                            <input type="hidden" name="film_id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        <?php
                    }
                    ?>
                    <?php include 'components/song-poster.php'; ?>
                    <div class="d-flex align-items-center">

                        <b>
                            <?= $song['name'] ?>
                        </b>

                    </div>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</body>

<script>
    function searchSongs() {
        var searchTerm = document.getElementById("songSearchTerm").value;
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "song/search-songs-handler.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    var resultsHtml = "";

                    for (var i = 0; i < data.length; i++) {
                        if (!isSongInFilm(data[i].song_id)) {
                            resultsHtml += '<div>';
                            resultsHtml += '<span>' + data[i].song_name + '</span>';
                            resultsHtml += '<button onclick="addSongToFilm(' + data[i].song_id + ')">Add to Film</button>';
                            resultsHtml += '</div>';
                        }
                    }

                    document.getElementById("songResults").innerHTML = resultsHtml;
                } else {
                    console.log("Error in AJAX request");
                }
            }
        };

        xhr.send("searchTerm=" + searchTerm);
    }

    function isSongInFilm(songId) {
        var songsInFilm = <?php echo json_encode(array_column($soundtrack, 'song_id')); ?>;
        return songsInFilm.includes(songId);
    }

    function addSongToFilm(songId) {
        var filmId = <?= $id ?>;
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "song/add-song-to-film.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log("Song added to film successfully");
                    location.reload();
                } else {
                    console.log("Error in AJAX request");
                }
            }
        };

        xhr.send("song_id=" + songId + "&film_id=" + filmId);

    }

    document.getElementById("searchForm").addEventListener("submit", function (event) {
        event.preventDefault();
        searchSongs();
    });

    function searchDirectors() {
        var searchTerm = document.getElementById("directorSearchTerm").value;
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "film/search-directors-handler.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    var resultsHtml = "";

                    console.log(data);

                    for (var i = 0; i < data.length; i++) {
                        if (!isDirectorInFilm(data[i].id)) {
                            resultsHtml += '<div>';
                            resultsHtml += '<span>' + data[i].name + '</span>';
                            resultsHtml += '<button onclick="addDirectorToFilm(' + data[i].id + ')">Add to Film</button>';
                            resultsHtml += '</div>';
                        }
                    }

                    document.getElementById("directorResults").innerHTML = resultsHtml;
                } else {
                    console.log("Error in AJAX request");
                }
            }
        };

        xhr.send("searchTerm=" + searchTerm);
    }

    function addDirectorToFilm(directorId) {
        var filmId = <?= $id ?>;
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "film/add-director-to-film.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log("Director added to film successfully");
                    location.reload();
                } else {
                    console.log("Error in AJAX request");
                }
            }
        };

        xhr.send("director_id=" + directorId + "&film_id=" + filmId);

    }

    function isDirectorInFilm(directorId) {
        var directorInFilm = <?php echo json_encode($film['director_id']); ?>;
        return directorInFilm == directorId;
    }

</script>



</html>