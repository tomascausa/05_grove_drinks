/**
 * Created by th on 15 Mai 2017.
 */

(function( $ ) {
    wp.customize.bind( 'ready', function() {
        function hideShowColorControls () {
            // array for our id titles
            var colorControlIds = [
                'lc_btn_bg_color',
                'lc_btn_bg_color_hover',
                'lc_btn_txt_color',
                'lc_btn_border_color',
                'lc_btn_txt_color_hover',
                'lc_btn_border_color_hover'
            ];
            if ( this.get() !== 'use_defaults' ) {
                $.each( colorControlIds, function( i, value ) {
                    $( '#customize-control-' + value ).show();
                    var control = wp.customize.instance( 'lc_customize['+ value +']' );
                    var value = $( '#customize-control-' + value + ' .wp-color-picker' ).val();
                    control.set('' );
                    control.set(value );
                } );
            }
            else {
                $.each( colorControlIds, function( i, value ) {
                    $( '#customize-control-' + value ).hide();
                   /* var control = wp.customize.instance( 'lc_customize[' + value + ']' );
                    control.set( $( '#customize-control-' + value + ' .wp-color-picker' ).data( 'defaultColor' ) );*/
                } );
            }
        }
        hideShowColorControls.apply( wp.customize.instance( 'lc_customize[lc_use_custom_btn_color]' ));
        wp.customize.instance( 'lc_customize[lc_use_custom_btn_color]' ).bind('change', hideShowColorControls);


    } );

})( jQuery );
