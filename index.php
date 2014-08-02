<?php 
	session_start(); 
	function base() {
		return "/game-of-life/";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Game of Life</title>
	<link rel="stylesheet" href="game.css" />
	<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico">
	<base href="<?php echo base(); ?>">
</head>
<body>
	<div class="main">	
		<?php include 'game.php'; ?>		
	</div>
</body>
</html>