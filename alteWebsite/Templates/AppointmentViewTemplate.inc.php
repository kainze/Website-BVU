<div align=center><img src='Layout/GetHeadline.php5' alt="Termine"></div>

<? if($this->Edit) { ?>
<script type="text/JavaScript">
function Delete(ID)
{
    if(confirm('Mechst den eintrag wirklich löschn?'))
        SendAction("action=DelAppointment&ID=" + ID,"index.php?content=Termine");
}

function Create()
{
    JavaScript:SendAction('action=NewAppointment&Date=' + document.getElementById('ntmDate').value + '&Description=' + document.getElementById('ntmDescription').value + '&Location=' + document.getElementById('ntmLocation').value + '&Hints=' + document.getElementById('ntmHints').value + '&Public=' + document.getElementById('ntmPublic').checked,'index.php?content=Termine');
}
</script>
<? } ?>
<br><br>
 <?
    $this->DataGrid->render();
?>

<br>

<? if($this->Edit) { ?>
    <table class='NewTermin'>
    <tr>
        <td>Datum</td>
        <td>
            <input type="text" name="ntmDate" id="ntmDate" readonly>
            <input type="button" onClick="JavaScript:displayDatePicker('ntmDate', false, 'ymd', '-');" value="Auswoin">
        </td>
    </tr>
    <tr>
        <td>Beschreibung</td>
        <td><input type='text' id='ntmDescription'></td>
    </tr>
    <tr>
        <td>Treffpunkt</td>
        <td><input type='text' id='ntmLocation'></td>
    </tr>
    <tr>
        <td>Hinweise</td>
        <td><input type='text' id='ntmHints'></td>
    </tr>
    <tr>
        <td>Öffentlich</td>
        <td><input type='checkbox' id='ntmPublic'></td>
    </tr>
    <tr>
        <td callspan='2'><input type='submit' value='Oleng' onclick="JavaScript:Create();"></td></tr>
    </table>
<? } ?>
