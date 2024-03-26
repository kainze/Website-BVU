<?php

include_once("Dialogs/DialogBase.class.php");

class EditUserDialog extends DialogBase {
    var $User;
    var $EditID;

    protected function  renderContent()
    {
        if(!User::GetCurrentUser())
            return;

        $this->EditID = $_POST["EditID"];

        if(empty($this->EditID) || !is_numeric($this->EditID))
            return;

        $this->User = User::LoadByID($this->EditID);

        include("DialogTemplates/EditUserDialogTemplate.inc.php");
    }
}
?>
