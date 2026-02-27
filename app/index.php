<?php
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MadeMyDay - Fresh Vegetables</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header> 🛒 MadeMyDay - Fresh Vegetables </header>

<nav>
    <a href="index.php">Vegetables</a>
    <a href="admin.php">Admin</a>
</nav>

<div class="container">
<?php
$sql = "SELECT * FROM vegetables";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='card'>";

        $imagePath = $row['image'];

        // If it's a URL (Azure Blob / Internet), use directly; else treat as local filename.
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            echo "<img src='".$imagePath."' alt='veg'>";
        } else {
            echo "<img src='images/".$imagePath."' alt='veg'>";
        }

        echo "<h3>".htmlspecialchars($row['name'])."</h3>";
        echo "<p>".htmlspecialchars($row['description'])."</p>";
        echo "<p class='price'>₹".htmlspecialchars($row['price'])."/kg</p>";
        echo "<button>Add to Cart</button>";
        echo "</div>";
    }
} else {
    echo "<p style='padding:40px;'>No vegetables available.</p>";
}
?>
</div>

<div style="text-align:center; margin-top:30px; font-size:14px;">
    <hr>
    <p>Server: <?php echo gethostname(); ?></p>
</div>

</body>
</html>
