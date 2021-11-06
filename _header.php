<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php wp_head(); ?>
</head>
<body>
	<form action="<?php print site_url(); ?>" method="get">
	<input type="text" value="<?php if( isset($_GET['s'] ) ) echo $_GET['s']; ?>" placeholder="Search here..." />
	<input type="submit" value="Search Our Site"  />
</form>