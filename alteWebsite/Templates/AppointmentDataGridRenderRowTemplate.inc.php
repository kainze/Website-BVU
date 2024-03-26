    <td><? echo $row["Date"]; ?></td>
    <td><? echo $row["Description"]; ?></td>
    <td><? echo $row["Location"]; ?></td>
    <td><? echo $row["Hints"]; ?></td>

<?if($dataClass->LoggedIn) { ?>
    <td><div align="center"><input type="checkbox" <? if($row["Public"] == "Y") echo "checked"; ?> disabled></div></td>
<? } ?>

<? if($dataClass->Edit) { ?>
     <td><a href="JavaScript:Delete(<? echo $row["ID"] ?>);"><img src='Layout/del.png' border='0'></a></td>
<? } ?>