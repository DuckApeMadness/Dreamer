<?php
session_start();
header('Cache-control: private'); // IE 6 FIX
 
if(isset($_GET['lan']))
{
$lan = $_GET['lan'];
 
// register the session and set the cookie
$_SESSION['lan'] = $lan;
 
setcookie('lan', $lan, time() + (3600 * 24 * 30));
}
else if(isset($_SESSION['lan']))
{
$lan = $_SESSION['lan'];
}
else if(isset($_COOKIE['lan']))
{
$lan = $_COOKIE['lan'];
}
 
switch ($lan) {
  case 'en':
  $lan_file = 'en.php';
  break;
 
  case 'lv':
  $lan_file = 'lv.php';
  break;
 
  default:
  $lan_file = 'en.php';
 
}
 
include_once 'languages/'.$lan_file;
?>
<html>
	<head>
		<link rel='stylesheet' type='text/css' href='style.css'>
		<link rel='stylesheet' type='text/css' href='css/bootstrap.css'>
		<meta charset='UTF-8'>
		<title>Registration</title>
	</head>
	<body id="loginBody">
		<table id="loginPage">
			<tr>
				<td>
					<?php
						if(isset($_POST['submit']))
						{
							$fname=$_POST['fname'];
							$lname=$_POST['lname'];
							$pass=$_POST['pass'];
							$rpass=$_POST['rpass'];
							$email=$_POST['email'];
							$gender=$_POST['gender'];
							//Vai lauki nav tukši
							if($fname<>"" && $lname<>"" && $pass<>"" && $rpass<>"" && $email<>"")
							{
											//Vai paroles sakrīt
								if($pass == $rpass)
								{
										//Savienojas ar datubāzi
										$con = mysql_connect('localhost', 'root', 'muabkoka');
										if(!$con)
										{
											die('Could not connect: '.mysql_error());
										}
										mysql_select_db('dreamer', $con);
										//Pārbauda vienādos lietotājus
										if(mysql_num_rows(mysql_query("SELECT * FROM users where email = '$email'")) == false)
										{
											//Piereģistrē
											$pass = md5($pass);
											mysql_query("INSERT INTO users (id, email, first_name, last_name, gender, password) VALUES ('', '$email', '$fname', '$lname', '$gender', '$pass')");
											echo "<div id='success'>Registration successful :)</div>";
										}else{
											echo "<div id='error'>Email already exists !</div>";
										}
								}else{
									echo "<div id='error'>The passwords do not match !</div>";
								}
							}else{
								echo "<div id='error'>Fill all fields !</div>";
							}
						}
					?>
					<div id="floatingBoxLogin" class="greenBox">
						<h1>Dreamer</h1>
						<form method="POST">
							<input autocomplete="off" type="text" name="fname" class="regField1" placeholder='<?php echo $lan['F1'];?>'><br>
							<input autocomplete="off" type="text" name="lname" class="regField1" placeholder='<?php echo $lan['F2'];?>'><br>
							<input type="password" name="pass" class="regField1" placeholder='<?php echo $lan['F3'];?>'><br>
							<input type="password" name="rpass" class="regField1" placeholder='<?php echo $lan['F4'];?>'><br>
							<input data-toggle="tooltip" data-placement="left" title="<?php echo $lan['TIP'];?>" autocomplete="off" type="text" name="email" class="regField1" placeholder='<?php echo $lan['F5'];?>'><br>
							<select name='gender' class='regField1'>
								<option disabled value='selectGender'><?php echo $lan['F6'];?></option>
								<option value="Male"><?php echo $lan['F7'];?></option>
								<option value="Female"><?php echo $lan['F8'];?></option>
								<option value="Other"><?php echo $lan['F9'];?></option>
							</select><br>
							<input type="submit" name="submit" class="btnBlue" value="<?php echo $lan['F10'];?>">
							<a href='login.php' id='links'><?php echo $lan['F11'];?></a>
						</form>
					</div>
				</td>
			</tr>
			<tr>
				<td id="aboutUsLogin" class="copyBox">
					<a href='https://www.youtube.com/user/DuckAndApeMadness' class='footerText'>Youtube</a>
					<a href='https://www.youtube.com/user/DuckAndApeMadness' class='footerText'>Twitter</a>
					<a href='' class='footerText'><?php echo $lan['ABOUT'];?></a>
					<a href='' class='footerText'><?php echo $lan['RULES'];?></a>
					<a href='' class='footerText'><?php echo $lan['CONTACTS'];?></a>
					<a href='' class='footerText'><?php echo $lan['PROBLEM'];?></a>
					<p class='footerText'>|</p>
					<p class='footerText'><?php echo $lan['LANGUAGES'];?></p>
					<a href='?lan=en' class='footerText'>En</a>
					<a href='?lan=lv' class='footerText'>Lv</a><br>
					<p class='footerCop'><?php echo $lan['AUTORI'];?></p>
				</td>
			</tr>
		</table>
	</body>
</html>