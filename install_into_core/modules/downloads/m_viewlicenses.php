<?php
require("ismodule.php");
echo "<p><b>Your Purchased Licenses</b><p>";

$query="SELECT * FROM d_licenses WHERE uid = $xrf_myid";
$result=mysql_query($query);
$num=mysql_num_rows($result);

if ($num > 0)
{
echo "<table><tr><td width=400><b>Product<br><i>Expiry</i></b><td width=400><b>License<br><i>Assigned</i></b></td></tr>";
$qq=0;
while ($qq < $num) {

$id=mysql_result($result,$qq,"id");
$pid=mysql_result($result,$qq,"pid");
$lic_key=mysql_result($result,$qq,"lic_key");
$assigned=mysql_result($result,$qq,"assigned");
$expiry=mysql_result($result,$qq,"expiry");

$pquery="SELECT descr FROM d_products WHERE id = '$pid'";
$presult=mysql_query($pquery);
$productname=mysql_result($presult,0,"descr");

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