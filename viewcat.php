<?php
require_once("includes/global.php");
require_once("includes/functions_bbc.php");
require_once("includes/functions_dl.php");
require_once("includes/header.php");

$id = $_GET['id'];
$id=(int)$id;
$query="SELECT * FROM d_categories WHERE id='$id'";
$result=mysql_query($query);
$cid=mysql_result($result,$qq,"id");
$cdesc=mysql_result($result,$qq,"descr");
$cpriv=mysql_result($result,$qq,"private");

if ($cprive == 0 || ($cpriv == 1 && $xrf_myid != 0))
{

echo "<font size=5><b>Category: $cdesc</b></font>";

$query="SELECT * FROM d_files WHERE cid='$cid' ORDER BY dlcount DESC, name ASC";
$result=mysql_query($query);
$num=mysql_numrows($result);

$qq=0;
while ($qq < $num) {

$key = "";
$authed = 0;
$fid=mysql_result($result,$qq,"id");
$fname=mysql_result($result,$qq,"name");
$fver=mysql_result($result,$qq,"version");
$fauth=mysql_result($result,$qq,"author");
$fdesc=mysql_result($result,$qq,"descr");
$ficon=mysql_result($result,$qq,"iconname");
$fsize=mysql_result($result,$qq,"filesize");
$fpriv=mysql_result($result,$qq,"private");
$fpid=mysql_result($result,$qq,"pid");
$fcount=mysql_result($result,$qq,"dlcount");
$fdesc=xrf_bbcode_format($fdesc);

if ($fpriv == 2)
{
	$authed = xrfd_check_license($xrf_myid, $fpid);
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