<?php
/**
 * Nutrition Diet functions and definitions
 *
 * @subpackage Nutrition Diet
 * @since 1.0
 */

//woocommerce//
//shop page no of columns
function nutrition_diet_woocommerce_loop_columns() {
	
	$retrun = get_theme_mod( 'nutrition_diet_archieve_item_columns', 3 );
    
    return $retrun;
}
add_filter( 'loop_shop_columns', 'nutrition_diet_woocommerce_loop_columns' );
function nutrition_diet_woocommerce_products_per_page() {

		$retrun = get_theme_mod( 'nutrition_diet_archieve_shop_perpage', 6 );
    
    return $retrun;
}
add_filter( 'loop_shop_per_page', 'nutrition_diet_woocommerce_products_per_page' );
// related products
function nutrition_diet_related_products_args( $args ) {
    $defaults = array(
        'posts_per_page' => get_theme_mod( 'nutrition_diet_related_shop_perpage', 3 ),
        'columns'        => get_theme_mod( 'nutrition_diet_related_item_columns', 3),
    );

    $args = wp_parse_args( $defaults, $args );

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'nutrition_diet_related_products_args' );
function nutrition_diet_related_products_heading($nutrition_diet_translated_text, $text, $domain) {
    $nutrition_diet_heading = get_theme_mod('woocommerce_related_products_heading', 'Related products');

    if ($text === 'Related products' && $domain === 'woocommerce') {
        $nutrition_diet_translated_text = $nutrition_diet_heading;
    }
    return $nutrition_diet_translated_text;
}
add_filter('gettext', 'nutrition_diet_related_products_heading', 20, 3);
// breadcrumb seperator
function nutrition_diet_woocommerce_breadcrumb_separator($nutrition_diet_defaults) {
    $nutrition_diet_separator = get_theme_mod('woocommerce_breadcrumb_separator', ' / ');

    // Update the separator
    $nutrition_diet_defaults['delimiter'] = $nutrition_diet_separator;

    return $nutrition_diet_defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'nutrition_diet_woocommerce_breadcrumb_separator');

//add animation class
if ( class_exists( 'WooCommerce' ) ) { 
	add_filter('post_class', function($nutrition_diet_classes, $class, $product_id) {
	    if( is_shop() || is_product_category() ){
	        
	        $nutrition_diet_classes = array_merge(['wow','swing'], $nutrition_diet_classes);
	    }
	    return $nutrition_diet_classes;
	},10,3);
}
//woocommerce-end//

// Get start function
function nutrition_diet_custom_admin_notice() {
    // Check if the notice is dismissed
    if (!get_user_meta(get_current_user_id(), 'dismissed_admin_notice', true)) {
        // Check if not on the theme documentation page
        $nutrition_diet_current_screen = get_current_screen();
        if ($nutrition_diet_current_screen && $nutrition_diet_current_screen->id !== 'appearance_page_nutrition-diet-guide-page') {
            $nutrition_diet_theme = wp_get_theme();
            ?>
            <div class="notice notice-info is-dismissible">
                <div class="notice-div">
                    <div>
                        <p class="theme-name"><?php echo esc_html($nutrition_diet_theme->get('Name')); ?></p>
                        <p><?php _e('For information and detailed instructions, check out our theme documentation.', 'nutrition-diet'); ?></p>
                    </div>
                    <a class="button-primary" href="themes.php?page=nutrition-diet-guide-page"><?php _e('Theme Documentation', 'nutrition-diet'); ?></a>
                </div>
            </div>
        <?php
        }
    }
}
add_action('admin_notices', 'nutrition_diet_custom_admin_notice');
// Dismiss notice function
function nutrition_diet_dismiss_admin_notice() {
    update_user_meta(get_current_user_id(), 'dismissed_admin_notice', true);
}
add_action('wp_ajax_nutrition_diet_dismiss_admin_notice', 'nutrition_diet_dismiss_admin_notice');
// Enqueue scripts and styles
function nutrition_diet_enqueue_admin_script($hook) {
    // Admin JS
    wp_enqueue_script('nutrition-diet-admin.js', get_theme_file_uri('/assets/js/nutrition-diet-admin.js'), array('jquery'), true);

    wp_localize_script('nutrition-diet-admin.js', 'nutrition_diet_scripts_localize', array(
        'ajax_url' => esc_url(admin_url('admin-ajax.php'))
    ));
}
add_action('admin_enqueue_scripts', 'nutrition_diet_enqueue_admin_script');
// Reset the dismissed notice status when the theme is switched
function nutrition_diet_after_switch_theme() {
    delete_user_meta(get_current_user_id(), 'dismissed_admin_notice');
}
add_action('after_switch_theme', 'nutrition_diet_after_switch_theme');
//get-start-function-end//

