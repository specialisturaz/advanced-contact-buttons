<?php
// Direkt erişimi engelle
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Kısa kod ile butonları frontend'de görüntüleme
function acb_display_buttons() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'acb_buttons';
    $buttons = $wpdb->get_results( "SELECT * FROM $table_name WHERE is_floating = 1" );

    if ( ! empty( $buttons ) ) {
        echo '<div class="acb-button-wrapper">';
        
        // Ana Buton
        echo '<a href="javascript:void(0);" class="acb-button main-button" style="background-color:#000; color:#fff;">Menu</a>';
        
        // Alt Menüdeki Butonlar
        echo '<div class="acb-dropdown">';
        foreach ( $buttons as $button ) {
            echo '<a href="' . esc_url( $button->url ) . '" class="acb-button acb-' . esc_attr( $button->type ) . '" style="background-color:' . esc_attr( $button->bg_color ) . '; color:' . esc_attr( $button->text_color ) . '; border-radius:' . esc_attr( $button->border_radius ) . '; box-shadow:' . esc_attr( $button->box_shadow ) . ';">';
            if ( ! empty( $button->icon ) ) {
                echo '<i class="' . esc_attr( $button->icon ) . '"></i> ';
            }
            echo esc_html( $button->label ) . '</a>';
        }
        echo '</div>'; // Dropdown
        echo '</div>'; // Button Wrapper
    }
}
add_shortcode( 'acb_buttons', 'acb_display_buttons' );

// CSS ve JS dosyalarını yükleme
function acb_enqueue_public_assets() {
    wp_enqueue_style( 'acb-public-css', plugin_dir_url( __FILE__ ) . 'public/css/acb-public.css', array(), '1.0.0' );
    wp_enqueue_script( 'acb-public-js', plugin_dir_url( __FILE__ ) . 'public/js/acb-public.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'acb_enqueue_public_assets' );

// CSS kodları
function acb_public_css() {
    echo "
    <style>
    .acb-buttons {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }

    .acb-button {
        display: block;
        margin-bottom: 10px;
        padding: 10px 15px;
        text-decoration: none;
        color: #fff;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .acb-button i {
        margin-right: 8px;
    }

    .acb-button:hover {
        opacity: 0.8;
    }

    .acb-whatsapp {
        background-color: #25D366;
    }

    .acb-email {
        background-color: #D44638;
    }

    .acb-phone {
        background-color: #34B7F1;
    }

    .acb-form {
        background-color: #FF9900;
    }

    /* Açılır Menü */
    .acb-button-wrapper {
        position: relative;
        display: inline-block;
    }

    .acb-button-wrapper .acb-dropdown {
        display: none;
        position: absolute;
        bottom: 50px;
        right: 0;
        z-index: 1000;
    }

    .acb-button-wrapper.open .acb-dropdown {
        display: block;
    }
    </style>
    ";
}
add_action( 'wp_head', 'acb_public_css' );

// JS kodları
function acb_public_js() {
    echo "
    <script>
    jQuery(document).ready(function($){
        // Ana butona tıklandığında menüyü açıp kapatma
        $('.acb-button-wrapper .main-button').on('click', function() {
            $(this).parent().toggleClass('open');
        });

        // Butona tıklandığında tıklama izleme
        $('.acb-button').on('click', function(e) {
            var buttonId = $(this).data('button-id');
            $.post({
                url: '" . admin_url( 'admin-ajax.php' ) . "',
                data: {
                    action: 'acb_track_click',
                    button_id: buttonId
                },
                success: function(response) {
                    console.log('Tıklama kaydedildi: ' + buttonId);
                }
            });
        });
    });
    </script>
    ";
}
add_action( 'wp_footer', 'acb_public_js' );
?>
