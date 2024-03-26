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

function ContextMenu(ElementsName) {
	var CurrentOwner = null;

	//Contextmenü einbaun
	var OuterDiv = document.createElement("div");
	var OuterDiv2 = document.createElement("div");
	var Shadow = document.createElement("div");
	var ContextTable = document.createElement("table");

	OuterDiv.appendChild(OuterDiv2);
	OuterDiv2.appendChild(Shadow);
	Shadow.appendChild(ContextTable);
	
	OuterDiv.className = "outerdiv urfade";
	OuterDiv2.className = "blfade";
	Shadow.className = "shadow";

	ContextTable.className = "ContextMenu";
	document.getElementsByTagName("body")[0].appendChild(OuterDiv);

    var ElementList = document.getElementsByName(ElementsName);
	//Rechtsklick behandeln
	for(var i = 0;i< ElementList.length; i++)
	{
		ElementList[i].onmouseup = function(event){
			if(event.button == 2 && ContextTable.childNodes.length > 0)
			{
				OuterDiv.style.left = MouseX + "px";
				OuterDiv.style.top = MouseY + "px";
				OuterDiv.style.visibility = "visible";
				CurrentOwner = event.target;
			}

			return false;
		}

		ElementList[i].oncontextmenu = function(){return false;}
	}

	document.onmousedown = function(event){
		if(event.button == 0 && event.target.Name != "ContextMenuItem")
			OuterDiv.style.visibility = "hidden";
	}

	//MenuItem erstellen
    ContextMenu.prototype.AddMenuItem = function(Text, Callback)
    {
        this.AddMenuItemWithIcon(Text, null, Callback);
    }

	ContextMenu.prototype.AddMenuItemWithIcon = function(Text, Icon, Callback)
	{
		var cmTR = document.createElement("tr");
		var cmTD = document.createElement("td");
        var cmIcon = document.createElement("td");

        ContextTable.appendChild(cmTR);
        cmTR.appendChild(cmIcon);
        cmTR.appendChild(cmTD);

		cmTD.Name = "ContextMenuItem";
		cmTR.onmouseout = function() {cmTR.className="";}
		cmTR.onmouseover = function() {cmTR.className="ContextMenuHover";}
		cmTR.onclick = function() {OuterDiv.style.visibility = "hidden";Callback(CurrentOwner);}
		cmTD.innerHTML = Text;

        cmIcon.className = "ContenxtMenuIcon";
        if(Icon) cmIcon.innerHTML = "<img src='" + Icon + "'>";
	}
}

