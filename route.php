<?php

include "config/database.php";

$sql = "SELECT products.product_name,
               products.aisle,
               products.rack
        FROM shopping_list
        JOIN products
        ON shopping_list.product_id = products.id";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartMart Route</title>

</head>

<body>

    <h1>🗺️ SmartMart Shopping Route</h1>

    <h2>Your Products & Locations</h2>

    <?php

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo "<h3>🛒 " . $row["product_name"] . "</h3>";

            echo "📍 " . $row["aisle"];
            echo " → 🗄️ Rack " . $row["rack"];

            echo "<hr>";
        }

    } else {

        echo "<h3>🛒 Your shopping list is empty.</h3>";

    }

    ?>

    <br>

    <a href="shopping-list.php">
        ← Back to Shopping List
    </a>

</body>

</html>