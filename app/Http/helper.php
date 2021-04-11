<?php
function makeImageFromName($name){
    $shortName = '';
    $userImage='';
    $names = explode(" ",$name);
    foreach($names as $r){
        $shortName.=$r[0];
    }
    $userImage = '<div class="name-image bg-primary">'.$shortName.'</div>';
    return $userImage;
}