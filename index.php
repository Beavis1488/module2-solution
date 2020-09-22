<?php
require_once "pdo.php";
// p' OR '1' = '1
if ( $_POST['email'] !='' && $_POST['password'] !='') {
  if (stripos($_POST['email'], '@') === FALSE) {
  echo "<p>Email must have an at-sign (@)</p>";
}
  else {

    $sql = "SELECT name FROM users
        WHERE email = :em AND password = :pw";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':em' => $_POST['email'],
        ':pw' => $_POST['password']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


   if ( $row === FALSE ) {
      echo "<p>Incorrect password.</p>\n";
      $check = crypt($_POST['password']);
      error_log("Login fail ".$_POST['email']." $check");
   } else {
      echo "<p>Login success.</p>\n";
      error_log("Login success ".$_POST['email']);
      header("Location: autos.php?name=".urlencode($row['name']));
   }
}
}
if ( $_POST['email'] == '' || $_POST['password'] == '') {
  if (isset($_POST['login'])) {
echo "<p>Email and password are required</p>";
}
}
?>
<p>Please Login</p>
<form method="post">
<p>Email:
<input type="text" size="40" name="email"></p>
<p>Password:
<input type="text" size="40" name="password"></p>
<p><input type="submit" value="Login" name="login"/>
<a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a></p>
</form>
