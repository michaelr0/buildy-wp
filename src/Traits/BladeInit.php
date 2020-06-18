<?php

namespace Michaelr0\BuildyWp\Traits;

use Jenssegers\Blade\Blade;

trait BladeInit {

    public $blade;
    public $ViewCacheLocation;
    public $viewPaths = [];


    public function blade(): object
    {
        /**
         * Check to see if $this->blade has already been set, if it has then continue on.
         * Otherwise if it is empty, then set it to be a new instance of the blade class and continue on.
         */
        if (empty($this->blade)) {

            $this->blade = new Blade($this->getViewPaths(), $this->getViewCachePath());

            /**
             * Share common/global data with Blade views
             * https://laravel.com/docs/6.x/views#sharing-data-with-all-views
             */
            $globalVars = [
                // 'wpdb' => $this->wpdb,
            ];

            foreach ($globalVars as $key => $val) {
                $this->blade->view()->share($key, $val);
            }
        }

        return $this->blade;
    }

    public function getViewCachePath(): string
    {
        /**
         * Get current cache location for compiled Blade files.
         */
        $ViewCacheLocation = trailingslashit($this->ViewCacheLocation);
        $this->locationExistsOrCreate($ViewCacheLocation);
        return "{$ViewCacheLocation}";
    }

    public function getViewPaths(): array
    {
        $views = [];

        // if(true .....) is currently used as a placeholder, we may add the ability to toggle blade file overrides from the options page.
        // In which case, overrides would be disabled by default.

        /**
         * If current theme is a child theme, then add the buildy-views folder of the child theme to the views path array.
         */
        if (true && is_child_theme()) {
            $childThemeViewsPath = trailingslashit(get_stylesheet_directory()) . 'buildy-views/';

            $this->locationExistsOrCreate($childThemeViewsPath) ? $views[] = $childThemeViewsPath : null;
        }

        /**
         * Add current theme (or Parent Theme) buildy-views folder to the views path array.
         */
        if(true){
            $themeViewsPath = trailingslashit(get_template_directory()) . 'buildy-views/';
            $this->locationExistsOrCreate($themeViewsPath) ? $views[] = $themeViewsPath : null;
        }

        /**
         * Add view paths from $this->viewPaths
         */
        if(true){
            foreach($this->viewPaths as $viewPath){
                $views[] = trailingslashit($viewPath);
            }
        }

        /**
         * Add buildy views folder to the views path array.
         */
        $views[] = trailingslashit(__DIR__) . '../../resources/views/';

        return $views;
    }
}
