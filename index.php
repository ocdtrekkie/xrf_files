<?php
require_once("includes/global.php");
require_once("includes/functions_dl.php");
require_once("includes/header.php");

$disclaimer = "Most of the files on this downloads site are placed here to provide myself and customers of mine a one-stop spot to download the technical support tools that I use. This site is not intended to violate any rules regarding software distribution. If your file is here against your wishes, please email ocdtrekkie (at) gmail.com";

echo "
<table width=\"100%\"><tr><td width=\"50%\">

<b>Quick Downloads</b>

<p align=\"left\"><a href=\"download.php?id=1\">Hijack This</a><br>
<a href=\"download.php?id=3\">Spybot Search & Destroy</a><br>
<a href=\"download.php?id=21\">Malwarebytes Anti-Malware</a><br>
<a href=\"download.php?id=22\">SUPERAntiSpyware</a><br>
<a href=\"download.php?id=23\">Process Explorer</a></p>

<p align=\"left\"><a href=\"download.php?id=4\">TeamViewer Full (PC)</a><br>
<a href=\"download.php?id=5\">TeamViewer Full (Mac)</a></p>

<p align=\"left\"><a href=\"download.php?id=6\">TeamViewer QuickSupport (PC)</a><br>
<a href=\"download.php?id=7\">TeamViewer QuickSupport (Mac)</a></p>

<p align=\"left\"><a href=\"download.php?id=2\">CoreFTP Lite</a></p>

</td><td width=\"50%\"><b>Categories</b>";

$query="SELECT * FROM d_categories ORDER BY descr ASC";
$result=mysql_query($query);
$num=mysql_numrows($result);

$qq=0;
while ($qq < $num) {

$cid=mysql_result($result,$qq,"id");
$cdesc=mysql_result($result,$qq,"descr");
$cpriv=mysql_result($result,$qq,"private");
$cnum=xrfd_count_files_in_cat($cid);

if ($cpriv == 0 || ($cpriv == 1 && $xrf_myid != 0))
echo "<p align=\"left\"><font size=5><a href=\"viewcat.php?id=$cid\">$cdesc</a></font> ($cnum)</p>";

$qq++;
}

echo "</td></tr></table><p align=\"left\"><font size=\"1\">$disclaimer</font></p>";

require_once("includes/footer.php");
?>