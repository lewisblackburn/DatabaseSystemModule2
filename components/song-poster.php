<?php
if (empty($song["image"])) {
    ?>
    <img class="cover" src="https://via.placeholder.com/300x450.png?text=No+Image" alt="<?= $song['name'] ?>">
    <?php
} else {
    ?>
    <img class="cover" src="<?= $song['image'] ?>" alt="<?= $song['name'] ?>">
    <?php
}
?>