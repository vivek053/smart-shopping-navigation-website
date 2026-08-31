<?php

include "config/database.php";

$product = "";
$result = null;

if (isset($_GET["product"])) {

    $product = $_GET["product"];

    $sql = "SELECT * FROM products
            WHERE product_name LIKE '%$product%'";

    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>SmartMart - Search Product</title>
</head>

<body>

    <h1>🛒 SmartMart Navigator</h1>

    <h2>🔍 Find Your Product</h2>

    <form method="GET">

        <input
            type="text"
            name="product"
            placeholder="Enter product name"
            value="<?php echo htmlspecialchars($product); ?>"
            required
        >

        <button type="submit">Search</button>

    </form>

    <br>

    <?php

    if ($result !== null) {

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                echo "<h3>✅ Product Found</h3>";

                echo "🛍️ Product: " . $row["product_name"] . "<br>";
                echo "📂 Category: " . $row["category"] . "<br>";
                echo "📍 Location: " . $row["aisle"] . "<br>";
                echo "🗄️ Rack: " . $row["rack"] . "<br>";
                echo "💰 Price: ₹" . $row["price"] . "<br>";

                if ($row["available"] == 1) {
                    echo "📦 Status: ✅ Available";
                } else {
                    echo "📦 Status: ❌ Not Available";
                }
            }

        } else {

            echo "<h3>❌ Product not found</h3>";
            echo "Please try another product.";

        }
    }

    ?>

</body>

</html>