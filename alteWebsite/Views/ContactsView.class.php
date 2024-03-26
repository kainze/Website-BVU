<?php

include_once("Classes/User.php");

class ContactsView {

    var $users = array();

    function render()
    {
        $this->users = array(
            "1. Vorstand" => User::LoadByFirstnameAndName("Josef","Jetzlsperger"),
            "2. Vorstand" => User::LoadByFirstnameAndName("Christoph","Kainzmaier"),
            "Design, Coding" => User::LoadByID(1)
        );

        include("Templates/ContactsViewTemplate.inc.php");
    }
}
?>
