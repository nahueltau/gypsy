<?php
/* IMAGE UPLOAD */
        /* Target Dir and Target Name */
        $tagetDir = '../assets/phones/';
        $modelWithOutSpaces = str_replace(' ','',$model);
        $commonPath = $tagetDir . strtolower($brand .'-'.$modelWithOutSpaces);
        function getExt($name){
            $result = strtolower(pathinfo(basename($_FILES[$name]['name']),PATHINFO_EXTENSION));
            return $result;
        }
        function moveToDir($name,$target){
            move_uploaded_file($_FILES[$name]["tmp_name"], $target);
        }
        function getView($i){
            $view = '';
            switch($i){
                case 1:$view = '-front.';break;
                case 2:$view = '-back.';break;
                case 3:$view = '-side.';break;
                case 4:$view = '-extra.';break;
            }
            return $view;
        }
        /* UPLOAD */
        for($e = 1; $e<=3;$e++){
            //For each Color
            if(isset($_POST['colorname'.$e])){
                //For each view
                for($i = 1; $i<=4;$i++){
                    $uploadOk = 1;
                    $targetPath = $commonPath .'-'. strtolower($_POST['colorname'.$e]).getView($i).getExt("image".$i."color".$e);
                    $targetPathGeneral = $commonPath .'.'.getExt("image1color1");

                    //Does file already exist?
                    if (file_exists($targetPath) && $uploadOk) {
                        echo "Sorry, "."image".$i."color".$e." already exists. </br>";
                        
                      }
                    //Is file too big?
                        if ($_FILES["image".$i."color".$e]["size"] > 500000 && $uploadOk) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                      }
                      
                    // Allow only png
                      if(getExt("image".$i."color".$e) != "png" && $uploadOk) {
                        echo "Sorry, only PNG files are allowed. "." image".$i."color".$e . '<br>';
                        $uploadOk = 0;
                      }
                    //FINAL UPLOAD
                    if($uploadOk){
                      movetoDir("image".$i."color".$e, $targetPath);
                      if($i === 1 && $e ===1){
                        copy($targetPath,$targetPathGeneral);
                
                      } 
                    }
                    
                }
            }
        }
       
   
    ?>