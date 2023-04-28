<main class="main">
        <div class="main-panel">
            <div class="customers-order-details">
                <h2>Customers Order Details</h2>
                <div class="order-box">
                    <form action="employee-dashboard.php">
                            <div class="clock-inputs">
                                <label for="employee_id">Order Lookup</label>
                                <!-- Options that entail the employees from the employee table -->
                                <?php
                                $con = mysqli_connect("db.luddy.indiana.edu", "i308s23_team37", "my+sql=i308s23_team37", "i308s23_team37");

                                if (!$con)
                                    { die("Failed to connect to MySQL: " . mysqli_connect_error() ); }

                                $sql = "SELECT
                                    CONCAT(entity.first_name, ' ', entity.last_name) AS name,
                                    entity.id AS id
                                FROM
                                    entity
                                ORDER BY
                                    name ASC
                                ";

                                $result = mysqli_query($con, $sql);

                                echo "<select name='entity_id'>";
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                echo "</select>";

                                mysqli_close($con);

                                ?>
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                    </form>
                    <div class="table">
                        <table>
                            <tr class="table-header">
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Items</th>
                                <th>Pickup Date</th>
                                <th>Return Date</th>
                                <th>Price</th>
                                <th>Deposit</th>
                                <th>Damage / Overdue Fees</th>
                                <th>Balance</th>
                            </tr>
                            <?php

                            $con = mysqli_connect("db.luddy.indiana.edu", "i308s23_team37", "my+sql=i308s23_team37", "i308s23_team37");

                            if (!$con)
                                { die("Failed to connect to MySQL: " . mysqli_connect_error() ); }

                            $entity_id = mysqli_real_escape_string($con, $_GET['entity_id']);


                            if ( !isset($_GET['entity_id']) ) {
                            $sql = "SELECT
                                e.email AS customer_email,
                                CONCAT(e.first_name, ' ', e.last_name) AS customer_name,
                                crl.rental_id,
                                crl.pickup_info AS pickup_date,
                                crl.return_info AS return_date,
                                quota.total_items_rented,
                                ROUND(quota.total_price, 2) AS total_price_before_deposit,
                                ROUND((quota.total_price + (quota.total_price * 0.20)), 2) AS total_price_after_deposit,
                                ROUND((quota.total_price * 0.20), 2) AS deposit,
                                ROUND((crl.fee_damage + crl.fee_overdue), 2) AS damage_overdue_fees,
                                ROUND((quota.total_price * 0.20 - (crl.fee_damage + crl.fee_overdue)), 2) AS balance
                            FROM
                                entity e
                                JOIN customer c ON e.id = c.customer_id
                                JOIN customer_order_logistics crl ON c.customer_id = crl.customer_id
                                JOIN (
                                    SELECT
                                        CONCAT(entity.first_name, ' ', entity.last_name) AS full_name,
                                        entity.email,
                                        rental.id AS rental_id,
                                        COUNT(item.id) AS total_items_rented,
                                        ROUND(SUM(
                                            CASE
                                                WHEN rental.rental_type = 'H' THEN item.price_hourly * rental.rental_type_amount
                                                WHEN rental.rental_type = 'D' THEN item.price_daily * rental.rental_type_amount
                                                ELSE 0
                                            END
                                        ), 2) AS total_price
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
                                    GROUP BY
                                        rental_id
                                ) AS quota
                            WHERE
                                quota.rental_id = crl.rental_id;
                            ";
                            } else {
                                $sql = "SELECT
                                    e.email AS customer_email,
                                    CONCAT(e.first_name, ' ', e.last_name) AS customer_name,
                                    crl.rental_id,
                                    crl.pickup_info AS pickup_date,
                                    crl.return_info AS return_date,
                                    quota.total_items_rented,
                                    ROUND(quota.total_price, 2) AS total_price_before_deposit,
                                    ROUND((quota.total_price + (quota.total_price * 0.20)), 2) AS total_price_after_deposit,
                                    ROUND((quota.total_price * 0.20), 2) AS deposit,
                                    ROUND((crl.fee_damage + crl.fee_overdue), 2) AS damage_overdue_fees,
                                    ROUND((quota.total_price * 0.20 - (crl.fee_damage + crl.fee_overdue)), 2) AS balance
                                FROM
                                    entity e
                                    JOIN customer c ON e.id = c.customer_id
                                    JOIN customer_order_logistics crl ON c.customer_id = crl.customer_id
                                    JOIN (
                                        SELECT
                                            CONCAT(entity.first_name, ' ', entity.last_name) AS full_name,
                                            entity.email,
                                            rental.id AS rental_id,
                                            COUNT(item.id) AS total_items_rented,
                                            ROUND(SUM(
                                                CASE
                                                    WHEN rental.rental_type = 'H' THEN item.price_hourly * rental.rental_type_amount
                                                    WHEN rental.rental_type = 'D' THEN item.price_daily * rental.rental_type_amount
                                                    ELSE 0
                                                END
                                            ), 2) AS total_price
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
                                        GROUP BY
                                            rental_id
                                    ) AS quota
                                WHERE
                                    quota.rental_id = crl.rental_id
                                    AND e.id = $entity_id;
                                ";
                            }

                            $result = mysqli_query($con, $sql);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['rental_id'] . "</td>";
                                echo "<td>" . $row['customer_name'] . "</td>";
                                echo "<td>" . $row['customer_email'] . "</td>";
                                echo "<td>" . $row['total_items_rented'] . "</td>";
                                echo "<td>" . $row['pickup_date'] . "</td>";
                                echo "<td>" . $row['return_date'] . "</td>";
                                echo "<td>$" . $row['total_price_before_deposit'] . "</td>";
                                echo "<td>$" . $row['deposit'] . "</td>";
                                echo "<td>$" . $row['damage_overdue_fees'] . "</td>";
                                echo "<td>$" . $row['balance'] . "</td>";
                                echo "</tr>";
                            }

                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>