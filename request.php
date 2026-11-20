
<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $patient = trim($_POST['patient_name']);
    $phone = trim($_POST['phone']);
    $blood = $_POST['blood_group'];
    $city = trim($_POST['city']);
    $hospital = trim($_POST['hospital']);
    $units = (int)$_POST['units'];

    $validGroups = [
        "A+", "A-", "B+", "B-",
        "O+", "O-", "AB+", "AB-"
    ];

    if (
        $patient == "" || $city == "" ||
        $hospital == "" ||
        !preg_match('/^[0-9]{10,15}$/', $phone) ||
        !in_array($blood, $validGroups) ||
        $units < 1 || $units > 10
    ) {
        $message = "Please enter valid details.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO blood_requests
            (patient_name, phone, blood_group, city, hospital, units)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssssi",
            $patient,
            $phone,
            $blood,
            $city,
            $hospital,
            $units
        );

        if ($stmt->execute()) {
            $message = "Blood request submitted successfully!";
        } else {
            $message = "Request failed. Please try again.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Blood | BLOODLINK</title>
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

    <h1>Request Blood ❤️</h1>
    <p>Submit your blood requirement details.</p>

    <?php if ($message != "") { ?>
        <p class="message">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php } ?>

    <form method="POST">

        <label>Patient Name</label>
        <input type="text" name="patient_name" required>

        <label>Phone Number</label>
        <input type="tel" name="phone"
               pattern="[0-9]{10,15}" required>

        <label>Blood Group</label>
        <select name="blood_group" required>
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
        <input type="text" name="city" required>

        <label>Hospital Name</label>
        <input type="text" name="hospital" required>

        <label>Units Required (Demo)</label>
        <input type="number" name="units"
               min="1" max="10" required>

        <button type="submit">Submit Request</button>

    </form>

</div>

<footer>
    <p>© 2026 BLOODLINK</p>
</footer>

</body>
</html>
