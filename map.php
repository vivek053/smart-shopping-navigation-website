<?php

include "config/database.php";

$selected_aisles = [];

/* Get shopping list products */

$sql = "SELECT products.aisle
        FROM shopping_list
        JOIN products
        ON shopping_list.product_id = products.id";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

    preg_match('/\d+/', $row["aisle"], $match);

    if (isset($match[0])) {
        $selected_aisles[] = intval($match[0]);
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartMart Store Map</title>

    <style>

        body {
            font-family: Arial;
            text-align: center;
        }

        .store {
            width: 800px;
            margin: 30px auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .aisle {
            border: 2px solid black;
            padding: 30px 10px;
            background: lightgray;
        }

        .selected {
            background: yellow;
            border: 4px solid orange;
        }

        .entrance {
            grid-column: span 4;
            padding: 15px;
            border: 2px solid green;
        }

        .exit {
            grid-column: span 4;
            padding: 15px;
            border: 2px solid red;
        }

    </style>

</head>

<body>

    <h1>🛒 SmartMart Store Map</h1>

    <p>
        🟨 <b>Yellow = Your Shopping Locations</b>
    </p>

    <div class="store">

        <div class="entrance">
            🚪 ENTRANCE
        </div>


        <div class="<?php echo in_array(1, $selected_aisles) ? 'aisle selected' : 'aisle'; ?>">
            <h3>Aisle 1</h3>
            🥛 Milk
        </div>


        <div class="<?php echo in_array(2, $selected_aisles) ? 'aisle selected' : 'aisle'; ?>">
            <h3>Aisle 2</h3>
            🍪 Biscuits
        </div>


        <div class="<?php echo in_array(3, $selected_aisles) ? 'aisle selected' : 'aisle'; ?>">
            <h3>Aisle 3</h3>
            🍚 Rice
        </div>


        <div class="<?php echo in_array(4, $selected_aisles) ? 'aisle selected' : 'aisle'; ?>">
            <h3>Aisle 4</h3>
            🛢️ Cooking Oil
        </div>


        <div class="<?php echo in_array(5, $selected_aisles) ? 'aisle selected' : 'aisle'; ?>">
            <h3>Aisle 5</h3>
            🧴 Shampoo
        </div>


        <div class="<?php echo in_array(6, $selected_aisles) ? 'aisle selected' : 'aisle'; ?>">
            <h3>Aisle 6</h3>
            🧼 Soap
        </div>


        <div class="<?php echo in_array(7, $selected_aisles) ? 'aisle selected' : 'aisle'; ?>">
            <h3>Aisle 7</h3>
            🥤 Drinks
        </div>


        <div class="<?php echo in_array(8, $selected_aisles) ? 'aisle selected' : 'aisle'; ?>">
            <h3>Aisle 8</h3>
            🍞 Bakery
        </div>


        <div class="exit">
            🚪 EXIT
        </div>

    </div>

</body>

</html>