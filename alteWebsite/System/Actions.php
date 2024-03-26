<?php

error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");

chdir("..");
include_once "Classes/DB.php";
include_once "Classes/User.php";
include_once "Classes/PictureInfo.php";

session_start();
ProcessAction();

function ProcessAction()
{
    $action = $_POST["action"];
    if(empty($action))
        $action = $_GET["action"];

    if ($action == "Login") {
        if (!User::Login($_POST["user"], $_POST["pass"]))
            echo "Dei Nam oda Kennwort stimmt ned";
    }
    else if($action == "Logout" && User::GetCurrentUser())
        User::GetCurrentUser()->Logout();

    else if ($action == "NewGB")
        AddGuestbookEntry();

    else if ($action == "DelGB")
        DelGuestbookEntry();

    else if ($action == "NewNews")
        AddNewsEntry();

    else if ($action == "DelNews")
        DelNewsEntry();

    else if ($action == "NewAppointment")
        AddAppointment();

    else if ($action == "DelAppointment")
        DelAppointment();

    else if ($action == "SetGalleryPrevPic")
        SetGalleryPrevPic();

    else if ($action == "NewGlG")
        AddGalleryGroup();

    else if ($action == "DelGlG")
        DelGalleryGroup();

    else if ($action == "DeleteGalleryPicture")
        DelGalleryPicture();

    else if ($action == "UpdateOwnProfile")
        UpdateOwnProfile();

    else if ($action == "GetAppointments")
        GetAppointments();

    else if ($action == "GetUsersAsCsv")
        GetUsersAsCsv();

    else if ($action == "CorrectDataSetEncoding")
        CorrectDataSetEncoding();

    else if ($action == "CorrectImageSize")
        CorrectImageSize();

    else if ($action == "DelUser")
        DelUser();

    else if ($action == "EditUser")
        EditUser();
}

/////////////////////////////////
// Funktionen
/////////////////////////////////

function AddGuestbookEntry()
{
    if ($_POST["Atr"] == "")
        echo "Du host dein Nam vagessn eizdrong!";
    else if ($_POST["Nchrt"] == "")
        echo "Du host dei Nachricht vagessn eizdrong!";
    else {
        $ip = getenv("REMOTE_ADDR");
        //Nachschaun ob die letzten 3 Sek die IP schon eine GB gemacht wurde
        $sql = "SELECT COUNT(*) FROM `guestbook` WHERE `CreatedDate` >= NOW() - INTERVAL 5 SECOND;";
        $res = DB::Query($sql);

        $GBEnteredLastSekonds = false;

        if ($row = mysql_fetch_row($res)) {
            if ($row[0] > 0)
                $GBEnteredLastSekonds = true;
        }

        if ($GBEnteredLastSekonds)
            echo "Du host erst k&uuml;rzlich an G&auml;stebucheintrag gmacht!";

        else if (strlen($_POST["Nchrt"]) > 2000)
            echo "Du host zvui Zeichen eigem";

        else if ($_POST["url"] == "aha" && $_POST["Name"] == "aha" && $_POST["Vorname"] == "Vorname") {
            $sql = "INSERT INTO `guestbook` (`Autor`,`EMail`,`WWW`,`MSG`,`IP`) VALUES ("
                    . "'" . mysql_escape_string($_POST["Atr"]) . "',"
                    . "'" . mysql_escape_string($_POST["Eml"]) . "',"
                    . "'" . mysql_escape_string($_POST["Adr"]) . "',"
                    . "'" . mysql_escape_string($_POST["Nchrt"]) . "',"
                    . "'" . $ip . "')";

            DB::Query($sql);
        }
    }
}

function DelGuestbookEntry()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Guestbook"))
        return;
    
    if (empty($_POST["ID"]))
        return;
    
    $sql = "DELETE FROM `guestbook` WHERE `ID` = " . mysql_escape_string($_POST["ID"]);
    DB::Query($sql);
}

