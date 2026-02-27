<?php
include 'db.php';

// Optional Azure Blob upload support.
// If composer + Azure SDK installed in /var/www/html/vendor, we can upload.
// If not installed, you can still paste an image URL or local filename.
$blobEnabled = false;
$blobClient = null;

$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    // db.php already loaded env, reuse those keys
    $account = $_ENV['BLOB_ACCOUNT_NAME'] ?? null;
    $key = $_ENV['BLOB_ACCOUNT_KEY'] ?? null;
    $container = $_ENV['BLOB_CONTAINER'] ?? 'vegetables';
    if ($account && $key && file_exists(__DIR__ . '/vendor/autoload.php')) {
        require __DIR__ . '/vendor/autoload.php';
        $blobEnabled = true;

        $connectionString = "DefaultEndpointsProtocol=https;AccountName={$account};AccountKey={$key};EndpointSuffix=core.windows.net";
        $blobClient = MicrosoftAzure\Storage\Blob\BlobRestProxy::createBlobService($connectionString);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MadeMyDay Admin - Add Vegetable</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>Admin - Add Vegetable</header>

<div style="padding:40px;">

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Vegetable Name" required><br><br>
    <input type="text" name="price" placeholder="Price" required><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>

    <?php if ($blobEnabled) { ?>
        <input type="file" name="image" required><br><br>
        <small>Blob upload is enabled. Image will be uploaded to Azure Blob.</small><br><br>
    <?php } else { ?>
        <input type="text" name="image" placeholder="Image filename (local) OR full URL" required><br><br>
        <small>Blob upload not enabled. Paste a URL or use a local image filename.</small><br><br>
    <?php } ?>

    <button type="submit" name="submit">Add Vegetable</button>
</form>

<?php
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $imageValue = null;

    if ($blobEnabled) {
        $container = $_ENV['BLOB_CONTAINER'] ?? 'vegetables';
        $account = $_ENV['BLOB_ACCOUNT_NAME'];

        $file = $_FILES['image']['tmp_name'];
        $blobName = basename($_FILES['image']['name']);

        try {
            $content = fopen($file, "r");
            $blobClient->createBlockBlob($container, $blobName, $content);
            $imageValue = "https://{$account}.blob.core.windows.net/{$container}/{$blobName}";
        } catch (Exception $e) {
            echo "<p style='color:red;'>Blob upload failed: ".htmlspecialchars($e->getMessage())."</p>";
        }
    } else {
        $imageValue = $_POST['image'];
    }

    if ($imageValue) {
        $sql = "INSERT INTO vegetables (name, price, description, image)
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdss", $name, $price, $description, $imageValue);
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Vegetable Added Successfully!</p>";
        } else {
            echo "<p style='color:red;'>DB Error: ".htmlspecialchars($stmt->error)."</p>";
        }
        $stmt->close();
    }
}
?>

</div>

</body>
</html>
