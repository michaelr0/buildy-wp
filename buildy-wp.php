<?php

/**
 *
 * Plugin Name: Buildy for WP
 * Plugin URI:
 * Description: Just like a chocolate milk, only apples!
 * Version:     2.1.5
 * Author:
 * Author URI:
 * Text Domain: buildy-wp
 * Github Plugin URI: https://github.com/michaelr0/buildy-wp.git
 */

if (!defined('ABSPATH')) {
    die('Invalid request.');
}

// Load Composer
require_once('vendor/autoload.php');

// Init Buildy
use Michaelr0\BuildyWp\Buildy;

//global $buildy;
$buildy = (new Buildy);
