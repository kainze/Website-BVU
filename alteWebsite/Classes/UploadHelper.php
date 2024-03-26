<?php

class UploadHelper {

    private static $MaxPictureWidth = 1024;
    private static $MaxPictureHeight = 768;

    static function IsUploadRequest()
    {
        if(!isset($_GET['action']))
            return false;
        
        return $_GET['action'] == "upload";
    }

    static function HandleUploadRequest()
    {
        if(!User::GetCurrentUser() || !User::GetCurrentUser()->IsInGroup("Pics"))
            return;

        if(empty($_GET["GID"]))
            return;

        foreach ($_FILES as $key => $value) {

            if(empty($value["tmp_name"]))
                continue;

            $imageInfo = getImageSize($value["tmp_name"]);
            $imgWidth = $imageInfo[0];
            $imgHeight = $imageInfo[1];
            $imgName = $value["name"];

            $TmpFilePath = $value["tmp_name"];
            $o_OrgImg = null;

            switch ($imageInfo["mime"]) {
                case "image/gif":
                    $o_OrgImg = imageCreateFromGIF($TmpFilePath);
                    break;
                case "image/jpeg":
                    $o_OrgImg = imageCreateFromJPEG($TmpFilePath);
                    break;
                case "image/png":
                    $o_OrgImg = imageCreateFromPNG($TmpFilePath);
                    break;
                case "image/wbmp":
                    $o_OrgImg = imageCreateFromWBMP($TmpFilePath);
                    break;
                default:
                    echo $imgName . ": Datei-Typ '" . $imageInfo["mime"] . "' ungültig.<br>";
            }

            if(empty($o_OrgImg))
                continue;
            
            $o_Img = UploadHelper::ScaleDownImage($o_OrgImg, $imgWidth, $imgHeight, UploadHelper::$MaxPictureWidth, UploadHelper::$MaxPictureHeight);
            if($o_Img == null)
            {
                echo $imgName . ": Fehler beim verkleinern des Bildes.<br>";
                imagedestroy($o_OrgImg);
                continue;
            }

            /*
            $ration = $imageInfo[1] / $imageInfo[0];
            $NewWidth = $imageInfo[0] < 1000 ? $imageInfo[0] : 1000;
            $NewHeight = (int) ($NewWidth * $ratio);

            echo "Ratio: " . $ratio . "<br>";
            echo "NewHeight: " . $NewHeight . "<br>";
            echo "NewWidth: " . $NewWidth . "<br>";

            //Bild verkleinern
            $o_ResisedImg = imageCreateTrueColor($NewWidth, $NewHeight);
            if (!imageCopyResampled($o_ResisedImg, $o_OrgImg, 0, 0, 0, 0, $NewWidth, $NewHeight, $imageInfo[0], $imageInfo[1]))
                die("Fehler bei Umwandlung");
            */

            //Logo aufstempeln
            $o_StempelImg = imageCreateFromPNG("GalleriePics/Static/Stempel.png");
            $StempelPrevInfo = getImageSize("GalleriePics/Static/Stempel.png");
            if (!imageCopy($o_Img, $o_StempelImg, $imgWidth - $StempelPrevInfo[0] - 5, $imgHeight - $StempelPrevInfo[1] - 5, 0, 0, $StempelPrevInfo[0], $StempelPrevInfo[1]))
            {
                echo $imgName . ": Fehler beim Einsetzten des Stempels.<br>";
                imageDestroy($o_Img);
                imageDestroy($o_OrgImg);
                imageDestroy($o_StempelImg);
                continue;
            }

            //Vorschau erstellen
            $o_PrevImg = UploadHelper::ScaleDownImage($o_Img, $imgWidth, $imgHeight, 133, 133);
            if($o_PrevImg == null)
            {
                echo $imgName . ": Fehler beim Erstellen der Vorschau.<br>";
                imageDestroy($o_Img);
                imagedestroy($o_OrgImg);
                imagedestroy($o_StempelImg);
                imagedestroy($o_PrevImg);
                continue;
            }

            //In der Datenbank registrieren
            $sql = "INSERT INTO `glitem` (`GLGroupID`) VALUES(" . mysql_escape_string($_GET["GID"]) . ")";
            DB::Query($sql);

            $NewID = mysql_insert_id();

            $NewPictureFolder = "GalleriePics/" . basename($_GET["GID"]);
            if (file_exists($NewPictureFolder)) {
                $NewPicturePreviewPath = $NewPictureFolder . "/p_" . $NewID . ".jpg";
                $NewPicturePath = $NewPictureFolder . "/" . $NewID . ".jpg";
                //Speichern
                imageJPEG($o_Img, $NewPicturePath, 80);
                imageJPEG($o_PrevImg, $NewPicturePreviewPath, 80);

                //echo $imgName . ": Ok. (" . $_GET["GID"] . ":" . $NewID . ") <br>";
            }else
                echo $imgName . ": Zielpfad nicht gefunden.<br>";

            //Speicher freigeben
            imagedestroy($o_Img);
            imageDestroy($o_OrgImg);
            imageDestroy($o_PrevImg);
            imageDestroy($o_StempelImg);
            
            echo "SUCCESS";
        }
    }
    
    private static function ScaleDownImage($o_img, $Width, $Height, $MaxWidth, $MaxHeight)
    {
        if($Height <= $MaxHeight && $Width <= $MaxWidth)
            return $o_img;
        
        $newHeight = 0;
        $newWidth = 0;
        $bUseHeight = false;
        
        if($Height > $MaxHeight && $Width <= $MaxWidth)
            $bUseHeight = true;
        else if($Height <= $MaxHeight && $Width > $MaxWidth)
            $bUseHeight = false;
        else if($Height >= $Width)
            $bUseHeight = true;
        else 
            $bUseHeight = false;
            
        if($bUseHeight)
        {
            $iRatio = $Width / $Height;
            $iNewHeight = $MaxHeight;
            $iNewWidth = $iNewHeight * $iRatio;
        }  else {
            $iRatio = $Height / $Width;
            $iNewWidth = $MaxWidth;
            $iNewHeight = $iNewWidth * $iRatio;
        }
        
        $o_newImg = imageCreateTrueColor($iNewWidth, $iNewHeight);
        if (!imageCopyResampled($o_newImg, $o_img, 0, 0, 0, 0, $iNewWidth, $iNewHeight, $Width, $Height))
            return null;
        
        return $o_newImg;
    }
}

?>
