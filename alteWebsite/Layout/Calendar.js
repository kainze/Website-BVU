///////////////////////////////////////////////////////////////////
//
//	Author: Christian Mayer <cmayer@xp8.de>
//	
//	CopyRight by Christian Mayer
//
//  	Name: Ajax-Kalender
//
//	Dieses Skript darf ohne meine Erlaubnis nicht kopiert und anderweitig verwendet werden!!!
//  	Anregungen, Verbesserungsvorschläge oder Anfragen ob ihr das Script benutzen dürft bitte an cmayer@xp8.de schicken
//
///////////////////////////////////////////////////////////////////

function Calendar() {
	var _Events = new Array();
	var _TDs = new Array();
	var _ajax = new Ajax();
	var _DivCalendar = null;
	var _DivCalendarDetail = null;
	var _DivLoading = null;
	var _BoolShown = false;

	var _DateTime = new Date();
	_DateTime.setDate(1);
	        
	_ajax.OnAnswer = function(Content)
	{
		var Days = Content.getElementsByTagName('Day');

		for(var i =0;i<Days.length;i++)
		{
			var Day = Days[i].attributes.length == 0 ? "" : Days[i].attributes[0].nodeValue;
			var Time = Days[i].getElementsByTagName('Time').length == 0 ? "" : Days[i].getElementsByTagName('Time')[0].firstChild.nodeValue;
			var Description = Days[i].getElementsByTagName('Description').length == 0 ? "" : Days[i].getElementsByTagName('Description')[0].firstChild.nodeValue;
			var Location = Days[i].getElementsByTagName('Location').length == 0 ? "" : Days[i].getElementsByTagName('Location')[0].firstChild.nodeValue;
			var Hints = Days[i].getElementsByTagName('Hints').length == 0  || Days[i].getElementsByTagName('Hints')[0].firstChild == null ? "" : Days[i].getElementsByTagName('Hints')[0].firstChild.nodeValue;
			Calendar.prototype.AddDay(Day,Time,Description,Location,Hints);
		}

		_DivLoading.innerHTML = "";
	}

	Calendar.prototype.AddDay = function(Day,Time,Description,Location,Hints) {

		var HTMLOutput = Time + " - <b>" + Description + "</b><hr>\n"
						 +"Treffpunkt :" + Location + "<br>\n"
						 +"Hinweis :" + Hints + "<br><br><br>\n";

		if(_Events[Day] == null)
			_Events[Day] = HTMLOutput;
		else
			_Events[Day] += HTMLOutput;

		_TDs[Day].className = "DaysWithEvent";
        
	}

	Calendar.prototype.ClearDays = function() {
		for(var i=0;i<_TDs.length;i++)
			_TDs[i].className = "Days";

		_Events = new Array();
	}

	function LoadAllEvents() {
		
        var DateString = "";
        DateString += (_DateTime.getYear() + 1900).toString();

		DateString += (_DateTime.getMonth()+1 < 10 ? "0" : "") + (_DateTime.getMonth() + 1).toString();

		for(var i = 0; i< _Events.length;i++)
			_Events[i] = null;

		_ajax.Request("System/Actions.php","action=GetAppointments&Time=" + DateString, true, false);
	} 

	function Reload() {
        
		_DivCalendar.innerHTML = "";
		var maintable = document.createElement("table");
		maintable.id="tblOuter";
		maintable.className="Outer";
		_DivCalendar.appendChild(maintable);
		
		var tbody = document.createElement("tbody");
		maintable.appendChild(tbody);

		var CurTr = document.createElement("tr");
		tbody.appendChild(CurTr);
		
		var CurTd = document.createElement("td");
		CurTd.colSpan="7";
		CurTd.className="HeadlineWithDate";
		CurTr.appendChild(CurTd);

		var arrow = document.createElement("img");
		arrow.onmousedown = function() {
			_DateTime.setMonth(_DateTime.getMonth()-1);
			Reload();
		}

		arrow.className="HeadlineWithDate";
		arrow.src="Layout/kalArrowLeft.jpg";
		CurTd.appendChild(arrow);

		var DateString = "";
        DateString += (_DateTime.getYear() + 1900).toString();

		DateString += "-" + (_DateTime.getMonth()+1<10 ? "0" : "") + (_DateTime.getMonth() +1).toString();
		boldText = document.createElement("b");
		boldText.innerHTML = DateString
		CurTd.appendChild(boldText);

		arrow = document.createElement("img");
		arrow.onmousedown = function(e) {
			_DateTime.setMonth(_DateTime.getMonth()+1);
			Reload();
		}	
		arrow.className="HeadlineWithDate";
		arrow.src="Layout/kalArrowRight.jpg";
		CurTd.appendChild(arrow);

		//Header
		CurTr = document.createElement("tr");
		tbody.appendChild(CurTr);
		
		CurTd = document.createElement("td");
		CurTd.className="CalendarHeader";
		CurTd.innerHTML = "So";
		CurTr.appendChild(CurTd);

		CurTd = document.createElement("td");
		CurTd.className="CalendarHeader";
		CurTd.innerHTML = "Mo";
		CurTr.appendChild(CurTd);

		CurTd = document.createElement("td");
		CurTd.className="CalendarHeader";
		CurTd.innerHTML = "Di";
		CurTr.appendChild(CurTd);

		CurTd = document.createElement("td");
		CurTd.className="CalendarHeader";
		CurTd.innerHTML = "Mi";
		CurTr.appendChild(CurTd);

		CurTd = document.createElement("td");
		CurTd.className="CalendarHeader";
		CurTd.innerHTML = "Do";
		CurTr.appendChild(CurTd);

		CurTd = document.createElement("td");
		CurTd.className="CalendarHeader";
		CurTd.innerHTML = "Fr";
		CurTr.appendChild(CurTd);

		CurTd = document.createElement("td");
		CurTd.className="CalendarHeader";
		CurTd.innerHTML = "Sa";
		CurTr.appendChild(CurTd);

		//Bis zum richtigen Tag auffüllen
		var DayOfWeek = _DateTime.getDay();
		
		CurTr = document.createElement("tr");
		tbody.appendChild(CurTr);

		var Pos = 0;
		
		for(var i=0;i<DayOfWeek;i++)
		{
			CurTr.appendChild(document.createElement("td"));
			Pos++;
		}

		var MaxDays = GetDaysOfMonth(_DateTime.getYear(),_DateTime.getMonth());
		_TDs = new Array();
		for(var i=1;i<MaxDays+1;i++)
		{

			var CurDate = CopyDate(_DateTime);
			CurDate.setDate(i);
			var Day = CurDate.getDate();

			//Neue Zeile
			if(Pos%7 == 0 && Pos != 0)
			{
				 CurTr = document.createElement("tr");
				 tbody.appendChild(CurTr);
			}
	
			CurTd = document.createElement("td");
			CurTd.name="tdDay";
			var Now = new Date();

			if(CurDate.getYear() == Now.getYear() && CurDate.getMonth() == Now.getMonth() && CurDate.getDate() == Now.getDate())
				CurTd.className="Days Today";			
			else
				CurTd.className="Days";

			CurTd.innerHTML = Day;
			//CurTd.innerHTML = (Day<10 ? "0" : "") + Day;
			if(document.addEventListener)
			{
				CurTd.addEventListener("mousemove",TD_onmousemove,false);
				CurTd.addEventListener("mouseout",TD_onmouseout,false);
			}
			else
			{
				CurTd.attachEvent("onmousemove",TD_onmousemove);
				CurTd.attachEvent("onmouseout",TD_onmouseout);
			}

			CurTr.appendChild(CurTd);
			_TDs[Day] = CurTd;

			Pos++;

		}

		CurTr = document.createElement("tr");
		tbody.appendChild(CurTr);

		CurTd = document.createElement("td");
		CurTd.colSpan="7";
						
		_DivLoading = document.createElement("div");
		_DivLoading.id="divKalenderLoadingAnzeige";
		_DivLoading.align="center";
		_DivLoading.innerHTML="<b>Loading...</b>";
		
		CurTd.appendChild(_DivLoading);
		CurTr.appendChild(CurTd);
		
		LoadAllEvents();
	}

	Calendar.prototype.show = function(ParentID) {
		if(!_BoolShown)
		{
			_BoolShown = true;

			_DivCalendar = document.createElement("div");
			_DivCalendar.className = "Calendar";
			_DivCalendarDetail = document.createElement("div");
			_DivCalendarDetail.className="DayDetail";

			Reload();

            var parent = document.getElementById(ParentID);
            if(!parent)
                parent = document.body;
            
			parent.appendChild(_DivCalendar);
			parent.appendChild(_DivCalendarDetail);
		}
	}
	
	function TD_onmousemove(e) {
		var ThisDay = 0;
		if(e["srcElement"])
			ThisDay = parseInt(e["srcElement"].innerHTML);
		else if(e["target"])
			ThisDay = parseInt(e["target"].innerHTML);
		
		if(_TDs[ThisDay].className != "DaysHover")
		{
			var Now = new Date();
			var CurDate = CopyDate(_DateTime);
			CurDate.setDate(ThisDay);

			if(CurDate.getYear() == Now.getYear() && CurDate.getMonth() == Now.getMonth() && CurDate.getDate() == Now.getDate())
				_TDs[ThisDay].className = "DaysHover Today";
			else
				_TDs[ThisDay].className = "DaysHover";
		}

		if(_Events[ThisDay] != null)
		{
			//Position festlegen
            _DivCalendarDetail.innerHTML = _Events[ThisDay];
			_DivCalendarDetail.style.visibility = "visible";
			_DivCalendarDetail.style.top = (MouseY +5).toString() + "px";
			_DivCalendarDetail.style.left = (MouseX -10 - _DivCalendarDetail.offsetWidth).toString() + "px";
		}
	}
	
	function TD_onmouseout(e) {
		var Target = null;
		if(window.ActiveXObject)
			Target = e.toElement;
		else
			Target = e.relatedTarget;

		var ThisDay = 0;
		if(e["srcElement"])
			ThisDay = parseInt(e["srcElement"].innerHTML);
		else if(e["target"])
			ThisDay = parseInt(e["target"].innerHTML);
		
			
		if(typeof Target != "HTMLFontElement" )
		{
			var Now = new Date();
			var CurDate = CopyDate(_DateTime);
			CurDate.setDate(ThisDay);

			if(_Events[ThisDay] != null)
			{
				if(CurDate.getYear() == Now.getYear() && CurDate.getMonth() == Now.getMonth() && CurDate.getDate() == Now.getDate())
					_TDs[ThisDay].className = "DaysWithEvent Today";
				else
					_TDs[ThisDay].className = "DaysWithEvent";
			}
			else
			{
				if(CurDate.getYear() == Now.getYear() && CurDate.getMonth() == Now.getMonth() && CurDate.getDate() == Now.getDate())
					_TDs[ThisDay].className = "Days Today";
				else
					_TDs[ThisDay].className = "Days";
			}
			
			_DivCalendarDetail.innerHTML = "";
			_DivCalendarDetail.style.visibility = "hidden";
		}
	}

	function GetDaysOfMonth(Year,Month)
	{
		return 32 - new Date(Year, Month, 32).getDate();
	}

	function CopyDate(DateTime)
	{
        return new Date(DateTime.getYear()+1900,DateTime.getMonth(),DateTime.getDate());
	}
	
}