function AddNewsEntry()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("News"))
        return;

    $sql = "INSERT INTO `news` (`MSG`,`UserID`) VALUES ('" . mysql_escape_string($_POST["txtNewNews"]) . "'," . User::GetCurrentUser()->ID . ")";
    DB::Query($sql);
}

function DelNewsEntry()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("News"))
        return;

    if (empty($_POST["ID"]))
        return;

    $sql = "DELETE FROM `news` WHERE `ID` = " . mysql_escape_string($_POST["ID"]);
    DB::Query($sql);
}

function AddAppointment()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Appointments"))
        return;

    $sql = "INSERT INTO `appointments` (`Date`,`Description`,`Location`, `Hints`, `Public`, `UserID`) VALUES ('" .
            mysql_escape_string($_POST["Date"]) . "','" .
            mysql_escape_string($_POST["Description"]) . "','" .
            mysql_escape_string($_POST["Location"]) . "','" .
            mysql_escape_string($_POST["Hints"]) . "','" .
            (($_POST["Public"] == "true") ? "Y" : "N") . "'," .
            User::GetCurrentUser()->ID . ")";

    DB::Query($sql);
}

function DelAppointment()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Appointments"))
        return;

    if(empty($_POST["ID"]))
        return;
    
    $sql = "DELETE FROM `appointments` WHERE `ID` = " . mysql_escape_string($_POST["ID"]);
    DB::Query($sql);
}

function SetGalleryPrevPic()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Pics"))
        return;

    if (!is_numeric($_POST["GID"]))
        echo "Keine g&uuml;ltige GallerieID angegeben!";
    else if (!is_numeric($_POST["ID"]))
        echo "Keine g&uuml;ltige BildID angegeben!";
    else {
        $sql = "UPDATE `glgroup` SET `PreviewBildID`=" . $_POST["ID"] . " WHERE `ID` = " . $_POST["GID"];
        DB::Query($sql);
    }
}

function AddGalleryGroup()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Pics"))
        return;

    if ($_POST["GlGBes"] == "")
        echo "Du host vagessn a Bezeichnung eizumgem!";
    else if ($_POST["GlGDate"] == "")
        echo "Du host vagessn a Datum eizumgem!";
    else {
        $sql = "INSERT INTO `glgroup` (`Description`,`PreviewBildID`,`Date`,`UserID`) VALUES ('" . mysql_escape_string($_POST["GlGBes"]) . "',NULL,'" . mysql_escape_string($_POST["GlGDate"]) . "'," . User::GetCurrentUser()->ID . ")";
        DB::Query($sql);

        if (mysql_error() == "")
            mkdir("GalleriePics/" . mysql_insert_id());
    }
}

function DelGalleryGroup()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Pics"))
        return;
    
    if (!is_numeric($_POST["ID"]))
        echo "Keine ID Angegeben!";
    else {
        DB::Query("DELETE FROM `glgroup` WHERE `ID` = " . mysql_escape_string($_POST["ID"]));
        DB::Query("DELETE FROM `glitem` WHERE `GLGroupID` = " . mysql_escape_string($_POST["ID"]));
        full_rmdir("GalleriePics/" . $_POST["ID"]);
    }
}

