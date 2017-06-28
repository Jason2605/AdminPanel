<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

if ($staffPerms['logs'] != '1') {
    header('Location: lvlError.php');
    die();
}

include 'verifyPanel.php';
masterconnect();

include 'header/header.php';

$page1 = $_GET['page'];

if ($page1 == '' || $page1 == '1') {
    $page = 0;
} else {
    $page = ($page1 * 20) - 20;
}

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h1 style = "margin-top: 70px">Log Menu</h1>
<p class="page-header">Log menu of the panel, allows you to see the logs.</p>

<?php
$resultQ = 'SELECT * FROM log ORDER BY logid DESC';
$result = mysqli_query($dbcon, $resultQ) or die('Connection could not be established');

$count = mysqli_num_rows($result);
$amount = $count / 20;
$amount = ceil($amount);

$currentpage = $page1;

$minusPage = $currentpage - 1;

if ($minusPage < 1) {
    $minusPage = 1;
}

$addPage = $currentpage + 1;

if ($addPage > $amount) {
    $addPage = $amount;
}

?>
          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Date/Time</th>
					<th>Admin Name</th>
					<th>Action</th>
                </tr>
              </thead>
              <tbody>
<?php
$sqlget = "SELECT * FROM log ORDER BY logid DESC limit $page,20";
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    echo '<form action=logs.php method=post>';
    echo '<tr>';

    echo '<td>'.$row['date_time'].'</td>';
    echo '<td>'.$row['user'].' </td>';
    echo '<td>'.$row['action'].' </td>';

    echo '</tr>';
    echo '</form>';
}

echo '</table></div>';
?>
              </tbody>
            </table>
<nav>
<ul class="pagination">
<?php if ($currentpage != 1) {
    ?>
<li>
  <a href="logs.php?page=<?php echo $minusPage; ?>" aria-label="Previous">
	<span aria-hidden="true">&laquo;</span>
  </a>
</li>
<?php

} else {
    ?>

<li class = "disabled">
  <a href="logs.php?page=<?php echo $minusPage; ?>" aria-label="Previous">
	<span aria-hidden="true">&laquo;</span>
  </a>
</li>

<?php

}
$amountPage = $currentpage + 2;
$pageBefore = $currentpage - 2;

if ($pageBefore == 0) {
    $pageBefore = 1;
    $amountPage = $amountPage + 1;
}

if ($pageBefore < 1) {
    $pageBefore = 1;
    $amountPage = $amountPage + 2;
}

for ($b = $pageBefore; $b <= $amountPage; ++$b) {
    if ($b == $currentpage) {
        ?><li class = "active"><a href = "logs.php?page=<?php echo $b; ?>" style = "text-decoration:none"><?php  echo $b.' '; ?></a><li><?php

    } else {
        ?><li><a href = "logs.php?page=<?php echo $b; ?>" style = "text-decoration:none"><?php  echo $b.' '; ?></a><li><?php

    }
}

if ($currentpage != $amount) {
    ?>
<li>
  <a href="logs.php?page=<?php echo $addPage; ?>" aria-label="Next">
	<span aria-hidden="true">&raquo;</span>
  </a>
</li>
<?php

} else {
    ?>

<li class = "disabled">
  <a href="logs.php?page=<?php echo $minusPage; ?>" aria-label="Next">
	<span aria-hidden="true">&raquo;</span>
  </a>
</li>

<?php

}
?>
</ul>
</nav>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
