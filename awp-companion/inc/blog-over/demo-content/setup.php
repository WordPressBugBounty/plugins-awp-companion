<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Blog Over — Demo Content Setup (OCDI Integration)
 *
 * Registers demos directly for the Blog Over theme, following
 * the same pattern as Neom and Formula themes.
 *
 * @package awp-companion
 * @since   1.5.3
 */

/**
 * Register demo import files for OCDI.
 *
 * @return array
 */
if (!function_exists('blog_over_starter_sites_import_files')) {

    function blog_over_starter_sites_import_files()
    {

        $demo_url = awp_companion_plugin_url;

        return array(
            array(
                'import_file_name' => esc_html__('Blog Over Default', 'awp-companion'),
                'categories' => array('Free Demos'),
                'import_file_url' => $demo_url . 'inc/blog-over/demo-content/default/blog-over.xml',
                'import_widget_file_url' => $demo_url . 'inc/blog-over/demo-content/default/blog-over.wie',
                'import_customizer_file_url' => $demo_url . 'inc/blog-over/demo-content/default/blog-over.dat',
                'preview_url' => 'https://awplife.com/demo/blog-over/',
                'import_preview_image_url' => $demo_url . 'inc/blog-over/demo-content/default/screenshot.png',
            ),
        );
    }
}
add_filter('pt-ocdi/import_files', 'blog_over_starter_sites_import_files');

/**
 * Post-import actions: assign menus, set static front page, etc.
 *
 * @param array $selected_import Data about the selected demo.
 */
if (!function_exists('blog_over_starter_sites_after_import')) {

    function blog_over_starter_sites_after_import($selected_import)
    {

        // Assign primary menu if it exists.
        $main_menu = get_term_by('name', 'Blog Over Menu', 'nav_menu');
        if (!$main_menu) {
            $main_menu = get_term_by('name', 'Primary Menu', 'nav_menu');
        }
        if ($main_menu) {
            set_theme_mod(
                'nav_menu_locations',
                array(
                    'blog-over-main-menu' => $main_menu->term_id,
                )
            );
        }

        // Blog Over is a blog theme — keep "Your homepage displays" as
        // "Your latest posts". Do NOT set a static front page here.
    }
}
add_action('pt-ocdi/after_import', 'blog_over_starter_sites_after_import');

/**
 * Customize the OCDI admin page for Blog Over.
 *
 * @param array $default_settings OCDI page settings.
 * @return array
 */
if (!function_exists('blog_over_starter_sites_page_setup')) {

    function blog_over_starter_sites_page_setup($default_settings)
    {

        $default_settings['parent_slug'] = 'themes.php';
        $default_settings['page_title'] = esc_html__('Blog Over Demo Import', 'awp-companion');
        $default_settings['menu_title'] = esc_html__('Blog Over Starter Sites', 'awp-companion');
        $default_settings['capability'] = 'import';
        $default_settings['menu_slug'] = 'one-click-demo-import';

        return $default_settings;
    }
}
add_filter('ocdi/plugin_page_setup', 'blog_over_starter_sites_page_setup');

/**
 * Register required plugins for Blog Over demos.
 *
 * @param array $plugins Existing plugin list.
 * @return array
 */
if (!function_exists('blog_over_starter_sites_register_plugins')) {

    function blog_over_starter_sites_register_plugins($plugins)
    {

        $theme_plugins = array(
            array(
                'name' => 'A WP Life Themes Companion',
                'slug' => 'awp-companion',
                'required' => true,
            ),
        );

        return array_merge($plugins, $theme_plugins);
    }
}
add_filter('ocdi/register_plugins', 'blog_over_starter_sites_register_plugins');


