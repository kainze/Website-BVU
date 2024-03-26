<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("Classes/User.php");

class DevelView
{
    function render()
    {
        if(!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Devel"))
            return;

        include("Templates/DevelViewTemplate.inc.php");
    }
}

?>
