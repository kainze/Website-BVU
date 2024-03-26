document.write("<div id='divToolTip'></div>");

function ShowToolTip(Html)
{
	var o_divToolTip = document.getElementById('divToolTip');
	o_divToolTip.style.position = "absolute";
	o_divToolTip.style.left = (MouseX + 10) + "px";
	o_divToolTip.style.top = (MouseY + 10) + "px";
	o_divToolTip.style.zIndex = "999";
	o_divToolTip.innerHTML = Html;
}

function HideToolTip()
{
	document.getElementById('divToolTip').innerHTML = '';
}
