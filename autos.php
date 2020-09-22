<?php
require_once "pdo.php";

// p' OR '1' = '1
if ($_GET['name']=='') {
  die("Name parameter missing");
}
if ( $_POST['make']!='' && isset($_POST['make']) && isset($_POST['add'])) {
  if (is_numeric($_POST['year'])==TRUE && is_numeric($_POST['mileage'])==TRUE){
    echo "<p>Record inserted</p>";
    $sql = "INSERT INTO autos (make, year, mileage)
              VALUES (:make, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
    );
    header ("Location: autos.php?name=".urlencode($row['name']));
  }
  else{
    if (isset($_POST['add'])){
    echo "<p>Mileage and year must be numeric</p>";
  }
  }
}
else{
  if (isset($_POST['add'])){
  echo "<p>Make is required</p>";
}
}

if ( isset($_POST['logout'])) {
  header("Location: login2.php");
}

$stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head></head><body>
<p>Add A New Auto</p>
<form method="post">
<p>Make:
<input type="text" name="make" size="40"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p><input type="submit" value="Add New" name="add"/></p>
<input type="submit" value="logout" name="logout"/>
</form>
<h1>Autos</h1>
<?php
foreach ( $rows as $row ) {
    echo "<div><span> ";
    echo($row['make']);
    echo("</span><span> ");
    echo($row['year']);
    echo("</span><span> ");
    echo($row['mileage']);
    echo("</span></div>");
}
?>
</body>
