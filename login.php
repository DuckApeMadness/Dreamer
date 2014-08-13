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
else
{
$lan = 'en';
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
		<link rel='stylesheet' href='css/bootstrap.css'>
		<meta charset='UTF-8'>
		<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src='js/bootstrap.js'></script>
		<title>Fall asleep</title>
	</head>
	<body id="loginBody">
		<table id="loginPage">
			<tr>
				<td>
					<?php
						if(isset($_POST['submit']))
						{
							$email=$_POST['email'];
							$password = md5($_POST['password']);
							//Vai lauki nav tukši
							if($password<>"" && $email<>"")
							{
								//Savienojas ar datubāzi
								
								$con = mysql_connect('localhost', 'root', 'muabkoka');
								if(!$con)
								{
									die('Could not connect: '.mysql_error());
								}
								mysql_select_db('dreamer', $con);
								//Pārbauda vienādos lietotājus
								if(mysql_num_rows(mysql_query("SELECT * FROM users where email = '$email' && password = '$password'")) == true)
								{
									if(mysql_num_rows(mysql_query("SELECT * FROM users where online = '0' && password = '$password'")) == true)
									{
										$con=mysqli_connect("localhost","root","muabkoka","dreamer");
										// Check connection
										if (mysqli_connect_errno()) {
										  echo "Failed to connect to MySQL: " . mysqli_connect_error();
										}

										mysqli_query($con,"UPDATE users SET online=1
										WHERE email='$email' AND password='$password'");

										mysqli_close($con);
									}else{
										echo "<script>alert('Already logged in');</script>";
									}
								}else{
									echo "<div id='error'>Incorrect data !</div>";
								}
							}else{
								echo "<div id='error'>Fill all fields !</div>";
							}
						}
					?>
					<div id="floatingBoxLogin" class="greenBox">
						<h1>Dreamer</h1>
						<form method="POST">
							<input type="text" name="email" class="logFields" placeholder='<?php echo $lan['PLACEHOLDER1'];?>'><br>
							<input type="password" name="password" class="logFields" placeholder='<?php echo $lan['PLACEHOLDER2'];?>'><br>
							<input type="submit" name="submit" class="btnBlue" value="<?php echo $lan['FALL'];?>">
							<a id='links2' href='register.php'><?php echo $lan['NEW'];?></a>
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
					<a href='#lang' data-toggle='modal'><p class='footerText'><?php echo $lan['LANGUAGES'];?></p></a>
					<a href='?lan=en' class='footerText'>En</a>
					<a href='?lan=lv' class='footerText'>Lv</a><br>
					<p class='footerCop'><?php echo $lan['AUTORI'];?></p>
				</td>
			</tr>
		</table>
		<!--Languages-->
			<div class="modal fade bs-example-modal-sm" id="lang" tabindex="-1" role="dialog" aria-labelledby="languages" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
					<h4 class="modal-title" id="languages">All selectable languages</h4>
				  </div>
				  <div class="modal-body">
					<ul style='	text-align: center; list-style-type: none;'>
						<li>
							<a href='?lan=en' id='langText'>EN-English</a><br>
							<a href='?lan=lv' id='langText'>LV-Latviski</a><br>
							<a id='langText'>LT-Lietuvių kalba</a><br>
							<a id='langText'>ST-Eesti keeles</a><br>
							<a id='langText'>IT-In italiano</a><br>
							<a id='langText'>DE-Deutsche Sprache</a><br>
							<a id='langText'>FR-En Français</a><br>
							<a id='langText'>PL-Polski</a><br>
							<a id='langText'>DN-Dansk sprog</a><br>
							<a id='langText'>CZ-Český jazyk</a><br>
						</li>
					</ul>
				  </div>
				  <div class="modal-footer">
					<button style='margin-left: auto; margin-right: auto; display: block;' type="button" class="btnBlue" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
	</body>
</html>