<?php
require("ismodule.php");

if ($do == "generate")
{
	$customer = mysqli_real_escape_string($xrf_db, $_POST['customer']);
	$assigned = mysqli_real_escape_string($xrf_db, $_POST['assigned']);
	$pid = $_POST['pid'];
	$pid = (int)$pid;

	$query="SELECT * FROM g_users WHERE email='$customer' || id='$customer'";
	$result=mysqli_query($xrf_db, $query);
	@$custid=xrf_mysql_result($result,0,"id");
	@$email=xrf_mysql_result($result,0,"email");
	@$fname=xrf_mysql_result($result,0,"fname");

	$key1 = xrf_generate_password(6);
	$key2 = xrf_generate_password(7);
	$key3 = xrf_generate_password(8);
	$lic_key = $pid . $key1 . "-" . $key2 . "-" . $key3;

	$query="SELECT descr, lic_duration FROM d_products WHERE id='$pid'";
	$result=mysqli_query($xrf_db, $query);
	$product_name=xrf_mysql_result($result,0,"descr");
	$lic_duration=xrf_mysql_result($result,0,"lic_duration");
	
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
	
	mysqli_query($xrf_db, "INSERT INTO d_licenses (uid, pid, lic_key, assigned, expiry) VALUES('$custid', '$pid', '$lic_key', '$assigned', '$expiry')") or die(mysqli_error($xrf_db)); 

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
	$result=mysqli_query($xrf_db, $query);
	$num=mysqli_num_rows($result);
	$qq=0;
	while ($qq < $num) {
		$p_id=xrf_mysql_result($result,$qq,"id");
		$p_descr=xrf_mysql_result($result,$qq,"descr");
		echo "<option value='$p_id'>$p_descr</option>";
		$qq++;
	}

	echo "</select></td></tr>
	<tr><td><b>Assigned to:</b></td><td><input type=\"text\" name=\"assigned\" size=\"50\"></td></tr>
	</table></form>";
}
?>