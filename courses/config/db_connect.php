<?php 
	$conn = mysqli_connect('localhost', 'meriise_user', 'VXF@M6Ym55Ndv29', 'courses_meriise');
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}

?>
