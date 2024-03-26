///////////////////////////////////////////////////////////////////
//
//	Author: Christian Mayer
//
//	CopyRight by Christian Mayer
//
//  	Name: Context-Menüs
//
//	Dieses Skript darf ohne die Erlaubnis des Authors nicht kopiert und anderweitig verwendet werden!!!
//
///////////////////////////////////////////////////////////////////

function DataGridController(DataGridId, Selectable, ShowContextBox)
{
    var rows;
    var activeRowIndex;
    this.contextMenu;

    DataGridController.prototype.Init = function() {
        var dataGrid = document.getElementById(DataGridId);
        rows = dataGrid.getElementsByTagName("tr");

        for(var i=0;i<rows.length;i++)
            InitRow(i);

        if(ShowContextBox)
            this.contextMenu = new ContextMenu(rows);
    }
    

    function InitRow(rowIndex)
    {
        if(Selectable)
            rows[rowIndex].addEventListener("mousedown",function(e) {onRowClicked(e,rowIndex);}, false);
    }

    function onRowClicked(e,rowIndex)
    {
        if(e.button == 0)
        {
            if(!e.ctrlKey)
            {
                for(var i=0;i<rows.length;i++)
                    rows[i].className = "";
            }

            if(e.shiftKey)
            {
                var iStart = activeRowIndex;
                var iEnd = rowIndex;

                if(iStart > iEnd)
                {
                    iStart = rowIndex;
                    iEnd = activeRowIndex;
                }

                for(var i=iStart;i<=iEnd;i++)
                    rows[i].className = "dgSelectedRow";
            }

            rows[rowIndex].className = "dgSelectedRow";
            activeRowIndex = rowIndex;
        }
    }

    function doDeleteSelectedRows()
    {
        alert("Delete");
    }
}