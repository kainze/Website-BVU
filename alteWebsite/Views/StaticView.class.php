<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StaticView
 *
 * @author mayer
 */
class StaticView {

    var $TemplateFile = "";

    function StaticView($TemplateFile)
    {
        $this->TemplateFile = $TemplateFile;
    }

    function render()
    {
        include($this->TemplateFile);
    }
}
?>
