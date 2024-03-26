<div align=center><img src="Layout/GetHeadline.php5" alt="Neis"></div><br>
<script type="text/JavaScript">
    <? if ($this->Edit) { ?>
    function Delete(ID)
    {
        if(confirm("Mechst den Eintrag wirklich löschn?"))
            SendAction("action=DelNews&ID=" + ID,"index.php?content=News");
    }
    <? } ?>
</script>
        
<?
    $this->DataGrid->render();
?>

<? if(User::GetCurrentUser() && User::GetCurrentUser()->IsInGroup("News")) { ?>
		<br><br>
<input id="btnToggle" type="button" value="Wos neis gibts" onClick="JavaScript: toggleEditor();"><br><br>
<textarea id="txtNewNews" class="NewNews" cols="82" rows="15"></textarea><br>
<input id="btnEidrong" class="Button NewNews" type="button" value="Eidrong" onClick="JavaScript:CreateNew();">

<script type="text/javascript">
    var elmBtnToggle = document.getElementById("btnToggle");
    var elmtxtNewNews = document.getElementById("txtNewNews");
    var elmBtnEidrong = document.getElementById("btnEidrong");

    <? include("Layout/Editor.php"); ?>

    function CreateNew()
    {
        SendAction("action=NewNews&txtNewNews=" + escape(tinyMCE.activeEditor.getContent()),"index.php?content=News");
    }

    function toggleEditor()
    {
        if(elmBtnToggle.value == "Wos neis gibts"){
            elmBtnToggle.value = "Doch ned";
            elmBtnEidrong.style.visibility = "visible";
            tinyMCE.execCommand("mceAddControl", true, "txtNewNews");
        } else {
            elmBtnToggle.value ="Wos neis gibts";
            elmtxtNewNews.value = "";
            tinyMCE.execCommand("mceRemoveControl", true, "txtNewNews");
            elmBtnEidrong.style.visibility = "hidden";
        }
    }
</script>
       
<? } ?>

