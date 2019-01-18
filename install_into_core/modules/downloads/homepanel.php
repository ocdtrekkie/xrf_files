<?php
require("ismodule.php");
$zquery="SELECT * FROM d_licenses WHERE uid = '$xrf_myid'";
$zresult=mysqli_query($xrf_db, $zquery);
$znum=mysqli_num_rows($zresult);

echo" <tr>
<td>

<a href=\"module_page.php?modfolder=$modfolder&modpanel=viewlicenses\">View Purchased Licenses</a>

</td>
<td align=\"right\">



</td>
</tr>";

//TODO: Check for expired licenses, and change to Expired Licenses: $num if > 0.

?>