<?php
session_start();

include 'includes/db_connect.php';

$sql = "SELECT lokasyon, fiyat, foto_yolu FROM lokasyonlar";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasyonlar</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/locations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.7.0/css/flag-icons.min.css">

</head>
<body>

<!-- Header -->
<?php include 'includes/header.php'; ?>

<!--Locations-->
<?php
if ($result && $result->num_rows > 0) {
    echo '<h1>Lokasyonlar</h1>';
    echo '<div class="main">';

    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="loc-card">
            <div class="loc-img">
                <img src="<?= htmlspecialchars($row['foto_yolu']) ?>" alt="<?= htmlspecialchars($row['lokasyon']) ?>">
            </div>
            <div class="loc-text"><?= htmlspecialchars($row['lokasyon']) ?></div>
        </div>
        <?php
    }

    echo '</div>';
} else {
    echo "<p>Lokasyon bulunamadı.</p>";
}
?>

<!--Footer-->
<?php include 'includes/footer.php'; ?>

<script src="scripts/script.js"></script>
</body>
</html>