// tag count
function nutrition_diet_display_post_tag_count() {
    $nutrition_diet_tags = get_the_tags();
    $nutrition_diet_tag_count = ($nutrition_diet_tags) ? count($nutrition_diet_tags) : 0;
    $nutrition_diet_tag_text = ($nutrition_diet_tag_count === 1) ? 'tag' : 'tags';
    echo $nutrition_diet_tag_count . ' ' . $nutrition_diet_tag_text;
}

//media post format
function nutrition_diet_get_media($nutrition_diet_type = array()){
	$nutrition_diet_content = apply_filters( 'the_content', get_the_content() );
  	$output = false;

  // Only get media from the content if a playlist isn't present.
  if ( false === strpos( $nutrition_diet_content, 'wp-playlist-script' ) ) {
    $output = get_media_embedded_in_content( $nutrition_diet_content, $nutrition_diet_type );
    return $output;
  }
}

// front page template
function nutrition_diet_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'nutrition_diet_front_page_template' );

// excerpt function
function nutrition_diet_custom_excerpt() {
    $nutrition_diet_excerpt = get_the_excerpt();
    $nutrition_diet_plain_text_excerpt = wp_strip_all_tags($nutrition_diet_excerpt);
    
    // Get dynamic word limit from theme mod
    $nutrition_diet_word_limit = esc_attr(get_theme_mod('nutrition_diet_post_excerpt', '30'));
    
    // Limit the number of words
    $nutrition_diet_limited_excerpt = implode(' ', array_slice(explode(' ', $nutrition_diet_plain_text_excerpt), 0, $nutrition_diet_word_limit));

    echo esc_html($nutrition_diet_limited_excerpt);
}

// typography
function nutrition_diet_fonts_scripts() {
	$nutrition_diet_headings_font = esc_html(get_theme_mod('nutrition_diet_headings_text'));
	$nutrition_diet_body_font = esc_html(get_theme_mod('nutrition_diet_body_text'));

	if( $nutrition_diet_headings_font ) {
		wp_enqueue_style( 'nutrition-diet-headings-fonts', '//fonts.googleapis.com/css?family='. $nutrition_diet_headings_font );
	} else {
		wp_enqueue_style( 'nutrition-diet-be-vietnam', '//fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900');
	}
	if( $nutrition_diet_body_font ) {
		wp_enqueue_style( 'nutrition-diet-body-fonts', '//fonts.googleapis.com/css?family='. $nutrition_diet_body_font );
	} else {
		wp_enqueue_style( 'nutrition-diet-be-vietnam', '//fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900');
	}
}
add_action( 'wp_enqueue_scripts', 'nutrition_diet_fonts_scripts' );

// Footer Text
function nutrition_diet_copyright_link() {
    $nutrition_diet_footer_text = get_theme_mod('nutrition_diet_footer_text', esc_html__('Nutrition Diet WordPress Theme', 'nutrition-diet'));
    $nutrition_diet_credit_link = esc_url('https://www.ovationthemes.com/wordpress/free-nutrition-wordpress-theme/');

    echo '<a href="' . $nutrition_diet_credit_link . '" target="_blank">' . esc_html($nutrition_diet_footer_text) . '<span class="footer-copyright">' . esc_html__(' By Ovation Themes', 'nutrition-diet') . '</span></a>';
}

