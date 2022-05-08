<!DOCTYPE html>
<html>
<head>

<script type="text/javascript" src="validate.js"></script>
<script type="text/javascript" src="logoff.js"></script>
<link rel="stylesheet" href="forms_and_inputs.css">
<link rel="stylesheet" href="navbar.css">

</head>

<body>
    <div id="navbar" class="column">
        <ul>
        <li><a href="signup.php">Signup</a></li>
        <li><a href="homepage.php">Home</a></li>
    </div>
    <div id="search">
            <form action="threadLookup.php" method="POST">
            <input type="text" id="threadString" name="threadString" placeholder="Search threads...">
            <input type="image" name="submit" src="imgs/search.png" alt="Submit" style="width: 30px; display: inline-block;">
            </form>
        </div>
    <div class="form-style">
    <h1>Log In</h1>
    <form method="POST" action="homepage.php" id="mainForm" >
        <div class="section">Username</div>
        <div class="inner-wrap">
        <label>Enter username <input type="text" name="username" id="username" class="required" /></label>
        </div>
        <div class="section">Password</div>
        <div class="inner-wrap">
        <label>Enter password <input type="password" name="password" id="password" class="required" /></label>
        </div>
        <div class="button-section">
        <input id="infoTyle" name="infoType" type="hidden" value="login">
        <input type="submit" value="Login">
    </div>
    </form>
</div>
</body>