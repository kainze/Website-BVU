<?php

class UsersView
{
    var $DataGrid;
    var $Edit;
    var $Filter;
    
    function render()
    {
        if(!User::GetCurrentUser())
            return;

        $this->Filter = $_POST["Filter"];
        if(empty($this->Filter))
            $this->Filter = $_GET["Filter"];
        
        $this->Edit = true;

        $query = "SELECT `ID`,`Firstname`, `Name`, `Street`, `Zip`, `City`, `Email`, `Phone`, `Mobile`,`Birthday`,`State` FROM `users` ";
        if(!empty($this->Filter))
        {
            $where = "`Firstname` LIKE '%" . mysql_escape_string($this->Filter) . "%' OR `Name` LIKE '%" . mysql_escape_string($this->Filter) . "%'";
            $query .= " WHERE " . $where;
        }

        $query .= " ORDER BY `Name`,`Firstname` ";

        $this->DataGrid = new DataGrid();
        $this->DataGrid->DataQuery = $query;
        $this->DataGrid->ShowHeader = false;
        $this->DataGrid->RenderRowTemplateFile = "Templates/UsersDataGridRenderRowTemplate.inc.php";
        $this->DataGrid->DataClass = $this;
        $this->DataGrid->CellsPerRow = 2;
        $this->DataGrid->TableHtmlStyle = "width: 100%";
        $this->DataGrid->PagingDataSetsMax = DB::GetDbCount("users",$where);
        $this->DataGrid->PagingDataSetsPerPage = 50;

        include("Templates/UsersViewTemplate.inc.php");
    }
}

?>