// custom sanitizations
// dropdown
function nutrition_diet_sanitize_dropdown_pages( $page_id, $setting ) {
	$page_id = absint( $page_id );
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}
// slider custom control
if ( ! function_exists( 'nutrition_diet_sanitize_integer' ) ) {
	function nutrition_diet_sanitize_integer( $input ) {
		return (int) $input;
	}
}
// range contol
function nutrition_diet_sanitize_number_absint( $number, $setting ) {

	// Ensure input is an absolute integer.
	$number = absint( $number );

	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;

	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );

	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );

	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}
// select post page
function nutrition_diet_sanitize_select( $input, $setting ){
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
// toggle switch
function nutrition_diet_callback_sanitize_switch( $value ) {
	// Switch values must be equal to 1 of off. Off is indicator and should not be translated.
	return ( ( isset( $value ) && $value == 1 ) ? 1 : 'off' );
}
//choices control
function nutrition_diet_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}
// phone number
function nutrition_diet_sanitize_phone_number( $phone ) {
  return preg_replace( '/[^\d+]/', '', $phone );
}
// Sanitize Sortable control.
function nutrition_diet_sanitize_sortable( $val, $setting ) {
	if ( is_string( $val ) || is_numeric( $val ) ) {
		return array(
			esc_attr( $val ),
		);
	}
	$sanitized_value = array();
	foreach ( $val as $item ) {
		if ( isset( $setting->manager->get_control( $setting->id )->choices[ $item ] ) ) {
			$sanitized_value[] = esc_attr( $item );
		}
	}
	return $sanitized_value;
}

// customizer-dropdowns
function nutrition_diet_slider_dropdown(){
	if(get_option('nutrition_diet_slider_arrows') == true ) {
		return true;
	}
	return false;
}
function nutrition_diet_about_dropdown(){
	if(get_option('nutrition_diet_about_enable') == true ) {
		return true;
	}
	return false;
}

// theme setup
function nutrition_diet_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( "align-wide" );
	add_theme_support( "wp-block-styles" );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( "responsive-embeds" );
	add_theme_support( 'title-tag' );
	add_theme_support('custom-background',array(
		'default-color' => 'ffffff',
	));
	add_image_size( 'nutrition-diet-featured-image', 2000, 1200, true );
	add_image_size( 'nutrition-diet-thumbnail-avatar', 100, 100, true );

	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nutrition-diet' ),
	) );

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array('video','gallery','audio','quote',) );
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', nutrition_diet_fonts_url() ) );
}
add_action( 'after_setup_theme', 'nutrition_diet_setup' );

// widgets
function nutrition_diet_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'nutrition-diet' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'nutrition-diet' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'nutrition-diet' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your pages and posts', 'nutrition-diet' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Sidebar 3', 'nutrition-diet' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'nutrition-diet' ),
		'before_widget' => '<section id="%1$s" class="widget wow zoomIn %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'nutrition-diet' ),
		'id'            => 'footer-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'nutrition-diet' ),
		'before_widget' => '<section id="%1$s" class="widget wow slideInLeft %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'nutrition-diet' ),
		'id'            => 'footer-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'nutrition-diet' ),
		'before_widget' => '<section id="%1$s" class="widget wow slideInLeft %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'nutrition-diet' ),
		'id'            => 'footer-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'nutrition-diet' ),
		'before_widget' => '<section id="%1$s" class="widget wow slideInRight %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'nutrition-diet' ),
		'id'            => 'footer-4',
		'description'   => __( 'Add widgets here to appear in your footer.', 'nutrition-diet' ),
		'before_widget' => '<section id="%1$s" class="widget wow slideInRight %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'nutrition_diet_widgets_init' );

