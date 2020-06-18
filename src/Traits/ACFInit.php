<?php

namespace Michaelr0\BuildyWp\Traits;

trait ACFInit {
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
}
