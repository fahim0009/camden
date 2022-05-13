<?php
session_start();
if(isset($_SESSION["uid"])){
	header("location:profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>- Delivering Real Indian Food</title>

<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<link href="css/div_styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="style.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">


<!-- <script src="js/fadein.js" type="text/javascript"></script> -->


<script src="js/jquery2.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="main.js"></script>

<style>
ul {
  list-style-type: none;
}



form {
	margin-bottom: 1em;
}

h1{
	font-family: 'Arvo', Georgia, Times, serif;
	font-size: 59px;
	line-height: 70px;
}

p {
	font-family: 'PT Sans', Helvetica, Arial, sans-serif;
	font-size: 16px;
	line-height: 25px;
}

.footer{
	padding-top: 1em;
	color: gray;
}

#about {
	padding-top: 50px;
	background-color: lightgray;
}
#projects {
	padding-top: 30px;
	background-color: darkgray;
}
#contact {
	padding-top: 30px;
	background-color: gray;
}
#myfooter {
	background-color: lightgray;
}

#custom-bootstrap-menu.navbar-default .navbar-brand {
    color: rgba(255, 255, 255, 1);
}
#custom-bootstrap-menu.navbar-default {
		font-family: 'Arvo', Georgia, Times, serif;
    font-size: 14px;
    background-color: rgba(0, 0, 0, 1);
    border-width: 0px;
    border-radius: 0px;
}
#custom-bootstrap-menu.navbar-default .navbar-nav>li>a {
    color: rgba(143, 143, 143, 1);
    background-color: rgba(0, 0, 0, 1);
}
#custom-bootstrap-menu.navbar-default .navbar-nav>li>a:hover,
#custom-bootstrap-menu.navbar-default .navbar-nav>li>a:focus {
    color: rgba(255, 255, 255, 1);
    background-color: rgba(248, 248, 248, 0);
}
#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a,
#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a:hover,
#custom-bootstrap-menu.navbar-default .navbar-nav>.active>a:focus {
    color: rgba(255, 255, 255, 1);
    background-color: rgba(89, 89, 89, 1);
}
#custom-bootstrap-menu.navbar-default .navbar-toggle {
    border-color: #595959;
}
#custom-bootstrap-menu.navbar-default .navbar-toggle:hover,
#custom-bootstrap-menu.navbar-default .navbar-toggle:focus {
    background-color: #595959;
}
#custom-bootstrap-menu.navbar-default .navbar-toggle .icon-bar {
    background-color: #595959;
}
#custom-bootstrap-menu.navbar-default .navbar-toggle:hover .icon-bar,
#custom-bootstrap-menu.navbar-default .navbar-toggle:focus .icon-bar {
    background-color: #000000;
}


/* Style all font awesome icons */
.fa {
    padding: 20px;
    font-size: 30px;
    width: 50px;
    text-align: center;
    text-decoration: none;
		color: white;
}

/* Add a hover effect if you want */
.fa:hover {
    opacity: 0.7;
	text-decoration: none;
}
	.resize{
		
		height: 80px;
		
	}
	
	
</style>

</head>
<body>
    
	<!-- top navigation menu -->
<nav id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top">
 <div class="container-fluid">
  <div class="row resize">
   <div class="col-md-1"></div>
   <div class="col-md-10" style="padding-top: 15px">
    <div class="navbar-header">
     <a class="navbar-brand" href="#"><img src="images/img_1118.jpg" height="25px" width="224px"></a>
    </div>
    <ul class="nav navbar-nav navbar-right">
     <li><a href="#about">HOME</a></li>
     <li><a href="#projects">ABOUT</a></li>
     <li><a href="#contact">MENU</a></li>
     <li><a href="#contact">GALLERY</a></li>
     <li><a href="#contact">OrderOnline</a></li>
    </ul>
   </div>
   <div class="col-md-1"></div>
  </div>
	 </div>
</nav>
	<br><br><br><br><br>
<!-- content -->

