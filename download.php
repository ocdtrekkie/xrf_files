<?php
require_once("includes/global.php");
require_once("includes/functions_dl.php");
require_once("includes/header.php");

$id = $_GET['id'];
$id=(int)$id;
$key = "";
$authed = 0;
$query="SELECT * FROM d_files WHERE id='$id'";
$result=mysqli_query($xrf_db, $query);

$name=xrf_mysql_result($result,0,"name");
$filename=xrf_mysql_result($result,0,"filename");
$dlcount=xrf_mysql_result($result,0,"dlcount");
$private=xrf_mysql_result($result,0,"private");
$pid=xrf_mysql_result($result,0,"pid");

if ($private == 2)
{
	$authed = xrfd_check_license($xrf_db, $xrf_myid, $pid);
}

if ($private == 0 || ($private == 1 && $xrf_myulevel > 1) || ($private == 2 && $authed == 1))
{
	$dlcount=$dlcount+1;
	$query="UPDATE d_files SET dlcount=$dlcount WHERE id='$id'";
	mysqli_query($xrf_db, $query);
	echo "Downloading $name";
	echo "<meta http-equiv=\"REFRESH\" content=\"2;url=$filename\">
	<br>Downloading... in 2 seconds <a href=$filename>Click here</a> if you dont wish to wait any longer.";
}
else
{
echo "You are not authorized to download this file.";
}
	
require_once("includes/footer.php");
?>