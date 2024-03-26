<?php

class PictureInfo
{
    var $ID;
    var $GalleryID;
    var $PrevPicID;
    var $NextPicID;

    var $Width;
    var $Height;

    function Load($ID, $GalleryID)
    {
        if(empty($ID) || empty($GalleryID) || !is_numeric($ID) || !is_numeric($GalleryID))
            return null;

        $PicturePath = "GalleriePics/". $GalleryID . "/" . $ID . ".jpg";

        if(!file_exists($PicturePath))
            return null;

        $PrevPicID = PictureInfo::GetPrevPictureID($ID,$GalleryID);
        $NextPicID = PictureInfo::GetNextPictureID($ID,$GalleryID);
        $imageInfo = getImageSize($PicturePath);

        $pi = new PictureInfo($ID,$GalleryID,$PrevPicID,$NextPicID,$imageInfo[0],$imageInfo[1]);
        return $pi;
    }

    function PictureInfo($ID ,$GalleryID, $PrevPicID, $NextPicID, $Width, $Height)
    {
        $this->ID = $ID;
        $this->GalleryID = $GalleryID;
        $this->PrevPicID = $PrevPicID;
        $this->NextPicID = $NextPicID;

        $this->Width = $Width;
        $this->Height = $Height;
    }

    function GetPicturePath() {
        return "GalleriePics/" . $this->GalleryID . "/" . $this->ID . ".jpg";
    }
    
    function GetPrevPicturePath() {
        return "GalleriePics/" . $this->GalleryID . "/" . $this->PrevPicID . ".jpg";
    }
    
    function GetNextPicturePath() {
        return "GalleriePics/" . $this->GalleryID . "/" . $this->NextPicID . ".jpg";
    }

    private function GetPrevPictureID($ID,$GalleryID) {
        $NextPicID = -1;

        $sql = "SELECT `ID` FROM `glitem` WHERE `GLGroupID` = " . mysql_escape_string($GalleryID) . " AND `ID` < " . mysql_escape_string($ID) . " ORDER BY `ID` DESC LIMIT 1";
        $res = DB::Query($sql);
        $row = mysql_fetch_array($res);
        if ($row)
            $NextPicID = $row["ID"];
        mysql_free_result($res);
        return $NextPicID;
    }

    private function GetNextPictureID($ID,$GalleryID) {
        $PrevPicID = -1;

        $sql = "SELECT `ID` FROM `glitem` WHERE `GLGroupID` = " . mysql_escape_string($GalleryID) . " AND `ID` > " . mysql_escape_string($ID) . " ORDER BY `ID` LIMIT 1";
        $res = DB::Query($sql);
        $row = mysql_fetch_array($res);
        if ($row)
            $PrevPicID = $row["ID"];
        mysql_free_result($res);
        return $PrevPicID;
    }

    static function CorrectImageSize($GID)
    {
        if(empty($GID) || !is_numeric($GID))
            return 0;

        $cnt = 0;

        if($handle = opendir('GalleriePics/' . $GID))
        {
            while (false !== ($file = readdir($handle)))
            {
                if($file == "." || $file == "..")
                    continue;

                $path = "GalleriePics/" . $GID . "/" . $file;

                // Nur Thumbnails
                // $maxWidth = (substr($file,0, 2) == "_p") ?  150 : 645;
                if(substr($file,0,2) != "p_")
                    continue;
                
                $maxWidth = 133;
                
                $imageInfo = getImageSize($path);;

                $width = $imageInfo[0];
                $height = $imageInfo[1];

                if($width > $maxWidth)
                {
                    $ratio = $height / $width;
                    $width = $maxWidth;
                    $height = $ratio * $width;

                    $o_OrgImg = null;

                    switch ($imageInfo["mime"]) {
                        case "image/gif":
                            $o_OrgImg = imageCreateFromGIF($path);
                            break;
                        case "image/jpeg":
                            $o_OrgImg = imageCreateFromJPEG($path);
                            break;
                        case "image/png":
                            $o_OrgImg = imageCreateFromPNG($path);
                            break;
                        case "image/wbmp":
                            $o_OrgImg = imageCreateFromWBMP($path);
                            break;
                        default:
                            echo("Unsupported FileType " . $path . "<br>");
                            continue;
                    }

                    //Bild verkleinern
                    $o_ResisedImg = imageCreateTrueColor($width, $height);
                    if (!imageCopyResampled($o_ResisedImg, $o_OrgImg, 0, 0, 0, 0, $width, $height, $imageInfo[0], $imageInfo[1]))
                    {
                        echo("Fehler bei Umwandlung<br>");
                        continue;
                    }

                    imageJPEG($o_ResisedImg, $path, 100);
                    $cnt++;
                }
            }
        }

        closedir($handle);
        return $cnt;
    }

    static function GetAllGalleryFolders()
    {
        $folders = array();
        
        if($handle = opendir('GalleriePics/' . $GID))
        {
            while (false !== ($file = readdir($handle)))
            {
                if($file != "." && $file != "..")
                    $folders[] = $file;
            }

            closedir($handle);
        }

        return $folders;
    }
}

?>
