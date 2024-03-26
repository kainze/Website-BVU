<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Appointment
 *
 * @author mayer
 */
class Appointment {


    function LoadAllComing($LoadPrivate)
    {
        $where = "`Date` >= NOW() ";
        if(!$LoadPrivate)
            $sql .= " AND `Public` = 'Y' ";
        return Appointment::Load($where);
    }

    private function Load($where = "")
    {
        $sql = "SELECT `ID`, UNIX_TIMESTAMP(`Date`) as Date, `Description`, `Location`, `Hints`, `Public`, `UserID` FROM `appointments` ";
        if(!empty($where))
            $sql .= " WHERE " . $where;
        $sql .= " ORDER BY `Date`";

        $res = DB::Query($sql);
        $appointments = array();

        while($row = mysql_fetch_array($res))
        {
            $appointment = new Appointment($row["ID"],$row["Date"],$row["Description"],$row["Location"],$row["Hints"],$row["Public"] == 'Y',$row["UserID"]);
            array_push($appointments,$appointment);
        }

        mysql_free_result($res);
        return $appointments;
    }

    var $ID;
    var $Date;
    var $Descr;
    var $Location;
    var $Hint;
    var $IsPublic;
    var $CreatorUserID;

    function Appointment($ID,$Date,$Descr,$Location,$Hint,$IsPublic,$CreatorUserID)
    {
        $this->ID = $ID;
        $this->Date = $Date;
        $this->Descr = $Descr;
        $this->Location = $Location;
        $this->Hint = $Hint;
        $this->IsPublic = $IsPublic;
        $this->CreatorUserID = $CreatorUserID;
    }
}
?>