// fonts
function nutrition_diet_fonts_url(){
	$nutrition_diet_font_url = '';
	$font_family = array();
	$font_family[] = 'Inter:wght@100;200;300;400;500;600;700;800;900';

	$nutrition_diet_query_args = array(
		'family'	=> rawurlencode(implode('|',$font_family)),
	);
	$nutrition_diet_font_url = add_query_arg($nutrition_diet_query_args,'//fonts.googleapis.com/css');
	return $nutrition_diet_font_url;
	$contents = wptt_get_webfont_url( esc_url_raw( $fonts_url ) );
}
//Enqueue scripts and styles.
function nutrition_diet_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'nutrition-diet-fonts', nutrition_diet_fonts_url(), array());

	//Bootstarp
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri().'/assets/css/bootstrap.css' );
	// Theme stylesheet.
	wp_enqueue_style( 'nutrition-diet-style', get_stylesheet_uri() );

	wp_style_add_data('nutrition-diet-style', 'rtl', 'replace');

	// Theme Customize CSS.
	require get_parent_theme_file_path( 'inc/extra_customization.php' );
	wp_add_inline_style( 'nutrition-diet-style',$nutrition_diet_custom_style );

	//font-awesome
	wp_enqueue_style( 'font-awesome-style', get_template_directory_uri().'/assets/css/fontawesome-all.css' );

	// Block Style
	wp_enqueue_style( 'nutrition-diet-block-style',get_template_directory_uri().'/assets/css/blocks.css' );

	//Custom JS
	wp_enqueue_script( 'nutrition-diet-custom.js', get_theme_file_uri( '/assets/js/theme-script.js' ), array( 'jquery' ), true );

	//Nav Focus JS
	wp_enqueue_script( 'nutrition-diet-navigation-focus', get_theme_file_uri( '/assets/js/navigation-focus.js' ), array( 'jquery' ), true );

	//Bootstarp JS
	wp_enqueue_script( 'bootstrap-js', get_theme_file_uri( '/assets/js/bootstrap.js' ), array( 'jquery' ),true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if (get_option('nutrition_diet_animation_enable', false) !== 'off') {
		//wow.js
		wp_enqueue_script( 'nutrition-diet-wow-js', get_theme_file_uri( '/assets/js/wow.js' ), array( 'jquery' ), true );

		//animate.css
		wp_enqueue_style( 'nutrition-diet-animate-css', get_template_directory_uri().'/assets/css/animate.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'nutrition_diet_scripts' );

// Enqueue editor styles for Gutenberg
function nutrition_diet_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'nutrition-diet-block-editor-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . '/assets/css/editor-blocks.css' );

	// Add custom fonts.
	wp_enqueue_style( 'nutrition-diet-fonts', nutrition_diet_fonts_url(), array());
}
add_action( 'enqueue_block_editor_assets', 'nutrition_diet_block_editor_styles' );

# Load scripts and styles.(fontawesome)
add_action( 'customize_controls_enqueue_scripts', 'nutrition_diet_customize_controls_register_scripts' );

function nutrition_diet_customize_controls_register_scripts() {
	
	wp_enqueue_style( 'nutrition-diet-ctypo-customize-controls-style', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );
}

// enque files
require get_parent_theme_file_path( '/inc/custom-header.php' );
require get_parent_theme_file_path( '/inc/template-tags.php' );
require get_parent_theme_file_path( '/inc/template-functions.php' );
require get_parent_theme_file_path( '/inc/customizer.php' );
require get_parent_theme_file_path( '/inc/dashboard/dashboard.php' );
require get_parent_theme_file_path( '/inc/typofont.php' );
require get_parent_theme_file_path( '/inc/wptt-webfont-loader.php' );
require get_parent_theme_file_path( '/inc/breadcrumb.php' );
require get_parent_theme_file_path( 'inc/sortable/sortable_control.php' );