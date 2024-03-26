<?php

class ProfileView
{
    var $ID;
    var $User;
    var $Edit;

    function render()
    {
        $this->ID = $_GET["ID"];
        if(empty($this->ID) || !is_numeric($this->ID))
            return;

        if(User::GetCurrentUser() && User::GetCurrentUser()->ID == $this->ID)
        {
            $this->Edit = true;
            $this->User = User::GetCurrentUser();
        }  else {
            $this->Edit = false;
            $this->User = User::LoadByID($this->ID);
        }

        include("Templates/ProfileViewTemplate.inc.php");
    }
}

?>
