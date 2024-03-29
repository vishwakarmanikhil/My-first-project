<?php

session_start();


require 'config/db.php';

$errors = array();
$username="";
$email="";
//if user click on the sign up button

if(isset($_POST['signup-btn'])){
	$firstname = $_POST['firstname'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password =$_POST['password'];
	$passwordConf = $_POST['passwordConf'];
	$mobilenumber = $_POST['mobilenumber'];


	//validation

	if (empty($firstname)) {
		$errors['firstname'] = "Name is Required";
	}

	if (empty($username)) {
		$errors['username'] = "Username is Required";
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email']="Invalid Email address";
	}

	if (empty($email)) {
		$errors['email'] = "Email Required";
	}

	if (empty($password)) {
		$errors['password'] = "Password Required";
	}

	if($password!==$passwordConf){
		$errors['password']="Password Mismatch";
	}
		
	if (strlen($mobilenumber)!==10) {
		$errors['mobilenumber'] = "Mobile Number Invalid ";
	}
	

	$emailQuery ="SELECT * FROM users WHERE email=? LIMIT 1";
	$stmt=$conn->prepare($emailQuery);
	$stmt->bind_param('s',$email);
	$stmt->execute();
	$result=$stmt->get_result();
	$userCount=$result->num_rows;
	$stmt->close();

	if ($userCount >0) {
		$errors['email']="Email already exists";
	}

	if(count($errors)===0){
		$password=password_hash($password, PASSWORD_DEFAULT);	
		$token=bin2hex(random_bytes(50));
		$verified=false;	

		$sql="INSERT INTO users (firstname, username, email, verified, token, password, mobilenumber) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$stmt=$conn->prepare($sql);
		$stmt->bind_param('sssbssi', $firstname ,$username, $email, $verified, $token, $password, $mobilenumber);
		
		if($stmt->execute()){
			//login user
			$user_id=$conn->insert_id;
			$_SESSION['id']=$user_id;
			$_SESSION['firstname']=$firstname;
			$_SESSION['username']=$username;
			$_SESSION['email']=$email;
			$_SESSION['verified']=$verified;			
			$_SESSION['mobilenumber']=$mobilenumber;

			//flash message
			$_SESSION['message']="You are now loged in";
			$_SESSION['alert-class']="alert-success";
			header('location: login.php');
			exit();

		}
		else{
			$errors['db_error']="DATABASE error : failed to register ";
		}
	}

}

//if user

if(isset($_POST['login-btn'])){
	$username = $_POST['username'];
	$password =$_POST['password'];


	//validation
	if (empty($username)) {
		$errors['username'] = "Username Required";
	}	

	if (empty($password)) {
		$errors['password'] = "Password Required";
	}

	if(count($errors) ===0)
	{
		$sql="SELECT *FROM users WHERE email=? OR username=? LIMIT 1";
	$stmt=$conn->prepare($sql);
	$stmt->bind_param('ss', $username, $username);
	$stmt->execute();
	$result=$stmt->get_result();
	$user=$result->fetch_assoc();

	if(password_verify($password, $user['password'])){
		//login success
			$_SESSION['id']=$user_id;
			$_SESSION['username']=$user['username'];
			$_SESSION['email']=$user['email'];
			$_SESSION['verified']=$user['verified'];

			//flash message
			$_SESSION['message']="You are now loged in";
			$_SESSION['alert-class']="alert-success";
			header('location: mainafterlogin.php');
			exit();

	}
	else{
		$errors['login_fail']="Wrong credentials";
	}

	}

}

//logout user
if (isset($_POST['logout'])) {
	session_destroy();
	unset($_SESSION['id']);
	unset($_SESSION['username']);
	unset($_SESSION['email']);
	unset($_SESSION['firstname']);
	unset($_SESSION['verified']);
	header('location: index.php');
	exit();

}