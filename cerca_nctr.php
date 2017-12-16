<!-- disattivato LOGIN 
<?php # if (isset($_COOKIE["login"])){ ?>
-->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Cerca per foglio e mappale</title>


<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="cxc.css" type="text/css" media="all">
<!-- CSS -->
<style type="text/css">
	Body {
	text-align: center;
	}
.myForm {
font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
font-size: 0.8em;
padding: 1em;
border: 1px solid #ccc;
border-radius: 3px;
}

.myForm * {
box-sizing: border-box;
}

.myForm label {
font-size: 0.9em;
}

.myForm .audioOnly {
position: absolute;
width: 1px;
height: 1px;
padding: 0;
margin: -1px;
overflow: hidden;
clip: rect(0, 0, 0, 0);
border: 0;
}

h3 {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

.myForm input {
border: 1px solid #ccc;
border-radius: 3px;
font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
font-size: 0.9em;
padding: 0.5em;
}

.myForm input[type="f"],
.myForm input[type="m"] {
width: 12em;
}

.myForm button {
padding: 0.7em;
border-radius: 0.5em;
background: #eee;
border: none;
font-weight: bold;
margin-left: 1.5em;
}

 .myForm button:hover {
background: #ccc;
cursor: pointer;
}
</style>

</head>
<body>
<?php
include "testata.php";
?>
<label><h3>Ricerca per foglio e mappale</h3></label>
<form class="myForm" method="get" enctype="application/x-www-form-urlencoded" action="nctr_results.php">
<label class="input"  for="f">foglio</label> 
<input type="text" name="f" value=""  required placeholder="foglio">
<label class="input" for="m">mappale</label> 
<input type="text" name="m" required placeholder="mappale">



<!--
<label>
<input type="checkbox"> Remember me
</label>



<button>invia</button>
-->

<input type="submit" value="INVIA">
</form>

</body>
</html>
<!-- disattivato LOGIN
<?php # } ?>
-->
