<?php

class User{

    ///////////////////////////////////
    // Static 
    ///////////////////////////////////

    public static $USER_STATE = array("Aktiv" => 1, "Passiv" => 2);
    public static $USER_FUNCTION = array("Mitglied" => 1, "Vorstandschaft" => 2, "Ehrenmitglied" => 3);
    private static $USER_GROUPS = array("News" => 1, "Pics" => 2, "Appointments" => 3, "Devel" => 4, "Guestbook" => 5, "Users" => 6);
    private static $CurrentUser = null;
    private static $CurrentUserLoaded = false;

    static function GetCurrentUser(){
        if(!User::$CurrentUserLoaded) {
            $sid = User::GetSid();
            User::$CurrentUser = User::Load("`SessionId` = '" . mysql_escape_string($sid) . "'");
            User::$CurrentUserLoaded = true;
        }

        return User::$CurrentUser;
    }

    static function Login($name, $pass){

        if(empty($name) || empty($pass))
            return false;

        $sql = "SELECT `ID` "
                . "FROM `users` "
                . "WHERE `Nick` LIKE '" . mysql_escape_string($name) . "' AND "
                . "`Passwd` LIKE '" . md5(mysql_escape_string($pass)) . "' AND "
                . "`LoginEnabled` = 1";

        $res = DB::Query($sql);

        $LoggedIn = false;

        if(mysql_num_rows($res) > 0) {
            //Session starten
            session_start();
            $data = mysql_fetch_array($res);
            $sid = User::GetSid();
            $sql = "UPDATE `users` SET `SessionId` = '" . mysql_escape_string($sid) . "' WHERE `ID` = " . $data["ID"];
            DB::Query($sql);
            $LoggedIn = true;
        }
        
        mysql_free_result($res);
        return $LoggedIn;
    }

    static function GetSid()
    {
        if (session_id() != "")
            $sid = session_id();
        else if ($_COOKIE["PHPSESSID"] != "")
            $sid = $_COOKIE["PHPSESSID"];
        return $sid;
    }

    static function Logout(){
        $sid = User::GetSid();
        $sql = "UPDATE `users` SET `SessionId` = '' WHERE `SessionId` = '" . mysql_escape_string($sid) . "'";
        DB::Query($sql);
        session_start();
        session_destroy();
    }

    static function LoadByID($ID){
        if(is_array($ID)) {
            if(count($ID) <= 0)
                return null;

            $where = "`ID` IN (";
            foreach($ID as $IDPart)
                $where .= "'" . mysql_escape_string($IDPart) . "', ";
            //Das letzte ", " entfernen
            $where = substr($where, 0,  strlen($where)-2);
            $where .= ")";

            return User::Load($where);
        } else
            return User::Load("`ID` = " . mysql_escape_string($ID));
    }

    static function LoadByFirstnameAndName($Firstname,$Name)
    {
        return User::Load("`Firstname` = '" . $Firstname . "' AND `Name` = '" . $Name . "'");
    }

    private static function Load($Where){
        $sql = "SELECT `ID`, `Nick`, `Firstname`, `Name`, `Street`, `Zip`, `City`, `EMail`, `Phone`, `Birthday`, `Mobile`, `State`, `Function`, `LoginEnabled`, `Passwd`, `SessionID` FROM `users` WHERE " . $Where;

        $res = DB::Query($sql);

        $usrReturn = array();

        while($row = mysql_fetch_array($res))
        {
            $User = new User($row["ID"], $row["Nick"], $row["Firstname"], $row["Name"], $row["Street"], $row["Zip"], $row["City"], $row["EMail"], $row["Phone"], strtotime($row["Birthday"]), $row["Mobile"], $row["State"], $row["Function"], $row["LoginEnabled"], $row["SessionID"]);
            array_push($usrReturn, $User);
        }

        mysql_free_result($res);

        if(count($usrReturn) <= 0)
            return null;
        else if(count($usrReturn) == 1)
            return $usrReturn[0];
        else
            return $usrReturn;
    }

