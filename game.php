<?php require_once 'blocks.php'; ?>

<div class="grid">
	<?php
		$cols = 20;
		$rows = 20;
		if (isset($_GET['cell'])) {
			$cell = (int)$_GET['cell'];
			$cells = $_SESSION['cells'];
			// validate cell param
			if ($cell >= 0 && $cell < $cols*$rows) {
				// toggle clicked cell			
				$cells[$cell] = ($cells[$cell] == 'alive') ? 'dead' : 'alive';
			}
		} elseif ($_POST) {
			// advance cells a generation		
			$cells = json_decode($_POST['cells']);
			$cells = update_cells($cells, $cols, $rows);
			$_SESSION['generation'] = (!empty($_SESSION['generation'])) ? $_SESSION['generation'] + 1 : 1;
		} else {
			// setup initial conditions
			$cells = dead_cells($cols*$rows);			
			$cells[150] = 'alive';
			$cells[170] = 'alive';
			$cells[171] = 'alive';
			$cells[169] = 'alive';
			$_SESSION['generation'] = 0;			
		}
		$_SESSION['cells'] = $cells;
		update_board($cells);
	?>
</div>

<form action="<?php echo base(); ?>" method="post">
	<input type="hidden" name="cells" value='<?php echo json_encode($cells); ?>' />
	<div>Generation: <?php echo $_SESSION['generation']; ?></div>
	<input type="submit" />
	<a href="<?php echo base(); ?>">Reset</a>
</form>