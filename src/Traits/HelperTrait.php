<?php

namespace Michaelr0\BuildyWp\Traits;

trait HelperTrait {
    // /**
    // * Appends a leading slash.
    // *
    // * Will remove leading forward and backslashes if it exists already before adding
    // * a leading forward slash. This prevents double slashing a string or path.
    // *
    // * The primary use of this is for paths and thus should be used for paths. It is
    // * not restricted to paths and offers no specific path support.
    // *
    // * @method addLeadingSlash
    // * @version 1.0.0
    // * @since 1.0.0
    // * @param string $string What to add the leading slash to.
    // * @return string String with leading slash added.
    // */
    // public function addLeadingSlash(string $string): string
    // {
    //     return '/' . $this->removeLeadingSlash($string);
    // }

    /**
    * Appends a trailing slash.
    *
    * Will remove trailing forward and backslashes if it exists already before adding
    * a trailing forward slash. This prevents double slashing a string or path.
    *
    * The primary use of this is for paths and thus should be used for paths. It is
    * not restricted to paths and offers no specific path support.
    *
    * @method addTrailingSlash
    * @version 1.0.0
    * @since 1.0.0
    * @param string $string What to add the trailing slash to.
    * @return string String with trailing slash added.
    */
    public function addTrailingSlash(string $string): string
    {
        return $this->removeTrailingSlash($string) . '/';
    }

    // /**
    // * Check to see if something contains something
    // *
    // * @method contains
    // * @version 1.0.0
    // * @since 1.0.0
    // * @param string $needle Check for this $needle
    // * @param string $haystack Check in this $haystack
    // * @return bool
    // */
    // public function contains(string $needle, string $haystack): bool
    // {
    // // returns true if $needle is a substring of $haystack
    //     return (strpos($haystack, $needle) !== false);
    // }

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

    // /**
    // * Removes leading forward slashes and backslashes if they exist.
    // *
    // * The primary use of this is for paths and thus should be used for paths. It is
    // * not restricted to paths and offers no specific path support.
    // *
    // * @method removeLeadingSlash
    // * @version 1.0.0
    // * @since 1.0.0
    // * @param string $string What to remove the leading slashes from.
    // * @return string String without the leading slashes.
    // */
    // public function removeLeadingSlash(string $string): string
    // {
    //     return ltrim($string, '/\\');
    // }

    /**
    * Removes trailing forward slashes and backslashes if they exist.
    *
    * The primary use of this is for paths and thus should be used for paths. It is
    * not restricted to paths and offers no specific path support.
    *
    * @method removeTrailingSlash
    * @version 1.0.0
    * @since 1.0.0
    * @param string $string What to remove the trailing slashes from.
    * @return string String without the trailing slashes.
    */
    public function removeTrailingSlash(string $string): string
    {
        return rtrim($string, '/\\');
    }
}
