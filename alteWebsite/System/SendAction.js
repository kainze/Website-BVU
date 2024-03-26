var http_request = false;

function SendAction(action,JumpOnSuccess)
{
    if (window.XMLHttpRequest) { // Mozilla, Safari,...
        http_request = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE
        try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }

    if(!http_request){
        alert("Es konnte keine XMLHTTP-Instanz erzeugt werden!");
        return false;
    }

    http_request.onreadystatechange = function(){
        if(http_request.readyState == 4){
            if(http_request.status == 200){
                if(http_request.responseText == "")
                {
                    if(JumpOnSuccess != "")
                        location.href=JumpOnSuccess;
                }
                else
                {
                    var diverr = document.getElementById('diverr');
                    diverr.innerHTML = "<table class='Error'><tr><td><font color='red'>" + http_request.responseText + "</font></td><td><img src='Layout/err.png'></td></tr></table>";
                    diverr.style.position = "absolute";
                    diverr.style.zindex = 250;
                    diverr.style.top =  parseInt(((window.innerHeight - diverr.offsetHeight)/2 + window.pageYOffset)) + "px";
                    diverr.style.left = parseInt(((window.innerWidth  - diverr.offsetWidth)/2 + window.pageXOffset)) + "px";
                    diverr.style.visibility = "visible";

                    window.setTimeout("document.getElementById('diverr').style.visibility = 'hidden'",3000);
                }
            }
        }
    }

    http_request.open('POST',"System/Actions.php",true);
    http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http_request.setRequestHeader("Content-length", action.length);
    http_request.setRequestHeader("Connection", "close");
    http_request.send(action);
}

