<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class DialogBase {

    var $ShowDialogFrame = true;

    public function render()
    {
        include("DialogTemplates/DialogBaseTemplate.inc.php");
    }

    protected abstract function renderContent();
}

?>