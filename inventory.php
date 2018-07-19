
<h2>Inventory List</h2>

<b><u>Note: We do not guarantee the book will still be in store.</u></b>
<br>
<?php

// this prevents fgetscsv from returning csv data in one array
ini_set('auto_detect_line_endings', true);

// retrieved from http://stackoverflow.com/questions/518795/dynamically-display-a-csv-file-as-an-html-table-on-a-web-page
function jj_readcsv($filename, $header=false) {
$handle = fopen($filename, "r");
echo '<table class="textbooks">';
//display header row if true
if ($header) {
	$csvcontents = fgetcsv($handle);
	echo '<tr>';
	foreach ($csvcontents as $headercolumn) {
		echo "<th>$headercolumn</th>";
	}
	echo '</tr>';
}
// displaying contents
while ($csvcontents = fgetcsv($handle)) {
	echo '<tr>';
	foreach ($csvcontents as $column) {
		echo "<td>$column</td>";
	}
	echo '</tr>';
}
echo '</table>';
fclose($handle);
}

jj_readcsv("inventory_list.csv", true);

?>