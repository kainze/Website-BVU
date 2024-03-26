<?php
class DataGrid {

    var $DataQuery;
    var $TableHtmlClass;
    var $TableHtmlId;
    var $ShowHeader;
    var $PagingDataSetsPerPage;
    var $PagingDataSetsMax;
    var $DataClass;
    var $RenderRowTemplateFile;

    var $Selectable;
    var $ShowContextBox;
    var $CellsPerRow;
    var $TableHtmlStyle;

    private $CurrentPage = 1;

    function DataGrid()
    {
        $this->PagingDataSetsPerPage = 0;
        if(!empty($_GET["p"]))
            $this->CurrentPage = $_GET["p"];
        $this->TableHtmlId = "dgTable";
        $this->RenderRowTemplateFile = "";
        $this->ShowHeader = true;
        $this->Columns = array();

        $this->Selectable = false;
        $this->CellsPerRow = 1;
        $this->TableHtmlStyle = "";
    }
    
    function render()
    {
        if(empty($this->DataQuery))
            return;
        
        if($this->PagingDataSetsPerPage > 0)
        {
            $start = ($this->CurrentPage - 1) * $this->PagingDataSetsPerPage;
            $this->DataQuery .= " LIMIT " . mysql_escape_string($start) . "," . mysql_escape_string($this->PagingDataSetsPerPage);
        }

        $res = DB::Query($this->DataQuery);

        if($this->PagingDataSetsPerPage > 0 && $this->PagingDataSetsPerPage < $this->PagingDataSetsMax)
        {
            $this->drawGBMenu();
            echo "<br>";
        }

        echo "<table class=' ";
        
        //Wenn das DataGrid auswählbar ist ist es die Tabelle nicht mehr (Text)
        if($this->Selectable)
            echo " unselectable ";
        echo $this->TableHtmlClass . "'";

        if(!empty($this->TableHtmlId))
            echo " id='" . $this->TableHtmlId . "'";

        if(!empty($this->TableHtmlStyle))
            echo " style='" . $this->TableHtmlStyle . "'";
        
        echo ">";

        if($this->ShowHeader)
            $this->printTableHeader($res);

        if($this->CellsPerRow <= 0)
            $this->CellsPerRow = 1;
        
        $cellOfRow = 0;

        while($row = mysql_fetch_array($res))
        {
            if($cellOfRow == 0)
                echo "<tr>";
            
            if(!empty($this->RenderRowTemplateFile))
            {
                $dataClass = $this->DataClass;
                include($this->RenderRowTemplateFile);
            }
            else
            {
                foreach($row as $key => $value)
                    echo "<td>" . $value . "</td>";
            }

            if($cellOfRow >= $this->CellsPerRow-1)
            {
                echo "</tr>";
                $cellOfRow = 0;
            }else
                $cellOfRow++;
        }

        echo "</table>";

        if($this->PagingDataSetsPerPage > 0 && $this->PagingDataSetsPerPage < $this->PagingDataSetsMax)
        {
            echo "<br>";
            $this->drawGBMenu();
        }

        echo "<link rel='stylesheet' type='text/css' href='Layout/DataGrid.css'>\n"
            ."<script type='text/javascript' src='Layout/DataGrid.js'></script>\n"
            ."<script type='text/JavaScript'>"
                ." var dg = new DataGridController('" . $this->TableHtmlId . "'," . ($this->Selectable ? "true" : "false") . "," . ($this->ShowContextBox ? "true" : "false" ) . ");"
                ." dg.Init();";

        if($this->Selectable)
            echo "dg.contextMenu.AddMenuItemWithIcon('Löschen',function() { alert('test'); },'Layout/del.png');";

        echo "</script>\n";

        mysql_free_result($res);
    }

    function printTableHeader($res)
    {
        echo "<tr>";

        if(count($this->Columns) > 0)
        {
            foreach($this->Columns as $column)
                echo "<td>" . $column . "</td>";
        }else
        {
            while($field = mysql_fetch_field($res))
                echo "<td>" . $field->name . "</td>";
        }
        echo "</tr>";
    }

    function drawGBMenu()
    {
        $pages = ceil($this->PagingDataSetsMax/$this->PagingDataSetsPerPage);
        
        $url = $_SERVER["REQUEST_URI"];
        $url = str_replace("&p=" . $this->CurrentPage, "", $url);

        echo "<table><tr><td>Seitn:</td>";

        for($i=1;$i<$pages+1;$i++)
        {
            echo "<td class='GBSeitenZahl";
            if($this->CurrentPage == $i)
                echo "Aktiv";

            echo "' onClick=\"JavaScript:window.location.href='http://" . $_SERVER["SERVER_NAME"] . $url . "&p=" . $i . "';\"><b>" . $i . "</b></td>";
        }
        echo "</tr></table>";
    }
}
?>
