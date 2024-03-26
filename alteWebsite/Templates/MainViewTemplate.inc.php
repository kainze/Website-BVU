<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Layout/Maincss.css">
        <link rel="stylesheet" type="text/css" href="Layout/Calendar.css">
        <link rel="stylesheet" type="text/css" href="Layout/ContextMenu.css">
        <link rel="stylesheet" type="text/css" href="Layout/DateTimePicker.css">
        <title>Burschenverein Unterneukirchen</title>
    </head>
    <body>
        <div id="divMainOuter" style="position: relative; width: 1024px; margin-left: auto; margin-right: auto">
            <script type="text/javascript" src="System/Ajax.js"></script>
            <script type="text/javascript" src="Layout/ToolTip.js"></script>
            <script type="text/javascript" src="Layout/Slide.js"></script>
            <script type="text/javascript" src="Layout/Calendar.js"></script>
            <script type="text/javascript" src="Layout/ContextMenu.js"></script>
            <script type="text/JavaScript" src="Layout/DateTimePicker.js"></script>
            <script type="text/JavaScript" src="System/SendAction.js"></script>
            <script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
            <script type="text/JavaScript" src="System/AnonymizeEmail.js"></script>
            <script type="text/JavaScript" src="Layout/DialogWindow.js"></script>
            <script type="text/JavaScript">

                var MouseX = 0;
                var MouseY = 0;

                document.onmousemove = function(e)
                {
                    if(window.ActiveXObject)
                    {
                        MouseX = event.clientX + document.body.scrollLeft;
                        MouseY = event.clientY + document.body.scrollTop;
                    } else {
                        MouseX = e.pageX;
                        MouseY = e.pageY;
                    }
                }

                var UserAgent = navigator.userAgent.toLowerCase();
                var BrowserName = "";
                if ( UserAgent.indexOf( "opera" ) != -1 ) {
                    BrowserName = "opera";
                } else if ( UserAgent.indexOf( "msie" ) != -1 ) {
                    BrowserName = "msie";
                } else if ( UserAgent.indexOf( "safari" ) != -1 ) {
                    BrowserName = "safari";
                } else if ( UserAgent.indexOf( "mozilla" ) != -1 ) {
                    if ( UserAgent.indexOf( "firefox" ) != -1 ) {
                        BrowserName = "firefox";
                    } else {
                        BrowserName = "mozilla";
                    }
                }

    <? if ($this->LoggedIn) { ?>
            function Logout(){
                SendAction("action=Logout","index.php");
            }
    <? } else { ?>
            function Login(){
                SendAction("action=Login&user=" + document.getElementById("liuser").value + "&pass=" + document.getElementById("lipass").value,"index.php");
            }
    <? } ?>

            </script>

    <? if ($this->LoggedIn) { ?>
                <img src="Layout/Logout.jpg" alt="Abmelden" class="Abmelden">
                <div class="Abmelden">
                    <a class="Menu" href="JavaScript:Logout()">Obmoidn</a>
                </div>
    <? } else { ?>
                <img src="Layout/Login.jpg" alt="Anmelden" class="Anmelden">
                <div class="Anmelden">
                    <table class="Anmelden">
                        <tr><td><input id="liuser" type="text" class="Anmelden" value="Dei Nam:" onfocus="if(this.value=='Dei Nam:') this.value='';" onblur="if(this.value=='') value='Dei Nam:'" onkeydown="if(event.keyCode==13) Login();"></td></tr>
                        <tr><td><input id="lipass" type="password" class="Anmelden" value="Kennwort:" onfocus="if(this.value=='Kennwort:') this.value='';" onblur="if(this.value=='') value='Kennwort:';" onkeydown="if(event.keyCode==13) Login();"></td></tr>
                        <tr><td align="center" colspan="2"><a class="Menu" href="JavaScript:Login()">Omoidn</a></td></tr>
                    </table>
                </div>
    <? } ?>

            <img id="cmtst" src="Layout/Header.jpg" alt="Burschenverein Unterneukirchen" class="Header">
            <img src="Layout/Menu.jpg" alt="Menü" class="HauptMenu">
            <div class="HauptMenu">
                <div><a class="Menu" href="index.php?content=News">Neis</a>

    <? if ($this->ShowNewNewsFlag) { ?>
                    <img class="MenuItemNew" src="Layout/BrandNewLittle.jpg" alt="Neu">
    <? } ?>
                    <br>
                    <a class="Menu" href="index.php?content=Ueberuns">Üba uns</a><br>
                    <a class="Menu" href="index.php?content=Termine">Termine</a><br>
                    <a class="Menu" href="index.php?content=Satzung">Satzung</a><br>
                    <a class="Menu" href="index.php?content=Vorstandschaft">Vorstandschaft</a><br>
                    <a class="Menu" href="index.php?content=Kontakt">Kontakt</a><br>
                    <br>
                    <a class="Menu" href="index.php?content=Gaestebuch">Gästebiache</a><br>
                    <a class="Menu" href="index.php?content=Gallerie">Buidl</a><br>
                    <br>
                    <a class="Menu" href="index.php?content=Links">Links</a><br>

    <? if ($this->LoggedIn) { ?>
                    <br>
                    <a class="Menu" href="index.php?content=Profil&ID=<? echo $this->UserID; ?>">Dei Profil</a><br>
                    <a class="Menu" href="index.php?content=Mitglieder">Mitglieder</a><br>
    <? } ?>

    <? if ($this->IsDevel) { ?>
                    <a class="Menu" href="index.php?content=Devel">Devel</a><br>
    <? } ?>

                </div>
            </div>
            <div class="MenuBottom">
                <div width="100%" style="text-align: center">Besucher: <? echo $this->Visitors ?></div>
                <br><br><br>  Copyright &copy; 2007<br>Christian Mayer<br>All rights reserved<br><br>
                <a class="Menu" href="index.php?content=Impressum">Impressum</a><br>
            </div>

            <script type="text/JavaScript">
                var cal = new Calendar();
                cal.show("divMainOuter");
            </script>

            <div id="divContentFrame">
    <?
        $ContentView = $this->GetContentView();
        if(!empty($ContentView))
            $ContentView->render();
    ?>
                <br><br>
            </div>
        </div>

        <div id="divDialogBackground" class="DialogBackground"></div>
        <div id="divDialogOuter" class="DialogOuter">
            <div id="divDialog" class="Dialog"></div>
        </div>

        <div id='diverr'></div>

    </body>
</html>
<!--- programmiert und gezeichnet von Christian Mayer-->

