<?php
// Direkt erişimi engelle
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Eklenti URL'sini almak için fonksiyon
function acb_get_plugin_url() {
    return ACB_PLUGIN_URL;
}

// Eklenti Dizini'ni almak için fonksiyon
function acb_get_plugin_dir() {
    return ACB_PLUGIN_DIR;
}

// Diğer ortak fonksiyonlar burada tanımlanabilir
