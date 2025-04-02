<?php
    require_once('../connectPDO.php'); 

    // Check if request contains query parameters
    if (!isset($_POST['cardQuery'])) {
        echo json_encode(["error" => "No query parameters provided."]);
        exit;
    }

    // Get the current logged-in user

    // if (session_status() === PHP_SESSION_NONE) {
    //     session_start();
    // }

    // if (!isset($_SESSION['userid'])) {
    //     echo json_encode(["error" => "User not authenticated."]);
    //     exit;
    // }

    $queryConditions =  json_decode($_POST['cardQuery']);
    
    echo($queryConditions->owner);

    $query = [];

    $myPDO = connectedPDO();

    $userType = "general";

    $conditions = [];
    $params = [];
    

    // only run if the user put owner = null 
    if (isset($queryConditions->owner) && $queryConditions->owner === null) {
        // Handle the case when 'owner' exists and is null
        
       
        $currentUserId = 2;
        $userTypeQuery = $myPDO->prepare("SELECT usertype FROM Users WHERE id = ?");
        $userTypeQuery->execute([
            $currentUserId
        ]);
        $userType = $userTypeQuery->fetchColumn();
        $params[] = $currentUserId;


    }
    
    // // Build SQL query based on provided conditions

    foreach ($queryConditions as $key => $value) {
        if ($value !== null) {
            array_push($conditions, "$key = ?");
            array_push($params,  $value);
        }
    }



    // Determine the type of jobs to fetch based on user type
    if ($userType === "student") {
        $sql = "SELECT 
                    Applications.status AS status,
                    JobPosts.posttitle AS jobTitle,
                    JobPosts.description AS jobDescription
                FROM Applications
                INNER JOIN JobPosts ON Applications.jobpostid = JobPosts.id
                WHERE Applications.userid = ?";

        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        $stmt = $myPDO->prepare($sql);
        $stmt->execute($params);
        
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($jobs) > 0){
            foreach ($jobs as &$job) {
                $job['type'] = "applicant";
            }
        }else{
            $job['type'] = "applicant";
        }
    } elseif ($userType === "employer") {
        $sql = "SELECT 
                    JobPosts.poststatus AS status,
                    JobPosts.posttitle AS jobTitle,
                    JobPosts.description AS jobDescription,
                    (SELECT COUNT(*) FROM Applications WHERE Applications.jobpostid = JobPosts.id) AS applicantsCount
                FROM JobPosts
                WHERE JobPosts.userid = ?";

        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        $params[] = $currentUserId;

        $stmt = $myPDO->prepare($sql);
        $stmt->execute($params);
        
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($jobs) > 0){
            foreach ($jobs as &$job) {
                $job['type'] = "applicant";
            }
        }else{
            $job['type'] = "applicant";
        }
    } elseif($userType === "admin"){

        $sql = "SELECT 
                    JobPosts.posttitle AS jobTitle,
                    Users.username AS companyName,
                    JobPosts.description AS jobDescription
                FROM JobPosts
                INNER JOIN Users ON JobPosts.userid = Users.id";

        if (!empty($conditions)) {
            $sql .= "WHERE  " . implode(" AND ", $conditions);
        }

        $stmt = $myPDO->prepare($sql);
        $stmt->execute($params);
        
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($jobs as &$job) {
            $job['type'] = "admin";
        }

    }else {
        // Generic job posts for users browsing jobs
        $sql = "SELECT 
                    JobPosts.posttitle AS jobTitle,
                    Users.username AS companyName,
                    JobPosts.description AS jobDescription
                FROM JobPosts
                INNER JOIN Users ON JobPosts.userid = Users.id
                WHERE JobPosts.adminstatus = 'accepted' AND JobPosts.poststatus = 'accepting'";

        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        $stmt = $myPDO->prepare($sql);
        $stmt->execute($params);
        
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($jobs as &$job) {
            $job['type'] = "generic";
        }
    }

    // Return the fetched jobs as JSON
    //echo json_encode($jobs);