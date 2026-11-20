
<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $blood_group = $_POST['blood_group'];
    $city = trim($_POST['city']);

    if ($name == "" || $phone == "" || $city == "") {
        $message = "Please fill all fields.";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $phone)) {
        $message = "Enter a valid phone number.";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO donors (name, phone, blood_group, city)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssss",
            $name,
            $phone,
            $blood_group,
            $city
        );

        if ($stmt->execute()) {
            $message = "Donor registered successfully!";
        } else {
            $message = "Registration failed. Please try again.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Registration | BLOODLINK</title>
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

    <h1>Become a Blood Donor ❤️</h1>
    <p>Register yourself and help save lives.</p>

    <?php if ($message != "") { ?>
        <p class="message">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php } ?>

    <form method="POST">

        <label>Full Name</label>
        <input type="text" name="name" required>

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

        <button type="submit">Register Now</button>

    </form>

</div>

</body>
</html>
