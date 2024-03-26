<?php
class DB {

    private static $mysql_host = "localhost";
    private static $mysql_user = "web595";
    private static $mysql_pass = "b13rg1bts";
    private static $mysql_db = "usr_web595_1";
    private static $charset = "utf8";

    static function Connect()
    {
        $con = mysql_pconnect(DB::$mysql_host,DB::$mysql_user,DB::$mysql_pass) or die("Koa Verbindung!");
        mysql_select_db(DB::$mysql_db,$con) or die("Koa Vabindung zua Dadnbank!");
        mysql_query("SET CHARSET utf8");
        mysql_query("SET NAMES utf8");

        return $con;
    }

    static function Query($Sql)
    {
        $con = DB::Connect();
        $res = mysql_query($Sql,$con);
        if(mysql_error() != "")
        {
            echo mysql_error();
            echo $Sql;
        }
        return $res;
    }

    static function GetDbCount($table,$where = "")
    {
        $sql = "SELECT COUNT(*) FROM `" . $table . "` ";
        if($where != "")
            $sql .= " WHERE " . $where;
        
        $res = DB::Query($sql);
        $row = mysql_fetch_row($res);
        $count = $row[0];
        mysql_free_result($res);
        return $count;
    }

    static function CorrectMixedUtf8AndLatin1Encoding($Table, $Column)
    {
        if(empty($Table) || Empty($Column))
            return 0;
        
        $replace_chars = array(
            "Ã¤" => "ä",
            "Ã¶" => "ö",
            "Ã¼" => "ü",
            "Ã„" => "Ä",
            "Ã–" => "Ö",
            "Ãœ" => "Ü",
            "ÃŸ" => "ß");

        if(!empty($Table) && !empty($Column))
        {
            $cntData = DB::GetDbCount($Table);
            $blockSize = 200;
            $cnt = 0;

            for($i=0;$i<$cntData;$i+=$blockSize)
            {
                $res = DB::Query("SELECT " . mysql_escape_string($Column). " FROM `". mysql_escape_string($Table) . "` LIMIT " . $i . "," . $blockSize);

                while($row = mysql_fetch_row($res))
                {
                    $DbLine = $row[0];
                    if(!strstr($DbLine,"Ã") && !strstr($DbLine,"Â"))
                        continue;
                    
                    foreach($replace_chars as $incChar => $Char)
                        $DbLine = str_replace($incChar, $Char, $DbLine);

                    if($DbLine != $row[0])
                    {
                        $qryUpdate = "UPDATE `" . mysql_escape_string($Table) . "` SET `" . mysql_escape_string($Column) . "` = '" . $DbLine . "' WHERE `" . mysql_escape_string($Column) . "` = '" . $row[0] . "'";
                        DB::Query($qryUpdate);
                        $cnt++;
                    }
                }
            }

            return $cnt;
        }
    }
}
?>
