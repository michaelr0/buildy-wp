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

    public function wordpress_acf_add_editor_fields()
    {
        if (function_exists('acf_add_local_field_group')) {
            $post_types = get_field('BMCB_post_types', 'option');
            if (!empty($post_types)) {
                $locations = [];

                foreach ($post_types as $post_type) {
                    $locations[][] = [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => strtolower(trim($post_type['BMCB_post_type'])),
                    ];
                }

                $acf_options = array(
                    'key' => 'group_5d55280584f62',
                    'title' => 'PageBuilder',
                    'fields' => array(
                        array(
                            'key' => 'field_5d552835c0f95',
                            'label' => 'Enable PageBuilder',
                            'name' => 'BMCB_use_PageBuilder',
                            'type' => 'true_false',
                            'instructions' => "",
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => "",
                                'class' => "",
                                'id' => "",
                            ),
                            'default_value' => 0,
                            'ui' => 1,
                            'ui_on_text' => "",
                            'ui_off_text' => "",
                        ),
                    ),
                    'location' => $locations,
                    'menu_order' => 0,
                    'position' => 'side',
                    'style' => 'default',
                    'label_placement' => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen' => "",
                    'active' => true,
                    'description' => "",
                );

                acf_add_local_field_group($acf_options);
            }
        }
    }

    public function wordpress_acf_add_options_fields()
    {
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_5d81b07219727',
                'title' => 'Buildy Options',
                'fields' => array(
                    array(
                        'key' => 'field_5d81b912abb03',
                        'label' => 'Post Types',
                        'name' => 'BMCB_post_types',
                        'type' => 'repeater',
                        'instructions' => 'Enable buildy functionality on these post types',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'table',
                        'button_label' => 'Add Post Type',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5d81b924abb04',
                                'label' => 'Post Type',
                                'name' => 'BMCB_post_type',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'bmcb-settings',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'seamless',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));

            acf_add_local_field_group(array(
                'key' => 'group_5e6f6786bb470',
                'title' => 'GUI Options',
                'fields' => array(
                    array(
                        'key' => 'field_5e6f67948b46b',
                        'label' => 'Overwrite Mode',
                        'name' => 'overwrite_mode',
                        'type' => 'true_false',
                        'instructions' => 'If things are not saving in the way they should (or everytime you open a module, the settings aren\'t saved from before) enable this option. This will force buildy to overwrite anything that was previously set (if it was corrupted or anything like that) and add the correct data in.',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_2f3f35918b46c',
                        'label' => 'Disable Frontend Files Output?',
                        'name' => 'disable_frontend_enqueue',
                        'type' => 'true_false',
                        'instructions' => 'If you\'re adding the scss and js into your theme itself, this disables the output of buildy default .css and .js',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'bmcb-settings',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
        }
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
            $config = json_encode([
                'post_id' => $post->ID,
                'post_type' => $post->post_type,
                'isGlobal' => $isGlobal,
                'overwrite_mode' => get_field('overwrite_mode', 'option'),
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

    public function wordpress_acf_add_options_pages()
    {

        // Check function exists.
        if (!function_exists('acf_add_options_page')) {
            return false;
        }

        // register options pages.
        acf_add_options_page(array(
            'page_title'    => __("BMCB General Settings"),
            'menu_title'    => __('BMCB Settings'),
            'menu_slug'     => 'bmcb-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }

    public function wordpress_init()
    {
        // Must register custom post types first
        $this->wordpress_custom_post_types_register_globals();

        // Must register custom post types first
        $this->wordpress_acf_add_options_pages();
        $this->wordpress_acf_add_options_fields();
        $this->wordpress_acf_add_editor_fields();

        add_action('admin_enqueue_scripts', [$this, 'wordpress_admin_enqueue_wp_media']);
        add_action('admin_footer', [$this, 'wordpress_admin_enqueue_footer']);
        add_action('admin_head', [$this, 'wordpress_admin_enqueue_header']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_dependancies']);
        add_action('edit_form_after_editor', [$this, 'wordpress_edit_form_after_editor']);
        add_filter('the_content', [$this, 'wordpress_add_filter_the_content']);
    }
}