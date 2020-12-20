<?php
// Initialize the session
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["id"] != 1){
    header("location: ../usersystem/login.php");
    exit;
}
echo "Benvingut admin.";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	include '../connect.php';
	$code = $_POST["code"];
	$con = connect_mysql();
	if(!$con){ echo "Error: (" . $con->errno . ") " . $con->error."<br>"; }
	if($stmt = $con->prepare("INSERT INTO activation_codes (code) VALUES (?)")){
		$stmt->bind_param("s", $code);
		$stmt->execute();
		echo "Ok.";
	};

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<input type="text" name="code">
		<input type="submit" value="crear">
	</form>
	<a href="./index.php">index</a>
	<a href="./logout.php">logout</a>

</body>
