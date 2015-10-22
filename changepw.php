<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "Got0895889227", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Login form
<hr>

<?PHP
    echo "ID : ".$_SESSION['ID']."<br>";
	if(isset($_POST['submit'])){
		#$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$newpassword = trim($_POST['newpassword']);
		$newpasswordagain = trim($_POST['newpasswordagain']);
		$query = "SELECT * FROM AA_LOGIN WHERE password='$password'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		$_SESSION['ID'] = $row['ID'];
		if(($row)&&($newpassword==$newpasswordagain)){
			$query = "update AA_LOGIN set password='$newpassword' where password = '$password'";
			$parseRequest = oci_parse($conn, $query);
		    oci_execute($parseRequest);
			$_SESSION['ID'] = $row['ID'];
			$_SESSION['NAME'] = $row['NAME'];
			$_SESSION['SURNAME'] = $row['SURNAME'];
			echo '<script>window.location = "MemberPage.php";</script>';
		}else{
			echo "Login fail.";
		}
	};
	oci_close($conn);
?>

<form action='changepw.php' method='post'>
	old Password<br>
	<input name='password' type='password'><br>
	
	new password<br><input name='newpassword'  type='password'><br>
	
	new password again<br><input name='newpasswordagain'  type='password'><br>
	<input name='submit' type='submit' value='confirm'>
</form>
