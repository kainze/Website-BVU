<? if($this->ShowDialogFrame) { ?>
<div class="CloseButton"><a class="CloseButton" href="JavaScript: HideDialog();"><img src="Layout/close.png" alt="Schließen"></a></div>
<? } ?>

<div id="divDialogContent" class="DialogContent">
<? $this->renderContent(); ?>
</div>