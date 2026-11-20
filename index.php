
<?php
include 'db.php';

$donors = $conn->query("SELECT COUNT(*) AS total FROM donors")->fetch_assoc()['total'];

$requests = $conn->query("SELECT COUNT(*) AS total FROM blood_requests")->fetch_assoc()['total'];

$groups = $conn->query("SELECT COUNT(DISTINCT blood_group) AS total FROM donors WHERE available='Yes'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOODLINK | Save Lives</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h2>🩸 BLOODLINK</h2>

    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Become a Donor</a>
        <a href="search.php">Find Donors</a>
        <a href="request.php">Request Blood</a>
        <a href="analytics.php">Analytics</a>
    </nav>
</header>

<section class="hero">
    <h1>Donate Blood.<br>Save Lives.</h1>

    <p>
        Every drop matters. Connect with blood donors
        and make a difference.
    </p>

    <a href="search.php" class="btn">Find a Donor</a>

    <a href="register.php" class="btn second">
        Become a Donor
    </a>
</section>

<section class="stats">

    <div class="stat-card">
        <h2><?php echo $donors; ?></h2>
        <p>Registered Donors</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $groups; ?></h2>
        <p>Blood Groups Listed</p>
    </div>

    <div class="stat-card">
        <h2><?php echo $requests; ?></h2>
        <p>Blood Requests</p>
    </div>

</section>

<section class="about">
    <h2>Why BLOODLINK?</h2>

    <p>
        BLOODLINK is a smart blood donor finder
        designed to make donor searching easier.
    </p>
</section>

<footer>
    <p>© 2026 BLOODLINK | Smart Blood Donor Finder</p>
</footer>

</body>
</html>
