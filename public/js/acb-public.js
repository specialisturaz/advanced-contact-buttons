jQuery(document).ready(function($){
    // Ana butona tıklandığında menüyü açıp kapatma
    $('.acb-button-wrapper .main-button').on('click', function() {
        $(this).parent().toggleClass('open');
    });

    // Butona tıklandığında tıklama izleme
    $('.acb-button').on('click', function(e) {
        var buttonId = $(this).data('button-id');
        $.post({
            url: admin_url( 'admin-ajax.php' ),
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
