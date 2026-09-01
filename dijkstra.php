<?php

include "config/database.php";

$nodes = [];
$routes = [];

/* Get all nodes */
$sql = "SELECT * FROM store_nodes";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $nodes[$row["id"]] = $row["node_name"];
}

/* Get all routes */
$sql = "SELECT * FROM store_routes";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

    $from = $row["from_node"];
    $to = $row["to_node"];
    $distance = $row["distance"];

    $routes[$from][$to] = $distance;
}

/* Dijkstra Algorithm */

$start = 1;
$end = 10;

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

            $new_distance = $distance[$current] + $weight;

            if ($new_distance < $distance[$neighbor]) {

                $distance[$neighbor] = $new_distance;
                $previous[$neighbor] = $current;
            }
        }
    }
}

/* Create shortest path */

$path = [];
$current = $end;

while ($current !== null) {

    array_unshift($path, $current);

    $current = $previous[$current];
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartMart Shortest Route</title>

</head>

<body>

    <h1>🗺️ SmartMart Shortest Route</h1>

    <h2>🚶 Route from Entrance to Exit</h2>

    <?php

    foreach ($path as $node_id) {

        echo "📍 " . $nodes[$node_id];

        if ($node_id != $end) {
            echo " → ";
        }
    }

    ?>

    <h3>
        📏 Total Distance:
        <?php echo $distance[$end]; ?> meters
    </h3>

</body>

</html>