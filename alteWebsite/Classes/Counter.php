<?php

/*
 * 	Author: Christian Mayer (cmayer@xp8.de)
 * 	
 * 	Kleiner Counter mit einer nicht allzu harten refresh-Sperre ;)
 * 	Eigentum vom Autor und darf nicht ohne sein Wissen benutzt werden !!!!
 */

class Counter {

    static function Count() {
        $IP = $_SERVER['REMOTE_ADDR'];
        $Referer = "";
        
        if(isset($_SERVER['HTTP_REFERER']))
            $Referer = $_SERVER['HTTP_REFERER'];

        $sql = "INSERT INTO `counter` (`IP`,`Referer`) VALUES('" . mysql_escape_string($IP) . "','" . mysql_escape_string($Referer) . "')";
        DB::Query($sql);
    }

    static function GetVisitors() {
        $sql = "SELECT CONCAT(YEAR(`TimeStamp`),MONTH(`TimeStamp`),DAY(`TimeStamp`)) AS Tag FROM `counter` GROUP BY `Tag`,`IP`";
        
        $res = DB::Query($sql);

        return mysql_num_rows($res);
    }

}

;
?>
