<?php
/**
 * Plugin Name: Advanced Contact Buttons
 * Description: Kullanıcıların dinamik olarak WhatsApp, e-posta, telefon ve kayıt formu butonları ekleyebileceği gelişmiş bir iletişim butonu eklentisi.
 * Version: 1.0.0
 * Author: İsminiz
 * Text Domain: advanced-contact-buttons
 */

// Direkt erişimi engelle
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Eklenti sabitleri
define( 'ACB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ACB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Gerekli dosyaların dahil edilmesi
require_once ACB_PLUGIN_DIR . 'includes/acb-functions.php';
require_once ACB_PLUGIN_DIR . 'admin/acb-admin.php';
require_once ACB_PLUGIN_DIR . 'public/acb-public.php';

// Eklenti aktivasyon fonksiyonu
function acb_activate_plugin() {
    // Veritabanı tablolarını oluştur
    require_once ACB_PLUGIN_DIR . 'includes/acb-activate.php';
    acb_create_tables();
}
register_activation_hook( __FILE__, 'acb_activate_plugin' );

// Eklenti de-aktivasyon fonksiyonu
function acb_deactivate_plugin() {
    // Gerekli temizleme işlemleri
}
register_deactivation_hook( __FILE__, 'acb_deactivate_plugin' );
