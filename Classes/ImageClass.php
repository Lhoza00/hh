<?php 

class Image{
    public $error ="";

    public function generateName($userName){
        $userName = addslashes($userName);
        return $userName . "_" . bin2hex(random_bytes(8));
    }
    public function generatePost($postID, $userName){
        $postID = addslashes($postID);
        $userName = addslashes($userName);
        return $userName . "_" . $postID;
    }

    public function cropImage($originFileName, $croppedImage, $maxWidth, $maxHeight, $imageType){
        $originFileName = addslashes($originFileName);
        $croppedImage = addslashes($croppedImage);
        $maxWidth = addslashes($maxWidth);
        $maxHeight = addslashes($maxHeight);
        $imageType = addslashes($imageType);
        if(file_exists($originFileName) && $imageType == "image/jpeg"){
            $originImage = imagecreatefromjpeg($originFileName);
            $originWidth = imagesx($originImage);
            $originHeight = imagesy($originImage);
            if($originHeight > $originWidth){
                //make width equal to max width;
                $ratio = $maxWidth / $originWidth;
                $newWidth = $maxWidth;
                $newHeight = $originHeight * $ratio;
            }else{
                //make height equal to max height
                $ratio = $maxHeight / $originHeight;
                $newHeight = $maxHeight;
                $newWidth = $originWidth * $ratio; 
            }
            if($maxWidth != $maxHeight){
                if($maxHeight > $maxWidth){
                    if($maxHeight > $newHeight){
                        $adjustment = ($maxHeight / $newHeight);
                    }else{
                        $adjustment = ($newHeight / $maxHeight);
                    }
                    $newWidth = $newWidth * $adjustment;
                    $newHeight = $newHeight * $adjustment;
                }else{
                    if($maxWidth > $newWidth){
                        $adjustment = ($maxWidth / $newWidth);
                    }else{
                        $adjustment = ($newWidth / $maxWidth);
                    }
                    $newWidth = $newWidth * $adjustment;
                    $newHeight = $newHeight * $adjustment;
                }
            }
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $originImage, 0,0,0,0, $newWidth, $newHeight, $originWidth, $originHeight);
            imagedestroy($originImage);
            //other one
            if($maxWidth != $maxHeight){
                if($maxWidth > $maxHeight){
                    $diff = ($newHeight - $maxHeight);
                    if($diff < 0){
                        $diff = $diff * -1;
                    }
                    $y = round($diff / 2);
                    $x = 0;
                }else{
                    $diff = ($newWidth - $maxWidth);
                    if($diff < 0){
                        $diff = $diff * -1;
                    }
                    $x = round($diff / 2);
                    $y = 0;
                }
            }else{
                if($newHeight > $newWidth){
                    $diff = ($newHeight - $newWidth);
                    $y = round($diff / 2);
                    $x = 0;
                }else{
                    $diff = ($newWidth - $newHeight);
                    $x = round($diff / 2);
                    $y = 0;
                }     
            }
            $newCroppedImage = imagecreatetruecolor($maxWidth, $maxHeight);
            imagecopyresampled($newCroppedImage, $newImage, 0,0,$x,$y, $maxWidth, $maxHeight, $maxWidth, $maxHeight);
            imagedestroy($newImage);
            imagejpeg($newCroppedImage, $croppedImage, 90);
            imagedestroy($newCroppedImage);

        }else if(file_exists($originFileName) && $imageType == "image/png"){
            $originImage = imagecreatefrompng($originFileName);
            $originWidth = imagesx($originImage);
            $originHeight = imagesy($originImage);
            if($originHeight > $originWidth){
                //make width equal to max width;
                $ratio = $maxWidth / $originWidth;
                $newWidth = $maxWidth;
                $newHeight = $originHeight * $ratio;
            }else{
                //make height equal to max height
                $ratio = $maxHeight / $originHeight;
                $newHeight = $maxHeight;
                $newWidth = $originWidth * $ratio; 
            }

            //here
            //adjust incase max width and height are different
            if($maxWidth != $maxHeight){
                if($maxHeight > $maxWidth){
                    if($maxHeight > $newHeight){
                        $adjustment = ($maxHeight / $newHeight);
                    }else{
                        $adjustment = ($newHeight / $maxHeight);
                    }
                    $newWidth = $newWidth * $adjustment;
                    $newHeight = $newHeight * $adjustment;
                }else{
                    if($maxWidth > $newWidth){
                        $adjustment = ($maxWidth / $newWidth);
                    }else{
                        $adjustment = ($newWidth / $maxWidth);
                    }
                    $newWidth = $newWidth * $adjustment;
                    $newHeight = $newHeight * $adjustment;
                }
            }
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $originImage, 0,0,0,0, $newWidth, $newHeight, $originWidth, $originHeight);
            imagedestroy($originImage);
            if($maxWidth != $maxHeight){
                if($maxWidth > $maxHeight){
                    $diff = ($newHeight - $maxHeight);
                    if($diff < 0){
                        $diff = $diff * -1;
                    }
                    $y = round($diff / 2);
                    $x = 0;
                }else{
                    $diff = ($newWidth - $maxWidth);
                    if($diff < 0){
                        $diff = $diff * -1;
                    }
                    $y = round($diff / 2);
                    $x = 0;
                }
            }else{
                if($newHeight > $newWidth){
                    $diff = ($newHeight - $newWidth);
                    $y = round($diff / 2);
                    $x = 0;
                }else{
                    $diff = ($newWidth - $newHeight);
                    $y = round($diff / 2);
                    $x = 0;
                }     
            }
            $newCroppedImage = imagecreatetruecolor($maxWidth, $maxHeight);
            imagecopyresampled($newCroppedImage, $newImage, 0,0,$x,$y, $maxWidth, $maxHeight, $maxWidth, $maxHeight);
            imagedestroy($newImage);
            imagepng($newCroppedImage, $croppedImage, 9);
            imagedestroy($newCroppedImage);
        }else{
            $this->error = "Please choose correct file type";
            return $this->error;
        }
    }

    //this is the other one
    public function resizeImage($originFileName, $resizedImage, $maxWidth, $maxHeight, $imageType){
        $originFileName = addslashes($originFileName);
        $resizedImage = addslashes($resizedImage);
        $maxWidth = addslashes($maxWidth);
        $maxHeight = addslashes($maxHeight);
        $imageType = addslashes($imageType);
        if(file_exists($originFileName) && $imageType == "image/jpeg"){
            $originImage = imagecreatefromjpeg($originFileName);
            $originWidth = imagesx($originImage);
            $originHeight = imagesy($originImage);
            if($originHeight > $originWidth){
                //make width equal to max width;
                $ratio = $maxWidth / $originWidth;
                $newWidth = $maxWidth;
                $newHeight = $originHeight * $ratio;
            }else{
                //make height equal to max height
                $ratio = $maxHeight / $originHeight;
                $newHeight = $maxHeight;
                $newWidth = $originWidth * $ratio; 
            }
            if($maxWidth != $maxHeight){
                if($maxHeight > $maxWidth){
                    if($maxHeight > $newHeight){
                        $adjustment = ($maxHeight / $newHeight);
                    }else{
                        $adjustment = ($newHeight / $maxHeight);
                    }
                    $newWidth = $newWidth * $adjustment;
                    $newHeight = $newHeight * $adjustment;
                }else{
                    if($maxWidth > $newWidth){
                        $adjustment = ($maxWidth / $newWidth);
                    }else{
                        $adjustment = ($newWidth / $maxWidth);
                    }
                    $newWidth = $newWidth * $adjustment;
                    $newHeight = $newHeight * $adjustment;
                }
            }
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $originImage, 0,0,0,0, $newWidth, $newHeight, $originWidth, $originHeight);
            imagedestroy($originImage);
           
            
            imagepng($newImage, $resizedImage, 9);
            imagedestroy($newImage);

        }else if(file_exists($originFileName) && $imageType == "image/png"){
            $originImage = imagecreatefrompng($originFileName);
            $originWidth = imagesx($originImage);
            $originHeight = imagesy($originImage);
            if($originHeight > $originWidth){
                //make width equal to max width;
                $ratio = $maxWidth / $originWidth;
                $newWidth = $maxWidth;
                $newHeight = $originHeight * $ratio;
            }else{
                //make height equal to max height
                $ratio = $maxHeight / $originHeight;
                $newHeight = $maxHeight;
                $newWidth = $originWidth * $ratio; 
            }

            //here
            //adjust incase max width and height are different
            if($maxWidth != $maxHeight){
                if($maxHeight > $maxWidth){
                    if($maxHeight > $newHeight){
                        $adjustment = ($maxHeight / $newHeight);
                    }else{
                        $adjustment = ($newHeight / $maxHeight);
                    }
                    $newWidth = $newWidth * $adjustment;
                    $newHeight = $newHeight * $adjustment;
                }else{
                    if($maxWidth > $newWidth){
                        $adjustment = ($maxWidth / $newWidth);
                    }else{
                        $adjustment = ($newWidth / $maxWidth);
                    }
                    $newWidth = $newWidth * $adjustment;
                    $newHeight = $newHeight * $adjustment;
                }
            }
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $originImage, 0,0,0,0, $newWidth, $newHeight, $originWidth, $originHeight);
            imagedestroy($originImage);
           
            
            imagepng($newImage, $resizedImage, 9);
            imagedestroy($newImage);
        }else{
            $this->error = "Please choose correct file type";
            return $this->error;
        }
    }
    //create thumbnail for cover picture
    public function getThumbCover($fileName){
        $fileName = addslashes($fileName);
        $imageType = mime_content_type($fileName);
        if($imageType == "image/png"){
            $thumbNail = $fileName . "_cover.png";
            $this->cropImage($fileName,$thumbNail, 800, 500,$imageType);
            if(file_exists($thumbNail)){
                return $thumbNail;
            }else{
                return $fileName;
            }
        }elseif($imageType == "image/jpeg"){
            $thumbNail = $fileName . "_cover.jpeg";
            $this->cropImage($fileName,$thumbNail, 800, 500,$imageType);
            if(file_exists($thumbNail)){
                return $thumbNail;
            }else{
                return $fileName;
            }
        }
    }
    //create thumbnail for profile picture
    public function getThumbProfile($fileName){
        $fileName = addslashes($fileName);
        $imageType = mime_content_type($fileName);
        if($imageType == "image/png"){
            $thumbNail =  $fileName . "_profile.png";
            if(file_exists($thumbNail)){
                return $thumbNail;
            }
            $this->cropImage($fileName,$thumbNail, 500, 500,$imageType);
            if(file_exists($thumbNail)){
                return $thumbNail;
            }else{
                return $fileName;
            }
        }elseif($imageType == "image/jpeg"){
            $thumbNail = $fileName . "_profile.jpeg";
            if(file_exists($thumbNail)){
                return $thumbNail;
            }
            $this->cropImage($fileName,$thumbNail, 500, 500,$imageType);
            if(file_exists($thumbNail)){
                return $thumbNail;
            }else{
                return $fileName;
            }
        }
    }
    //create thumbnail for posts picture 
    public function getThumbPost($fileName){
        $fileName = addslashes($fileName);
        $imageType = mime_content_type($fileName);
        if($imageType == "image/png"){
            $thumbNail =  $fileName . "_post.png";
            if(file_exists($thumbNail)){
                return $thumbNail;
            }
            $this->cropImage($fileName,$thumbNail, 700, 700,$imageType);
            if(file_exists($thumbNail)){
                return $thumbNail;
            }else{
                return $fileName;
            }
        }elseif($imageType == "image/jpeg"){
            $thumbNail = $fileName . "_post.jpeg";
            if(file_exists($thumbNail)){
                return $thumbNail;
            }
            $this->cropImage($fileName,$thumbNail, 700, 700,$imageType);
            if(file_exists($thumbNail)){
                return $thumbNail;
            }else{
                return $fileName;
            }
        }
    }
}
?>