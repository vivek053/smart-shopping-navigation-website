<?php

include "config/database.php";

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>SmartMart Products</title>
</head>

<body>

    <h1>🛒 SmartMart Products</h1>

    <table border="1" cellpadding="10">

        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Aisle</th>
            <th>Rack</th>
            <th>Price</th>
            <th>Availability</th>
        </tr>

        <?php

        while ($row = $result->fetch_assoc()) {

            echo "<tr>";

            echo "<td>" . $row["product_name"] . "</td>";
            echo "<td>" . $row["category"] . "</td>";
            echo "<td>" . $row["aisle"] . "</td>";
            echo "<td>" . $row["rack"] . "</td>";
            echo "<td>₹" . $row["price"] . "</td>";

            if ($row["available"] == 1) {
                echo "<td>✅ Available</td>";
            } else {
                echo "<td>❌ Not Available</td>";
            }

            echo "</tr>";
        }

        ?>

    </table>

</body>
</html>