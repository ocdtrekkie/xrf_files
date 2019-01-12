<?php
require("ismodule.php");

if ($do == "generate")
{
	$customer = xrf_mysql_sanitize_string($_POST['customer']);
	$assigned = xrf_mysql_sanitize_string($_POST['assigned']);
	$pid = $_POST['pid'];
	$pid = (int)$pid;

	$query="SELECT * FROM g_users WHERE email='$customer' || id='$customer'";
	$result=mysql_query($query);
	@$custid=mysql_result($result,$i,"id");
	@$email=mysql_result($result,$i,"email");
	@$fname=mysql_result($result,$i,"fname");

	$key1 = xrf_generate_password(6);
	$key2 = xrf_generate_password(7);
	$key3 = xrf_generate_password(8);
	$lic_key = $pid . $key1 . "-" . $key2 . "-" . $key3;

	$query="SELECT descr, lic_duration FROM d_products WHERE id='$pid'";
	$result=mysql_query($query);
	$product_name=mysql_result($result,$i,"descr");
	$lic_duration=mysql_result($result,$i,"lic_duration");
	
	if ($lic_duration == 0)
	{
		$expiry = "0";
		$expirymsg = " This license does not expire.";
	}
	else
	{
		$texpiry = time() + ($lic_duration * 24 * 60 * 60);
		$expiry = date("Y-m-d H:i:s", $texpiry);
		$expirymsg = " This license expires at $expiry.";
	}
	
	mysql_query("INSERT INTO d_licenses (uid, pid, lic_key, assigned, expiry) VALUES('$custid', '$pid', '$lic_key', '$assigned', '$expiry')") or die(mysql_error()); 

	$from = "From: $xrf_admin_email \r\n";
	mail($email, "$product_name License Key", "$fname,\n\nYou have been granted a license for $product_name for use on $assigned. Your license key is $lic_key.$expirymsg\n\nThank you,\n$xrf_site_name", $from);

	xrf_go_redir("acp.php","License created.",2);
}
else
{
	echo "<b>Grant License</b><p>";

	echo "<form action=\"acp_module_panel.php?modfolder=downloads&modpanel=addlicense&do=generate\" method=\"POST\">
	<table><tr><td><b>Customer ID or Email:</b></td><td><input type=\"text\" name=\"customer\" size=\"50\"> <input type=\"submit\" value=\"Grant\"></td></tr>
	<tr><td><b>Product:</b></td><td><select name=\"pid\">";

	$query="SELECT * FROM d_products ORDER BY name, id ASC";
	$result=mysql_query($query);
	$num=mysql_numrows($result);
	$qq=0;
	while ($qq < $num) {
		$p_id=mysql_result($result,$qq,"id");
		$p_descr=mysql_result($result,$qq,"descr");
		echo "<option value='$p_id'>$p_descr</option>";
		$qq++;
	}

	echo "</select></td></tr>
	<tr><td><b>Assigned to:</b></td><td><input type=\"text\" name=\"assigned\" size=\"50\"></td></tr>
	</table></form>";
}
?>