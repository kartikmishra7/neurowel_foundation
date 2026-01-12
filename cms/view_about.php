<?php

session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ngo_db"; // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from database
$query = "SELECT * FROM about_page ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

// Check if data exists
if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    die("No data found in about_page table");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page Content Preview</title>
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
        <h1 class="page-title">About Page Content Preview</h1>


        <!-- Hero Section -->
        <div class="card">
            <div class="section-header">
                <h3>Hero Section</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=hero" class="edit-btn">Edit</a>
            </div>
            <div class="text"><?= $data['hero_title'] ?></div>
            <div class="image-box">
                <?php 
                // Fix image path - remove 'uploads/' prefix if exists
                $hero_image = $data['hero_image'];
                if(strpos($hero_image, 'uploads/') === 0) {
                    $hero_image = substr($hero_image, 8);
                }
                ?>
                <img src="../uploads/<?= $hero_image ?>" alt="hero">
            </div>
        </div>

        <!-- Who We Are Section -->
        <div class="card">
            <div class="section-header">
                <h3>Who We Are</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=who" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['who_we_are'] ?></div>
                <div class="image-box">
                    <?php 
                    $who_image = $data['who_image'];
                    if(strpos($who_image, 'uploads/') === 0) {
                        $who_image = substr($who_image, 8);
                    }
                    ?>
                    <img src="../uploads/<?= $who_image ?>" alt="who">
                </div>
            </div>
        </div>

        <!-- Our Mission Section -->
        <div class="card">
            <div class="section-header">
                <h3>Our Mission</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=mission" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['mission'] ?></div>
                <div class="image-box">
                    <?php 
                    $mission_image = $data['mission_image'];
                    if(strpos($mission_image, 'uploads/') === 0) {
                        $mission_image = substr($mission_image, 8);
                    }
                    ?>
                    <img src="../uploads/<?= $mission_image ?>" alt="mission">
                </div>
            </div>
        </div>

        <!-- Our Vision Section -->
        <div class="card">
            <div class="section-header">
                <h3>Our Vision</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=vision" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['vision'] ?></div>
                <div class="image-box">
                    <?php 
                    $vision_image = $data['vision_image'];
                    if(strpos($vision_image, 'uploads/') === 0) {
                        $vision_image = substr($vision_image, 8);
                    }
                    ?>
                    <img src="../uploads/<?= $vision_image ?>" alt="vision">
                </div>
            </div>
        </div>

        <!-- Our Approach Section -->
        <div class="card">
            <div class="section-header">
                <h3>Our Approach</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=approach" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['approach'] ?></div>
                <div class="image-box">
                    <?php 
                    $approach_image = $data['approach_image'];
                    if(strpos($approach_image, 'uploads/') === 0) {
                        $approach_image = substr($approach_image, 8);
                    }
                    ?>
                    <img src="../uploads/<?= $approach_image ?>" alt="approach">
                </div>
            </div>
        </div>

        <!-- Founder Section -->
        <div class="card">
            <div class="section-header">
                <h3>Founder</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=founder" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div>
                    <h4 style="margin-bottom:10px; color:#1e3a8a;"><?= $data['founder_name'] ?></h4>
                    <p style="color:#6b7280; font-size:14px; margin-bottom:10px;"><?= $data['founder_title'] ?></p>
                    <div class="text"><?= $data['founder_description'] ?></div>
                </div>
                <div class="image-box">
                    <?php 
                    $founder_image = $data['founder_image'];
                    if(strpos($founder_image, 'uploads/') === 0) {
                        $founder_image = substr($founder_image, 8);
                    }
                    ?>
                    <img src="../uploads/<?= $founder_image ?>" alt="founder">
                </div>
            </div>
        </div>

    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>