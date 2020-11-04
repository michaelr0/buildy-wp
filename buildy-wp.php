<?php

/**
 *
 * Plugin Name: Buildy for WP
 * Plugin URI:
 * Description: Before you judge a man, walk a mile in his shoes. After that who cares?... He’s a mile away and you’ve got his shoes!
 * Version:     2.5.0
 * Author:
 * Author URI:
 * Text Domain: buildy-wp
 * GitHub Plugin URI: https://github.com/michaelr0/buildy-wp.git
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
