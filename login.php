<?php
session_set_cookie_params(1209600);
session_start();
ob_start();
?>

<html>
<script src="scripts/na.js"></script>
</html>

<?php
if (isset($_COOKIE['logged'])) {
header("home.php");
}

include('verifyPanel.php');
loginconnect();

if (!$dbconL) {
  echo "Bruh";
  setcookie('conecFail', '1');
  header("Location: index.php");
  die;
}
else {
  echo "connected fam";

if (isset($_COOKIE['conecFail'])):
  setcookie('conecFail', '', time() - 7000000, '/');
endif;

setcookie('conecFail', '0');

}

$username = mysqli_real_escape_string($dbconL, $_POST['username']);
$password = mysqli_real_escape_string($dbconL, $_POST['password']);

$encPass = sha1($password);

if ($username && $password)
{
$sqlget = "SELECT * FROM users WHERE username='$username'";
$res = mysqli_query($dbconL, $sqlget);


$numrows = mysqli_num_rows($res);

  if ($numrows != 0)
  {
    while ($row = mysqli_fetch_assoc($res))
    {
      $dbusername = $row['username'];
      $dbpassword = $row['password'];
      $adminLevel = $row['level'];
    }
    if ($username == $dbusername && $encPass == $dbpassword)
    {

    if (isset($_COOKIE['conecFail'])):
      setcookie('conecFail', '', time() - 7000000, '/');
    endif;


    if (isset($_COOKIE['fail'])):
      setcookie('fail', '', time() - 7000000, '/');
    endif;

    $_SESSION = array();

      echo "You are logged in!";
      $_SESSION['logged'] = 1;

      $_SESSION['user'] = $dbusername;

      $_SESSION['adminLevel'] = $adminLevel;

      header("Location: home.php");
    }
    else {
      echo "Your user/password is incorrect!";
      setcookie('fail', '1');
      echo "<script type='text/javascript'>alert('Login details incorrect!');</script>";
      header("Location: index.php");
    }
  }
  else {
    echo("That user does not exist!");
    setcookie('fail', '1');
    header("Location: index.php");
  }
}
else {
  echo("please enter username/password!");
  setcookie('fail', '1');
  header("Location: index.php");
}
?>
