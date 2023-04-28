<main class="main">
        <div class="main-panel">
            <h2>Top States</h2>
            <div class="top-states">
                <div class="states">

                    <?php

                    $con = mysqli_connect("db.luddy.indiana.edu", "i308s23_team37", "my+sql=i308s23_team37", "i308s23_team37");

                    if (!$con)
                        { die("Failed to connect to MySQL: " . mysqli_connect_error() ); }

                    $s_date = mysqli_real_escape_string($con, $_GET['s_date']);
                    $e_date = mysqli_real_escape_string($con, $_GET['e_date']);

                    if (!isset($_GET['s_date']) && !isset($_GET['e_date'])) {
                    $sql = "SELECT 
                            address.state,
                            COUNT(address.state) AS total_rentals
                        FROM
                            customer_order_logistics AS col
                            JOIN customer ON col.customer_id = customer.customer_id
                            JOIN entity ON customer.customer_id = entity.id
                            JOIN card ON col.card_id = card.id
                            JOIN address ON card.billing_id = address.id
                        WHERE
                            col.pickup_info BETWEEN '2023-04-01' AND '2023-04-29'
                            AND col.return_info BETWEEN '2023-04-01' AND '2023-04-29'
                        GROUP BY
                            address.state
                        ORDER BY
                            total_rentals DESC
                        LIMIT
                            5
                        ";
                    } else {
                        $sql = "SELECT 
                            address.state,
                            COUNT(address.state) AS total_rentals
                        FROM
                            customer_order_logistics AS col
                            JOIN customer ON col.customer_id = customer.customer_id
                            JOIN entity ON customer.customer_id = entity.id
                            JOIN card ON col.card_id = card.id
                            JOIN address ON card.billing_id = address.id
                        WHERE
                            col.pickup_info BETWEEN '$s_date' AND '$e_date'
                            AND col.return_info BETWEEN '$s_date' AND '$e_date'
                        GROUP BY
                            address.state
                        ORDER BY
                            total_rentals DESC
                        LIMIT
                            5
                        ";
                    }

                    $result = mysqli_query($con, $sql);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='state'>";
                        echo "<h3>" . $row['state'] . "</h3>";
                        echo "<p class='rental_amount'>" . $row['total_rentals'] . "</p>";
                        echo "<p>Rentals</p>";
                        echo "</div>";
                    }

                    ?>
                </div>
                <form class="state-inputs" action="employee-dashboard.php" method="get">
                    <div class="input-container">
                        <div class="input-box">
                            <label for="s_date">Start Date</label>
                            <input type="date" name="s_date" placeholder="Start Date" />
                        </div>
                        <div class="input-box">
                            <label for="e_date">End Date</label>
                            <input type="date" name="e_date" placeholder="End Date" />
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
        </div>
    </main>