<?php defined('PROMO_ACCESS') or die('No direct script access.');

/**
 * Set meta generator
 */
Action::add('theme_meta', 'setMetaGenerator');
function setMetaGenerator() { echo '<meta name="generator" content="Powered by Promo '.Promo::VERSION.'" />'."\n"; }
