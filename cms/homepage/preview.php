<?php
include "../../config.php";

// Fetch homepage data
$query = "SELECT * FROM welcome_homepage ORDER BY id DESC LIMIT 1";
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
<title>Homepage Preview - Neurowel</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 100px 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}

.hero-section h1 {
    font-size: 3.5rem;
    margin-bottom: 20px;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-section p {
    font-size: 1.3rem;
    margin-bottom: 30px;
    opacity: 0.95;
}

.hero-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 15px 35px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-primary {
    background: #fff;
    color: #1e3a8a;
}

.btn-primary:hover {
    background: #f0f0f0;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.btn-secondary {
    background: transparent;
    color: #fff;
    border: 2px solid #fff;
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.1);
    transform: translateY(-2px);
}

.hero-image {
    margin-top: 40px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.hero-image img {
    width: 100%;
    height: auto;
    display: block;
}

/* Section Styles */
.section {
    padding: 80px 20px;
    background: #fff;
}

.section:nth-child(even) {
    background: #f9fafb;
}

.section-title {
    text-align: center;
    font-size: 2.5rem;
    color: #1e3a8a;
    margin-bottom: 20px;
    font-weight: 700;
}

.section-subtitle {
    text-align: center;
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 50px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.section-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
    margin-top: 40px;
}

.section-content.reverse {
    direction: rtl;
}

.section-content.reverse > * {
    direction: ltr;
}

.section-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
}

