<?php
session_start();
ob_start();

$json = file_get_contents('http://139.59.163.114/Other/Admin/AdminPanel_V2/API/apiExample.php');

//var_dump($json);

$response = json_decode($json, true);

//echo json_last_error();
?>

    <title> Admin Panel</title>

    <link href="../dist/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="../styles/dashboard.css" rel="stylesheet">
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>
  </head>

  <body>

      <div class='panel panel-info'>
          <div class='panel-heading'>
              <h3 class='panel-title'>Players</h3>
          </div>
          <div class='panel-body'>
              <p> <?php echo 'Total money on your server is: '.$response; ?> </p>
          </div>
      </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


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
    <script src = "../../assets/js/vendor/holder.min.js" > </script>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
