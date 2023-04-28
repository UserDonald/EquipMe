<section class="product-list">

    <?php

    $con=mysqli_connect("db.luddy.indiana.edu", "i308s23_team37", "my+sql=i308s23_team37", "i308s23_team37");

    if (!$con)
	{ die("Failed to connect to MySQL: " . mysqli_connect_error() ); }

    $item = mysqli_real_escape_string($con, $_GET['item']);

    if (!isset($_GET['item'])) {
        $sql = "
        SELECT
            item.name AS name,
            item.price_hourly AS price_hourly,
            item.price_daily AS price_daily,
            COUNT(rental.id) AS total_rented
        FROM
            customer_order_logistics AS col
            JOIN rental ON col.rental_id = rental.id
            JOIN item_rental ON rental.id = item_rental.rental_id
            JOIN item ON item_rental.item_id = item.id
        WHERE
            col.pickup_info BETWEEN '2023-04-01' AND '2023-04-29'
            AND col.return_info BETWEEN '2023-04-01' AND '2023-04-29'
        GROUP BY
            item.name
        ORDER BY 
            total_rented DESC
        LIMIT
            12;
        ";
    } else {
        $sql = "
        SELECT
            item.name AS name,
            item.price_hourly AS price_hourly,
            item.price_daily AS price_daily
        FROM
            item
        WHERE 
            item.name LIKE '$item%'
            OR
            item.name LIKE '%$item%'
            OR
            item.name LIKE '%$item'
        ORDER BY
            item.price_hourly ASC;
        ";
    }

    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<div class='product'>";
        echo "<div class='product-img'>";
        echo "<img src='#' alt='" . $row['name'] . "'>";
        echo "</div>";
        echo "<div class='product-info'>";
        echo "<h4>" . $row['name'] . "</h4>";
        echo "<div class='product-price'>";
        if ($_GET['price-type'] == 'D') {
            echo "<p>$" . $row['price_daily'] . "</p>";
            echo "<p class='price-type'>DAILY</p>";
        } else {
            echo "<p>$" . $row['price_hourly'] . "</p>";
            echo "<p class='price-type'>HOURLY</p>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

    /* Close the Connection */
    mysqli_close($con);

    ?>
</section>