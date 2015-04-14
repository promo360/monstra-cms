<?php defined('PROMO_ACCESS') or die('No direct script access.');

/**
 * Add new shortcode {siteurl}
 */
Shortcode::add('siteurl', 'returnSiteUrl');
function returnSiteUrl() { return Option::get('siteurl'); }
