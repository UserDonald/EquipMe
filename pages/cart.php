<?php
session_start();
if (!isset($_SESSION['email'])){
    header("Location: https://cgi.luddy.indiana.edu/~djnash/pages/login.php");
    exit();
};
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Links -->
    <link rel="stylesheet" href="../styles.css">

    <title>EquipMe</title>
</head>

<body>

    <?php include '../components/navigation.php';?>

    <main class="main">
        <div class="main-panel">
            <h2>Billing Information</h2>
            <div class="cart-information">
                <div class="cart-row row-1">
                    <div class="input-box">
                        <label for="name">First Name</label>
                        <input type="text" name="name" placeholder="First Name" required />
                    </div>
                    <div class="input-box">
                        <label for="name">Last Name</label>
                        <input type="text" name="name" placeholder="First Name" required />
                    </div>
                    <div class="input-box">
                        <label for="phone">Mobile Number</label>
                        <input type="text" name="phone" placeholder="(XXX) XXX-XXXX" required />
                    </div>
                </div>
                <div class="cart-row row-2">
                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="text" name="email" placeholder="Email" required />
                    </div>
                    <div class="input-box">
                        <label for="email">City</label>
                        <input type="text" name="city" placeholder="City" required />
                    </div>
                </div>
                <div class="cart-row row-3">
                    <div class="input-box">
                        <label for="email">APT # (optional)</label>
                        <input type="text" name="email" placeholder="APT #" />
                    </div>
                    <div class="input-box">
                        <label for="email">ZIP</label>
                        <input type="text" name="email" placeholder="ZIP" required />
                    </div>
                    <div class="input-box">
                        <label for="email">State</label>
                        <input type="text" name="email" placeholder="State" required />
                    </div>
                </div>
                <div class="cart-row row-4">
                    <div class="input-box">
                        <label for="email">Address</label>
                        <input type="text" name="email" placeholder="Address" required />
                    </div>
                </div>
            </div>
            <h2>Past Rentals</h2>
            <div class="past-rentals">
                <div class="table">
                    <table>
                        <tr class="table-header">
                            <th>Date</th>
                            <th>Items</th>
                            <th>Price</th>
                            <th>Receipt</th>
                        </tr>
                        <?php
                        
                        $con=mysqli_connect("db.luddy.indiana.edu", "i308s23_team37", "my+sql=i308s23_team37", "i308s23_team37");

                        if (!$con)
                        { die("Failed to connect to MySQL: " . mysqli_connect_error() ); }

                        $sql = "SELECT
                            CONCAT(entity.first_name, ' ', entity.last_name) AS full_name,
                            entity.email,
                            rental.id AS rental_id,
                            COUNT(item.id) AS total_items_rented,
                            SUM(
                                CASE
                                    WHEN rental.rental_type = 'H' THEN item.price_hourly * rental.rental_type_amount
                                    WHEN rental.rental_type = 'D' THEN item.price_daily * rental.rental_type_amount
                                    ELSE 0
                                END
                            ) AS total_price,
                            customer_order_logistics.pickup_info AS rental_date
                        FROM
                            entity
                            JOIN customer_order_logistics ON entity.id = customer_order_logistics.customer_id
                            JOIN rental ON customer_order_logistics.rental_id = rental.id
                            JOIN item_rental ON rental.id = item_rental.rental_id
                            JOIN item ON item_rental.item_id = item.id
                            JOIN customer_card_status ON customer_card_status.customer_id = entity.id
                            AND customer_card_status.is_primary = true
                            JOIN card ON customer_card_status.card_id = card.id
                            JOIN address ON card.billing_id = address.id
                        WHERE
                            entity.email = '{$_SESSION['email']}'
                        GROUP BY
                            rental_id;
                        ";

                        $result = mysqli_query($con, $sql);

                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['rental_date'] . "</td>";
                            echo "<td>" . $row['total_items_rented'] . "</td>";
                            echo "<td>" . $row['total_price'] . "</td>";
                            echo "<td><a href='#' class='btn btn-primary'>View Receipt</a></td>";
                            echo "</tr>";
                        }

                        ?>
                    </table>
                </div>
            </div>
        </div>

        <div class="side-panel">
            <h2>Order Summary</h2>
            <div class="order-summary">
                
            </div>
        </div>
    </main>

    <?php include '../components/footer.php';?>

</body>

</html>