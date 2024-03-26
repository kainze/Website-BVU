<?php

include_once("Classes/Appointment.php");

class AppointmentView {

    var $Appointments;
    var $Edit;

    var $DataGrid;
    
    function render()
    {
        $this->LoggedIn = User::GetCurrentUser() != null;
        $this->Edit = User::GetCurrentUser() && User::GetCurrentUser()->IsInGroup("Appointments");

        $columns = array("Datum","Beschreibung","Treffpunkt","Hinweise");
        if($this->LoggedIn) $columns[] = "Öffentlich";
        $columns[] = " ";

        $where = "`Date` >= NOW() " . (!$this->LoggedIn ? " AND `Public` = 'Y'" : "");
		$orderby = "`appointments`.`Date`";
        $query = "SELECT `ID`, DATE_FORMAT(`Date`,'%d.%m.%Y %H:%i') AS Date, `Description`, `Location`, `Hints`, `Public`, `UserID` FROM `appointments` WHERE " . $where . " ORDER BY " . $orderby;

        $this->DataGrid = new DataGrid();
        $this->DataGrid->DataQuery = $query;
        $this->DataGrid->PagingDataSetsPerPage = 50;
        $this->DataGrid->PagingDataSetsMax = DB::GetDbCount("appointments",$where);
        $this->DataGrid->DataClass = $this;
        $this->DataGrid->RenderRowTemplateFile = "Templates/AppointmentDataGridRenderRowTemplate.inc.php";
        $this->DataGrid->Columns = $columns;
        $this->DataGrid->TableHtmlClass = "Appointments";
        $this->DataGrid->Selectable = true;

        include("Templates/AppointmentViewTemplate.inc.php");
    }

}

?>
