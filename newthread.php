<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="validate.js"></script>
        <script type="text/javascript" src="logoff.js"></script>
        <link rel="stylesheet" href="forms_and_inputs.css">
        <link rel="stylesheet" href="navbar.css">
    </head>
    <body>
        <?php session_start();?>
        
        <div id="navbar">
            <ul>
            <li><a href="homepage.php">Home</a></li></ul>
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                    echo "<footer><a href=\"profile.php\" style=\"float: right;\">Logged in as: ".$_SESSION['username']."  </a>
                          <br><button onclick=\"logoff()\" style=\"float: right;\">Log out</button></footer>";
                  } else {
                    echo "<div id=\"navbar\">
                    <ul>
                    <li class=\"login\"><a href=\"login.php\">Login</a></li>
                    <li class=\"signup\"><a href=\"signup.php\">Signup</a></li>
                    <li class=\"home\"><a href=\"homepage.php\">Home</a></li>
                </ul>
                </div>";}?>
        </div>
    <div id="search">
        <form action="threadLookup.php" method="POST">
        <input type="text" id="threadString" name="threadString" placeholder="Search threads...">
        <input type="image" name="submit" src="imgs/search.png" alt="Submit" style="width: 30px; display: inline-block;">
        </form>
    </div>
        
        <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                echo "<div class=\"form-style\"><h1>Create New Thread</h1><form action=\"postThread.php\" method=\"POST\" id=\"threadForm\" name=\"threadForm\">
                        <div class=\"inner-wrap\"><label for=\"threadTitle\"><strong>Topic:</strong></label>
                        <input type=\"text\" id=\"threadTitle\" name=\"threadTitle\" class=\"required\"></div>
                        <div class=\"inner-wrap\"><label for=\"threadBody\"><strong>Description:<strong></label>
                      <textarea rows=\"4\" cols=\"50\" name=\"threadBody\"  class=\"required\" form=\"threadForm\"></textarea></div>
                      <input type=\"submit\" form=\"threadForm\"></form>";
            } else {
                echo "<p>Please <a href=\"login.php\">login</a> to create a thread.</p>";
            }
        ?>
    </body>
</html>