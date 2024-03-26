<?
    $userID = $row["UserID"];
    $user = $dataClass->UsersByID[$userID];
?>

<td>
<table class="News">
    <tr>
        <td class="NewsCaption">Erstellt Von:</td>
        <td><? echo $user->GetDynamicNick(); ?></td>

        <? if ($row["BrandNew"] == "1") {?>
            <td class="NewsFlag borderBottom" rowspan="2"><img src="Layout/BrandNew.jpg" alt="Nei"></td>
        <? } ?>

        <td class="NewsEditDel borderBottom" rowspan="2">

        <? if ($dataClass->Edit) { ?>
            <a href="JavaScript: Delete(<? echo $row["ID"] ?>);"><img border=0 src="Layout/del.png" alt="Löschen"></a>
        <? } ?>

        </td>
    </tr>
    <tr>
        <td class="borderBottom">Erstellt Am:</td>
        <td class="borderBottom"><? echo $row["TimeStamp"]; ?></td>
    </tr>
    <tr>
        <td colspan="4">
        <div id="News<? echo $row["ID"]; ?>"><? echo $row["MSG"];?></div>
        </td>
    </tr>
</table>
</td>