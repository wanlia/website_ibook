<? include("head.php");
include("connect.php");
include("functions/input_validators.php");

$numrows = -1;

if(isset($_GET['dept']) && isset($_GET['courseNo'])) {

	$myDept = quote_smart($_GET['dept']);
	$myCourseNo = $_GET['courseNo'];

	$q = "SELECT * FROM `Textbooks` WHERE dept='$myDept' AND courseNo='$myCourseNo' ORDER BY `dept`,`courseNo`,`author` ASC";
	$result= mysql_query($q, $db_handle) or die("Could not execute query : $q." . mysql_error());
	$numrows = mysql_num_rows($result);
}

else if(isset($_GET['searchFor']) && isset($_GET['t_a_i'])) {

	$searchFor = $_GET['searchFor'];
	$t_a_i = $_GET['t_a_i'];

	$searchFor_array = explode(" ",$searchFor);

	// Build SQL Query for each keyword entered
	foreach ($searchFor_array as $searchFor2){

	// EDIT HERE and specify your table and field names for the SQL query

     	$q = "SELECT * FROM `Textbooks` WHERE $t_a_i LIKE \"%$searchFor2%\" ORDER BY `dept`,`courseNo`,`author` ASC";

	$result= mysql_query($q, $db_handle) or die("Could not execute query : $q." . mysql_error());
	$numrows = mysql_num_rows($result);
	}
}
?>

<h2>Textbook Search</h2>

<div class="search">
<h4>Search Textbooks By Course</h4>
<form name="textbook_search_by_course" method="GET" action="textbook_search.php">
	Department (eg. ENGL): <input type="text" name="dept" size="4" value="<? print $myDept ?>">
	Course Number (eg. 101): <input type="text" name="courseNo" size="3" value="<? print $myCourseNo ?>">
	<input type="submit" value="Search">
</form>
</div>

<div class="search">
<h4>Keyword Textbook Search</h4>
<form name="textbook_search" method="GET" action="textbook_search.php">
Search For: <input type="text" name="searchFor" size="13" value="<? print $searchFor ?>"> in
<select class="textbook_search" name="t_a_i">
  <option value="title">Title </option>
  <option value="author">Author</option>
  <option value="isbn">ISBN</option>
</select>
<input type="submit" value="Search">
</form>
</div>

<?
if($numrows == -1) {

}


else if($numrows == 0) {
print "<h3>Search Results</h3>";

	print("Could not find any textbooks that fit search parameters. Please try again");
	}


else {
print "<h3>Search Results</h3>";

	print "<table class=\"textbooks\">
		<tr>
		<td>Course</td>
		<td>ISBN</td>
		<td>Author</td>
		<td>Title</td>
		<td>New Price</td>
		</tr>";

	while ($row=mysql_fetch_array($result)) {
		$ISBN=$row["ISBN"];
		$dept=$row["dept"];
		$courseNo=$row["courseNo"];
		$title=$row["title"];
		$author=$row["author"];
		$edition=$row["edition"];
		$newPrice=$row["newPrice"];

		print "<tr>";
		print "<td>$dept$courseNo</td> <td>$ISBN</td> <td>$author</td> <td>$title $edition/E</td> <td>$newPrice</td>";
		print "</tr>";
	}

	print "</table>";
	}


?>

<? include("foot.php"); ?>