<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Chemistry Awards System - University of Michigan</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META content="" name=KEYWORDS>
<META content="" name=description>

<link rel="stylesheet" href="../eebstyle.css">

</head>

<body>
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../support/awards_dbConnect.inc');
require_once('nav.php');
$year = $purifier->purify($_REQUEST['year']);
if ($year == '') {
   $year = $report_year;
}
   
		
$id = $purifier->purify($_REQUEST[id]);
if ($id == "") {
     $uniqname = $purifier->purify($_REQUEST[uniqname]);
     $sql = "SELECT faculty.`id`, `uniqname`, `Name`, faculty.`Rank`, rank.rank as rank, `Year_PhD`, `birth_year`, `Appt_Start`  FROM `faculty`, rank  WHERE rank.id = faculty.Rank AND faculty.uniqname = '$uniqname'";
}
else {
#show Faculty  record
	$sql = "SELECT faculty.`id`, `uniqname`, `Name`, faculty.`Rank`, rank.rank as rank, `Year_PhD`, `birth_year`, `Appt_Start`  FROM `faculty`, rank  WHERE rank.id = faculty.Rank AND faculty.id = '$id'";
}
//echo $sql;
$result=mysqli_query($conn, $sql) or die("There was an error: ".mysqli_error($conn));
	$adata = mysqli_fetch_array($result, MYSQLI_BOTH);
$maxid = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(id) FROM faculty"), MYSQLI_NUM)[0];
$minid = mysqli_fetch_array(mysqli_query($conn, "SELECT MIN(id) FROM faculty"), MYSQLI_NUM)[0];

	//Everything is peachy, pull record.
$uniqname = $adata['uniqname'];
?>	

<table>
<tr>
        <th>uniqname<br> (click to edit)</th>
        <th>Name</a></th>
        <th>Rank</a></th>
        <th>Year Phd</th>
        <th>Birth Year</th>
        <th>Appt Start</th>

<tr>
<td><a href='edit_faculty.php?id=<?php echo $adata[id]; ?>'><?php echo $uniqname; ?></a></td>  
<td> <?php print($adata['Name']) ?> 
<td> <?php print($adata['rank']) ?> 
<td> <?php print($adata['Year_PhD']) ?> 
<td> <?php print($adata['birth_year']) ?> 
<td> <?php print($adata['Appt_Start']) ?> 
</table>
		<br><div align="center"><img src="../images/linecalendarpopup500.jpg"></div><br>
			
<form name='form2' action='facultyone.php' method='post'>
<input type="hidden" name="uniqname" id="uniqname" value="<?php echo $uniqname; ?>">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
<?php
// faculty information
$sql = "SELECT DISTINCT(year) FROM faculty_data ORDER BY year";
$result = mysqli_query($conn, $sql) or die("Query failed :".mysqli_error($conn));
    echo "<select name='year' id='info' onchange='this.form.submit()'>";
    echo "<option select value='error'> - choose year -</option>";

       while ($data = mysqli_fetch_array($result, MYSQLI_BOTH))
        {
           echo "<option";
           if ($data[year] == $year) { echo " selected"; }
           echo " value='$data[year]'>$data[year]</option>";
        }
    echo "</select><br><br>";
echo "<div id='txtHint'></div>";
$sql = "SELECT question, answer FROM faculty_data WHERE uniqname = '$uniqname' AND year = '$year'";
$result = mysqli_query($conn, $sql) or die("Query failed :".mysqli_error($conn));
echo "<table>";
while ($qdata = mysqli_fetch_array($result, MYSQLI_BOTH))  {

echo "<tr><th>";
echo $qdata['question'];
echo "<td>";
   echo $qdata['answer'];
}
echo "</table><br><br>";

echo "<table>";

$sql1 = "SELECT * FROM faculty_letters WHERE uniqname = '$uniqname' ORDER BY type";
//echo $sql1;
$result1 = mysqli_query($conn, $sql1) or die ("Query failed : " . mysqli_error($conn));
WHILE ($recUpload = mysqli_fetch_array($result1, MYSQLI_BOTH))
<<<<<<< HEAD
        { ?>
              <tr><td> <?php print("$recUpload[type]") ?> :</td><td>
                 <?php print("<a href=\"http://apps-prod.chem.lsa.umich.edu/chem-awards/uploadfiles/$recUpload[link]\" target=\"_blank\"> $recUpload[link]</a>") ?><br>
              <td> <?php print("$recUpload[upload_date]") ?></td>
=======
        { $link = $uploaddir . $recUpload[link];
 ?>
              <tr><td> <? print("$recUpload[type]") ?> :</td><td>
                 <? print("<a href=". $link . " target=\"_blank\"> $recUpload[link]</a>") ?><br>
              <td> <? print("$recUpload[upload_date]") ?></td>
>>>>>>> master

                <?php
        }//while
?>
</table>
<form>
		<br><div align="center"><img src="../images/linecalendarpopup500.jpg"></div><br>


</div>   
</div> 
</script>
<script type="text/javascript">
function getinfo(str) {
console.log(str);

    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        var uniqname = document.getElementById('uniqname');
        uniqname = [uniqname.value];
console.log(uniqname);
        xmlhttp.open("GET","getFaculyInfo.php?q="+str+"&uniqname="+uniqname,true);
        xmlhttp.send();
    }
}

</script>
</body>
</html>

