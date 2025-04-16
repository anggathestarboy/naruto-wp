<?php
if (!function_exists('newsplace_theme_enqueue_styles')) {
    add_action('wp_enqueue_scripts', 'newsplace_theme_enqueue_styles');

    function newsplace_theme_enqueue_styles()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        $newsplace_version = wp_get_theme()->get('Version');
        $parent_style = 'morenews-style';

        // Enqueue Parent and Child Theme Styles
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap' . $min . '.css', array(), $newsplace_version);
        wp_enqueue_style($parent_style, get_template_directory_uri() . '/style' . $min . '.css', array(), $newsplace_version);
        wp_enqueue_style(
            'newsplace',
            get_stylesheet_directory_uri() . '/style.css',
            array('bootstrap', $parent_style),
            $newsplace_version
        );

        // Enqueue RTL Styles if the site is in RTL mode
        if (is_rtl()) {
            wp_enqueue_style(
                'morenews-rtl',
                get_template_directory_uri() . '/rtl.css',
                array($parent_style),
                $newsplace_version
            );
        }
    }
}


function newsplace_override_morenews_header_section()
{
    remove_action('morenews_action_header_section', 'morenews_header_section', 40);
}

add_action('wp_loaded', 'newsplace_override_morenews_header_section');

function newsplace_header_section()
{

    $morenews_header_layout = morenews_get_option('header_layout');


?>

    <header id="masthead" class="<?php echo esc_attr($morenews_header_layout); ?> morenews-header">
        <?php morenews_get_block('layout-centered', 'header');  ?>
    </header>

<?php
}

add_action('morenews_action_header_section', 'newsplace_header_section', 40);

function newsplace_filter_default_theme_options($defaults)
{
    $defaults['site_title_font_size'] = 72;
    $defaults['site_title_uppercase']  = 0;
    $defaults['disable_header_image_tint_overlay']  = 1;
    $defaults['show_primary_menu_desc']  = 0;
    $defaults['show_popular_tags_section']  = 1;
    $defaults['select_popular_tags_mode']  = 'category';
    $defaults['header_layout'] = 'header-layout-centered';
    $defaults['aft_custom_title']           = __('Watch Video', 'newsplace');
    $defaults['select_main_banner_layout_section'] = 'layout-5';    
    $defaults['flash_news_title'] = __('Breaking News', 'newsplace');
    $defaults['main_popular_news_section_title'] = __('Popular', 'newsplace');
    $defaults['main_latest_news_section_title'] = __('Latest', 'newsplace');
    $defaults['main_update_news_section_title'] = __('Trending', 'newsplace');
    $defaults['secondary_color'] = '#0140DD';
    $defaults['global_show_min_read'] = 'no';
    $defaults['frontpage_content_type']  = 'frontpage-widgets-and-content';
    $defaults['featured_news_section_title'] = __('Featured News', 'newsplace');
    $defaults['show_featured_post_list_section']  = 1;
    $defaults['featured_post_list_section_title_1']           = __('General News', 'newsplace');
    $defaults['featured_post_list_section_title_2']           = __('Top News', 'newsplace');
    $defaults['featured_post_list_section_title_3']           = __('More News', 'newsplace');
    
    return $defaults;
}
add_filter('morenews_filter_default_theme_options', 'newsplace_filter_default_theme_options', 1);



/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function newsplace_widgets_init()
{

    register_sidebar(array(
        'name'          => esc_html__('Above Main Banner Section', 'newsplace'),
        'id'            => 'home-above-main-banner-widgets',
        'before_widget' => '<div id="%1$s" class="widget morenews-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="heading-line-before"></span><span class="heading-line">',
        'after_title' => '</span><span class="heading-line-after"></span></h2>',
    ));
}

add_action('widgets_init', 'newsplace_widgets_init');
