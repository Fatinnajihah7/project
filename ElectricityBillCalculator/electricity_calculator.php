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
                <label for="hours">Usage Time (Hours):</label>
                <input type="number" step="any" name="hours" id="hours" class="form-control" required>
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
            $hours = $_POST['hours'];
            $rate = $_POST['rate'];

            // Calculate Power and Energy
            $power = $voltage * $current; // in Watts
            $energy_per_hour = $power / 1000; // in kWh
            $energy_per_day = $energy_per_hour * 24; // in kWh

            // Convert rate from sen/kWh to RM by dividing by 100
            $rate_in_rm = $rate / 100;
            
            // Charge per hour
            $charge_per_hour_rm = $energy_per_hour * $rate_in_rm;

            // Charge per day
            $charge_per_day_rm = $energy_per_day * $rate_in_rm;

            // Tariff rates for Domestic Tariff (in sen/kWh)
            $rates = [
                [200, 21.80],
                [100, 33.40],
                [300, 51.60],
                [300, 54.60],
                [PHP_INT_MAX, 57.10]
            ];

            // Calculate the bill based on tiers
            $remaining_energy = $energy_per_hour;
            $total_charge_sen = 0;

            foreach ($rates as $tier) {
                $limit = $tier[0];
                $rate = $tier[1];

                if ($remaining_energy <= 0) break;

                $usage = min($remaining_energy, $limit);
                $total_charge_sen += $usage * $rate;
                $remaining_energy -= $usage;
            }

            // Convert sen to RM and apply minimum charge
            $total_charge_rm = $total_charge_sen / 100;
            $total_charge_rm = max($total_charge_rm, 3.00);

            // Display results
            echo "<div class='mt-4 p-4 bg-success text-white rounded'>";
            echo "<h4>Results:</h4>";
            echo "<p>Power: <strong>" . number_format($power, 2) . " W</strong></p>";
            echo "<p>Energy per hour: <strong>" . number_format($energy_per_hour, 2) . " kWh</strong></p>";
            echo "<p>Energy per day: <strong>" . number_format($energy_per_day, 2) . " kWh</strong></p>";
            echo "<p>Total Charge per hour: <strong>RM " . number_format($charge_per_hour_rm, 2) . "</strong></p>";
            echo "<p>Total Charge per day: <strong>RM " . number_format($charge_per_day_rm, 2) . "</strong></p>";
            echo "<p>Total Charge (based on tiered rates): <strong>RM " . number_format($total_charge_rm, 2) . "</strong></p>";
            echo "</div>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>