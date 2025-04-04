<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../allFunctions/connectPDO.php");

$pdo = connectedPDO();
$currentUserId = 1; // Test ID
$userType = 'student'; // Change to 'employer' for employer view

$jobpostid = isset($_GET['postid']) ? intval($_GET['postid']) : 0;

// Fetch the job post details
$stmtJobs = $pdo->prepare("SELECT * FROM JobPosts WHERE id = :postid"); // Ensure column name is correct
$stmtJobs->execute([':postid' => $jobpostid]);
$job = $stmtJobs->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    die("❌ Error: Job post not found.");
}

// Fetch job applications related to this job post (for employer view)
$stmtApplications = $pdo->prepare("SELECT * FROM Applications WHERE jobpostid = :postid");
$stmtApplications->execute([':postid' => $jobpostid]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications</title>
    <link rel="stylesheet" href="applications.css">
</head>
<body>

<h2><?= $userType == 'employer' ? "All Job Applications" : "Submit your application!" ?></h2>
<a href="../Search/index.php" class="exit-button">✖</a>
<div class="application-box">
    <!-- Student Section: Display Job Post Details & Application Form -->
    <div class="application-card">
        <p><strong>Title:</strong> <?= htmlspecialchars($job['posttitle']) ?></p>
        <p><strong>Type:</strong> <?= htmlspecialchars($job['jobtype']) ?></p>
        <p><strong>Days:</strong> <?= htmlspecialchars($job['jobdays']) ?></p>
        <p><strong>Shifts:</strong> <?= htmlspecialchars($job['shifts']) ?></p>
        <p><strong>Pay:</strong> $<?= htmlspecialchars(number_format((float) $job['pay'], 2)) ?>/hr</p>
        <p><strong>Location:</strong> <?= htmlspecialchars($job['address'] ?? 'N/A') ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($job['description'])) ?></p>
    <?php if ($userType == 'student'): ?>
        <form class="applyForm" enctype="multipart/form-data">
            <input type="hidden" name="postid" value="<?= isset($_GET['postid']) ? htmlspecialchars($_GET['postid']) : '' ?>">
            <label for="resume">Upload Resume (PDF, PNG, JPG):</label>
            <input type="file" name="resume" required>
            <label for="motivation">Why do you want this job? (200 words max)</label>
            <textarea name="motivation" rows="4" maxlength="200" required></textarea>
            <button type="button" onclick="processApplication(this)">Apply</button>
        </form>
        <div class="response"></div>
    <?php endif; ?>
    </div>
    <!-- Employer Section: Loop through Applications -->
    <?php if ($userType == 'employer'): ?>
        <?php while ($row = $stmtApplications->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="application-card">                
                <p><strong>Status:</strong> <span class="status <?= strtolower($row['status']) ?>"><?= ucfirst($row['status']) ?></span></p>
                <a href="../Data/Uploads/<?= htmlspecialchars($row['resumes']) ?>" target="_blank">Download Resume</a>
                <div id="optionBtnsContainer">
                    <button id="acceptBtn" class="optionBtns" onclick="updateStatus(<?= $row['id'] ?>, 'accepted')">Accept</button>
                    <button id="denyBtn" class="optionBtns" onclick="updateStatus(<?= $row['id'] ?>, 'denied')">Deny</button>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<script src="applications.js"></script>

</body>
</html>