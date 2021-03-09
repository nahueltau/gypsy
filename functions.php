<?php
/* Parses url for images in the product page */
function getImgSrc($result,$colornames,$iterance){
            $imgUrl = strtolower('assets/phones/' . $result->brand.'-'. str_replace(' ','',$result->model).'-'. $colornames[$iterance]);
            return $imgUrl;
        }
/* Parses attributes for rotateColors() function in the product page */
function getRotateColorsAttributes($colornames,$i){
    $color1 = $colornames[0];
    $color2 ='';
    if(isset($colornames[1])){$color2=$colornames[1];}
    $color3 ='';
    if(isset($colornames[2])){$color3=$colornames[2];}
    return $colornames[$i] . "','"  . $color1 . "','" . $color2 . "','" . $color3;
}
/* Parses url for images in the index page */
function getImageForUrl($result,$iterance=null){
    $imgURL = '';
    if($iterance===null){
        $imgURL = strtolower(str_replace(' ','',$result->brand) . '-' . str_replace(' ','',$result->model)); 
    }else{
        $imgURL = strtolower(str_replace(' ','',$result[$iterance]->brand) . '-' . str_replace(' ','',$result[$iterance]->model)); 
    }
    return $imgURL;
}
/* Transforms model name into a string parsed for a GET request */
function getQueryForGet($result ,$iterance=null){
    $query_for_get = '';
    if($iterance===null){
        $query_for_get = str_replace('.','-',strtolower(str_replace(' ','_',$result->model)));
    }else{
        $query_for_get = str_replace('.','-',strtolower(str_replace(' ','_',$result[$iterance]->model)));
    } 
    return $query_for_get;
}
?>