<?php
include 'db_connection.php'; // Make sure this connects to your database
session_start();

// Fetch categories
$categories = [];
$result = mysqli_query($conn, "SELECT * FROM categories WHERE name != 'Other'");
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Initialize variables
$name = $price = $quantity = $categoryId = $newCategory = "";
$errors = [];
$previewTotal = null;
$remainingBudget = 1000; // Replace this with your logic
$totalSpent = 200;       // Replace this with your logic

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $price = floatval($_POST["price"]);
    $quantity = intval($_POST["quantity"]);
    $categoryId = $_POST["categoryId"];
    $newCategory = trim($_POST["newCategory"]);

    // Validate
    if (empty($name)) $errors['name'] = "Item name is required";
    if (!is_numeric($price) || $price < 0) $errors['price'] = "Price must be a positive number";
    if (!is_numeric($quantity) || $quantity < 1) $errors['quantity'] = "Quantity must be at least 1";
    if (empty($categoryId) && empty($newCategory)) $errors['categoryId'] = "Category is required";

    // Add new category if provided
    if (!empty($newCategory)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $newCategory);
        $stmt->execute();
        $categoryId = $newCategory;
        $stmt->close();
    }

    $previewTotal = $price * $quantity;
    $remaining = $remainingBudget - $totalSpent;

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO grocery_items (name, price, quantity, categoryId, checked) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("sdis", $name, $price, $quantity, $categoryId);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Item added successfully!";
            header("Location: list.php");
            exit();
        } else {
            $errors['submit'] = "Failed to add item. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!-- HTML FORM -->
<!DOCTYPE html>
<html>
<head>
  <title>Add Item</title>
  <style>
    .error { color: red; font-size: 12px; }
    .notice { padding: 10px; background-color: #eef; border-radius: 4px; margin-top: 10px; }
  </style>
</head>
<body>
  <h2>Add Grocery Item</h2>

  <form method="POST">
    <label>Item Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>"><br>
    <?php if (isset($errors['name'])): ?><span class="error"><?= $errors['name'] ?></span><br><?php endif; ?>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($price) ?>"><br>
    <?php if (isset($errors['price'])): ?><span class="error"><?= $errors['price'] ?></span><br><?php endif; ?>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="<?= htmlspecialchars($quantity) ?>"><br>
    <?php if (isset($errors['quantity'])): ?><span class="error"><?= $errors['quantity'] ?></span><br><?php endif; ?>

    <label>Category:</label><br>
    <select name="categoryId">
      <option value="">Select a category</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= htmlspecialchars($cat['name']) ?>" <?= $categoryId === $cat['name'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['name']) ?>
        </option>
      <?php endforeach; ?>
    </select><br>

    <small>Or add new category:</small><br>
    <input type="text" name="newCategory" value="<?= htmlspecialchars($newCategory) ?>"><br>
    <?php if (isset($errors['categoryId'])): ?><span class="error"><?= $errors['categoryId'] ?></span><br><?php endif; ?>

    <?php if ($previewTotal): ?>
      <div class="notice">
        Item total: ₱<?= number_format($previewTotal, 2) ?><br>
        <?php if ($previewTotal > $remaining): ?>
          <strong style="color: red;">Warning: Over budget by ₱<?= number_format($previewTotal - $remaining, 2) ?></strong>
        <?php else: ?>
          Budget remaining after adding: ₱<?= number_format($remaining - $previewTotal, 2) ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <br><button type="submit">Add Item</button>
    <?php if (isset($errors['submit'])): ?><br><span class="error"><?= $errors['submit'] ?></span><?php endif; ?>
  </form>
</body>
</html>