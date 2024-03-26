<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("Dialogs/DialogBase.class.php");

class UploadImagesDialog extends DialogBase {

    var $GID;

    function renderContent() {

        if(!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Pics"))
            return;

        $this->GID = $_POST["GID"];

        include("DialogTemplates/UploadImagesTemplate.inc.php");
    }

}
?>
