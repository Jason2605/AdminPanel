<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];
?>

    <title > Admin Panel - Dashboard < /title >

    <!-- Bootstrap core CSS-- >
    <link href = "dist/css/bootstrap.css" rel = "stylesheet" >

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug-- >
    <link href = "assets/css/ie10-viewport-bug-workaround.css" rel = "stylesheet" >

    <!-- Custom styles for this template-- >
    <link href = "styles/dashboard.css" rel = "stylesheet" >

    <!-- Just for debugging purposes.Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<?php
include 'header/header.php';
?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Unauthorised</h1>
		  <p class="page-header">You do not have permission to view this.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src = "../../assets/js/vendor/jquery.min.js" > <\/script > ')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line!-- >
    <script src = "../../assets/js/vendor/holder.min.js" > </script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
