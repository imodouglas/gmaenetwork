<?php

$companyName = "GMAE Network";
$companyPhone = "08012345678";
$companyEmail = "info@gmaenetwork.com";
// $rootURL = "http://gmaenetwork.ew/dashboard/";
$rootURL = "https://gmaenetwork.com/dashboard/";


if(isset($_SESSION['user_session'])){
    $userSession = $_SESSION['user_session'];
} else if(isset($_SESSION['editor_session'])){
    $userSession = $_SESSION['editor_session'];
} else if(isset($_SESSION['admin_session'])){
    $userSession = $_SESSION['admin_session'];
}

?>