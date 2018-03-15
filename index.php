<?php
$baza1='baza1';
$databaze = mysqli_connect('localhost', 'root', '', $baza1);
 
	$Tables = mysqli_query($databaze, "SHOW TABLES");
	$b1=array();
		while($t = mysqli_fetch_array($Tables))
		{

			$table=$t['Tables_in_'.$baza1];
			$b1[] = $table; 
			
		}		


	$databaze->close();

?>

<?php

$baza2 = 'baza2';
$databaze = mysqli_connect('localhost', 'root', '', $baza2);
 
	$Tables = mysqli_query($databaze, "SHOW TABLES");
		
	$b2 = array();	
		
		while($t = mysqli_fetch_array($Tables))
		{
			
			$table=$t['Tables_in_'.$baza2];
			$b2[] = $table; 
			
		}
			

	$databaze->close();


?>

  <?php
 
$diff1 = array_diff($b2, $b1);
echo '<B>tablice, które są w bazie '.$baza2.', a nie ma ich w bazie '.$baza1.' - '.count ($diff1).' </B>';
foreach ($diff1 as $item) {
    echo $item.', ';
}
echo '</br>';
echo '</br>';

$diff2 = array_diff($b1, $b2);
echo '<B>tablice, które są w bazie '.$baza1.', a nie ma ich w bazie '.$baza2.', - '.count ($diff2).' </B>';
foreach ($diff2 as $item) {
    echo $item.', ';
}
echo '</br>';
echo '</br>';


  ?>

  <B> Tablice o tej samej nazwie </B>

<?php
$tt=array();

$databaze_a = mysqli_connect('localhost', 'root', '', $baza1);
$databaze_b = mysqli_connect('localhost', 'root', '', $baza2);
	 
		$inters = array_intersect($b1, $b2);		
		echo count($inters);
		foreach ($inters as $table)
		{
			echo '<div style="width:100%;" ><div id="b1" style="width:35%; float:left;">';
			
				$j=0;$col_b1 = array();
				echo 'b1 <B>'.$table.'</B></br><table border="2px">';
				$Columns_b1 = mysqli_query($databaze_a, "SHOW COLUMNS FROM $table");
				while($c = mysqli_fetch_array($Columns_b1))
				{
					$j=$j+1;
					$col_b1[]=$c['Field'];
					echo '<tr><td>'.$j.'</td><td>'.$c['Field'].'</td><td>'.$c['Type'].'</td></tr>';
					//<td>'.$c['Type'].'</td>
				}
				echo '</table></br>';
				
			echo '</div><div id="b2" style="width:35%; float:left;">';
				
				$j=0;$col_b2 = array();
				echo 'b2 <B>'.$table.'</B></br><table border="2px">';
				$Columns_b2 = mysqli_query($databaze_b, "SHOW COLUMNS FROM $table");
				while($c = mysqli_fetch_array($Columns_b2))
				{
					$j=$j+1;
					$col_b2[]=$c['Field'];
					echo '<tr><td>'.$j.'</td><td>'.$c['Field'].'</td><td>'.$c['Type'].'</td></tr>';
					//<td>'.$c['Type'].'</td>
				}
				echo '</table></br>';			
			echo '</div><div id="footer" style="clear: both; width: 100%;">';
			
			
			
			$diff1 = array_diff($col_b1, $col_b2 );
			if($diff1){
			echo '<B> elementy, które są w bazie '.$baza1.', a nie ma ich w bazie '.$baza2.'  - </B>';
			foreach ($diff1 as $item) {
				echo $item.', ';
				
			}
			}
			
			echo '</br>';
			$diff2 = array_diff($col_b2,$col_b1);
			if($diff2){
			echo '<B>elementy, które są w bazie '.$baza2.', a nie ma ich w bazie '.$baza1.' - </B>';
			foreach ($diff2 as $item) {
				echo $item.', ';
			
			}
			}
			
			if($diff1 == array() && $diff2 == array())
			{
				$tt[]=$table;
				echo ' ok ';
			}
			
			
			echo '<hr /></div></div>';
			
		unset($col_b2);
		unset($col_b1);
			
		}

	$databaze_a->close();
	$databaze_b->close();
	
	echo '<B>tabele do skopiowania: '.count($tt).'</B> ';
	foreach ($tt as $item) {
				echo $item.', ';
			}
?>
</div>









