<div align=center><img src="Layout/GetHeadline.php5" alt="Gallerie"></div><br>

<? foreach($this->AvailableYears as $Year) { ?>

<? if($this->SelectedYear != $Year) { ?>
        <div class="GallYearSep"><a href="index.php?content=Gallerie&year=<? echo $Year; ?>"><img class="noborder" src="Layout/plus.jpg" alt="+"></a><? echo $Year; ?></div>
<? } else { ?>
        <div class="GallYearSep"><img src="Layout/minus.jpg" alt="-"><? echo $Year; ?></div>

        <table>
<? foreach($this->SelectedYearPictures as $pic) { ?>

<? if($i == 0) { ?>
                <tr>
<? } ?>
            <td class="Gallerie">
                <a href="JavaScript:document.location.href='index.php?content=GallerieDetails&ID=<? echo $pic->ID; ?>';">
                    <img name="Thumbnails" alt="" id="tmb<? echo $pic->ID ?>" border='0' src="<? echo $pic->GetThumbnailPath(); ?>">
                </a>
                <br><? echo $pic->Descr . "<br>" . strftime("%d.%m.%Y", $pic->Date); ?>
            </td>

        <?
            if($i == 3) {
                echo "</tr>";
                $i = 0;
            } else
                $i++;
        ?>
<? } ?>

<? if($i != 0)
            echo "</tr>"; ?>
        </table>
<? } ?>
<? } ?>

<? if(User::GetCurrentUser() && User::GetCurrentUser()->IsInGroup("Pics")) { ?>

<hr>

<br><br>
<script type="text/javascript">
    var ctxm = new ContextMenu('Thumbnails');
    ctxm.AddMenuItemWithIcon('Löschn', 'Layout/del.png', function(Own) { if(confirm('Mechst de ganze Gallerie wirklich löschn?')) { SendAction('action=DelGlG&ID=' + Own.id.substr(3),'index.php?content=Gallerie'); } });

    function NewGlGroup() {
        if(document.frmnew.GlGBes.value == '')
            alert('Du host vagessn a Bezeichnung eizumgem!');
	    else if(document.frmnew.GlGDate.value == '')
	    	alert('Du host vagessn a Datum eizumgem!');
	    else
	    	document.frmnew.submit();
	    }

	    function ToggleNewGlGroupFrame()
	    {
	    	var Frame = document.getElementById('NewGlGroupFrame');
	    	if(Frame.style.display == 'none')
	    		Frame.style.display = 'block';
	    	else
            {
	    		document.getElementById('GlGBes').value = '';
	    		document.getElementById('GlGDate').value = '';
	    		Frame.style.display = 'none';
            }
	    }

</script>

<input type='button' onClick='JavaScript:ToggleNewGlGroupFrame();' value='Nei'>
<div id='NewGlGroupFrame' style='display:none;'>
    <table>
	    <tr><td>Beschreibung:</td><td><input type='text' id='GlGBes' name='GlGBes'></td></tr>
	    <tr><td>Datum:</td><td><input type='text' id='GlGDate' name='GlGDate' readonly> <input type='button' onClick="JavaScript:displayDatePicker('GlGDate', false, 'ymd', '-');" value='Auswoin'></td></tr>
    </table>
	<input type='button' value='Oleng' onClick="JavaScript:SendAction('action=NewGlG&GlGBes=' + document.getElementById('GlGBes').value + '&GlGDate=' + document.getElementById('GlGDate').value,'index.php?content=Gallerie');" >
</div>

<? } ?>