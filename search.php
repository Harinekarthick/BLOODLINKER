
<?php
include 'db.php';

if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');

    $blood = $_GET['blood_group'] ?? '';
    $city = trim($_GET['city'] ?? '');

    $stmt = $conn->prepare(
        "SELECT name, blood_group, city
         FROM donors
         WHERE blood_group = ?
         AND city LIKE ?
         AND available = 'Yes'
         LIMIT 50"
    );

    $searchCity = "%" . $city . "%";
    $stmt->bind_param("ss", $blood, $searchCity);
    $stmt->execute();

    $result = $stmt->get_result();
    $donors = [];

    while ($row = $result->fetch_assoc()) {
        $donors[] = $row;
    }

    echo json_encode($donors);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Find Donors | BLOODLINK</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h2>🩸 BLOODLINK</h2>
    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="search.php">Find Donors</a>
        <a href="request.php">Request Blood</a>
    </nav>
</header>

<div class="form-container">
    <h1>Find Blood Donors ❤️</h1>

    <label>Blood Group</label>
    <select id="blood">
        <option value="">Select Blood Group</option>
        <option>A+</option>
        <option>A-</option>
        <option>B+</option>
        <option>B-</option>
        <option>O+</option>
        <option>O-</option>
        <option>AB+</option>
        <option>AB-</option>
    </select>

    <label>City</label>
    <input type="text" id="city"
           placeholder="Enter your city">

    <div id="results"></div>
</div>

<script src="script.js"></script>
</body>
</html>
