<?php
if (empty($film["image"])) {
    ?>
    <img class="card-img-top poster" src="https://via.placeholder.com/300x450.png?text=No+Image"
        alt="<?= $film['title'] ?>">
    <?php
} else {
    ?>
    <img class="card-img-top poster" src="<?= $film['image'] ?>" alt="<?= $film['title'] ?>">
    <?php
}
?>