function DelGalleryPicture()
{
    if (!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Pics"))
        return;

    if(empty($_POST["ID"]))
        return;
    
    //DeleteGalleriePicture
    DB::Query("DELETE FROM `glitem` WHERE `ID` = " . mysql_escape_string($_POST["ID"]));
    DB::Query("UPDATE `glgroup` SET `PreviewBildID` = NULL WHERE `PreviewBildID` = " . $_POST["ID"]);
    unlink("GalleriePics/" . $_POST["GID"] . "/" . $_POST["ID"] . ".jpg");
    unlink("GalleriePics/" . $_POST["GID"] . "/p_" . $_POST["ID"] . ".jpg");
}

function UpdateOwnProfile()
{
    if (!User::GetCurrentUser() || !is_numeric($_POST["ID"]) || $_POST["ID"] != User::GetCurrentUser()->ID)
        return;

    if ($_POST["Pass"] != "" && $_POST["Pass"] != $_POST["Pass2"])
        echo "Die Passwörter stimman ned überein!";
    else if ($_POST["Zip"] != "" && !is_numeric($_POST["Zip"]))
        echo "De Postleitzahl is ned gültig!";
    else if ($_POST["Email"] != "" && !preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $_POST["Email"]))
        echo "So schaud koa E-Mail-Adressn aus!";
    else {

        $sql = "UPDATE `users` SET "
                . "`Firstname` = '" . mysql_escape_string($_POST["Firstname"]) . "',"
                . "`Name` = '" . mysql_escape_string($_POST["Name"]) . "',"
                . "`Street` = '" . mysql_escape_string($_POST["Street"]) . "',"
                . "`Zip` = '" . mysql_escape_string($_POST["Zip"]) . "',"
                . "`City` = '" . mysql_escape_string($_POST["City"]) . "',"
                . "`EMail` = '" . mysql_escape_string($_POST["Email"]) . "',"
                . "`Phone` = '" . mysql_escape_string($_POST["Phone"]) . "', "
                . "`Mobile` = '" . mysql_escape_string($_POST["Mobile"]) . "' ";

        if ($_POST["Pass"] != "")
            $sql .= ",`Passwd` = MD5('" . mysql_escape_string($_POST["Pass"]) . "') ";

        $sql .= " WHERE `ID` = " . mysql_escape_string($_POST["ID"]);

        DB::Query($sql);
    }


    /* if($_POST["delete"] != "")
      {
      unlink("UserPics/" . $_POST["ID"] . ".jpg");
      }
      else if($_FILES["NewUserFile"]["size"] != 0)
      {
      $imageInfo = getImageSize($_FILES["NewUserFile"]["tmp_name"]);
      $TmpFilePath = $_FILES["NewUserFile"]["tmp_name"];

      switch ($imageInfo["mime"])
      {
      case "image/gif":
      $o_OrgImg = imageCreateFromGIF($TmpFilePath);
      break;
      case "image/jpeg":
      $o_OrgImg = imageCreateFromJPEG($TmpFilePath);
      break;
      case "image/png":
      $o_OrgImg = imageCreateFromPNG($TmpFilePath);
      break;
      case "image/wbmp":
      $o_OrgImg = imageCreateFromWBMP($TmpFilePath);
      break;
      default:
      die("Unsupported Filetype");
      }

      $ratio = $imageInfo[0] / $imageInfo[1];
      $NewHeight = 200;
      $NewWidth = (int)($NewHeight * $ratio);

      $o_ResisedImg = imageCreateTrueColor($NewWidth,$NewHeight);
      if(!imageCopyResampled($o_ResisedImg,$o_OrgImg,0,0,0,0,$NewWidth,$NewHeight,$imageInfo[0],$imageInfo[1]))
      die("Fehler bei Umwandlung");

      imageJPEG($o_ResisedImg,"UserPics/" . $_POST["ID"] . ".jpg",80);

      imageDestroy($o_OrgImg);
      imageDestroy($o_ResisedImg);
      } */
}

function GetAppointments()
{
    $Time = $_POST["Time"];

    if ($Time != "") {
        echo "<root>\n";
        echo "<Content>\n";

        $sql = "SELECT DATE_FORMAT(`Date` , '%e' ) AS Day,DATE_FORMAT(`Date`,'%H:%i') as Time, `Description` , `Location` , `Hints` FROM `appointments` WHERE DATE_FORMAT(`Date` , '%Y%m' )='" . mysql_escape_string($Time) . "' ";
        if (!User::GetCurrentUser()) {
            $sql .= " AND Public='Y' ";
        }

        $sql .= " ORDER BY `Date` ASC ";
        $res = DB::Query($sql);
        echo mysql_error();

        $Day = -1;

        while ($row = mysql_fetch_array($res)) {
            $Day = htmlentities($row["Day"], ENT_COMPAT, "UTF-8");
            $Time = htmlentities($row["Time"], ENT_COMPAT, "UTF-8");
            $Description = htmlentities($row["Description"], ENT_COMPAT, "UTF-8");
            $Location = htmlentities($row["Location"], ENT_COMPAT, "UTF-8");
            $Hints = htmlentities($row["Hints"], ENT_COMPAT, "UTF-8");

            echo "<Day value='" . $Day . "'>";
            echo "<Time><![CDATA[" . $Time . "]]></Time>\n";
            echo "<Description><![CDATA[" . $Description . "]]></Description>\n";
            echo "<Location><![CDATA[" . $Location . "]]></Location>\n";
            echo "<Hints><![CDATA[" . $Hints . "]]></Hints>\n";
            echo "</Day>\n";
        }

        echo "</Content>\n";
        echo "</root>\n";
    }
}

