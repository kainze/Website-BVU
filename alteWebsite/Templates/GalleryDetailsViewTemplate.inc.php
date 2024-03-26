<div align="center"><img src="Layout/GetHeadline.php5"></div>

<? $this->DataGrid->render(); ?>

<? if($this->Edit) { ?>
<script type="text/javascript" src="Layout/swfobject.js"></script>

<script language='JavaScript'>
    var cmBilder = new ContextMenu('Thumbnail');
    cmBilder.AddMenuItem('Ois Vorschau Setztn', function(Own){ SendAction('action=SetGalleryPrevPic&GID=<?php echo $this->GalleryGroupInfo->ID; ?>&ID=' + Own.id.substr(3),'index.php?content=GallerieDetails&ID=<?php echo $this->GalleryGroupInfo->ID; ?>'); });
    cmBilder.AddMenuItemWithIcon('l&ouml;schn', 'Layout/del.png', function(Own){if(confirm('Bild wirklich löschen?')) { SendAction('action=DeleteGalleryPicture&GID=<? echo $this->GalleryGroupInfo->ID; ?>&ID=' + Own.id.substr(3),'index.php?content=GallerieDetails&ID=<? echo $this->GalleryGroupInfo->ID; ?>'); }});
</script>

<br><br><br>
<input type="Button" value="Buidl Hinzuf&uuml;gen" onClick="ShowDialog('dialog=UploadImages&GID=<?php echo $this->GalleryGroupInfo->ID; ?>');"><br>
<? } ?>