.section-image {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.section-image img {
    width: 100%;
    height: auto;
    display: block;
}

/* Focus Areas Grid */
.focus-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.focus-card {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

.focus-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.focus-card h3 {
    color: #1e3a8a;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.focus-card p {
    color: #666;
    line-height: 1.6;
}

.focus-card-image {
    margin-bottom: 20px;
    border-radius: 10px;
    overflow: hidden;
}

.focus-card-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* Impact Section */
.impact-section {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    padding: 80px 20px;
}

.impact-section .section-title {
    color: white;
}

.impact-section .section-subtitle {
    color: rgba(255,255,255,0.9);
}

/* Media Section */
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 40px;
}

.media-item {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.media-item video,
.media-item img {
    width: 100%;
    height: auto;
    display: block;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section h1 {
        font-size: 2.5rem;
    }
    
    .section-content {
        grid-template-columns: 1fr;
    }
    
    .focus-grid {
        grid-template-columns: 1fr;
    }
    
    .hero-buttons {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        text-align: center;
    }
}

/* Back Button */
.back-button {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #1e3a8a;
    color: white;
    padding: 12px 24px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    z-index: 1000;
    transition: all 0.3s ease;
}

.back-button:hover {
    background: #1e40af;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}
</style>
</head>
<body>

<a href="veiw.php" class="back-button">← Back to Admin</a>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1><?= htmlspecialchars($data['hero_title'] ?? 'Welcome to Neurowel') ?></h1>
        <p><?= htmlspecialchars($data['hero_description'] ?? 'Making a difference in the community') ?></p>
        <div class="hero-buttons">
            <a href="#" class="btn btn-primary"><?= htmlspecialchars($data['hero_donation_btn'] ?? 'Donate Now') ?></a>
            <a href="#" class="btn btn-secondary"><?= htmlspecialchars($data['hero_volunteers_btn'] ?? 'Become a Volunteer') ?></a>
        </div>
        <?php if (!empty($data['hero_image'])): ?>
        <div class="hero-image">
            <img src="../../uploads/<?= htmlspecialchars($data['hero_image']) ?>" alt="Hero Image">
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Welcome Section -->
<?php if (!empty($data['welcome_page_title'])): ?>
<section class="section">
    <div class="container">
        <h2 class="section-title"><?= htmlspecialchars($data['welcome_page_title']) ?></h2>
        <div class="section-content">
            <div class="section-text">
                <p><?= htmlspecialchars($data['welome_page_description'] ?? '') ?></p>
            </div>
            <?php if (!empty($data['welcome_page_image'])): ?>
            <div class="section-image">
                <img src="../../uploads/<?= htmlspecialchars($data['welcome_page_image']) ?>" alt="Welcome">
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Our Focus Area -->
<?php if (!empty($data['our_focus_title'])): ?>
<section class="section">
    <div class="container">
        <h2 class="section-title"><?= htmlspecialchars($data['our_focus_title']) ?></h2>
        <div class="focus-grid">
            <!-- Food Security -->
            <?php if (!empty($data['food_security_title'])): ?>
            <div class="focus-card">
                <?php if (!empty($data['food_security_image'])): ?>
                <div class="focus-card-image">
                    <img src="../../uploads/<?= htmlspecialchars($data['food_security_image']) ?>" alt="Food Security">
                </div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($data['food_security_title']) ?></h3>
                <p><?= htmlspecialchars($data['food_security_description'] ?? '') ?></p>
            </div>
            <?php endif; ?>

            <!-- Clothing -->
            <?php if (!empty($data['clothing_title'])): ?>
            <div class="focus-card">
                <?php if (!empty($data['clothing_image'])): ?>
                <div class="focus-card-image">
                    <img src="../../uploads/<?= htmlspecialchars($data['clothing_image']) ?>" alt="Clothing">
                </div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($data['clothing_title']) ?></h3>
                <p><?= htmlspecialchars($data['clothing_description'] ?? '') ?></p>
            </div>
            <?php endif; ?>

            <!-- Education -->
            <?php if (!empty($data['eduction_title'])): ?>
            <div class="focus-card">
                <?php if (!empty($data['eduction_image'])): ?>
                <div class="focus-card-image">
                    <img src="../../uploads/<?= htmlspecialchars($data['eduction_image']) ?>" alt="Education">
                </div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($data['eduction_title']) ?></h3>
                <p><?= htmlspecialchars($data['eduction_description'] ?? '') ?></p>
            </div>
            <?php endif; ?>

            <!-- Livelihood -->
            <?php if (!empty($data['livelihood_title'])): ?>
            <div class="focus-card">
                <?php if (!empty($data['livelihood_image'])): ?>
                <div class="focus-card-image">
                    <img src="../../uploads/<?= htmlspecialchars($data['livelihood_image']) ?>" alt="Livelihood">
                </div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($data['livelihood_title']) ?></h3>
                <p><?= htmlspecialchars($data['livelihood_description'] ?? '') ?></p>
            </div>
            <?php endif; ?>

            <!-- Mental Wellness -->
            <?php if (!empty($data['mental_title'])): ?>
            <div class="focus-card">
                <?php if (!empty($data['mental_image'])): ?>
                <div class="focus-card-image">
                    <img src="../../uploads/<?= htmlspecialchars($data['mental_image']) ?>" alt="Mental Wellness">
                </div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($data['mental_title']) ?></h3>
                <p><?= htmlspecialchars($data['mental_description'] ?? '') ?></p>
            </div>
            <?php endif; ?>

            <!-- Community -->
            <?php if (!empty($data['community_title'])): ?>
            <div class="focus-card">
                <?php if (!empty($data['community_image'])): ?>
                <div class="focus-card-image">
                    <img src="../../uploads/<?= htmlspecialchars($data['community_image']) ?>" alt="Community">
                </div>
                <?php endif; ?>
                <h3><?= htmlspecialchars($data['community_title']) ?></h3>
                <p><?= htmlspecialchars($data['community_description'] ?? '') ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Our Impact -->
<?php if (!empty($data['our_impact_title'])): ?>
<section class="impact-section">
    <div class="container">
        <h2 class="section-title"><?= htmlspecialchars($data['our_impact_title']) ?></h2>
        <p class="section-subtitle"><?= htmlspecialchars($data['our_impact_description'] ?? '') ?></p>
        <?php if (!empty($data['our_impact_image'])): ?>
        <div class="section-image" style="max-width: 800px; margin: 40px auto;">
            <img src="../../uploads/<?= htmlspecialchars($data['our_impact_image']) ?>" alt="Our Impact">
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- Media & Stories -->
<?php if (!empty($data['media_title'])): ?>
<section class="section">
    <div class="container">
        <h2 class="section-title"><?= htmlspecialchars($data['media_title']) ?></h2>
        <p class="section-subtitle"><?= htmlspecialchars($data['media_description'] ?? '') ?></p>
        <?php if (!empty($data['media_video_title'])): ?>
        <h3 style="text-align: center; color: #1e3a8a; margin: 30px 0 20px;"><?= htmlspecialchars($data['media_video_title']) ?></h3>
        <?php endif; ?>
        <?php if (!empty($data['media_video_image'])): ?>
        <div class="media-grid">
            <?php
            $videos = $data['media_video_image'];
            if ($videos) {
                $videoFiles = array_map('trim', explode(',', $videos));
                foreach ($videoFiles as $video) {
                    $path = "../../uploads/" . $video;
                    if (file_exists($path)) {
                        $ext = strtolower(pathinfo($video, PATHINFO_EXTENSION));
                        if (in_array($ext, ['mp4','webm','ogg'])) {
                            echo '<div class="media-item"><video width="100%" controls><source src="'.$path.'" type="video/'.$ext.'"></video></div>';
                        } else {
                            echo '<div class="media-item"><img src="'.$path.'" alt="Media"></div>';
                        }
                    }
                }
            }
            ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

</body>
</html>

<?php mysqli_close($conn); ?>