function DelUser()
{
    if(!User::GetCurrentUser())
        return;

    $ID = $_POST["ID"];
    if(empty($ID) || !is_numeric($ID))
        return;

    $res = DB::Query("SELECT `Name`,`Firstname`,`LoginEnabled` FROM `users` WHERE `ID` = '" . $ID . "'");
    if($row = mysql_fetch_array($res))
    {
        if($row["LoginEnabled"] == 1)
        {
            echo $row["Name"] . ", " . $row["Firstname"] . " kon se auf da Seitn im Admin-Bereich omoidn und konn desweng ned gelöscht werden.";
            return;
        }
    }

    DB::Query("DELETE FROM `users` WHERE `ID` = " . mysql_escape_string($ID));
}

function EditUser()
{
    if(!User::GetCurrentUser())
        return;

    $ID = $_POST["ID"];
    if(empty($ID) || !is_numeric($ID))
        return;

    $Name = mysql_escape_string($_POST["name"]);
    $Firstname = mysql_escape_string($_POST["firstname"]);
    $Street = mysql_escape_string($_POST["street"]);
    $Zip = mysql_escape_string($_POST["zip"]);
    $City = mysql_escape_string($_POST["city"]);
    $Phone = mysql_escape_string($_POST["phone"]);
    $Mobile = mysql_escape_string($_POST["mobile"]);
    $Email = mysql_escape_string($_POST["email"]);
    $Birthday = date("Y-m-d",  strtotime($_POST["birthday"]));
    $State = mysql_escape_string($_POST["state"]);

    if(empty($Name) || empty($Firstname))
    {
        echo "Bitte gib no an Name und an Vornamen ei.";
        return;
    }

    if($ID == -1)
        DB::Query("INSERT INTO `users` (`Name`,`Firstname`,`Street`,`Zip`,`City`,`Phone`,`Mobile`,`Email`,`Birthday`,`State`) VALUES "
            . " ('" . $Name . "','" . $Firstname . "','" . $Street . "','" . $Zip . "','" . $City . "','" . $Phone . "','" . $Mobile . "','" . $Email . "','" . $Birthday . "','" . $State . "')");
    else
        DB::Query("UPDATE `users` SET `Name` = '" . $Name . "', `Firstname` = '" . $Firstname . "', `Street` = '" . $Street . "', `Zip` = '" . $Zip . "', `City` = '" . $City . "', `Phone` = '" . $Phone . "', `Mobile` = '" . $Mobile . "', `Email` = '" . $Email . "', "
                        ."`Birthday` = '" . $Birthday . "', `State` = '" . $State . "' WHERE `ID` = '" . $ID . "'");
}

