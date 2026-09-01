<?php

include "config/database.php";

/* Get store nodes */

$nodes = [];

$sql = "SELECT * FROM store_nodes";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $nodes[$row["id"]] = $row["node_name"];
}


/* Get store routes */

$routes = [];

$sql = "SELECT * FROM store_routes";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

    $from = $row["from_node"];
    $to = $row["to_node"];
    $distance = $row["distance"];

    $routes[$from][$to] = $distance;
}


/* Get shopping list */

$sql = "SELECT products.product_name,
               products.aisle,
               products.rack
        FROM shopping_list
        JOIN products
        ON shopping_list.product_id = products.id";

$result = $conn->query($sql);

$shopping_items = [];

while ($row = $result->fetch_assoc()) {
    $shopping_items[] = $row;
}


/* Convert Aisle number to node ID */

$shopping_nodes = [];

foreach ($shopping_items as $item) {

    preg_match('/\d+/', $item["aisle"], $match);

    if (isset($match[0])) {

        $aisle_number = intval($match[0]);

        // Entrance = 1
        // Aisle 1 = 2
        // Aisle 2 = 3

        $node_id = $aisle_number + 1;

        $shopping_nodes[] = $node_id;
    }
}


/* Add Exit */

$shopping_nodes[] = 10;


/* Dijkstra Function */

function dijkstra($nodes, $routes, $start, $end)
{

    $distance = [];
    $previous = [];
    $visited = [];

    foreach ($nodes as $node_id => $node_name) {

        $distance[$node_id] = INF;
        $previous[$node_id] = null;
        $visited[$node_id] = false;
    }

    $distance[$start] = 0;


    for ($i = 0; $i < count($nodes); $i++) {

        $current = null;
        $smallest = INF;

        foreach ($distance as $node_id => $value) {

            if (!$visited[$node_id] && $value < $smallest) {

                $smallest = $value;
                $current = $node_id;
            }
        }


        if ($current === null) {
            break;
        }


        $visited[$current] = true;


        if (isset($routes[$current])) {

            foreach ($routes[$current] as $neighbor => $weight) {

                $new_distance =
                    $distance[$current] + $weight;


                if ($new_distance < $distance[$neighbor]) {

                    $distance[$neighbor] = $new_distance;

                    $previous[$neighbor] = $current;
                }
            }
        }
    }


    /* Create path */

    $path = [];

    $current = $end;

    while ($current !== null) {

        array_unshift($path, $current);

        $current = $previous[$current];
    }


    return [
        "path" => $path,
        "distance" => $distance[$end]
    ];
}


/* Create complete route */

$complete_route = [];
$total_distance = 0;

$current_start = 1;


/* Visit each shopping location */

foreach ($shopping_nodes as $destination) {

    $result = dijkstra(
        $nodes,
        $routes,
        $current_start,
        $destination
    );

    $path = $result["path"];

    $total_distance += $result["distance"];


    /* Avoid duplicate starting node */

    if (count($complete_route) > 0) {
        array_shift($path);
    }


    $complete_route = array_merge(
        $complete_route,
        $path
    );


    $current_start = $destination;
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartMart Smart Route</title>

</head>

<body>

    <h1>🛒 SmartMart Smart Route</h1>

    <h2>📋 Shopping List</h2>

    <?php

    if (count($shopping_items) > 0) {

        foreach ($shopping_items as $item) {

            echo "🛍️ " . $item["product_name"];
            echo " → 📍 " . $item["aisle"];
            echo " → 🗄️ Rack " . $item["rack"];

            echo "<br><br>";
        }

    } else {

        echo "❌ Shopping list is empty.";

    }

    ?>

    <hr>

    <h2>🗺️ Calculated Route</h2>

    <?php

    if (count($complete_route) > 0) {

        foreach ($complete_route as $node_id) {

            echo "📍 " . $nodes[$node_id];

            if ($node_id != end($complete_route)) {
                echo " → ";
            }
        }

        echo "<br><br>";

        echo "<h3>";
        echo "📏 Total Distance: ";
        echo $total_distance;
        echo " meters";
        echo "</h3>";

    } else {

        echo "No route available.";

    }

    ?>

    <br>

    <a href="shopping-list.php">
        ← Back to Shopping List
    </a>

</body>

</html>