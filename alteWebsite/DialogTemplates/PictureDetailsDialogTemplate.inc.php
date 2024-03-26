<script type="text/JavaScript">
    function picOnMouseOut(id)
    {
<? if ($this->PictureInfo->PrevPicID != -1) { ?>
            document.getElementById("div_picprev").className="PicPrevNext";
<? } ?>
<? if ($this->PictureInfo->NextPicID != -1) { ?>
            document.getElementById("div_picnext").className="PicPrevNext";
<? } ?>
    }

    function picOnMouseOver(id)
    {
<? if ($this->PictureInfo->PrevPicID != -1) { ?>
            document.getElementById("div_picprev").className="PicPrevNextHover";
<? } ?>
<? if ($this->PictureInfo->NextPicID != -1) { ?>
            document.getElementById("div_picnext").className="PicPrevNextHover";
<? } ?>
    }

</script>

    <div class="GalleryPicInner" style="Width: <? echo $this->PictureInfo->Width; ?>px; Height: <?echo $this->PictureInfo->Height; ?>px" >
        <img class="GalleryPic" src="<? echo $this->PictureInfo->GetPicturePath(); ?>" alt="Bild">
        <table class="GalleryPic">
            <tr>
                <?
                $mouseHandlers = "onmouseover=\"this.className='PicPrevNextHover';\" onmouseout=\"this.className='PicPrevNext';\" ";
                $prevClickHandler = "onclick=\"JavaScript: ShowDialog('dialog=PictureDetails&GallerieID=" . $this->PictureInfo->GalleryID  . "&BildID=" . $this->PictureInfo->PrevPicID . "');\" ";
                $nextClickHandler = "onclick=\"JavaScript: ShowDialog('dialog=PictureDetails&GallerieID=" . $this->PictureInfo->GalleryID  . "&BildID=" . $this->PictureInfo->NextPicID . "');\" ";
                ?>
                
                <th class="PicPrevNext" id="div_picprev" <? if($this->PictureInfo->PrevPicID != -1) echo $mouseHandlers . $prevClickHandler ?>><img src="Layout/blackarrowleft.png"></th>
                <td onmouseout="JavaScript:picOnMouseOut('');" onmouseover="JavaScript:picOnMouseOver('');"></td>
                <th class="PicPrevNext" id="div_picnext" <? if($this->PictureInfo->NextPicID != -1) echo $mouseHandlers . $nextClickHandler ?>><img src="Layout/blackarrowright.png"></th>
            </tr>
        </table>
    </div>


<script type="text/JavaScript">
<? if ($this->PictureInfo->PrevPicID != -1) { ?>
        var img1 = new Image();
        img1.src = "<? echo $this->PictureInfo->GetPrevPicturePath(); ?>";
<? } ?>
<? if ($this->PictureInfo->NextPicID != -1) { ?>
        var img2 = new Image();
        img2.src = "<? echo $this->PictureInfo->GetNextPicturePath(); ?>";
<? } ?>

</script>
