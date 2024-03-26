<?php

include_once("Controls/DataGrid.php");

class GuestbookView {

    var $DataGrid;
    var $Edit;

    function render()
    {        
        $this->DataGrid = new DataGrid();
        $this->DataGrid->DataQuery = "SELECT `ID`,`Autor`, `EMail`, `WWW`, `CreatedDate`, `MSG` FROM `guestbook` ORDER BY `CreatedDate` DESC";
        $this->DataGrid->PagingDataSetsPerPage = 8;
        $this->DataGrid->PagingDataSetsMax = DB::GetDbCount("guestbook");
        $this->DataGrid->DataClass = $this;
        $this->DataGrid->ShowHeader = false;
        $this->DataGrid->RenderRowTemplateFile = "Templates/GuestbookDataGridRenderRowTemplate.inc.php";
        $this->Edit = User::GetCurrentUser() && User::GetCurrentUser()->IsInGroup("Guestbook");

        include("Templates/GuestbookViewTemplate.inc.php");
    }
}

?>
