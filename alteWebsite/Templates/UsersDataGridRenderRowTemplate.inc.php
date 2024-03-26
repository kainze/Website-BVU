<td>
<table id="tblUser<? echo $row["ID"]; ?>" style="border: 1px solid black; width:100%; border-collapse: collapse;">
    <?
    $now = mktime();
    $birthday = strtotime($row["Birthday"]);
    $age = intval(($now - $birthday) / (3600 * 24 * 365));
    ?>
    <tr>
        <td style="border-bottom: 1px solid black; width:100%;" colspan="4" ><b><? echo $row["Name"] . ", " . $row["Firstname"]?></b></td>
        <td style="border-bottom: 1px solid black; white-space: nowrap" align="right">
            <? if($dataClass->Edit == true) { ?>
            <a href="JavaScript: Edit(<? echo $row["ID"] ?>);"><img border=0 src="Layout/edit.png" alt="Bearbeiten"></a>
            <a href="JavaScript: Delete(<? echo $row["ID"] ?>);"><img border=0 src="Layout/del.png" alt="Löschen"></a>
            <? } ?>
        </td>
    </tr>
    <tr><td colspan="4"><? echo $row["Street"] . ", " . $row["Zip"] . " " . $row["City"] ?></td></tr>
    <tr><td><b>Telefon: </b></td><td><? echo $row["Phone"]; ?></td><td><b>Handy: </b></td><td><? echo $row["Mobile"]; ?></td></tr>
    <tr><td><b>E-Mail: </b></td><td colspan="3"><? echo $row["Email"]; ?></td></tr>
    <tr><td><b>Geburstag: </b></td><td><? echo date("d.m.Y",$birthday); ?></td><td><b>Alter: </b></td><td><? echo $age; ?></td></tr>
    <tr><td><b>Status: </b></td><td><? echo array_search($row["State"],User::$USER_STATE); ?></td></tr>
</table>
</td>