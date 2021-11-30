<?php

/**
 * Filters
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Mira_Snackbar
 * @subpackage Mira_Snackbar/includes
 */
class Mira_Snackbar_Filters
{

    public function init_filter()
    {
        add_filter('mira_snackbar_list_class', [$this, 'get_list_class'], 10, 1);
        add_filter('mira_snackbar_el_style', [$this, 'get_el_style'], 10, 1);
    }

    public function get_list_class($params)
    {
        return implode(' ', array_map(function ($param) {
            return 'mira-snackbar-list--' . $param;
        }, $params));
    }

    public function get_el_style($params)
    {
        $params = array_filter($params, function ($el) {
            return !empty($el);
        });

        $output = "";

        foreach ($params as $key => $value) {
            $output .= sprintf("%s: %s;", $key, $value);
        }
        return $output;
    }
}
