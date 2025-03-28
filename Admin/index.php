<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="admin.css">
  <script src="../allFunctions/Sanitization/checkValidInputs.js"></script>
</head>
<body>
  <!-- section ------------------------------------------- -->
   <div id="pageHeader"><h1>Admin</h1></div>

  <div id="overview">
    <!-- left side of the OverView -->
    <div id="sideBarLeft">
      <!-- sideBarLeftBackground -->
      <div id="sideBarLeftBackground"></div>
      <!-- click buttons -->
      <button name="jobPosts" type="button" class="leftSideBarItems selected">Job Posts</button>
      <button name="accounts" type="button" class="leftSideBarItems">Accounts</button>
    </div>

    <div id="sideBarRight">

      <!-- Header for the right bar  -->
      <div id="sideBarRightHeaderHolder">
        <div id="jobPostsHeader" class="rightSideBarHeader">
          <h2>Job Posts</h2>
        </div>
        <div id="accountsHeader" class="rightSideBarHeader hide">
          <h2>Accounts</h2>
        </div>
      </div>


      <!-- Info for right side bar  -->
      <div id="rightSideBarMain">

        <!-- appliaction container  -->
        <div id="jobPostsContainer" class="rightSideBarSections">
          
        </div>

        <!-- preferences container -->
        <div id="accountsContainer" class="rightSideBarSections">
            <div id="makeUser">
                <form>
                    <input name="username" type="text" placeholder="Username...">
                    <input name="password" type="text" placeholder="Password...">
                    <label for="userType">Pick user type:</label>
                        <select id="userType" name="userType">
                            <option value="student">Student</option>
                            <option value="employer">Employer</option>
                        </select>
                    <button type="button" onclick="checkIfValid();">Submit!</button>
                </form>
            </div>
            <div id="confirmUser">

            </div>
        </div>
      </div>
    </div>

  </div>
  
  <script src="admin.js"></script>
</body>

</html>