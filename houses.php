<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

include 'verifyPanel.php';
masterconnect();

$sqlget = 'SELECT * FROM houses';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

include 'header/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<h1 style = "margin-top: 70px">House Menu</h1>
<p class="page-header">House menu of the panel, allows you to change house database values.</p>

<div id="alert-area"></div>
<?php
$sqlget = 'SELECT * FROM houses';
$sqldata = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

?>
          <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>ID</th>
					<th>Owner UID</th>
					<th>House Pos</th>
					<th>Owned</th>
                    <th>Containers</th>
                </tr>
              </thead>
              <tbody>
<?php
while ($row = mysqli_fetch_array($sqldata, MYSQLI_ASSOC)) {
    echo '<tr>';
    echo '<td>'.$row['id'].'</td>';
    echo '<td>'.$row['pid'].' </td>';
    echo '<td>'.$row['pos'].' </td>';

    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'owned', '<?php echo $row['owned']; ?>')" type=text value= "<?php echo $row['owned']; ?>" >
    <?php
    echo '</td>';
    echo '<form action=editHouses.php method=post>';
    echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=edit value=View".' </td>';
    echo "<td style='display:none;'>".'<input type=hidden name=hidden value='.$row['id'].' </td>';
    echo '</form>';

    echo '</tr>';
}

echo '</table></div>';
?>

<script>

function newAlert (type, message) {
    $("#alert-area").append($("<div class='alert " + type + " fade in' data-alert><p> " + message + " </p></div>"));
    $(".alert").delay(2000).fadeOut("slow", function () { $(this).remove(); });
}


function dbSave(value, uid, column, original){

        if (value != original) {

            newAlert('alert-success', 'Value Updated!');

            $.post('Backend/updateHouses.php',{column:column, editval:value, id:uid},
            function(){
                //alert("Sent values.");
            });
        };

}


</script>
              </tbody>
            </table>
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
