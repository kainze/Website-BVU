<?php

include_once("Classes/PictureInfo.php");
include_once("Dialogs/DialogBase.class.php");

class PictureDetailsDialog extends DialogBase {

    var $PictureInfo;

    function renderContent() {
        $PictureID = $_POST["BildID"];
        $GalleryID = $_POST["GallerieID"];

        $this->PictureInfo = PictureInfo::Load($PictureID,$GalleryID);
        if (!$this->PictureInfo)
            die("Bild nicht gefunden!");

        include("DialogTemplates/PictureDetailsDialogTemplate.inc.php");
    }
}
?>
