jQuery(document).ready(function ($) {
    /**
     * File customizer.js.
     *
     * Theme Customizer enhancements for a better user experience.
     *
     * Contains handlers to make Theme Customizer preview reload changes asynchronously.
    */

    $('.bb-repeater-field-title.accordion-section-title').click(function () {
        $(this).toggleClass('expanded');
    });
    $('.bb-repeater-selected-icon').click(function () {
        $(this).find( ".fa-angle-down" ).toggleClass('fa-angle-up');
    });
    
    // Site title and description.
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            $( '.site-title a' ).text( to );
        } );
    } );
    
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            $( '.site-description' ).text( to );
        } );
    } );

    // Header text color.
    wp.customize( 'header_textcolor', function( value ) {
        value.bind( function( to ) {
            if ( 'blank' === to ) {
                $( '.site-title, .site-description' ).css( {
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                } );
            } else {
                $( '.site-title, .site-description' ).css( {
                    'clip': 'auto',
                    'position': 'relative'
                } );
                $( '.site-title a, .site-description' ).css( {
                    'color': to
                } );
            }
        } );
    } );

    /**
     * Repeater Fields
     */
    function bb_refresh_repeater_values() {
        $(".bb-repeater-field-control-wrap").each(function () {
            var values = [];
            var $this = $(this);
            $this.find(".bb-repeater-field-control").each(function () {
                var valueToPush = {};
                $(this).find('[data-name]').each(function () {
                    var dataName = $(this).attr('data-name');
                    var dataValue = $(this).val();
                    valueToPush[dataName] = dataValue;
                });
                values.push(valueToPush);
            });
            $this.next('.bb-repeater-collector').val(JSON.stringify(values)).trigger('change');
        });
    }

    $('#customize-theme-controls').on('click', '.bb-repeater-field-title', function () {
        $(this).next().slideToggle();
        $(this).closest('.bb-repeater-field-control').toggleClass('expanded');
    });
    $('#customize-theme-controls').on('click', '.bb-repeater-field-close', function () {
        $(this).closest('.bb-repeater-fields').slideUp();
        ;
        $(this).closest('.bb-repeater-field-control').toggleClass('expanded');
    });

    $("body").on("click", '.bb-add-control-field', function () {
        var $this = $(this).parent();
        if (typeof $this != 'undefined') {
            var field = $this.find(".bb-repeater-field-control:first").clone();
            if (typeof field != 'undefined') {
                
                field.find("input[type='text'][data-name]").each(function () {
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });

                field.find("textarea[data-name]").each(function(){
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });
                field.find("select[data-name]").each(function () {
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });

                field.find(".bb-repeater-icon-list").each(function () {
                    var defaultValue = $(this).next('input[data-name]').attr('data-default');
                    $(this).next('input[data-name]').val(defaultValue);
                    $(this).prev('.bb-repeater-selected-icon').children('i').attr('class', '').addClass(defaultValue);

                    $(this).find('li').each(function () {
                        var icon_class = $(this).find('i').attr('class');
                        if (defaultValue == icon_class) {
                            $(this).addClass('icon-active');
                        } else {
                            $(this).removeClass('icon-active');
                        }
                    });
                });

                field.find(".attachment-media-view").each(function () {
                    var defaultValue = $(this).find('input[data-name]').attr('data-default');
                    $(this).find('input[data-name]').val(defaultValue);
                    if (defaultValue) {
                        $(this).find(".thumbnail-image").html('<img src="' + defaultValue + '"/>').prev('.placeholder').addClass('hidden');
                    } else {
                        $(this).find(".thumbnail-image").html('').prev('.placeholder').removeClass('hidden');
                    }
                });

                field.find('.bb-fields').show();

                $this.find('.bb-repeater-field-control-wrap').append(field);

                field.addClass('expanded').find('.bb-repeater-fields').show();
                $('.accordion-section-content').animate({scrollTop: $this.height()}, 1000);
                bb_refresh_repeater_values();
            }

        }
        return false;
    });

    $("#customize-theme-controls").on("click", ".bb-repeater-field-remove", function () {
        if (typeof    $(this).parent() != 'undefined') {
            $(this).closest('.bb-repeater-field-control').slideUp('normal', function () {
                $(this).remove();
                bb_refresh_repeater_values();
            });
        }
        return false;
    });

    $("#customize-theme-controls").on('keyup change', '[data-name]', function () {
        bb_refresh_repeater_values();
        return false;
    });

    $('body').on('click', '.bb-selected-icon', function () {
        $(this).next().slideToggle();
    });

    /*Drag and drop to change order*/
    $(".bb-repeater-field-control-wrap").sortable({
        orientation: "vertical",
        update: function (event, ui) {
            bb_refresh_repeater_values();
        }
    });

    $('body').on('click', '.bb-repeater-icon-list li', function () {
        var icon_class = $(this).find('i').attr('class');
        $(this).addClass('icon-active').siblings().removeClass('icon-active');
        $(this).parent('.bb-repeater-icon-list').prev('.bb-repeater-selected-icon').children('i').attr('class', '').addClass(icon_class);
        $(this).parent('.bb-repeater-icon-list').next('input').val(icon_class).trigger('change');
        bb_refresh_repeater_values();
    });

    $('body').on('click', '.bb-repeater-selected-icon', function () {
        $(this).next().slideToggle();
    });

    /*
      * Switch Enable/Disable Control.
    */
    $('body').on('click', '.onoffswitch', function () {
        var $this = $(this);
        if ($this.hasClass('switch-on')) {
            $(this).removeClass('switch-on');
            $this.next('input').val('disable').trigger('change')
        } else {
            $(this).addClass('switch-on');
            $this.next('input').val('enable').trigger('change')
        }
    });

    /**
     * Select Multiple Category
     */
    $('.customize-control-checkbox-multiple input[type="checkbox"]').on('change', function () {

            var checkbox_values = $(this).parents('.customize-control').find('input[type="checkbox"]:checked').map(
                function () {
                    return $(this).val();
                }
            ).get().join(',');

            $(this).parents('.customize-control').find('input[type="hidden"]').val(checkbox_values).trigger('change');

        }
    );

});