/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function ShowDialog(action)
{
    var ajax = new Ajax();

    ajax.OnAnswer = function(Content)
    {
        var div = document.getElementById("divDialog");
        var divOuter = document.getElementById("divDialogOuter");
        var divBg = document.getElementById("divDialogBackground");

        div.innerHTML = Content;

        divBg.style.visibility = "visible";
        divOuter.style.visibility = "visible";
        div.style.visibility = "visible";
    }

    ajax.Request("index.php", action, false, true);
}

function HideDialog()
{
    var div = document.getElementById("divDialog");
    var divOuter = document.getElementById("divDialogOuter");
    var divBg = document.getElementById("divDialogBackground");
    
    div.innerHTML = "";

    divBg.style.visibility = "hidden";
    divOuter.style.visibility = "hidden";
    div.style.visibility = "hidden";
}