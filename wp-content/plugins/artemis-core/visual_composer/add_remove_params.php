<?php
/*
	Add new params to vc row
*/

function ARTEMIS_SWP_add_vc_row_custom_params() {
	if (!function_exists('vc_add_param')) {
		return;
	}

	vc_add_param( "vc_row", array(
		"type"			=> "colorpicker",
		"class"			=> "",
		"heading"		=> esc_html__("Color Overlay", "artemis-swp-core"),
		"param_name"	=> "js_color_overlay",
		"value"			=> "",
		"description"	=> esc_html__("Use a color overlay over the background image", "artemis-swp-core")
	));
	
	vc_add_param( "vc_row", array(
		"type"			=> "dropdown",
		"class"			=> "",
		"heading"		=> esc_html__("Color Scheme", "artemis-swp-core"),
		"param_name"	=> "lc_swp_row_color_scheme",
		"value"			=> array(
						esc_html__("Theme Settings Default", "artemis-swp-core")	=> "theme_default",
						esc_html__("White On Black", "artemis-swp-core")			=> "white_on_black",
						esc_html__("Black On White", "artemis-swp-core")			=> "black_on_white"
						),
		"description"	=> esc_html__("Add a custom color scheme that will overwrite the option in Appearance - Artemis Settings - General. This is an option added by Artemis theme", "artemis-swp-core")
	));

	vc_add_param( "vc_row", array(
		"type"			=> "dropdown",
		"class"			=> "",
		"heading"		=> esc_html__("Custom Row Width/Alignment", "artemis-swp-core"),
		"param_name"	=> "at_swp_row_boxed_width",
		"value"			=> array(
							esc_html__("Default", "artemis-swp-core")		=> "default",
							esc_html__("Boxed Width", "artemis-swp-core")	=> "force_boxed",
							esc_html__("Full Width", "artemis-swp-core")	=> "force_full"
						),
		"description"	=> esc_html__("Force row width for this row. Choose to make the row boxed width or full width. This setting makes the row to respect the theme alignment. ", "artemis-swp-core")
	));

	vc_add_param( "vc_column", array(
		"type"			=> "dropdown",
		"class"			=> "",
		"heading"		=> esc_html__("Custom Aspect Ratio", "artemis-swp-core"),
		"param_name"	=> "at_swp_col_aspect_ratio",
		"value"			=> array(
							esc_html__("Default", "artemis-swp-core")		=> "default",
							esc_html__("Square", "artemis-swp-core")	=> "ar_square",
							esc_html__("4/3", "artemis-swp-core")	=> "ar_43",
							esc_html__("16/9", "artemis-swp-core")	=> "ar_169"
						),
		"description"	=> esc_html__("Choose a custom aspect ratio for this column. The column height will be adjusted automatically according to the column width.", "artemis-swp-core")
	));	

	$category_filter_description = esc_html__( "Choose whether to display products categories masonry filter before items.", "artemis-swp-core" );
	$category_filter_description .= ' ' . esc_html__( "The filters will be visible only if more than one category is available for displayed products.", "artemis-swp-core" );

    vc_add_param( 'recent_products', array(
        "type"        => "dropdown",
        "class"       => "",
        "heading"     => esc_html__( "Show category filter", "artemis-swp-core" ),
        "param_name"  => "categories_filter",
        "value"       => array(
            esc_html__( "Disabled", "artemis-swp-core" ) => 0,
            esc_html__( "Enabled", "artemis-swp-core" )  => 1,
        ),
        "description" => $category_filter_description
    ) );
    vc_add_param( 'products', array(
        "type"        => "dropdown",
        "class"       => "",
        "heading"     => esc_html__( "Show category filter", "artemis-swp-core" ),
        "param_name"  => "categories_filter",
        "value"       => array(
            esc_html__( "Disabled", "artemis-swp-core" ) => 0,
            esc_html__( "Enabled", "artemis-swp-core" )  => 1,
        ),
        "description" => $category_filter_description
    ) );

    vc_add_param( 'sale_products', array(
        "type"        => "dropdown",
        "class"       => "",
        "heading"     => esc_html__( "Show category filter", "artemis-swp-core" ),
        "param_name"  => "categories_filter",
        "value"       => array(
            esc_html__( "Disabled", "artemis-swp-core" ) => 0,
            esc_html__( "Enabled", "artemis-swp-core" )  => 1,
        ),
        "description" => $category_filter_description
    ) );

    vc_add_param( 'featured_products', array(
        "type"        => "dropdown",
        "class"       => "",
        "heading"     => esc_html__( "Show category filter", "artemis-swp-core" ),
        "param_name"  => "categories_filter",
        "value"       => array(
            esc_html__( "Disabled", "artemis-swp-core" ) => 0,
            esc_html__( "Enabled", "artemis-swp-core" )  => 1,
        ),
        "description" => $category_filter_description
    ) );

    vc_add_param( 'best_selling_products', array(
        "type"        => "dropdown",
        "class"       => "",
        "heading"     => esc_html__( "Show category filter", "artemis-swp-core" ),
        "param_name"  => "categories_filter",
        "value"       => array(
            esc_html__( "Disabled", "artemis-swp-core" ) => 0,
            esc_html__( "Enabled", "artemis-swp-core" )  => 1,
        ),
        "description" => $category_filter_description
    ) );

    vc_add_param( 'top_rated_products', array(
        "type"        => "dropdown",
        "class"       => "",
        "heading"     => esc_html__( "Show category filter", "artemis-swp-core" ),
        "param_name"  => "categories_filter",
        "value"       => array(
            esc_html__( "Disabled", "artemis-swp-core" ) => 0,
            esc_html__( "Enabled", "artemis-swp-core" )  => 1,
        ),
        "description" => $category_filter_description
    ) );

    /*add a default css class to [product] shortcode*/
    vc_add_param( 'product', array(
        "type"        => "hidden",
        "class"       => "",
        "param_name"  => "class",
        'save_always' => true,
        "value"       => "swp_woocommerce_single_prod_scd",
    ));    


}
add_action("vc_after_init", "ARTEMIS_SWP_add_vc_row_custom_params");

