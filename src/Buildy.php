<?php

namespace Michaelr0\BuildyWp;

use Michaelr0\BuildyWp\Traits\ACFInit;
use Michaelr0\BuildyWp\Traits\BladeInit;
use Michaelr0\BuildyWp\Traits\HelperTrait;
use Michaelr0\BuildyWp\Traits\WordpressInit;

class Buildy {
    use HelperTrait;
    use BladeInit;
    use ACFInit;
    use WordpressInit;

    public $use_PageBuilder = false;
    public $ViewCacheLocation;

    public function __construct()
    {
        $this->ViewCacheLocation = __DIR__ . "/../cache/";

        add_action('admin_init', [$this, 'wordpress_admin_init']);
        add_action('init', [$this, 'wordpress_init']);
    }

    public function renderFrontend($post_id): string
    {
        $content = $this->getContent($post_id);

        /**
         * Run do_shortcode on the returned HTML just incase any modules had any shortcode in them.
         */
        return do_shortcode($this->renderContent($content));
    }

    public function seoUrl($string): string {
      //Lower case everything
      $string = strtolower($string);
      //Make alphanumeric (removes all other characters)
      $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
      //Clean up multiple dashes or whitespaces
      $string = preg_replace("/[\s-]+/", " ", $string);
      //Convert whitespaces and underscore to dash
      $string = preg_replace("/[\s_]/", "-", $string);
      return $string;
    }

    public function renderContent($content): string
    {
        $html = "";

        if (!empty($content)) {
            foreach ($content as $data) {

              if ($data->attributes->renderDisabled ?? false && !empty($_GET['preview'])) {
                continue;
              }

                /**
                 * str_replace text-module to text.
                 * Check if returned module type is section, row or column.
                 * If it is then specify that the Blade file location is in the layouts folder.
                 * Otherwise it is located in the modules folder.
                 */
                $type = str_replace('-module', '', $data->type);
                $template = $data->options->moduleStyle ?? null;

                if(!empty($template)) {
                  $template = $this->seoUrl($template);
                }

                $location = 'modules';

                if (in_array($type, ['section', 'row', 'column'])) {
                    $location = 'layouts';
                }

                /**
                 * Generate the Bootstrap col-X-X classes for the current loop
                 */
                $columns = "";
                if (!empty($data->options->columns)) {
                    foreach ($data->options->columns as $key => $val) {
                        if (!empty($val)) {
                            // Legacy -- XS no longer exists and is defaulted to just col-val
                            if ($key == 'xs') {
                                // This is for backwards compatibility
                                $columns .= "col-{$val} ";
                            } else {
                                $columns .= "col-{$key}-{$val} ";
                            }
                        }
                    }
                    $columns = rtrim($columns, ' ');
                }

                /**
                * Generate the spacing classes (margin/paddings) for each breakpoint size
                */
                $margins = collect($data->inline->margin ?? []);
                $paddings = collect($data->inline->padding ?? []);
                $spacingClasses = "";

                foreach($margins as $breakpoint => $direction):
                    $direction = collect($direction ?? []);
                    if(!$breakpoint || !$direction) {
                        continue;
                    }
                    foreach($direction as $name => $val):
                        if(!$name || $val !== 0 && !$val) {
                            continue;
                        }
                        $first_char = substr($name, 0, 1);
                        $marginClasses = ($breakpoint === 'xs' ? '' : "$breakpoint:") . 'm' . $first_char . '-' . $val;
                        if (isset($spacingClasses)) {
                            $spacingClasses .= " $marginClasses";
                        } else {
                            $spacingClasses = $marginClasses;
                        }
                    endforeach;
                endforeach;

                foreach($paddings as $breakpoint => $direction):
                    $direction = collect($direction);
                    if(!$breakpoint || !$direction) {
                        continue;
                    }
                    foreach($direction as $name => $val):
                        if(!$name || $val !== 0 && !$val) {
                            continue;
                        }
                        $first_char = substr($name, 0, 1);
                        $paddingClasses = ($breakpoint === 'xs' ? '' : "$breakpoint:") . 'p' . $first_char . '-' . $val;
                        if (isset($spacingClasses)) {
                            $spacingClasses .= " $paddingClasses";
                        } else {
                            $spacingClasses = $paddingClasses;
                        }
                    endforeach;
                endforeach;

                /**
                 * Append data to $data->generatedAttributes // $bladeData->generatedAttributes on the view.
                 */
                $data->generatedAttributes = (object) [
                    'columns' => $columns,
                    'spacing' => $spacingClasses,
                ];

                $html .= $this->blade()->first(["{$location}.{$type}-{$template}", "{$location}.{$type}"], ['buildy' => $this, 'bladeData' => $data]);
            }
        }
        return $html;
    }

    public function getContent($post_id)
    {
        if ($post_id !== 0) {
            $content = get_post($post_id)->post_content;

            if (!empty($content)) {
                return json_decode($content);
            }

            return [];
        }
    }

    public function isPageBuilderEnabled(): bool
    {
        /**
         * Check if current page is in the Wordpress Admin section.
         * Check to see if the current screen is the general pages overview/list.
         * If it is, cancel out as we do not want to load the builder.
         */
        if (is_admin()) {
            $screen = get_current_screen();
            if (!empty($screen->base) && $screen->base === 'edit') {
                return false;
            }
        }

        /**
         * Check to see if PageBuilder is enabled
         */

        if (function_exists('get_field') && get_field('BMCB_use_PageBuilder')) {

            if(is_admin()) {
                wp_enqueue_editor();
            }
            return true;
        }

        return false;
    }
}
