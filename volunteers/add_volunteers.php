<?php

if (isset($_POST['submit'])) {

    // Take form values
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Insert into database
    $query = "INSERT INTO volunteers (name, email, phone, status)
              VALUES ('$name', '$email', '$phone', 'pending')";

    if (mysqli_query($conn, $query)) {
        echo "<p style='color:green;'>Volunteer added successfully (waiting for approval)</p>";
    } else {
        echo "<p style='color:red;'>Error adding volunteer</p>";
    }
}
?>

<h3>Add Volunteer</h3>

<form method="POST">
    Name:<br>
    <input type="text" name="name" required><br><br>

    Email:<br>
    <input type="email" name="email" required><br><br>

    Phone:<br>
    <input type="text" name="phone" required><br><br>

    <button type="submit" name="submit">Save Volunteer</button>
</form>
