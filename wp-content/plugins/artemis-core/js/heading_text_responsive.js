/**
 * Created by th on 13 Mar 2017.
 */

if ( typeof window.vc.atts !== 'undefined' ) {
    vc.atts.at_swp_letter_spacing_responsive = {
        parse    : function( param ) {
            var arr = {'ls' : {}, 'fs' : {}},
                    new_value = "";
            if ( _.isUndefined( param.save_always ) ) {
                param.save_always = true; // fix #1239
            }
            var content = this.$content;

            jQuery( 'input.at_swp_heading_ls_field', content ).each( function() {
                var val = jQuery( this ).val();
                if ( val ) {
                    arr.ls[jQuery( this ).data( 'width' )] = parseInt( val );
                }
            } );

            jQuery( 'input.at_swp_heading_fs_field', content ).each( function() {
                var val = jQuery( this ).val();
                if ( val ) {
                    arr.fs[jQuery( this ).data( 'width' )] = parseInt( val );
                }
            } );

            new_value = JSON.stringify( arr );
            return new_value;
        },
        defaults : function( param ) {
            return '';
        }
    };
}
