<?php
  include_once("../allFunctions/createNavBar/createNavBar.php");
  include_once("../allFunctions/connectPDO.php");

  $indexPDO = connectedPDO();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./create.css" >
  
    <!-- for nav  -->
    <link rel="stylesheet" href="../allFunctions/createNavBar/createNavBar.css">
    
</head>
<body>

    <?php
      createNavBar("search");
    ?>

    <div id="jobFormSection">
        <div id="jobForm">
            <h2>Create a Job Posting</h2>

            <label for="title">Post Titles:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="jobTitle">Job Titles:</label>
            <input list="jobTitle" name="jobTitle">
            <datalist id="jobTitle" required>
                <?php
                    $jobTitlesQuery = $indexPDO->query("SELECT DISTINCT jobtitles FROM SettingsOptions WHERE jobtitles IS NOT NULL");
                    while ($jobTitle = $jobTitlesQuery->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value=\"{$jobTitle['jobtitles']}\">{$jobTitle['jobtitles']}</option>";
                    }
                ?>
            </datalist>

            <label for="jobType">Job Type:</label>
            <select id="jobType" name="jobType" required>
                <?php
                    $jobTypesQuery = $indexPDO->query("SELECT DISTINCT jobtypes FROM SettingsOptions WHERE jobtypes IS NOT NULL");
                    while ($jobType = $jobTypesQuery->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value=\"{$jobType['jobtypes']}\">{$jobType['jobtypes']}</option>";
                    }
                ?>
            </select>

            <label for="days">Work Days:</label>
            <select id="days" name="days" required>
                <?php
                    $workDaysQuery = $indexPDO->query("SELECT DISTINCT jobdays FROM SettingsOptions WHERE jobdays IS NOT NULL");
                    while ($workDay = $workDaysQuery->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value=\"{$workDay['jobdays']}\">{$workDay['jobdays']}</option>";
                    }
                ?>
            </select>

            <label for="shifts">Shifts:</label>
            <div id="allShifts">
                <div class="addedShift">
                    <input type="time"  name="startShifts" required>
                    <input type="time"  name="endShifts" required>
                    <div class="removeAddedShift">&#8212;</div>
                </div>
            </div>
            <div id="addAnotherShiftJobPost"> Add Another Shift <span>+</span></div>

            <label for="pay">Pay ($/hour):</label>
            <input type="number" id="pay" name="pay" min="0" required>

            <label for="address">Job Location:</label>
            <input type="text" id="address" name="address" required>

            <button type="submit">Post Job</button>

            <div id="responseMessage"></div>
        </div>
    </div>



    <script src="./create.js"></script>
    <script src="../allFunctions/createNavBar/createNavBar.js"></script>
</body>
</html>