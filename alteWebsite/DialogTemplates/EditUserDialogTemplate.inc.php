<script type="text/JavaScript">
    window.SaveUser = function()
    {
        var id = <? echo $this->EditID ?>;
        var name = encodeURIComponent(document.getElementById("UsersEditName").value);
        var firstname = encodeURIComponent(document.getElementById("UsersEditFirstname").value);
        var street = encodeURIComponent(document.getElementById("UsersEditStreet").value);
        var zip = encodeURIComponent(document.getElementById("UsersEditZip").value);
        var city = encodeURIComponent(document.getElementById("UsersEditCity").value);
        var phone = encodeURIComponent(document.getElementById("UsersEditPhone").value);
        var mobile = encodeURIComponent(document.getElementById("UsersEditMobile").value);
        var email = encodeURIComponent(document.getElementById("UsersEditEmail").value);
        var birthday = encodeURIComponent(document.getElementById("UsersEditBirthday").value);
        var state = encodeURIComponent(document.getElementById("UsersEditActive").value);

        var filter = encodeURIComponent(document.getElementById("txtUserFilter").value);
        SendAction("action=EditUser&ID=" + id + "&name=" + name + "&firstname=" + firstname + "&street=" + street + "&zip=" + zip + "&city=" + city + "&phone=" + phone + "&mobile=" + mobile + "&email=" + email + "&birthday=" + birthday + "&state=" + state, "index.php?content=Mitglieder&Filter=" + filter);
    }
</script>

<table align="center" style="width: 400px; border-collapse: collapse;">
    <tr>
        <td>Name:</td>
        <td colspan="2"><input tabindex="1" style="width:100%" type="text" id="UsersEditName" value="<? echo $this->User->Name; ?>"></td>
        <td align="center">
            <a href="JavaScript: window.SaveUser();"><img border=0 src="Layout/save.png" alt="Bearbeiten"></a>
        </td>
    </tr>
    <tr><td>Vorname:</td><td colspan="2"><input tabindex="2" style="width:100%" type="text" id="UsersEditFirstname" value="<? echo $this->User->Firstname; ?>"></td></tr>
    <tr><td>Straße:</td><td colspan="2"><input tabindex="3" style="width:100%" type="text" id="UsersEditStreet" value="<? echo $this->User->Street; ?>"></td></tr>
    <tr>
        <td>PLZ/Ort:</td>
        <td><input tabindex="4" style="width:50px" type="text" id="UsersEditZip" value="<? echo $this->User->Zip; ?>" ></td>
        <td><input tabindex="5" style="width:100%" type="text" id="UsersEditCity" value="<? echo $this->User->City; ?>"></td>
    </tr>
    <tr><td>Telefon:</td><td colspan="2"><input tabindex="6" style="width:100%" type="text" id="UsersEditPhone" value="<? echo $this->User->Phone; ?>"></td></tr>
    <tr><td>Mobile:</td><td colspan="2"><input tabindex="7" style="width:100%" type="text" id="UsersEditMobile" value="<? echo $this->User->Mobile; ?>"></td></tr>
    <tr><td>E-Mail:</td><td colspan="2"><input tabindex="8" style="width:100%" type="text" id="UsersEditEmail" value="<? echo $this->User->EMail; ?>"></td></tr>
    <tr>
        <td>Geburtstag:</td>
        <td colspan="2"><input style="width:100%" tabindex="9" type="text" id="UsersEditBirthday" name="UsersEditBirthday" value="<? echo date("d.m.Y",$this->User->Birthday); ?>"></td>
    </tr>
    <tr><td>Status:</td><td colspan="2"><select tabindex="10" id="UsersEditActive"><option <? echo $this->User->State == "1" ? "selected" : ""; ?> value="1">Aktiv</option><option <? echo $this->User->State == "2" ? "selected" : ""; ?> value="2">Passiv</option></select></td></tr>
</table>