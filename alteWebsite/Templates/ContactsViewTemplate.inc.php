<div align=center><img src='Layout/GetHeadline.php5' alt="Kontakt"></div>
<br><br><br>
<div align="center">

    <? foreach($this->users as $amt => $user) {
        echo "<b>" . $amt . ": " . $user->Name . ", " . $user->Firstname . "</b><br>"
           . $user->Street . ", " . $user->Zip . " " . $user->City . "<br>"
           . "Tel.: " . $user->Phone . "<br>"
           . "Handy: " . $user->Mobile . "<br>"
           . "Email: ";
	$user->PrintAnonymizedEmailLink();
	echo "<br><br>";
    } ?>
</div>