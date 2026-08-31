<?php

include "config/database.php";

// Add product to shopping list
if (isset($_POST["product_id"])) {

    $product_id = $_POST["product_id"];

    $sql = "INSERT INTO shopping_list (product_id)
            VALUES ($product_id)";

    $conn->query($sql);
}

// Get all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartMart Shopping List</title>

</head>

<body>

    <h1>🛒 SmartMart Navigator</h1>

    <h2>My Shopping List</h2>

    <hr>

    <h3>➕ Add Products</h3>

    <?php

    while ($row = $result->fetch_assoc()) {

        echo "<form method='POST' style='margin-bottom:10px;'>";

        echo "<input type='hidden' name='product_id'
               value='" . $row["id"] . "'>";

        echo $row["product_name"];
        echo " - ₹" . $row["price"];

        echo " <button type='submit'>Add</button>";

        echo "</form>";
    }

    ?>

    <hr>

    <h3>🛍️ Your Shopping List</h3>

    <?php

    $sql = "SELECT shopping_list.id,
                   products.product_name,
                   products.aisle,
                   products.rack,
                   products.price
            FROM shopping_list
            JOIN products
            ON shopping_list.product_id = products.id";

    $list = $conn->query($sql);

    if ($list->num_rows > 0) {

        while ($row = $list->fetch_assoc()) {

            echo "🛍️ " . $row["product_name"];
            echo " → 📍 " . $row["aisle"];
            echo " → 🗄️ " . $row["rack"];
            echo " → ₹" . $row["price"];

            echo "<br><br>";
        }

    } else {

        echo "Your shopping list is empty.";

    }

    ?>

</body>

</html>