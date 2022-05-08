<!DOCTYPE html>
<html>
<head>

<script type="text/javascript" src="validate.js"></script>
<script type="text/javascript" src="logoff.js"></script>

    <script type="text/javascript">
        function checkPasswordMatch(e){
            if (document.getElementById('password').value != document.getElementById('password-check').value) {
                alert("Password did not match");
                makeRed(document.getElementById('password'));
                makeRed(document.getElementById('password-check'));
                e.preventDefault();
            }
        }
    </script>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="forms_and_inputs.css">

</head>

<body>
    <div id="navbar">
        <ul>
        <li class="login"><a href="login.php">Login</a></li>
        <li class="home"><a href="homepage.php">Home</a></li>
    </ul>
</div>
<div id="search">
            <form action="threadLookup.php" method="POST">
            <input type="text" id="threadString" name="threadString" placeholder="Search threads...">
            <input type="image" name="submit" src="imgs/search.png" alt="Submit" style="width: 30px; display: inline-block;">
            </form>
        </div>

    <div class="form-style">
    <h1>Sign Up<span>Sign up to add your own threads to <strong><u>The Weave!</u></strong></span></h1>
    <form method="POST" action="homepage.php" id="mainForm" >
    <div class="section"><span>1</span>Username</div>
    <div class="inner-wrap">
        <label>Enter username <input type="text" name="username" id="username" class="required" /></label>
        </div>
        <div class="section"><span>2</span>Email address</div>
        <div class="inner-wrap">
            <label>Enter email address <input type="text" name="email" id="email" class="required" /></label>
        </div>
        <div class="section"><span>3</span>Password</div>
        <div class="inner-wrap">
            <label>Enter password <input type="password" name="password" id="password" class="required" /></label>
            <label>Confirm Password <input type="password" name="password-check" id="password-check" class="required" /></label>
        </div>
        <div class="button-section">
        <input id="infoType" name="infoType" type="hidden" value="signup">
        <input type="submit" value="Sign Up" />
    </div>
    </form>
</div>
</body>
