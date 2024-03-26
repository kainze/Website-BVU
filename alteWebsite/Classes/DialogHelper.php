<?php

include_once("Dialogs/EditUserDialog.class.php");
include_once("Dialogs/PictureDetailsDialog.class.php");
include_once("Dialogs/UploadImages.class.php");

class DialogHelper
{
    static function RenderRequestedDialog()
    {
        if($_POST["dialog"] == "EditUser")
            $dialog = new EditUserDialog();
        if($_POST["dialog"] == "PictureDetails")
            $dialog = new PictureDetailsDialog();
        if($_POST["dialog"] == "UploadImages")
            $dialog = new UploadImagesDialog();

        if(isset($dialog))
            $dialog->render();
    }

    static function IsDialogRequest()
    {
        return isset($_POST["dialog"]);
    }
}

?>
