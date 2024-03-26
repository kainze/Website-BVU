<?php

include_once("System/Login.php");

if ($GET["ID"] == "") {
    $ID = $_GET["ID"];

    $Edit = $ID == GetUserID();

    $CurUser = User::Load($ID);

    if ($CurUser != null) {
        echo "<h1>" . $CurUser->Nick . "</h1>"
        . "<table width='100%'>"
        . "<tr><td width='400px'>"
        . "<table>"
        . "<tr>"
        . "<td>Vorname</td>"
        . "<td>";
        if ($Edit)
            echo "<input type='text' size='27' id='epVorname' value='" . $CurUser->Vorname . "'>";
        else
            echo $CurUser->Vorname;

        echo "</td>"
        . "</tr>"
        . "<tr>"
        . "<td>Nam:</td>"
        . "<td>";
        if ($Edit)
            echo "<input type='text' size='27' id='epName' value='" . $CurUser->Name . "'>";
        else
            echo $CurUser->Name;

        echo "</td>"
        . "</tr>"
        . "<tr>"
        . "<td>Strass:</td>"
        . "<td>";
        if ($Edit)
            echo "<input type='text' size='27' id='epStrasse' value='" . $CurUser->Strasse . "'>";
        else
            echo $CurUser->Strasse;

        echo "</td>"
        . "</tr>"
        . "<tr>"
        . "<td>Ort:</td>"
        . "<td>";
        if ($Edit)
            echo "<input type='text' size='4' id='epPLZ' value='" . $CurUser->PLZ . "'> <input type='text' id='epWohnort' value='" . $CurUser->Wohnort . "'>";
        else
            echo $CurUser->PLZ . " " . $CurUser->Wohnort;

        echo "</td>"
        . "</tr>"
        . "<tr>"
        . "<td>Email:</td>"
        . "</td>"
        . "<td>";
        if ($Edit)
            echo "<input type='text' size='27' id='epEMail' value='" . $CurUser->EMail . "'>";
        else
            echo "<a href='mailto:" . $CurUser->EMail . "'>" . $CurUser->EMail . "</a>";

        echo "</td>"
        . "</tr>"
        . "<tr>"
        . "<td>Tel:</td>"
        . "<td>";
        if ($Edit)
            echo "<input type='text' size='27' id='epTel' value='" . $CurUser->Tel . "'>";
        else
            echo $CurUser->Tel;

        echo "</td>"
        . "</tr>";

        if ($Edit) {
            echo "<tr>"
            . "<td>Passwort:</td>"
            . "<td>"
            . "<input type='password' size='27' id='epPass'>"
            . "</td>"
            . "</tr>"
            . "<tr>"
            . "<td>nommoi Passwort:</td>"
            . "<td>"
            . "<input type='password' size='27' id='epPass2'>"
            . "</td>"
            . "</tr>"
            . "<tr><td>&nbsp</td></tr>"
            . "<tr>"
            . "<td colspan='2' align='center'>"
            . "<input type='button' value='Speichern' onClick=\"JavaScript:SendAction('action=EditProfil&ID=" . $ID . "&Vorname=' + document.getElementById('epVorname').value + '&Name=' + document.getElementById('epName').value + '&Strasse=' + document.getElementById('epStrasse').value + '&PLZ=' + document.getElementById('epPLZ').value + '&Wohnort=' + document.getElementById('epWohnort').value + '&Email=' + document.getElementById('epEMail').value + '&Tel=' + document.getElementById('epTel').value + '&Pass=' + document.getElementById('epPass').value + '&Pass2=' + document.getElementById('epPass2').value,'index.php?content=Profil&ID=" . $ID . "');\"  >"
            . " <input type='button' value='Abbrechen' onClick=\"JavaScript:location.href='index.php?content=MyProfil'\">"
            . "</td>"
            . "</tr>";
        }

        echo "</table>"
        . "</td>"
        . "<td align='center'>"
        . "	<img src='" . $CurUser->GetUserPicPath() . "'><br>";

        if ($Edit) {
            echo "<input type='button' class='button' value='l&ouml;schen' onClick='\"JavaScript:SendAction('action=DeleteProfilPic&ID=" . $ID . "','index.php?content=MyProfil');\"><br>";
        }

        echo "</td></tr>";
    }
}
?>
