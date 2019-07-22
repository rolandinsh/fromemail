<?php

namespace Rolandinsh;

/**
  Plugin Name: From the info email
  Plugin URI: https://rolandinsh.lv
  Description: Simple replacement for wordpress@example.com to info@example.com
  Version: 1.1.0
  Requires at least: 3.3
  Tested up to: 5.2.2
  Author: Rolands Umbrovskis
  Author URI: https://umbrovskis.com
  License: simplemediacode
  License URI: https://simplemediacode.com/license/gpl/

  Copyright (C) 2008-2019, Rolands Umbrovskis

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

    var $sitename;
    var $sitemail;
    var $fromname;

    public function __construct()
    {
        add_filter("wp_mail_from", [&$this, 'mailFrom'], 15);
        add_filter("wp_mail_from_name", [&$this, 'fromName'], 15);
        $this->sitename = $this->siteName();
        $this->sitemail = $this->mailFrom();
        $this->fromname = $this->fromName();
    }

    /**
     * Set site name to domain name
     * @return string
     */
    public function siteName()
    {
        $sitename = strtolower($_SERVER['SERVER_NAME']);
        if (substr($sitename, 0, 4) == 'www.') { // wild guess
            $sitename = substr($sitename, 4);
        }
        return $sitename;
    }

    /**
     * Set email address in "From:" to "info@..."
     * @param string $email
     * @return string
     */
    public function mailFrom($email = '')
    {
        $sitefront = 'info@';
        $siteback  = $this->sitename;
        $sitefrom  = $sitefront . $siteback;

        return $sitefrom;
    }

    /**
     * Domain name in "From" part
     * @param string $from_name
     * @return string
     */
    public function fromName($from_name = 'WordPress')
    {
        $sitename = $this->sitename;
        return $sitename ? '[' . $sitename . ']' : $from_name;
    }

}
