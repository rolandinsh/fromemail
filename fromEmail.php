<?php

/**
  Plugin Name: fromEmail (rolandinsh)
  Plugin URI: http://rolandinsh.lv
  Description: post types
  Version: 1.0.201602281
  Requires at least: 3.3
  Tested up to: 4.4.2
  Author: Rolands Umbrovskis
  Author URI: http://umbrovskis.com
  License: simplemediacode
  License URI: http://simplemediacode.com/license/gpl/

  Copyright (C) 2008-2016, Rolands Umbrovskis

 */
/*
 * Starting fromEmail
 */

try {

    new fromEmail();
} catch (Exception $e) {
    $eartfromemail_debug = 'Caught exception: fromEmail ' . $e->getMessage() . "\n";

    if (apply_filters('eartfromemail_debug_log', defined('WP_DEBUG_LOG') && WP_DEBUG_LOG)) {
        error_log(print_r(compact('eartfromemail_debug'), true));
    }
}



/*
 * fromEmail class
 * @since 2.0
 */

class fromEmail
{

    public function __construct()
    {
        add_filter("wp_mail_from", array(&$this, 'mailFrom'), 15);
        add_filter("wp_mail_from_name", array(&$this, 'fromName'), 15);
    }

    public function siteName()
    {
        $sitename = strtolower($_SERVER['SERVER_NAME']);
        if (substr($sitename, 0, 4) == 'www.') { // wild guess
            $sitename = substr($sitename, 4);
        }
        return $sitename;
    }

    function mailFrom($email)
    {
        /* start of code lifted from wordpress core, at http://svn.automattic.com/wordpress/tags/3.4/wp-includes/pluggable.php */
        $sitename = $this->siteName();
//        /* end of code lifted from wordpress core */
        $myfront = "info@";
        $myback = $sitename;
        $myfrom = $myfront . $myback;

        return $myfrom;
    }

    function fromName($from_name)
    {
        $sitename = $this->siteName();
        return $sitename ? '[' . $sitename . ']' : "Rolandinsh.LV"; //fallback
    }

}
