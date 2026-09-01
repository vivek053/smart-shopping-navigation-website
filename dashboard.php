<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>SmartMart Dashboard</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .header {
            background: #222;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .logout {
            color: white;
            text-decoration: none;
            background: #e74c3c;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            margin-bottom: 5px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-decoration: none;
            color: #222;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .icon {
            font-size: 40px;
        }

        .card h2 {
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
        }

        @media (max-width: 700px) {

            .cards {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 15px 20px;
            }

        }

    </style>

</head>

<body>

    <div class="header">

        <div class="logo">
            🛒 SmartMart
        </div>

        <a class="logout" href="logout.php">
            Logout
        </a>

    </div>


    <div class="container">

        <div class="welcome">

            <h1>
                Welcome,
                <?php echo htmlspecialchars($_SESSION["user_name"]); ?>! 👋
            </h1>

            <p>
                Plan your shopping and find products faster.
            </p>

        </div>


        <div class="cards">

            <a class="card" href="shopping-list.php">

                <div class="icon">🛒</div>

                <h2>My Shopping List</h2>

                <p>
                    Add and manage the products you want to buy.
                </p>

            </a>


            <a class="card" href="search.php">

                <div class="icon">🔍</div>

                <h2>Search Product</h2>

                <p>
                    Find a product and its exact rack location.
                </p>

            </a>


            <a class="card" href="map.php">

                <div class="icon">🗺️</div>

                <h2>Store Map</h2>

                <p>
                    Explore the supermarket layout.
                </p>

            </a>


            <a class="card" href="smart-route.php">

                <div class="icon">🚶</div>

                <h2>Smart Route</h2>

                <p>
                    Get an efficient route for your shopping list.
                </p>

            </a>

        </div>

    </div>

</body>

</html>