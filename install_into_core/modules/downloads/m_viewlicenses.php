<?php
require("ismodule.php");
echo "<p><b>Your Purchased Licenses</b><p>";

$query="SELECT * FROM d_licenses WHERE uid = $xrf_myid";
$result=mysqli_query($xrf_db, $query);
$num=mysqli_num_rows($result);

if ($num > 0)
{
echo "<table><tr><td width=400><b>Product<br><i>Expiry</i></b><td width=400><b>License<br><i>Assigned</i></b></td></tr>";
$qq=0;
while ($qq < $num) {

$id=xrf_mysql_result($result,$qq,"id");
$pid=xrf_mysql_result($result,$qq,"pid");
$lic_key=xrf_mysql_result($result,$qq,"lic_key");
$assigned=xrf_mysql_result($result,$qq,"assigned");
$expiry=xrf_mysql_result($result,$qq,"expiry");

$pquery="SELECT descr FROM d_products WHERE id = '$pid'";
$presult=mysqli_query($xrf_db, $pquery);
$productname=xrf_mysql_result($presult,0,"descr");

if ($expiry == "0")
	$expiry = "Never";
else
{
	if (strtotime($expiry) < time())
		$expiry = "<font color=\"red\"><b>$expiry</b></font>";
}

echo "<tr><td>$productname<br><font size=2><i>Expires: $expiry</i></font></td><td>$lic_key<br><font size=2><i>$assigned</i></font></td></tr>";

$qq++;
}
}
else
{
echo "You have not purchased any licenses.";
}

echo "</table>";
?>