<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LinksView
 *
 * @author mayer
 */
class LinksView {

    var $links = array();

    function render()
    {
        $this->links = array(
            "Pfarrgemeinde-Unterneukirchen" => "http://www.pfarrgemeinde-unterneukirchen.de",
            "Patenburschenverein H&ouml;rpolding"=> "http://www.burschenverein-hoerpolding.de",
            "Kath. Burschen-und Krankenunterst&uuml;nzugsverein Surheim e.V:"=> "http://www.bv-surheim.de",
            "Burschenverein Vachendorf"=> "http://www.burschenverein-vachendorf.de",
            "Burschenverein Kienberg"=> "http://www.bv-kienberg.de",
            "Arbeiterverein Stein"=> "http://www.arbeiterverein-stein.de",
            "Dirndlschaft Heiligkreuz"=> "http://www.dirndlschaft-heiligkreuz.de.tl",
            "Burschenverein H&ouml;slwnag"=> "http://www.burschensaft.de",
            "Wikipedia auf Boarisch"=> "http://bar.wikipedia.org/wiki/Hauptseitn"
        );

        include("Templates/LinksViewTemplate.inc.php");
    }
}
?>
