<td>
<table class="GB">
    <tr>
        <td class="GB">Nam:</td>
        <td><? echo $row["Autor"]; ?></td>
<? if ($dataClass->Edit) { ?>
        <td class="borderBottom" rowspan="4" align="right"><a href="JavaScript:Delete(<? echo $row["ID"] ?>);"><img border=0 src="Layout/del.png"></a></td>
<? } ?>

    </tr>
    <tr>
        <td class="GB">Mehlfach:</td>
        <td><? echo $row["EMail"]; ?></td>
    </tr>
    <tr>
        <td class="GB">Sei Seitn:</td>
        <td><? echo $row["WWW"]; ?></td>
    </tr>
    <tr>
        <td class="GB borderBottom">Datum:</td>
        <td class="borderBottom"><? echo $row["CreatedDate"]; ?></td>
    </tr>
    <tr>
        <td colspan="2"><? echo $row["MSG"]; ?></td>
    </tr>
</table>
</td>