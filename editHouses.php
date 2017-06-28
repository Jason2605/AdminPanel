<?php

session_start();
ob_start();
$version = '';

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    die();
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

$houseID = $_POST['hidden'];

include 'verifyPanel.php';
masterconnect();
include 'header/header.php';
?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Edit Houses</h1>
		  <p class="page-header">Edit houses menu of the panel, allows you to change values in more depth.</p>
          <div id="alert-area"></div>
            <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Container Inventory</th>
					<th>Container Gear</th>
                    <th>Container Active</th>
                    <th>Container Owned</th>
                </tr>
              </thead>
              <tbody>

<?php


$sqlget = "SELECT * FROM containers WHERE id='$houseID';";
$search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
    echo '<tr>';
    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'inventory', '<?php echo $row['inventory']; ?>')"; type=text value= '<?php echo $row['inventory']; ?>' >
    <?php
    echo '</td>';
    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'gear', '<?php echo $row['gear']; ?>')"; type=text value= '<?php echo $row['gear']; ?>' >
    <?php
    echo '</td>';
    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'active', '<?php echo $row['active']; ?>')"; type=text value= "<?php echo $row['active']; ?>" >
    <?php
    echo '</td>';
    echo '<td>' ?>
    <input class="form-control" onBlur="dbSave(this.value, '<?php echo $row['id']; ?>', 'ownedCrate', '<?php echo $row['owned']; ?>')"; type=text value= "<?php echo $row['owned']; ?>" >
    <?php
    echo '</td>';
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
  </body>
</html>
