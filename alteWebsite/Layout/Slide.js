//////////////////////////
// Autor : Christian Mayer
//
// Thema : Sliden eines Objektes
//
//	Dieses Skript darf ohne meine Erlaubnis nicht kopiert und anderweitig verwendet werden!!!
//  Anregungen, Verbesserungsvorschläge oder Anfragen ob ihr das Script benutzen dürft bitte an cmayer@xp8.de schicken
/////////////////////////

var pos = 0;
var OrgPos = 0;
var interv;
var SlideAbwerts = true;

function ToggleSlide(ObjID)
{
	SlideObjTo(ObjID,0);
	setTimeout("ToogleSlideBack('" + ObjID + "')",5000);
}

function ToogleSlideBack(ObjID)
{
	var NewY = document.getElementById(ObjID).offsetHeight * -1;
	SlideObjTo(ObjID,NewY);
}

function SlideObjTo(ObjID,NewY)
{
	pos = 0;
	OrgPos = parseInt(document.getElementById(ObjID).style.top);
	if(OrgPos > NewY)
		SlideAbwerts = true;
	else
		SlideAbwerts = false;	

	interv = window.setInterval("DoSlideObjTo('" + ObjID + "','" + NewY + "')",10);
}

function DoSlideObjTo(ObjID,NewY)
{
	var Obj = document.getElementById(ObjID);
	Obj.value = pos;

	if(SlideAbwerts)
	{
		if(parseInt(Obj.style.top) > NewY)
		{
			pos = pos+1;
			Obj.style.top = parseInt(OrgPos - pos) + "px";
		}
		else
			window.clearInterval(interv);
	}
	else
	{
		if(parseInt(Obj.style.top) < NewY)
		{
			pos = pos+1;
			Obj.style.top = parseInt(OrgPos + pos) + "px";
		}
		else
			window.clearInterval(interv);
	}
}
