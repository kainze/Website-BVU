<?php

include_once("Classes/GalleryGroupInfo.php");

class GalleryView {
    var $SelectedYear = "";
    var $AvailableYears = array();
    var $SelectedYearPictures = "";
    var $Edit = false;

    function render() {
        $this->AvailableYears = $this->GetAvailableYears();
        $this->SelectedYear = $_GET["year"];
        if (empty($this->SelectedYear))
            $this->SelectedYear = $this->AvailableYears[count($this->AvailableYears) - 1];
        $this->SelectedYearPictures = GalleryGroupInfo::LoadForYear($this->SelectedYear);

        include("Templates/GalleryViewTemplate.inc.php");
    }



    function GetAvailableYears() {
        $years = array();

        $sql = "SELECT DISTINCT YEAR(`Date`) FROM `glgroup`";
        $res = DB::Query($sql);

        while ($row = mysql_fetch_array($res))
            array_push($years, $row[0]);

        mysql_free_result($res);

        return $years;
    }

}

?>