function GetUsersAsCsv()
{
    if (!User::GetCurrentUser())
        return;

    $users = User::LoadAll("`Name`,`Firstname`");

    $dateSeq = date("Y-m-d");
    header("Content-Disposition: attachment; filename=Mitglieder_" . $dateSeq . ".csv");
    header("Content-Type: application/octet-stream");

    echo GetCsvField("Name");
    echo GetCsvField("Vorname");
    echo GetCsvField("Geb.Datum");
    echo GetCsvField("Straße");
    echo GetCsvField("PLZ");
    echo GetCsvField("Ort");
    echo GetCsvField("Telefon");
    echo GetCsvField("Handy");
    echo GetCsvField("E-Mail");
    echo GetCsvField("Status");
    echo GetCsvField("Funktion");
    echo "\r\n";

    foreach($users as $user)
    {
        echo GetCsvField($user->Name);
        echo GetCsvField($user->Firstname);
        echo GetCsvField(date("d.m.Y", $user->Birthday));
        echo GetCsvField($user->Street);
        echo GetCsvField($user->Zip);
        echo GetCsvField($user->City);
        echo GetCsvField($user->Phone);
        echo GetCsvField($user->Mobile);
        echo GetCsvField($user->EMail);
        echo GetCsvField($user->GetStateDisplayText());
        echo GetCsvField($user->GetFunctionDisplayText());
        echo "\r\n";
    }
}

function GetCsvField($value)
{
    $ColSep = ";";
    $value = str_replace("\"", "\"\"", $value);
    $value = str_replace($ColSep, $ColSep . $ColSep, $value);
    return "\"" . iconv("UTF-8","Windows-1252//TRANSLIT",$value) . "\"" . $ColSep;
}

function CorrectDataSetEncoding()
{
    if(!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Devel"))
        return;

    echo "Korrigiere 'Appointment'<br>";
    $cnt = DB::CorrectMixedUtf8AndLatin1Encoding("appointments","Description");
    $cnt += DB::CorrectMixedUtf8AndLatin1Encoding("appointments","Location");
    $cnt += DB::CorrectMixedUtf8AndLatin1Encoding("appointments","Hints");
    echo "Insgesammt " . $cnt . " Datensätze aktualisiert.<br>";

    echo "Korrigiere 'glgroup'<br>";
    $cnt = DB::CorrectMixedUtf8AndLatin1Encoding("glgroup","Description");
    echo "Insgesammt " . $cnt . " Datensätze aktualisiert.<br>";

    echo "Korrigiere 'guestbook'<br>";
    $cnt = DB::CorrectMixedUtf8AndLatin1Encoding("guestbook","Autor");
    $cnt += DB::CorrectMixedUtf8AndLatin1Encoding("guestbook","MSG");
    echo "Insgessammt " . $cnt . " Datensätze aktualisiert.<br>";

    echo "Korrigiere 'news'<br>";
    $cnt = DB::CorrectMixedUtf8AndLatin1Encoding("news","MSG");
    echo "Insgesammt " . $cnt . " Datensätze aktualisiert.<br>";
}

function CorrectImageSize()
{
    if(!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Devel"))
        return;

    $folders = PictureInfo::GetAllGalleryFolders();
    $GID = $_GET["GID"];
    if(empty($GID))
        $GID = $folders[0];

    echo "Kontrolliere Gallerie " . $GID . "<br>";
    $cnt = PictureInfo::CorrectImageSize($GID);
    echo $cnt . " Bilder korrigiert.<br>";

    $i = 0;
    for($i=0;$folders[$i] != $GID;$i++);
    if($i+1 >= count($folders))
        echo "Fertig!";
    else
    {
        $GID = $folders[$i+1];
        echo "Fahre fort mit " . $GID . "<br>";

        echo "<meta http-equiv='refresh' content='2; url=Actions.php?action=CorrectImageSize&GID=" . $GID . "'>";
    }
}

/////////////////////////////////
// Hilfs-Funktionen
/////////////////////////////////

function full_rmdir($dir) {
    if (!is_writable($dir)) {
        if (!@chmod($dir, 0777)) {
            return FALSE;
        }
    }

    $d = dir($dir);
    while (FALSE !== ( $entry = $d->read() )) {
        if ($entry == '.' || $entry == '..') {
            continue;
        }
        $entry = $dir . '/' . $entry;
        if (is_dir($entry)) {
            if (!full_rmdir($entry)) {
                return FALSE;
            }
            continue;
        }
        if (!@unlink($entry)) {
            $d->close();
            return FALSE;
        }
    }

    $d->close();

    rmdir($dir);

    return TRUE;
}