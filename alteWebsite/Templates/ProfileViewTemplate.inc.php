<h1><? echo $this->User->Nick; ?></h1>

<? if($this->Edit) { ?>
<script type="text/JavaScript">
    function Save()
    {
        var ID = <? echo $this->ID; ?>;
        var Firstname = encodeURIComponent(document.getElementById('opFirstname').value);
        var Name = encodeURIComponent(document.getElementById('opName').value);
        var Street = encodeURIComponent(document.getElementById('opStreet').value);
        var Zip = encodeURIComponent(document.getElementById('opZip').value);
        var City = encodeURIComponent(document.getElementById('opCity').value);
        var Email = encodeURIComponent(document.getElementById('opEmail').value);
        var Phone = encodeURIComponent(document.getElementById('opPhone').value);
        var Mobile = encodeURIComponent(document.getElementById('opMobile').value);
        var Pass = encodeURIComponent(document.getElementById('opPass').value);
        var Pass2 = encodeURIComponent(document.getElementById('opPass2').value);

        SendAction("action=UpdateOwnProfile&ID=" + ID + "&Firstname=" + Firstname + "&Name=" + Name + "&Street=" + Street + "&Zip=" + Zip + "&City=" + City + "&Email=" + Email
                  +"&Phone=" + Phone + "&Mobile=" + Mobile + "&Pass=" + Pass + "&Pass2=" + Pass2 ,'index.php?content=Profil&ID=' + ID);
    }
</script>
    <table  width='100%'>
        <tr>
            <td width="80px"><b>Vorname:</b></td>
            <td><input type='text' size='27' id='opFirstname' value='<? echo $this->User->Firstname; ?>'></td>
            <td rowspan="7" align='center'><img src='<? echo $this->User->GetUserPicPath(); ?>'></td>
        </tr>
        <tr>
            <td><b>Nam:</b></td>
            <td><input type='text' size='27' id='opName' value='<? echo $this->User->Name; ?>'></td>
        </tr>
        <tr>
            <td><b>Strass:</b></td>
            <td><input type='text' size='27' id='opStreet' value='<? echo $this->User->Street; ?>'></td>
        </tr>
        <tr>
            <td><b>Ort:</b></td>
            <td><input type='text' size='4' id='opZip' value='<? echo $this->User->Zip; ?>'> <input type='text' id='opCity' value='<? echo $this->User->City; ?>'></td>
        </tr>
        <tr>
            <td><b>Tel:</b></td>
            <td><input type='text' size='27' id='opPhone' value='<? echo $this->User->Phone; ?>'></td>
        </tr>
        <tr>
            <td><b>Handy:</b></td>
            <td><input type='text' size='27' id='opMobile' value='<? echo $this->User->Mobile; ?>'></td>
        </tr>
        <tr>
            <td><b>Email:</b></td>
            <td><input type='text' size='27' id='opEmail' value='<? echo $this->User->EMail; ?>'></td>
        </tr>
        <tr>
            <td><b>Passwort:</b></td>
            <td><input type='password' size='27' id='opPass'></td>
        </tr>
        <tr>
            <td><b>nommoi Passwort:</b></td>
            <td><input type='password' size='27' id='opPass2'></td>
        </tr>
        <tr><td>&nbsp</td></tr>
        <tr>
            <td colspan='2' align='center'>
                <input type='button' value='Speichern' onClick="JavaScript: Save();">
                <input type='button' value='Abbrechen' onClick="JavaScript:location.href='index.php?content=Profil&ID=<? echo $this->ID; ?>'">
            </td>
        </tr>
        <tr><td height="100%">&nbsp;</td></tr>
    </table>
<? } else { ?>
    <table  width='100%'>
        <tr>
            <td width="80px"><b>Vorname:</b></td>
            <td><? echo $this->User->Firstname; ?></td>
            <td rowspan="7" align='center'><img src='<? echo $this->User->GetUserPicPath(); ?>'></td>
        </tr>
        <tr>
            <td><b>Nam:</b></td>
            <td><? echo $this->User->Name; ?></td>
        </tr>
        <tr>
            <td><b>Strass:</b></td>
            <td><? echo $this->User->Street; ?></td>
        </tr>
        <tr>
            <td><b>Ort:</b></td>
            <td><? echo $this->User->Zip . " " . $this->User->City; ?></td>
        </tr>
        <tr>
            <td><b>Tel:</b></td>
            <td><? echo $this->User->Phone; ?></td>
        </tr>
        <tr>
            <td><b>Handy:</b></td>
            <td><? echo $this->User->Mobile; ?></td>
        </tr>
        <tr>
            <td><b>Email:</b></td>
            <td><? echo $this->User->PrintAnonymizedEmailLink(); ?></td>
        </tr>
        <tr><td height="100%">&nbsp;</td></tr>
    </table>
<? } ?>