    static function LoadAll($OrderBy = ""){
        $sql = "SELECT `ID`,`Nick`, `Firstname`, `Name`, `Street`, `Zip`, `City`, `EMail`, `Phone`, `Birthday`, `Mobile`, `State`, `Function`, `LoginEnabled`, `Passwd`, `SessionID` FROM `users`";
        if(!empty($OrderBy))
            $sql .= " ORDER BY " . $OrderBy;

        $res = DB::Query($sql);
        $users = array();

        while($row = mysql_fetch_array($res)) {
            $user = new User($row["ID"], $row["Nick"], $row["Firstname"], $row["Name"], $row["Street"], $row["Zip"], $row["City"], $row["EMail"], $row["Phone"], strtotime($row["Birthday"]), $row["Mobile"], $row["State"], $row["Function"], $row["LoginEnabled"], $row["SessionID"]);
            array_push($users, $user);
        }

        return $users;
    }

    ////////////////////////////////////////////
    // Instance
    ////////////////////////////////////////////
    var $ID;
    var $Firstname;
    var $Name;
    var $Street;
    var $Zip;
    var $City;
    var $EMail;
    var $Phone;
    var $Birthday;
    var $Mobile;
    var $State;
    var $Function;
    var $LoginEnabled;
    var $SessionID;

    function User($ID, $Nick, $Firstname, $Name, $Street, $Zip, $City, $EMail, $Phone, $Birthday, $Mobile, $State, $Function, $LoginEnabled, $SessionID){
        $this->ID = $ID;
        $this->Nick = $Nick;
        $this->Firstname = $Firstname;
        $this->Name = $Name;
        $this->Street = $Street;
        $this->Zip = $Zip;
        $this->City = $City;
        $this->EMail = $EMail;
        $this->Phone = $Phone;
        $this->Birthday = $Birthday;
        $this->Mobile = $Mobile;
        $this->State = $State;
        $this->Function = $Function;
        $this->LoginEnabled = $LoginEnabled;
        $this->SessionID = $SessionID;
    }

    function IsInGroup($Group){
        $GroupID = User::$USER_GROUPS[$Group];
        $sql = "SELECT COUNT(*) FROM `m_users_groups` WHERE `UserID` = " . $this->ID . " AND `GroupID` = " . $GroupID;
        $res = DB::Query($sql);

        $row = mysql_fetch_row($res);
        if($row) {
            if($row[0] == "1")
                return true;
            else
                return false;
        }

        return false;
    }

    function GetUserPicPath(){
        $PicPath = "UserPics/" . $this->ID . ".jpg";
        if(file_exists($PicPath))
            return $PicPath;
        else
            return "http://www.bv-unterneukirchen.de/UserPics/static/nopic.jpg";
    }

    function GetDynamicNick(){
        return "<a class='UserLink' onmouseout='HideToolTip();' onmousemove=\"ShowToolTip('<img src=\\'" . $this->GetUserPicPath() . "\\'>');\" href='index.php?content=Profil&ID=" . $this->ID . "'>" . $this->Nick . "</a>";
    }

    function GetAge(){
        if(empty($this->Birthday))
            return "";

        $now = mktime();
        $diff = $now - $this->Birthday;
        $age = intval($diff / (3600 * 24 * 365));
        return $age;
    }

    function GetAnonymizedEmail(){
        return str_replace("@", "%%1%%", str_replace(".", "%%2%%", $this->EMail));
    }

    function PrintAnonymizedEmailLink(){
        echo "<script type=\"text/JavaScript\">printEmailLink(\"" . $this->GetAnonymizedEmail() . "\");</script>";
    }

    function GetStateDisplayText()
    {
        $State = array_search($this->State, USER::$USER_STATE);
        return $State;
    }

    function GetFunctionDisplayText()
    {
        $Function = array_search($this->Function, USER::$USER_FUNCTION);
        return $Function;
    }
}

?>
