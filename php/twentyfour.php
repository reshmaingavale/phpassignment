<?php
if(isset($_POST['submit']))
{
$name = $_POST['name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$gender = $_POST['gender'];

	if (eregi('^[A-Za-z0-9 ]{3,20}$',$name))
	{
		$valid_name=$name;
	}
	else
	{
		$error_name='Enter your Name.';
	}


	if ($email!=null)	
	{
		$valid_email=$email;
	}
	else
	{
		$error_email='Enter your Email.';
	}

	if ($username!='')
	{
		$valid_username=$username;
	}
	else
	{
		$error_username='Enter Username.';
	}
	if ($password!='')
	{
		$valid_password=$password;
	}
	else
	{
		$error_password='Enter Password.';
	}

	// Gender
	if ($gender==0)
	{
		$error_gender='Select Gender';
	}
	else
	{
		$valid_gender=$gender;
	}

	if($valid_name&&$valid_email&&$valid_username&&$valid_password&&$valid_gender)
	{
		header("Location: thanks.html");
	}
	

}
?>
<form method="post" action="" name="form">
Name : <input type="text" name="name" value="<?php echo $valid_name; ?>" /><br>
<?php echo $error_name; ?><br>
Email : <input type="text" name="name" value="<?php echo $valid_email; ?>" /><br>
<?php echo $error_email; ?><br>
Username : <input type="text" name="name" value="<?php echo $valid_username; ?>" /><br>
<?php echo $error_username; ?><br>
Password : <input type="password" name="name" value="<?php echo $valid_password; ?>" /><br>
<?php echo $error_password; ?><br>
Gender : <select name="gender">
<option value="0">Gender</option>
<option value="1">Male</option>
<option value="2">Female</option>
</select><br>
<?php echo $error_gender; ?><br>
<input type="submit" name="submit" value="submit">
</form>
