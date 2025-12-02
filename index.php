<?php
/**
 * Ana Index Dosyası - Modüler Routing Yapısı
 * EcoCarbon - Karbon Ayak İzi Hesaplama Sistemi
 */
require_once "config/config.php";

$page_title = "Ana Sayfa";

include("modules/_header.php");

include("modules/_navbar.php");

echo '<div id="alertContainer" class="container mx-auto px-4 mt-4"></div>';

if(isset($_GET["page"])){
    $page = $_GET["page"];
    $url_parts = parse_url($page);
    
    if(isset($url_parts['query'])){
        parse_str($url_parts['query'], $query_params);
        $current_get = $_GET;
        $_GET = array_merge($current_get, $query_params);
        $_GET["page"] = $url_parts["path"];
        
        if (!file_exists("pages/".$url_parts["path"].".php")) {   
            include("pages/home.php");                        
        } else {
            include("pages/".$url_parts["path"].".php");
        }
    } else {
        if (!file_exists("pages/".$_GET["page"].".php")) {   
            include("pages/home.php");                        
        } else {
            include("pages/".$_GET["page"].".php");
        }
    }
} else {
    include("pages/home.php");
}
include("modules/_footer.php");
?>
