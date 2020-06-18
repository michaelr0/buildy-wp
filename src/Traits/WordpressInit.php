<?php

namespace Michaelr0\BuildyWp\Traits;

trait WordpressInit {
    public function wordpress_add_filter_the_content($content)
    {
        /**
         * Possibly crude way of intercepting the output of the_content()
         * We intercept the_content() via a Wordpress filter.
         * Normally you would modify $content in some way and then return it as normal.
         *
         * However in this case, we don't want anything from the Wordpress text area to output.
         */
        if ($this->isPageBuilderEnabled()) {

            if (is_admin()) {
                return null; // Stop shortcode render on backend.
            }

            // Get the current page/post id.
            $post_id = get_queried_object_id();

            /**
             * Render the page/post content via Blade
             */
            return $this->renderFrontend($post_id);
        }

        /**
         * If the Page Builder was not enabled on this post.
         * Return the content, as is.
         */
        return $content;
    }

    public function wordpress_custom_post_types_register_globals()
    {
        return register_post_type(
            'bmcb-global',
            array(
                'labels' => array(
                    'name' => __('Globals'),
                    'singular_name' => __('Global')
                ),
                'public'             => false,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'has_archive' => false,
                'show_in_rest' => true,
                'rewrite' => array('slug' => 'bmcb-globals'),
            )
        );
    }

    public function wordpress_edit_form_after_editor($post)
    {
        /**
         * Define if this post is a global or not.
         */
        if ($post->post_type === 'bmcb-global') {
            $isGlobal = true;
        } else {
            $isGlobal = false;
        }

        if ($this->isPageBuilderEnabled()) {
            /**
             * Create config array for the Page Builder.
             */


            // Custom theme option settings from Site Options (ACF)
            if (function_exists('get_field')) :
                $theme_colours = get_field('theme_colours', 'option');
                $overwrite_mode = get_field('overwrite_mode', 'option');
            endif;

            $config = json_encode([
                'post_id' => $post->ID,
                'post_type' => $post->post_type,
                'isGlobal' => $isGlobal,
                'theme_colours' => $theme_colours ?: null,
                'overwrite_mode' => $overwrite_mode ?: false,
                'is_admin' => current_user_can('administrator'),
                'site_url' => get_site_url(),
                'registered_post_types' => get_post_types(['_builtin' => false]),
                'global_api' => get_rest_url(get_current_blog_id(), 'wp/v2/bmcb-global'),
            ]);

            // This script contains the Config Array for the Page Builder.
            echo "<script id='config' type='application/json'>{$config}</script>";

            // This Div Loads Vue
            echo '<div id="app"></div>';

            // This style hides the Wordpress text editor.
            echo '<style>#postdivrich { display: none !important; }</style>';
        }
    }

    public function wordpress_admin_enqueue_footer()
    {
        /**
         * If Page Builder is marked as enabled for this page/post.
         * Include the needed CSS/JS files.
         */
        if ($this->isPageBuilderEnabled()) {
            $url = plugins_url() . "/buildy-wp";

            echo "<script src='{$url}/buildy-wp-gui/dist/chunk-vendors.js'></script>";
            echo "<script src='{$url}/buildy-wp-gui/dist/app.js'></script>";
        }
    }

    public function wordpress_admin_enqueue_header()
    {
        /**
         * If Page Builder is marked as enabled for this page/post.
         * Include the needed CSS/JS files.
         */
        if ($this->isPageBuilderEnabled()) {
            $url = plugins_url() . "/buildy-wp";

            echo "<link href='{$url}/buildy-wp-gui/dist/app.css' rel='stylesheet'>";
        }
    }

    public function wordpress_admin_enqueue_wp_media()
    {
        /**
         * If Page Builder is marked as enabled for this page/post.
         * Enqueue the needed scripts to allow the Media Library to function in the builder.
         */
        if (is_admin() && $this->isPageBuilderEnabled()) {
            wp_enqueue_media();
        }
    }

    public function enqueue_frontend_dependancies()
    {
        /**
         * If Page Builder is marked as enabled for this page/post.
         * Enqueue the needed css and js for MVP frontend
         * Will need a button in the settings page to enable/disable this as well
         */
        $url = plugins_url() . "/buildy-wp";

         if ($this->isPageBuilderEnabled() && !get_field('disable_frontend_enqueue', 'option')) {
            wp_enqueue_style( 'buildy-css', "{$url}/public/frontend.css", null, '1.0.0', '');
            wp_enqueue_script( 'buildy-js', "{$url}/public/frontend-bundle.js", null, '1.0.0', true );
        }

    }

    public function wordpress_admin_init()
    {
        $this->check_plugin_dependency_is_active('classic_editor', 'classic-editor/classic-editor.php');
        $this->check_plugin_dependency_is_active('acf', 'advanced-custom-fields-pro/acf.php');

        add_action('admin_enqueue_scripts', [$this, 'wordpress_admin_enqueue_wp_media']);
        add_action('admin_head', [$this, 'wordpress_admin_enqueue_header']);
        add_action('admin_footer', [$this, 'wordpress_admin_enqueue_footer']);
        add_action('edit_form_after_editor', [$this, 'wordpress_edit_form_after_editor']);
    }

    public function wordpress_init()
    {
        // Must register custom post types first
        $this->wordpress_custom_post_types_register_globals();

        // Must register custom post types first
        $this->wordpress_acf_add_options_pages();
        $this->wordpress_acf_add_options_fields();
        $this->wordpress_acf_add_editor_fields();

        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_dependancies']);
        add_filter('the_content', [$this, 'wordpress_add_filter_the_content']);
    }

    private function check_plugin_dependency_is_active(string $plugin, string $pluginPath) {
        if (is_admin() && current_user_can( 'activate_plugins' ) && !is_plugin_active($pluginPath)){
            if(method_exists($this, "dependency_notice_for_{$plugin}")){
                add_action('admin_notices', [$this, "dependency_notice_for_{$plugin}"]);
            }

            deactivate_plugins('buildy-wp/buildy-wp.php');
        }
    }

    public function dependency_notice_for_classic_editor(){
        echo '<div class="error"><p>Sorry, but Buildy requires the Classic Editor plugin to be installed and active.</p></div>';
    }

    public function dependency_notice_for_acf()
    {
        echo '<div class="error"><p>Sorry, but Buildy requires the Advanced Custom Fields plugin to be installed and active.</p></div>';
    }
}
