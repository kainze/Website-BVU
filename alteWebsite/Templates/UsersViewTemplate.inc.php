<div align=center><img src='Layout/GetHeadline.php5'></div><br>

<script type="text/JavaScript">

    function Delete(ID)
    {
        if(confirm('Mechst den Benutzer wirklich löschn?'))
            SendAction("action=DelUser&ID=" + ID,"index.php?content=Mitglieder&Filter=<? echo $this->Filter; ?>");
    }

    function Edit(ID)
    {
        ShowDialog("dialog=EditUser&EditID=" + ID);
    }
</script>

<table width="100%">
    <tr>
        <form id="frmUserFilter" action="index.php?content=Mitglieder" method="POST">
        <td>Suche: </td>
        <td><input onkeydown="if(event.keyCode==13) document.getElementById("frmUserFilter").submit();" size="50" type="text" id="txtUserFilter" name="Filter" value="<? echo $this->Filter ?>"></td>
        <td style="white-space: nowrap;">
            <input style="border: 0; background-color: white;" type="image" src="Layout/search.png">
            <? if($this->Filter != "") { ?>
                <a href="index.php?content=Mitglieder"><img src="Layout/searchdel.png"></a>
            <? } ?>
        </td>
        </form>
        <td style="text-align: right; width: 100%">
            <a href="JavaScript: Edit(-1);"><img src="Layout/add.png"></a>
            <a href="System/Actions.php?action=GetUsersAsCsv"><img src="Layout/Excel.png"></a>
        </td>
    </tr>
</table>

<br><br>

<? $this->DataGrid->render(); ?>