<?php

//Function xrfd_check_license
//Use: Checks if the user is licensed for a particular product
function xrfd_check_license($uid, $pid)
{
	$query="SELECT * FROM d_licenses WHERE uid='$uid' AND pid='$pid' ORDER BY id DESC";
	$keycheck=mysql_query($query);
	@$lic_key=mysql_result($keycheck,$kk,"lic_key");
	@$expiry=mysql_result($keycheck,$kk,"expiry");
	if ($lic_key != "" && ((strtotime($expiry) > time()) || $expiry == "0"))
		return (1);
	else
		return (0);
}

//Function xrfd_clean_filesize
//Use: Creates a friendly version of the filesize details
function xrfd_clean_filesize($bytes)
{
	$kbytes = $bytes / 1024;
	$mbytes = $kbytes / 1024;
	$gbytes = $mbytes / 1024;
	$tbytes = $gbytes / 1024;

	if ((int)$tbytes > 0)
	{
		$clean = round($tbytes,2) . " TB";
	}
	else
	{
		if ((int)$gbytes > 0)
		{
			$clean = round($gbytes,2) . " GB";
		}
		else
		{
			if ((int)$mbytes > 0)
			{
				$clean = round($mbytes,2) . " MB";
			}
			else
			{
				if ((int)$kbytes > 0)
				{
					$clean = round($kbytes,2) . " KB";
				}
				else
				{
					$clean = $bytes . " B";
				}
			}
		}
	}

	return $clean;
}

//Function xrfd_count_files_in_cat
//Use: Gets the number of files in a particular category
function xrfd_count_files_in_cat($cid)
{
	$query="SELECT * FROM d_files WHERE cid='$cid'";
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	return ($num);
}

?>