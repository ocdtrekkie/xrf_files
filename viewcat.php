<?php
require_once("includes/global.php");
require_once("includes/functions_bbc.php");
require_once("includes/functions_dl.php");
require_once("includes/header.php");

$id = $_GET['id'];
$id=(int)$id;
$query="SELECT * FROM d_categories WHERE id='$id'";
$result=mysqli_query($xrf_db, $query);
$cid=xrf_mysql_result($result,$qq,"id");
$cdesc=xrf_mysql_result($result,$qq,"descr");
$cpriv=xrf_mysql_result($result,$qq,"private");

if ($cpriv == 0 || ($cpriv == 1 && $xrf_myid != 0))
{

echo "<font size=5><b>Category: $cdesc</b></font>";

$query="SELECT * FROM d_files WHERE cid='$cid' ORDER BY dlcount DESC, name ASC";
$result=mysqli_query($xrf_db, $query);
$num=mysqli_num_rows($result);

$qq=0;
while ($qq < $num) {

$key = "";
$authed = 0;
$fid=xrf_mysql_result($result,$qq,"id");
$fname=xrf_mysql_result($result,$qq,"name");
$fver=xrf_mysql_result($result,$qq,"version");
$fauth=xrf_mysql_result($result,$qq,"author");
$fdesc=xrf_mysql_result($result,$qq,"descr");
$ficon=xrf_mysql_result($result,$qq,"iconname");
$fsize=xrf_mysql_result($result,$qq,"filesize");
$fpriv=xrf_mysql_result($result,$qq,"private");
$fpid=xrf_mysql_result($result,$qq,"pid");
$fcount=xrf_mysql_result($result,$qq,"dlcount");
$fdesc=xrf_bbcode_format($fdesc);

if ($fpriv == 2)
{
	$authed = xrfd_check_license($xrf_db, $xrf_myid, $fpid);
}

if ($fpriv == 0 || ($fpriv == 1 && $xrf_myid != 0) || ($fpriv == 2 && $authed == 1))
$dllink = "<a href=\"download.php?id=$fid\"><b>Download</b></a>";
if ($fpriv == 2 && $authed == 0 && $xrf_myid != 0)
$dllink = "<font color=\"red\">Not Licensed</font>";
if (($fpriv == 1 || $fpriv == 2) && $xrf_myid <= 0)
$dllink = "<font color=\"red\">Not Logged In</font>";
$fcleansize = xrfd_clean_filesize($fsize);

if ($fpriv == 0 || ($fpriv == 1 && $xrf_myid != 0) || $fpriv == 2)
echo "<table width=\"100%\"><tr><td width=\"85\" align=\"left\"><img width=\"80\" height= \"80\" src=\"icons/$ficon\"></td><td align=\"left\"><font size=4><b>$fname</b></font> $fver<br>Developer: $fauth<br>$fdesc<br>$dllink | $fcleansize | $fcount downloads</td></tr></table><p>";

$qq++;
}

}

require_once("includes/footer.php");
?>