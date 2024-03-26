<div align="center"><img src="Layout/GetHeadline.php5"></div><br>
<script type="text/JavaScript" src="tiny_mce/tiny_mce.js"></script>
    <script type="text/JavaScript">
<? if ($this->Edit) { ?>
        function Delete(ID)
        {
            if(confirm("Mechst den Eintrag wirklich löschn?"))
                SendAction("action=DelGB&ID=" + ID,"index.php?content=Gaestebuch");
        }
<? } ?>
    
        function SendNewGBEntry()
        {
            SendAction("action=NewGB&Atr=" + document.getElementById("ngbAtr").value + "&url=" + document.getElementById("ngburl").value + "&Name=" + document.getElementById("ngbName").value + "&Eml=" + document.getElementById("ngbEml").value + "&Adr=" + document.getElementById("ngbAdr").value + "&Nchrt=" + escape(tinyMCE.activeEditor.getContent()) + "&Vorname=Vorname","index.php?content=Gaestebuch");
        }
    </script>

<?
$this->DataGrid->render()
?>

<table>
    <tr>
        <td width="70">Dei Nam:</td>
        <td><input type="text" id="ngbAtr">
            <input class="GBInput1" type="text" value="aha" id="ngburl"><input class="GBInput2" type="text" value="aha" id="ngbName"></td>
    </tr>
    <tr>
        <td>Mehlfach:</td>
        <td><input type="text" id="ngbEml"></td>
    </tr>
    <tr>
        <td>Dei Seitn:</td>
        <td><input type="text" id="ngbAdr"></td>
    </tr>
    <tr>
        <td colspan="2" align="right">Zeichen :<input id="txtCharCount" type="text" size="5" value="2000" disable="disable"></td>
    </tr>
    <tr>
        <td colspan="2"><textarea id="ngbNchrt" class="GB"></textarea></td>
    </tr>
    <tr>
        <td colspan="2"><input class="Button NewNews" type="button" value="Eidrong" onClick="JavaScript: SendNewGBEntry();"></td>
    </tr>
</table>
<script type="text/javascript">

<? include("Layout/Editor.php"); ?>

    var CheckSizeAlertShown = false;
    tinyMCE.execCommand("mceAddControl", true, "ngbNchrt");
    function CheckSize() {
        var CharLength = tinyMCE.getContent().length;
        var CharLimit = 2000;
        document.getElementById("txtCharCount").value = CharLimit - CharLength;
        return true;
    }
</script>

