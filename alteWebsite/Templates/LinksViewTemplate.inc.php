<div align="center"><img src="Layout/GetHeadline.php5"></div><br>
<br><br><br>

<? foreach($this->links as $name => $url) {
    echo $name . ":<br><a target='_blank' href='" . $url . "'>" . $url . "</a><br><br>";
} ?>
