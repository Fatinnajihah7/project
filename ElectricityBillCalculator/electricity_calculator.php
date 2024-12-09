<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domestic Electricity Tariff Calculator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Electricity Bill Calculator (Domestic Tariff)</h2>
        <form method="POST" action="" class="border p-4 bg-light rounded">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number" step="any" name="voltage" id="voltage" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number" step="any" name="current" id="current" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate (sen/kWh):</label>
                <input type="number" step="any" name="rate" id="rate" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Calculate</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // User inputs
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $rate = $_POST['rate'];

            // Functions
            function calculate_power($voltage, $current) {
                return $voltage * $current; // Power in Watts
            }

            function calculate_energy_per_hour($power) {
                return $power / 1000; // Energy in kWh
            }

            function calculate_energy_per_day($energy_per_hour) {
                return $energy_per_hour * 24; // Energy in kWh
            }

            function calculate_charge($energy, $rate) {
                return $energy * ($rate / 100); // Charge in RM
            }

            // Calculation
            $power = calculate_power($voltage, $current);
            $energy_per_hour = calculate_energy_per_hour($power);
            $energy_per_day = calculate_energy_per_day($energy_per_hour);
            $charge_per_hour = calculate_charge($energy_per_hour, $rate);
            $charge_per_day = calculate_charge($energy_per_day, $rate);

            // Display results
            echo "<div class='mt-4 p-4 bg-success text-white rounded'>";
            echo "<h4>Results:</h4>";
            echo "<p>Power: <strong>" . number_format($power, 2) . " W</strong></p>";
            echo "<p>Energy per hour: <strong>" . number_format($energy_per_hour, 2) . " kWh</strong></p>";
            echo "<p>Energy per day: <strong>" . number_format($energy_per_day, 2) . " kWh</strong></p>";
            echo "<p>Total Charge per hour: <strong>RM " . number_format($charge_per_hour, 2) . "</strong></p>";
            echo "<p>Total Charge per day: <strong>RM " . number_format($charge_per_day, 2) . "</strong></p>";
            echo "</div>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
