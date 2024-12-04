<?php

$pdo = new PDO('mysql:host=localhost;dbname=barcode_db', 'root', ''); // Database connection

// Initialize variables to hold error and success messages
$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if form data is set
    if (isset($_POST['product_name']) && isset($_POST['price']) && isset($_POST['series_no'])) {
        $productName = trim($_POST['product_name']);
        $price = floatval($_POST['price']); // Convert price to float
        $seriesNo = trim($_POST['series_no']); // Get series number from POST

        // Check if series number already exists
        $checkSeriesStmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE series_no = ?");
        $checkSeriesStmt->execute([$seriesNo]);
        $seriesExists = $checkSeriesStmt->fetchColumn();

        // Check if product already exists
        $checkProductStmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE product_name = ?");
        $checkProductStmt->execute([$productName]);
        $productExists = $checkProductStmt->fetchColumn();

        if ($seriesExists && $productExists) {
            // Both series number and product already exist
            $errorMessage = 'Both the product name and series number already exist. Please enter different values.';
        } elseif ($seriesExists) {
            // Series number already exists
            $errorMessage = 'The series number already exists. Please enter a different series number.';
        } elseif ($productExists) {
            // Product already exists
            $errorMessage = 'Product already exists. Please enter a different product name.';
        } else {
            // Insert new product into database
            $stmt = $pdo->prepare("INSERT INTO products (product_name, price, series_no) VALUES (?, ?, ?)");
            if ($stmt->execute([$productName, $price, $seriesNo])) {
                // Success message
                $successMessage = 'Product has been successfully added.';
            } else {
                // Error during insertion
                $errorMessage = 'There was an error adding the product.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div style="font-size: 14px; font-family: tahoma; text-align: center; max-width: 400px; margin: auto;">
        <h3>Add New Product</h3>
        
        <!-- Display error message if exists -->
        <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>

        <!-- Display success message if exists -->
        <?php if (!empty($successMessage)): ?>
            <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
        <?php endif; ?>

        <form method="POST">
            <!-- Input for product name -->
            <input required type="text" name="product_name" placeholder="Product Name" style="padding: 5px; width: 95%; margin-bottom: 10px;">
            
            <!-- Input for price -->
            <input required type="text" name="price" placeholder="Price" style="padding: 5px; width: 95%; margin-bottom: 10px;">
            
            <!-- Input for series number -->
            <input required type="text" name="series_no" placeholder="Series Number" style="padding: 5px; width: 95%; margin-bottom: 10px;">
            
            <!-- Submit button -->
            <button type="submit" style="padding: 5px; cursor: pointer;">Add Product</button>
        </form>
        <br>
        <a href="index.php">Back to Barcode Generator</a>
    </div>
</body>
</html>
