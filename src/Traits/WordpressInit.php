<?php

namespace Michaelr0\BuildyWp\Traits;

trait WordpressInit {
	public function wordpress_wp_default_editor($r){
		if($this->isPageBuilderEnabled()){
			return 'html'; // HTML / Text tab in TinyMCE
		}

		return $r;
	}

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

             if (!function_exists('_get_all_image_sizes')) {
               /**
                 * Get all the registered image sizes along with their dimensions
                 *
                 * @global array $_wp_additional_image_sizes
                 *
                 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
                 * @return array $image_sizes The image sizes
                 */
                function _get_all_image_sizes() {
                  global $_wp_additional_image_sizes;

                  $default_image_sizes = array( 'thumbnail', 'medium', 'large' );

                  foreach ( $default_image_sizes as $size ) {
                    $image_sizes[$size]['width']	= intval( get_option( "{$size}_size_w") );
                    $image_sizes[$size]['height'] = intval( get_option( "{$size}_size_h") );
                    $image_sizes[$size]['crop']	= get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
                  }

                  if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) )
                    $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );

                  return $image_sizes;
                }
             }


            // Custom theme option settings from Site Options (ACF)
            if (function_exists('get_field') && function_exists('get_theme_colors')) :
                $theme_colours = get_theme_colors();
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
                'registered_image_sizes' => _get_all_image_sizes(),
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

            wp_localize_script( 'hmw-child-frontend-scripts', 'global_vars', array(
            'admin_ajax_url' => admin_url( 'admin-ajax.php' )
          ) );

          echo sprintf("
            <script type='text/javascript'>
                var global_vars = {
                  rest_api_base: '%s'
                }
            </script>",
          get_rest_url());

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

        if (/*$this->isPageBuilderEnabled() && */!get_field('disable_frontend_enqueue', 'option')) {
            // Temporary IE 11 polyfills --- These don't affect file size for non-ie browsers.
            wp_enqueue_script('ie-pollyfil', 'https://polyfill.io/v3/polyfill.min.js?features=IntersectionObserver%2CIntersectionObserverEntry%2CCustomEvent', null, null, false);
            wp_enqueue_script( 'buildy-js', "{$url}/public/frontend-bundle.js", null, '1.0.0', true );
            wp_enqueue_style( 'buildy-css', "{$url}/public/frontend.css", null, '1.0.0', '');
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

    public function get_module_styles($request) {
      if (!is_wp_error($request) ) {

        $module_type = $request['module_styles'];

        $data = get_field("module_styles_{$module_type}", 'option');

        // print_r($request);
        return new \WP_REST_Response(
          array(
            'status' => 200,
            'response' => 'API hit success',
            'body' => $data
        ));
      } else {
        return new WP_Error($response_code, $response_message, $response_body);
      }
    }

    public function wordpress_init()
    {
		add_filter( 'wp_default_editor', [$this, 'wordpress_wp_default_editor']);

        // Enables the rich text/media stuff to work
        wp_enqueue_editor();

        //The Following registers an api route with multiple parameters.
        add_action( 'rest_api_init', function() {
            register_rest_route( 'bmcb/v1', '/module_styles=(?P<module_styles>[a-zA-Z0-9-]+)', array(
                'methods' => 'GET',
                'callback' => [$this, 'get_module_styles'],
            ));
        });



        // Load jQuery in the header rather than footer.
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_script('jquery');
            wp_enqueue_script('jquery', '', [], false, false);
        });

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
