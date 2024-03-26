
<? if($dataClass->Edit && $row["ID"] == $dataClass->GalleryGroupInfo->PreviewPicID) { ?>
    <td class="Gallerie" style="border: 2px solid blue">
<? } else { ?>
    <td class="Gallerie" style="border: 2px solid white">
<? } ?>
     
<a href="JavaScript: ShowDialog('dialog=PictureDetails&GallerieID=<? echo $dataClass->GalleryGroupInfo->ID; ?>&BildID=<? echo $row["ID"]; ?>');">
    <img class="GalleryThumbnail" name="Thumbnail" id="tmb<? echo $row["ID"]; ?>" src="GalleriePics/<? echo $dataClass->GalleryGroupInfo->ID?>/p_<? echo $row["ID"]; ?>.jpg">
</a>
</td>