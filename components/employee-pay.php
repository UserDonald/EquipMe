<main class="main">
        <div class="main-panel">
            <div class="clock-info">
                <h2>Clock Information</h2>
                <div class="clock-card">
                    <form action="employee-dashboard.php">
                            <div class="clock-inputs">
                                <label for="employee_id">Employee Lookup</label>
                                <!-- Options that entail the employees from the employee table -->
                                <?php
                                $con = mysqli_connect("db.luddy.indiana.edu", "i308s23_team37", "my+sql=i308s23_team37", "i308s23_team37");

                                if (!$con)
                                    { die("Failed to connect to MySQL: " . mysqli_connect_error() ); }

                                $sql = "SELECT
                                    CONCAT(entity.first_name, ' ', entity.last_name) AS employee_name,
                                    employee.employee_id AS employee_id
                                FROM
                                    employee
                                    JOIN entity ON employee.employee_id = entity.id
                                ORDER BY
                                    employee_name ASC
                                ";

                                $result = mysqli_query($con, $sql);

                                echo "<select name='employee_id'>";
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['employee_id'] . "'>" . $row['employee_name'] . "</option>";
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
                                <th>Employee Name</th>
                                <th>Hourly Rate</th>
                                <th>Total Hours</th>
                                <th>Total Earnings</th>
                            </tr>
                            <?php

                            $con = mysqli_connect("db.luddy.indiana.edu", "i308s23_team37", "my+sql=i308s23_team37", "i308s23_team37");

                            if (!$con)
                                { die("Failed to connect to MySQL: " . mysqli_connect_error() ); }

                            $employee_id = mysqli_real_escape_string($con, $_GET['employee_id']);

                            if (!isset($_GET['employee_id'])) {
                                $sql = "SELECT
                                    CONCAT(entity.first_name, ' ', entity.last_name) AS employee_name,
                                    employee.salary AS hourly_rate,
                                    SUM(TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end)) AS total_hours_worked,
                                    SUM(TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end)) * employee.salary AS total_earnings
                                FROM
                                    employee_shift
                                    JOIN employee ON employee_shift.employee_id = employee.employee_id
                                    JOIN shift ON employee_shift.shift_id = shift.id
                                    JOIN entity ON employee.employee_id = entity.id
                                GROUP BY
                                    employee_name;
                                ";
                            } else {
                                $sql = "SELECT
                                    CONCAT(entity.first_name, ' ', entity.last_name) AS employee_name,
                                    employee.salary AS hourly_rate,
                                    SUM(TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end)) AS total_hours_worked,
                                    SUM(TIMESTAMPDIFF(HOUR, shift.shift_start, shift.shift_end)) * employee.salary AS total_earnings
                                FROM
                                    employee_shift
                                    JOIN employee ON employee_shift.employee_id = employee.employee_id
                                    JOIN shift ON employee_shift.shift_id = shift.id
                                    JOIN entity ON employee.employee_id = entity.id
                                WHERE
                                    employee.employee_id = '$employee_id'
                                GROUP BY
                                    employee_name;
                                ";
                            }

                            $result = mysqli_query($con, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['employee_name'] . "</td>";
                                echo "<td>$" . $row['hourly_rate'] . "</td>";
                                echo "<td>" . $row['total_hours_worked'] . "</td>";
                                echo "<td>$" . $row['total_earnings'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>