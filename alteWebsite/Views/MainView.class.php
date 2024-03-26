<?php

include_once("Views/GalleryView.class.php");
include_once("Views/StaticView.class.php");
include_once("Views/ContactsView.class.php");
include_once("Views/LinksView.class.php");
include_once("Views/GuestbookView.class.php");
include_once("Views/NewsView.class.php");
include_once("Views/AppointmentView.class.php");
include_once("Views/DevelView.class.php");
include_once("Views/GalleryDetailsView.class.php");
include_once("Views/UsersView.class.php");
include_once("Views/ProfileView.class.php");

class MainView {

    var $LoggedIn = false;
    var $IsDevel = false;
    var $Visitors = 0;
    var $ShowNewNewsFlag = false;
    var $UserID = 0;

    function render() {

        $this->LoggedIn = User::GetCurrentUser()!= null;
        $this->UserID = User::GetCurrentUser() ? User::GetCurrentUser()->ID : 0;
        $this->IsDevel = User::GetCurrentUser() && User::GetCurrentUser()->IsInGroup("Devel");
        $this->Visitors = Counter::GetVisitors();
        $this->ShowNewNewsFlag = DB::GetDbCount("news", "DATE_ADD(`TimeStamp`, INTERVAL 7 DAY) > NOW()") > 0;
        Counter::Count();
        include("Templates/MainViewTemplate.inc.php");
    }

    function GetContentView() {
        //Einbinden der Seiten jeh nach content
        $Content = $_GET["content"];

        if($Content == "")
            return new StaticView("Templates/WelcomeViewTemplate.inc.php");
        if($Content == "BildDetails")
            return new PictureDetailsView();
        if($Content == "Gallerie")
            return new GalleryView();
        if($Content == "Kontakt")
            return new ContactsView();
        if($Content == "Impressum")
            return new StaticView("Templates/LegalInfoViewTemplate.inc.php");
        if($Content == "Gaestebuch")
            return new GuestbookView();
        if($Content == "Links")
            return new LinksView();
        if($Content == "Ueberuns")
            return new StaticView("Templates/AboutUsViewTemplate.inc.php");
        if($Content == "News")
            return new NewsView();
        if($Content == "Satzung")
            return new StaticView("Templates/StatutesViewTemplate.inc.php");
        if($Content == "Termine")
            return new AppointmentView();
        if($Content == "Vorstandschaft")
            return new StaticView("Templates/LeaderViewTemplate.inc.php");
        if($Content == "Devel")
            return new DevelView();
        if($Content == "GallerieDetails")
            return new GalleryDetailsView();
        if($Content == "Mitglieder")
            return new UsersView();
        if($Content == "Profil")
            return new ProfileView();
        
        /*
        if ($Content == "Aktionview")
            return "Contents/Aktionview.php";
        if ($Content == "BildDetail")
            return "Contents/BildDetail.php";
        if ($Content == "Profil")
            return "Contents/Profil.php";
        if ($Content == "Mitglieder")
            return "Contents/Mitglieder.php";

        return "";
        */
    }

}

?>
