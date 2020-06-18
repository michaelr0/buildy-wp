<?php

namespace Michaelr0\BuildyWp\Traits;

trait HelperTrait {
    /**
    * Check to see if the location exists.
    * If it does not, then create it.
    *
    * @method locationExistsOrCreate
    * @version 1.0.0
    * @since 1.0.0
    * @param string $location Path or location to check/create
    * @return bool
    */
    public function locationExistsOrCreate(string $location): bool
    {
        return is_dir($location) ?: mkdir($location, 0755, true);
    }
}
