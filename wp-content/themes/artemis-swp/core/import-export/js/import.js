/**
 * Created by th on 20 Apr 2017.
 */
/**
 * Created By theodor-flavian hanu
 * Date: 18 Mar 2016
 * Time: 12:39
 */
(function( $ ) {
    'use strict';

    var theme = null;
    var revsliderUrl = '';
    var contentData = {};

    function addMessage ( msg ) {
        $( '#artemis-swp-import-processing' ).append( '<p>' + msg + '</p>' );
        return true;
    }

    function error ( jqXHR, textStatus, errorThrown ) {
        addMessage( artemisSwpImport.messages.error + ' <div class="hidden_msg">' + jqXHR.responseText + '</div>' );
        addMessage( jqXHR.status + '. ' + errorThrown );
        if ( 500 === jqXHR.status ) {
            var messageDetails = '<div class="updated js_server_error">This error indicates that the Artemis Demo Importer cannot successfully import the demo under the current' +
                                 ' <strong>PHP memory limit.</strong> ';
            messageDetails += "<br>Don't worry, this is a common problem on web servers that have low PHP memory limit, and your hosting provider can easily fix this. ";
            messageDetails += "<br>Please contact your hosting support service, and ask them to increase the amount of memory dedicated to php.";
            messageDetails += "<br>If something is not clear or you need more details, feel free to mail us to support@smartwpress.com.</div>";
            addMessage( messageDetails );
        }
        toggleLoading( false );
    }

    function makeRequest ( data, success ) {
        data = $.extend( {}, {
            'action'               : 'artemis-demo-data',
            'artemis_swp_ie_nonce' : artemisSwpImport.nonce
        }, data );

        $.ajax( {
            'method'  : 'POST',
            'url'     : ajaxurl,
            'data'    : data,
            'success' : success,
            'error'   : error
        } );

    }

    function toggleLoading ( type ) {
        $( '#import_items' ).find( '.import_spinner' ).toggleClass( 'active', type );
    }

    function processResponse ( response ) {
        //there should always be a message param in response object
        addMessage( response.message );
        //if there is error=true then return false, true otherwise
        var success = ((typeof response.success !== "undefined") && response.success );
        if ( !success ) {
            toggleLoading( false );
        }
        return success;
    }

    function importThemeContent () {
        addMessage( '<strong>' + artemisSwpImport.messages.content + '</strong>' );
        makeRequest( {'type' : 'content', 'import_theme' : theme}, function( response, textStatus, jqXhr ) {
            try {
                response = JSON.parse( response );
            }
            catch ( err ) {
                error( jqXhr, textStatus, artemisSwpImport.messages.invalidResponse );
                toggleLoading( false );
                return;
            }
            if ( processResponse( response ) ) {
                contentData = response;
                revsliderUrl = response.revslider_url;
                contentData = response;
                importThemeOptions();
            }
        } );
    }

    function importThemeOptions () {
        addMessage( '<strong>' + artemisSwpImport.messages.theme_options + '</strong>' );
        var themeOptionsData = $.extend( {'type' : 'theme_options', 'import_theme' : theme}, contentData );
        makeRequest( themeOptionsData, function( response, textStatus, jqXhr ) {
            try {
                response = JSON.parse( response );
            }
            catch ( err ) {
                error( jqXhr, textStatus, artemisSwpImport.messages.invalidResponse);
                toggleLoading( false );
                return;
            }
            processResponse( response ) && importWidgets();
        } );
    }

    function importWidgets () {
        var widgetsData = $.extend( {'type' : 'widgets', 'import_theme' : theme}, contentData );
        addMessage( '<strong>' + artemisSwpImport.messages.widgets + '</strong>' );
        makeRequest( widgetsData, function( response, textStatus, jqXhr ) {
            try {
                response = JSON.parse( response );
            }
            catch ( err ) {
                error( jqXhr, textStatus, artemisSwpImport.messages.invalidResponse );
                toggleLoading( false );
                return;
            }
            if ( processResponse( response ) ) {
                if ( artemisSwpImport.revslider ) {
                    importRevslider();
                }
            }
        } );
    }

    function importRevslider () {

        addMessage( '<strong>' + artemisSwpImport.messages.revslider + '</strong>' );
        var data = {'type' : 'revslider', 'revslider_url' : revsliderUrl, 'import_theme' : theme};
        makeRequest( data, function( response, textStatus, jqXhr ) {
            try {
                response = JSON.parse( response );
            }
            catch ( err ) {
                error( jqXhr, textStatus, artemisSwpImport.messages.invalidResponse);
                toggleLoading( false );
                return;
            }
            if ( processResponse( response ) ) {
                $( '#artemis-swp-import-complete' ).show();
            }
            toggleLoading( false );
        } );
    }

    $( document ).ready( function() {
        $( '.import_artemis_homepage_btn ' ).on( 'click', function( event ) {
            event.preventDefault();
            var theme = $( this ).data( 'theme' );
            var processingContainer = $( '#artemis-swp-import-processing' );
            processingContainer.show();
            toggleLoading( true );
            var data = $.extend( {}, {
                'action'               : 'artemis-import-homepage',
                'artemis_swp_ie_nonce' : artemisSwpImport.nonce,
                'import_theme'         : theme
            }, data );

            $.ajax( {
                'method'   : 'POST',
                'url'      : ajaxurl,
                'data'     : data,
                'dataType' : 'json',
                'success'  : function( response ) {
                    processResponse( response );
                },
                'error'    : error,
                'complete' : function() {
                    toggleLoading( false );
                }
            } );
        } );
        $( '.import_artemis_btn ' ).click( function( event ) {
            event.preventDefault();
            var _self = this;
            theme = $( this ).data( 'theme' );
            var processingContainer = $( '#artemis-swp-import-processing' );
            processingContainer.show();

            toggleLoading( true );

            $( 'html,body' ).stop().animate( {
                scrollTop : processingContainer.find( 'p:last-of-type' ).offset().top
            }, 500 );

            importThemeContent();
            return;
            makeRequest( {'type' : 'content', 'import_theme' : theme}, function( response ) {
                try {
                    response = JSON.parse( response );
                }
                catch ( e ) {

                    return;
                }

                var contentData = response;
                var themeOptionsData = $.extend( {'type' : 'theme_options', 'import_theme' : theme}, contentData );
                processResponse( response )
                && addMessage( '<strong>' + artemisSwpImport.messages.theme_options + '</strong>' )
                && makeRequest( themeOptionsData, function( response ) {
                    var widgetsData = $.extend( {'type' : 'widgets', 'import_theme' : theme}, response );
                    processResponse( response )
                    && addMessage( '<strong>' + artemisSwpImport.messages.widgets + '</strong>' )
                    && makeRequest( widgetsData, function( response ) {
                        if ( processResponse( response ) ) {
                            if ( artemisSwpImport.revslider ) {
                                addMessage( '<strong>' + artemisSwpImport.messages.revslider + '</strong>' );
                                makeRequest( {'type' : 'revslider', 'revslider_url' : contentData.revslider_url, 'import_theme' : theme}, function( response ) {
                                    if ( processResponse( response ) ) {
                                        $( '#artemis-swp-import-complete' ).show();
                                    }
                                    toggleLoading( false );
                                } );
                            }
                            else {
                                $( '#artemis-swp-import-complete' ).show();
                            }
                        }
                    } );
                } );
            } );
        } );
    } );

})( window.jQuery );
