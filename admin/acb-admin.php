<?php
// Direkt erişimi engelle
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Admin menü öğesi ekleme
function acb_add_admin_menu() {
    add_menu_page(
        __( 'İletişim Butonları', 'advanced-contact-buttons' ),
        __( 'İletişim Butonları', 'advanced-contact-buttons' ),
        'manage_options',
        'acb_settings',
        'acb_render_admin_page',
        'dashicons-admin-generic',
        80
    );
}
add_action( 'admin_menu', 'acb_add_admin_menu' );

// Admin sayfasını oluşturma
function acb_render_admin_page() {
    ?>
    <div class="wrap">
        <h1><?php _e( 'Buton Ekleme ve Yönetimi', 'advanced-contact-buttons' ); ?></h1>

        <!-- Buton ekleme formu -->
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="acb_save_button">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="acb_button_type"><?php _e( 'Buton Tipi', 'advanced-contact-buttons' ); ?></label>
                    </th>
                    <td>
                        <select id="acb_button_type" name="acb_button_type">
                            <option value="whatsapp"><?php _e( 'WhatsApp', 'advanced-contact-buttons' ); ?></option>
                            <option value="email"><?php _e( 'E-posta', 'advanced-contact-buttons' ); ?></option>
                            <option value="phone"><?php _e( 'Telefon', 'advanced-contact-buttons' ); ?></option>
                            <option value="form"><?php _e( 'Kayıt Formu', 'advanced-contact-buttons' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="acb_button_label"><?php _e( 'Buton Etiketi', 'advanced-contact-buttons' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="acb_button_label" name="acb_button_label" value="" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="acb_button_url"><?php _e( 'Buton URL', 'advanced-contact-buttons' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="acb_button_url" name="acb_button_url" value="" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="acb_button_icon"><?php _e( 'Buton İkonu', 'advanced-contact-buttons' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="acb_button_icon" name="acb_button_icon" value="" class="regular-text" />
                        <p class="description"><?php _e( 'FontAwesome veya Dashicons sınıf adlarını ekleyin (örneğin, fa fa-whatsapp veya dashicons-email).' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="acb_bg_color"><?php _e( 'Arka Plan Rengi', 'advanced-contact-buttons' ); ?></label>
                    </th>
                    <td>
                        <input type="color" id="acb_bg_color" name="acb_bg_color" value="#ffffff" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="acb_text_color"><?php _e( 'Metin Rengi', 'advanced-contact-buttons' ); ?></label>
                    </th>
                    <td>
                        <input type="color" id="acb_text_color" name="acb_text_color" value="#000000" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="acb_border_radius"><?php _e( 'Kenar Yuvarlaklığı', 'advanced-contact-buttons' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="acb_border_radius" name="acb_border_radius" value="5px" class="small-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="acb_box_shadow"><?php _e( 'Gölge', 'advanced-contact-buttons' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="acb_box_shadow" name="acb_box_shadow" value="" class="regular-text" />
                    </td>
                </tr>
            </table>
            <?php submit_button( __( 'Buton Ekle', 'advanced-contact-buttons' ) ); ?>
        </form>

        <h2><?php _e( 'Mevcut Butonlar', 'advanced-contact-buttons' ); ?></h2>

        <!-- Butonları listeleme -->
        <?php acb_list_buttons(); ?>
    </div>
    <?php
}

// Butonları kaydetme işlemi
function acb_save_button() {
    global $wpdb;

    // Formdan gelen verileri alın
    if ( isset( $_POST['acb_button_type'] ) && isset( $_POST['acb_button_label'] ) ) {
        $button_type = sanitize_text_field( $_POST['acb_button_type'] );
        $button_label = sanitize_text_field( $_POST['acb_button_label'] );
        $button_url = sanitize_text_field( $_POST['acb_button_url'] );
        $button_icon = sanitize_text_field( $_POST['acb_button_icon'] );
        $bg_color = sanitize_hex_color( $_POST['acb_bg_color'] );
        $text_color = sanitize_hex_color( $_POST['acb_text_color'] );
        $border_radius = sanitize_text_field( $_POST['acb_border_radius'] );
        $box_shadow = sanitize_text_field( $_POST['acb_box_shadow'] );

        // Veritabanına kaydet
        $table_name = $wpdb->prefix . 'acb_buttons';
        $wpdb->insert(
            $table_name,
            array(
                'type' => $button_type,
                'label' => $button_label,
                'url' => $button_url,
                'icon' => $button_icon,
                'bg_color' => $bg_color,
                'text_color' => $text_color,
                'border_radius' => $border_radius,
                'box_shadow' => $box_shadow,
                'position' => 'bottom-right', // Varsayılan değer
                'is_floating' => true
            )
        );

        // Yönlendirme
        wp_redirect( admin_url( 'admin.php?page=acb_settings&status=success' ) );
        exit;
    }
}
add_action( 'admin_post_acb_save_button', 'acb_save_button' );

// Mevcut butonları listeleme
function acb_list_buttons() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'acb_buttons';
    $buttons = $wpdb->get_results( "SELECT * FROM $table_name" );

    if ( ! empty( $buttons ) ) {
        echo '<table class="widefat fixed">';
        echo '<thead><tr><th>' . __( 'Etiket', 'advanced-contact-buttons' ) . '</th><th>' . __( 'Tip', 'advanced-contact-buttons' ) . '</th><th>' . __( 'URL', 'advanced-contact-buttons' ) . '</th><th>' . __( 'İşlemler', 'advanced-contact-buttons' ) . '</th></tr></thead>';
        echo '<tbody>';
        foreach ( $buttons as $button ) {
            echo '<tr>';
            echo '<td>' . esc_html( $button->label ) . '</td>';
            echo '<td>' . esc_html( $button->type ) . '</td>';
            echo '<td>' . esc_html( $button->url ) . '</td>';
            echo '<td>';
            echo '<a href="#">' . __( 'Düzenle', 'advanced-contact-buttons' ) . '</a> | <a href="#">' . __( 'Sil', 'advanced-contact-buttons' ) . '</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>' . __( 'Henüz bir buton eklenmedi.', 'advanced-contact-buttons' ) . '</p>';
    }
}

// Kısa kod ile butonları frontend'de görüntüleme
function acb_display_buttons() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'acb_buttons';
    $buttons = $wpdb->get_results( "SELECT * FROM $table_name WHERE is_floating = 1" );

    if ( ! empty( $buttons ) ) {
        echo '<div class="acb-buttons">';
        foreach ( $buttons as $button ) {
            echo '<a href="' . esc_url( $button->url ) . '" class="acb-button acb-' . esc_attr( $button->type ) . '" style="background-color:' . esc_attr( $button->bg_color ) . '; color:' . esc_attr( $button->text_color ) . '; border-radius:' . esc_attr( $button->border_radius ) . '; box-shadow:' . esc_attr( $button->box_shadow ) . ';">';
            if ( ! empty( $button->icon ) ) {
                echo '<i class="' . esc_attr( $button->icon ) . '"></i> ';
            }
            echo esc_html( $button->label ) . '</a>';
        }
        echo '</div>';
    }
}
add_shortcode( 'acb_buttons', 'acb_display_buttons' );

// CSS ve JS dosyalarını yükleme
function acb_enqueue_public_assets() {
    wp_enqueue_style( 'acb-public-css', plugin_dir_url( __FILE__ ) . 'public/css/acb-public.css', array(), '1.0.0' );
    wp_enqueue_script( 'acb-public-js', plugin_dir_url( __FILE__ ) . 'public/js/acb-public.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'acb_enqueue_public_assets' );

// CSS
function acb_public_css() {
    echo "
    <style>
    .acb-buttons {
        position: fixed;
        bottom: 20px; /* Varsayılan pozisyon sağ alt */
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
    </style>
    ";
}
add_action( 'wp_head', 'acb_public_css' );

// JS
function acb_public_js() {
    echo "
    <script>
    jQuery(document).ready(function($){
        // Ana butona tıklandığında menüyü aç/kapa
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
