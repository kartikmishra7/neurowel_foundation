<?php

session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngo_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from database
$query = "SELECT * FROM our_impact ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    die("No data found in table");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>our imapct</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #b9bbc0ff;
            padding: 20px;
        }
        
        .page-wrapper {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-title {
            text-align: center;
            color: #2c5aa0;
            margin-bottom: 40px;
            font-size: 2.5rem;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .section-header h3 {
            color: #2c5aa0;
            font-size: 1.8rem;
        }
        
        .edit-btn {
            background-color: #2c5aa0;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
        }
        
        .edit-btn:hover {
            background-color: #1e3a70;
        }
        
        .text {
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .image-box {
            margin-top: 20px;
        }
        
        .image-box img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <h1 class="page-title">our impact</h1>

        <!-- Hero Section -->
        <div class="card">
            <div class="section-header">
                <h3>Hero Section</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=hero_title" class="edit-btn">Edit</a>
            </div>
            <div class="text"><?= $data['hero_title'] ?></div>
            <div class="image-box">
<?php
$hero_image = $data['hero_image'] ?? '';

if ($hero_image != '' && file_exists("../../uploads/" . $hero_image)) {
    // image exists → show it
    echo '<img src="../../uploads/' . htmlspecialchars($hero_image) . '" alt="hero">';
} 
elseif ($hero_image != '') {
    // name in database but file missing
    echo '<small style="color:red;">Image not found: ' . htmlspecialchars($hero_image) . '</small>';
}
// else → nothing shown when no image
?>
</div>

            
        </div>

        <!-- the diiffrence we cretae  -->
        <div class="card">
            <div class="section-header">
                <h3>the diffrence we create</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=the_diffrence" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['the_diffrence'] ?></div>
                   <div class="image-box">
<?php
$the_diffrence_image = $data['the_diffrence_image'] ?? '';

if ($the_diffrence_image != '' && file_exists("../../uploads/" . $the_diffrence_image)) {
    echo '<img src="../../uploads/' . htmlspecialchars($the_diffrence_image) . '" alt="the_difference">';
} 
elseif ($the_diffrence_image != '') {
    echo '<small style="color:red;">Image not found: ' . htmlspecialchars($the_diffrence_image) . '</small>';
}
?>
</div>



        
</body>
</html>

<?php
mysqli_close($conn);
?>