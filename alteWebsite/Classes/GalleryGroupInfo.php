<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GalleryPictureInfo
 *
 * @author mayer
 */
class GalleryGroupInfo {
    var $ID;
    var $Descr;
    var $Date;
    var $PreviewPicID;

    function LoadForYear($Year) {
        if(!is_numeric($Year))
            return null;
        
        return GalleryGroupInfo::Load("YEAR(`Date`) = '" . mysql_escape_string($Year) . "'");
    }

    function LoadByID($ID)
    {
        if(!is_numeric($ID))
            return null;
        
        $groupInfos = GalleryGroupInfo::Load("ID = " . mysql_escape_string($ID));
        return $groupInfos[0];
    }

    private function Load($Where)
    {
        $sql = "SELECT `ID`,`Description`,UNIX_TIMESTAMP(`Date`) as Date,`PreviewBildID`,`UserID` FROM `glgroup` ";
        if(isset($Where))
            $sql .= " WHERE " . $Where;
        
        $res = DB::Query($sql);
        $pictures = array();

        while ($row = mysql_fetch_array($res)) {
            $pi = new GalleryGroupInfo($row["ID"], $row["Description"], $row["Date"], $row["PreviewBildID"]);
            array_push($pictures, $pi);
        }

        mysql_free_result($res);
        return $pictures;
    }

    function GalleryGroupInfo($ID, $Descr, $Date, $PreviewPicID)
    {
        $this->ID = $ID;
        $this->Descr = $Descr;
        $this->Date = $Date;
        $this->PreviewPicID = $PreviewPicID;
    }

    function GetThumbnailPath() {
        if (empty($this->PreviewPicID))
            return "GalleriePics/Static/nopic.jpg";
        else
            return "GalleriePics/" . $this->ID . "/p_" . $this->PreviewPicID . ".jpg";
    }
}
?>
