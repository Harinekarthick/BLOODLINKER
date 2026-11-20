
<?php
include 'db.php';

// Get donor count for each blood group
$sql = "SELECT blood_group, COUNT(*) AS total
        FROM donors
        WHERE available = 'Yes'
        GROUP BY blood_group";

$result = $conn->query($sql);

$labels = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['blood_group'];
    $counts[] = (int)$row['total'];
}

// Total available donors
$totalResult = $conn->query(
    "SELECT COUNT(*) AS total FROM donors WHERE available = 'Yes'"
);
$totalDonors = $totalResult->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Analytics | BLOODLINK</title>
    <link rel="stylesheet" href="style.css">

    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<header>
    <h2>🩸 BLOODLINK</h2>
    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="search.php">Find Donors</a>
        <a href="request.php">Request Blood</a>
        <a href="analytics.php">Analytics</a>
    </nav>
</header>

<section class="analytics-container">

    <h1>Blood Group Analytics 📊</h1>
    <p>Live statistics of available registered donors</p>

    <div class="analytics-card">
        <h2><?php echo $totalDonors; ?></h2>
        <p>Total Available Donors</p>
    </div>
<div class="chart-container">
    <canvas id="bloodChart"></canvas>
</div>

<div class="chart-container">
    <canvas id="bloodBarChart"></canvas>
</div>
    

</section>

<script>
const bloodGroups = <?php echo json_encode($labels); ?>;
const donorCounts = <?php echo json_encode($counts); ?>;

const ctx = document.getElementById('bloodChart');

new Chart(ctx, {
    type: 'doughnut',

    data: {
        labels: bloodGroups,

        datasets: [{
            label: 'Number of Donors',
            data: donorCounts,
            backgroundColor: [
                '#e63946',
                '#457b9d',
                '#2a9d8f',
                '#f4a261',
                '#9b5de5',
                '#f15bb5',
                '#00bbf9',
                '#ffbe0b'
            ],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: true,

        plugins: {
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'Donors by Blood Group'
            }
        }
    }
});

new Chart(document.getElementById('bloodBarChart'), {
    type: 'bar',

    data: {
        labels: bloodGroups,
        datasets: [{
            label: 'Number of Donors',
            data: donorCounts,
            backgroundColor: '#b51224',
            borderRadius: 8
        }]
    },

    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Blood Group Comparison'
            },
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

</script>

</body>
</html>
