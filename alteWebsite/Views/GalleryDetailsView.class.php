<?php

include_once("Classes/User.php");
include_once("Controls/DataGrid.php");

class GalleryDetailsView
{
    var $Edit;
    var $DataGrid;
    var $GalleryGroupInfo;
    
    function render()
    {
        $GalleryID = $_GET["ID"];
        if(empty($GalleryID) || !is_numeric($GalleryID))
            return;
        
        $this->Edit = User::GetCurrentUser() && User::GetCurrentUser()->IsInGroup("Pics");
        $this->GalleryGroupInfo = GalleryGroupInfo::LoadByID($GalleryID);

        $this->DataGrid = new DataGrid();
        $this->DataGrid->RenderRowTemplateFile = "Templates/GalleryDetailsViewRenderRowTemplate.inc.php";
        $this->DataGrid->DataClass = $this;

        $where = "`GLGroupID` = " . mysql_escape_string($GalleryID);
        $this->DataGrid->DataQuery = "SELECT `ID` FROM `glitem` WHERE " . $where . " ORDER BY `ID`";
        $this->DataGrid->PagingDataSetsMax = DB::GetDbCount("glitem",$where);
        $this->DataGrid->PagingDataSetsPerPage = 100;
        
        $this->DataGrid->CellsPerRow = 4;
        $this->DataGrid->ShowHeader = false;

        include("Templates/GalleryDetailsViewTemplate.inc.php");
    }
}

?>