/*
 * Heading text responsive
 */
function AT_SWP_letter_spacing_responsive_form_field($settings, $value)
{
    $sizes = array(
        'lg' => 'Large',
        'md' => 'Medium',
        'sm' => 'Small',
        'xs' => 'Extra small'
    );

    $values = json_decode($value, true);
    if( ! $values ) {
        $values = array();
    }

    $defaults = array('ls' => array(), 'fs' => array());
    $values   = array_merge_recursive($defaults, $values);
    ob_start();
    ?>
    <input name="<?php echo esc_attr($settings['param_name']) ?>"
           class="wpb_vc_param_value <?php echo esc_attr($settings['param_name']) ?>
        <?php echo esc_attr($settings['type']) ?>_field" type="hidden" value="<?php echo esc_attr($value) ?>"/>
    <table class="vc_table vc_column-offset-table">
        <tr>
            <th>
                <?php esc_html_e('Device', 'artemis-swp-core') ?>
            </th>
            <th>
                <?php esc_html_e('Letter Spacing', 'artemis-swp-core') ?>
            </th>
            <th>
                <?php esc_html_e('Font Size', 'artemis-swp-core') ?>
            </th>
        </tr>
        <?php foreach ($sizes as $key => $size) :
            $val_ls = isset($values['ls'][ $key ]) && $values['ls'][ $key ] ? $values['ls'][ $key ] : '';
            $val_fs = isset($values['fs'][ $key ]) && $values['fs'][ $key ] ? $values['fs'][ $key ] : '';
            ?>
            <tr class="vc_size-<?php echo esc_attr($key); ?>">
                <td class="vc_screen-size vc_screen-size-<?php echo esc_attr($key); ?>">
                    <span class="vc_icon" title="<?php echo esc_attr($size); ?>"></span>
                </td>
                <td>
                    <input type="text"
                           id="at_swp_heading_ls_field-<?php echo esc_attr($key)?>"
                           class="pb-textinput textfield at_swp_heading_ls_field"
                           data-width="<?php echo esc_attr($key); ?>"
                           value="<?php echo esc_attr($val_ls); ?>"
                    />
                </td>
                <td>
                    <input type="text"
                           id="at_swp_heading_fs_field-<?php echo esc_attr($key) ?>"
                           class="pb-textinput textfield at_swp_heading_fs_field"
                           data-width="<?php echo esc_attr($key); ?>"
                           value="<?php echo esc_attr($val_fs); ?>">
                </td>
			</tr>
        <?php endforeach ?>
    </table>
    <?php
    $output = ob_get_clean();
    return $output;
}

function ARTEMIS_SWP_letter_spacing_responsive_param()
{
    vc_add_shortcode_param('at_swp_letter_spacing_responsive', 'AT_SWP_letter_spacing_responsive_form_field');
}

add_action('vc_load_default_params', 'ARTEMIS_SWP_letter_spacing_responsive_param');
?>
