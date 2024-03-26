<?php
class NewsView {

    var $UsersByID = array();
    var $DataGrid;
    var $Edit = false;
    
    function render()
    {
        $this->DataGrid = new DataGrid();
        $this->DataGrid->DataQuery = "SELECT `ID`,DATE_FORMAT(`TimeStamp`,'%e.%c.%Y %k:%i') AS TimeStamp, DATE_ADD(`TimeStamp`, INTERVAL 7 DAY) > NOW() as BrandNew,`MSG`,`UserID` FROM `news` ORDER BY `news`.`TimeStamp` DESC";
        $this->DataGrid->DataClass = $this;
        
        $this->DataGrid->PagingDataSetsPerPage = 10;
        $this->DataGrid->PagingDataSetsMax = DB::GetDbCount("news");
        $this->DataGrid->ShowHeader = false;
        $this->DataGrid->RenderRowTemplateFile = "Templates/NewsDataGridRenderRowTemplate.inc.php";

        $userIds = $this->GetUserIdsFromNews();
        $users = User::LoadById($userIds);
        
        foreach($users as $usr)
            $this->UsersByID[$usr->ID] = $usr;

        $this->Edit = User::GetCurrentUser() && User::GetCurrentUser()->IsInGroup("News");
        include("Templates/NewsViewTemplate.inc.php");
    }

    function GetUserIDsFromNews()
    {
        //TODO: Paging berücksichtigen. Nur wenige die News schreiben dürfen ?
        $sql = "SELECT DISTINCT `UserID` FROM `news`";
        $res = DB::Query($sql);

        $userIds = array();

        while($row = mysql_fetch_row($res))
            array_push($userIds,$row[0]);
        
        mysql_free_result($res);

        return $userIds;
    }
}

?>
