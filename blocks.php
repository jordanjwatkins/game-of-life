<?php 
	/* 
		Game of Life Rules:
		If a cell is empty and there are exactly three neighbors, populate the cell.
		If a cell is populated and there are fewer than two or greater than three neighbors, empty the cell.
	*/
	
	function update_cells($cells, $cols, $rows)
	{
		// make a copy of current state of all cells
		$cells_original = $cells;
		
		// check each cell to see if it should switch state according to the game of life rules
		foreach ($cells as $key => $cell) {
			$type = get_cell_type($key, $cols, $rows);
			$live_neighbors = live_neighbors($key, $type, $cells_original, $cols);		
			if ($cell == 'dead') {			
				if ($live_neighbors == 3) {
					$cells[$key] = 'alive';
				}
			} elseif ($live_neighbors < 2 || $live_neighbors > 3) {
				$cells[$key] = 'dead';			
			}
		}
		return $cells;
	}
	
	function get_cell_type($cell, $cols, $rows) 
	{
		$type = '';
		if ($cell == 0) {
			$type = 'ul';
		} elseif ($cell>0 && $cell<$cols-1) {
			$type = 'us';
		} elseif ($cell == $cols-1){
			$type = 'ur';
		} elseif ($cell%$cols == 0 && $cell<($rows-1)*$cols ) {
			$type = 'ls';
		} elseif (($cell+1)%$cols == 0 && $cell<$rows*$cols-1) {
			$type = 'rs';
		} elseif ($cell==($rows-1)*$cols) {
			$type = 'bl';
		} elseif ($cell==$rows*$cols-1) {
			$type = 'br';
		} elseif ($cell<$rows*$cols-1 && $cell>($rows-1)*$cols) {
			$type = 'bs';
		} else {
			$type = 'mid';
		}
		return $type;
	}
	
	// count a cell's living neighbors
	function live_neighbors($key, $type, $cells, $cols)
	{
		$live_neighbors = 0;
		if ($type !== 'ur' && $type !== 'rs' && $type !== 'br' && $cells[$key+1] == 'alive') {
			$live_neighbors++;
		}
		if ($type !== 'ul' && $type !== 'ls' && $type !== 'bl' && $cells[$key-1] == 'alive') {
			$live_neighbors++;
		}
		if ($type !== 'bl' && $type !== 'bs' && $type !== 'br' && $cells[$key+$cols] == 'alive') {
			$live_neighbors++;
		}
		if ($type !== 'ur' && $type !== 'rs' && $type !== 'br' && $type !== 'bl' && $type !== 'bs' && $cells[$key+$cols+1] == 'alive') {
			$live_neighbors++;
		}
		if ($type !== 'ul' && $type !== 'ls' && $type !== 'br' && $type !== 'bl' && $type !== 'bs' && $cells[$key+$cols-1] == 'alive') {
			$live_neighbors++;
		}	
		if ($type !== 'ul' && $type !== 'us' && $type !== 'ur' && $cells[$key-$cols] == 'alive') {
			$live_neighbors++;
		}		
		if ($type !== 'ul' && $type !== 'ls' && $type !== 'us' && $type !== 'bl' && $type !== 'ur' && $cells[$key-$cols-1] == 'alive') {
			$live_neighbors++;
		}	
		if ($type !== 'ul' && $type !== 'us' && $type !== 'br' && $type !== 'ur' && $type !== 'rs' && $cells[$key-$cols+1] == 'alive') {
			$live_neighbors++;
		}
		return $live_neighbors;
	}
	
	// create an array of dead cells
	function dead_cells($cell_count)
	{
		$cells = array();
		for ($i=0; $i<$cell_count; $i++) {
			$cells[] = 'dead'; 
		}
		return $cells;
	}
	
	// update the dom representation of the state of all cells
	function update_board($cells)
	{
		foreach ($cells as $key => $cell) {
			if ($cell !== 'alive') {
				$status = 'dead';
			} else {
				$status = 'alive';
			}
			echo '<div class="'.$status.'"><a href="'.base().'?cell='.$key.'"></a></div>';
		}
	}
	
	// debugging helper
	function console_debug($data) 
	{
		$data = json_encode($data);
		echo "<script>console.dir($data)</script>";
	}