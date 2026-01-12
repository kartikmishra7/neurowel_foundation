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
$query = "SELECT * FROM who_we_are ORDER BY id DESC LIMIT 1";
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
    <title>who_we_are Content Preview</title>
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
        <h1 class="page-title">who we are Content</h1>

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
                $hero_image = trim($hero_image);
                if (strpos($hero_image, 'uploads/') === 0) {
                    $hero_image = substr($hero_image, 8);
                }
                $hero_image = basename($hero_image);

                // Resolve filesystem path and check if file exists
                $uploads_dir = realpath(__DIR__ . '/../../uploads');
                $hero_path = $uploads_dir && $hero_image !== '' ? $uploads_dir . DIRECTORY_SEPARATOR . $hero_image : '';

                if (!empty($hero_image) && $uploads_dir && file_exists($hero_path)) :
                ?>
                    <img src="../../uploads/<?= htmlspecialchars($hero_image) ?>" alt="hero">
                <?php elseif (!empty($hero_image)): ?>
                    <small style="color:red;">Hero image file not found: <?= htmlspecialchars($hero_image) ?></small>
                <?php else: ?>
                    <!-- No hero image uploaded -->
                <?php endif; ?>
            </div>
        </div>

        <!-- our program -->
        <div class="card">
            <div class="section-header">
                <h3>our program</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=program_title" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['program_title'] ?></div>
                <div class="image-box">
                    <?php
                    $program_image = $data['program_image'] ?? '';
                    $program_image = trim($program_image);
                    if (strpos($program_image, 'uploads/') === 0) {
                        $program_image = substr($program_image, 8);
                    }
                    $program_image = basename($program_image);

                    $program_path = $uploads_dir && $program_image !== '' ? $uploads_dir . DIRECTORY_SEPARATOR . $program_image : '';

                    if (!empty($program_image) && $uploads_dir && file_exists($program_path)) :
                    ?>
                        <img src="../../uploads/<?= htmlspecialchars($program_image) ?>" alt="program">
                    <?php elseif (!empty($program_image)): ?>
                        <small style="color:red;">Program image file not found: <?= htmlspecialchars($program_image) ?></small>
                    <?php else: ?>
                        <!-- No program image uploaded -->
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- clothing -->
        <div class="card">
            <div class="section-header">
                <h3>clothing distribution programs</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=clothing_title" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['clothing_title'] ?></div>
                <div class="image-box">
                    <?php 
                    $clothing_image = $data['clothing_image'] ?? '';
                    $clothing_image = trim($clothing_image);
                    if (strpos($clothing_image, 'uploads/') === 0) {
                        $clothing_image = substr($clothing_image, 8);
                    }
                    $clothing_image = basename($clothing_image);

                    $clothing_path = $uploads_dir && $clothing_image !== '' ? $uploads_dir . DIRECTORY_SEPARATOR . $clothing_image : '';

                    if (!empty($clothing_image) && $uploads_dir && file_exists($clothing_path)) :
                    ?>
                        <img src="../../uploads/<?= htmlspecialchars($clothing_image) ?>" alt="mission">
                    <?php elseif (!empty($clothing_image)): ?>
                        <small style="color:red;">Clothing image file not found: <?= htmlspecialchars($clothing_image) ?></small>
                    <?php else: ?>
                        <!-- No clothing image uploaded -->
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Education support -->
        <div class="card">
            <div class="section-header">
                <h3>Education support</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=eduction_title" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['eduction_title'] ?></div>
                <div class="image-box">
                    <?php 
                    $eduction_image = $data['eduction_image'] ?? '';
                    $eduction_image = trim($eduction_image);
                    if (strpos($eduction_image, 'uploads/') === 0) {
                        $eduction_image = substr($eduction_image, 8);
                    }
                    $eduction_image = basename($eduction_image);

                    $eduction_path = $uploads_dir && $eduction_image !== '' ? $uploads_dir . DIRECTORY_SEPARATOR . $eduction_image : '';

                    if (!empty($eduction_image) && $uploads_dir && file_exists($eduction_path)) :
                    ?>
                        <img src="../../uploads/<?= htmlspecialchars($eduction_image) ?>" alt="eduction">
                    <?php elseif (!empty($eduction_image)): ?>
                        <small style="color:red;">Education image file not found: <?= htmlspecialchars($eduction_image) ?></small>
                    <?php else: ?>
                        <!-- No education image uploaded -->
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- livehood & skill development -->
        <div class="card">
            <div class="section-header">
                <h3>livehood & skill development</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=livelihood_title" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['livelihood_title'] ?></div>
                <div class="image-box">
                    <?php 
                    $livelihood_image = $data['livelihood_image'] ?? '';
                    $livelihood_image = trim($livelihood_image);
                    if (strpos($livelihood_image, 'uploads/') === 0) {
                        $livelihood_image = substr($livelihood_image, 8);
                    }
                    $livelihood_image = basename($livelihood_image);

                    $livelihood_path = $uploads_dir && $livelihood_image !== '' ? $uploads_dir . DIRECTORY_SEPARATOR . $livelihood_image : '';

                    if (!empty($livelihood_image) && $uploads_dir && file_exists($livelihood_path)) :
                    ?>
                        <img src="../../uploads/<?= htmlspecialchars($livelihood_image) ?>" alt="livelihood">
                    <?php elseif (!empty($livelihood_image)): ?>
                        <small style="color:red;">Livelihood image file not found: <?= htmlspecialchars($livelihood_image) ?></small>
                    <?php else: ?>
                        <!-- No livelihood image uploaded -->
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Mental wellness & emotional development -->
        <div class="card">
            <div class="section-header">
                <h3>Mental wellness & emotional development</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=mental_title" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['mental_title'] ?></div>
                <div class="image-box">
                    <?php 
                    $mental_image = $data['mental_image'] ?? '';
                    $mental_image = trim($mental_image);
                    if (strpos($mental_image, 'uploads/') === 0) {
                        $mental_image = substr($mental_image, 8);
                    }
                    $mental_image = basename($mental_image);

                    $mental_path = $uploads_dir && $mental_image !== '' ? $uploads_dir . DIRECTORY_SEPARATOR . $mental_image : '';

                    if (!empty($mental_image) && $uploads_dir && file_exists($mental_path)) :
                    ?>
                        <img src="/NGO dashboard/uploads/<?= htmlspecialchars($mental_image) ?>" alt="mental">
                    <?php elseif (!empty($mental_image)): ?>
                        <small style="color:red;">Mental image file not found: <?= htmlspecialchars($mental_image) ?></small>
                    <?php else: ?>
                        <!-- No mental wellness image uploaded -->
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- community development iniatives -->
        <div class="card">
            <div class="section-header">
                <h3>community development iniatives</h3>
                <a href="edit.php?id=<?= $data['id'] ?>&section=community_title" class="edit-btn">Edit</a>
            </div>
            <div class="two-col">
                <div class="text"><?= $data['community_title'] ?></div>
                <div class="image-box">
                    <?php 
                    $community_image = $data['community_image'] ?? '';
                    $community_image = trim($community_image);
                    if (strpos($community_image, 'uploads/') === 0) {
                        $community_image = substr($community_image, 8);
                    }
                    $community_image = basename($community_image);

                    $community_path = $uploads_dir && $community_image !== '' ? $uploads_dir . DIRECTORY_SEPARATOR . $community_image : '';

                    if (!empty($community_image) && $uploads_dir && file_exists($community_path)) :
                    ?>
                        <img src="../../uploads/<?= htmlspecialchars($community_image) ?>" alt="community">
                    <?php elseif (!empty($community_image)): ?>
                        <small style="color:red;">Community image file not found: <?= htmlspecialchars($community_image) ?></small>
                    <?php else: ?>
                        <!-- No community image uploaded -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>