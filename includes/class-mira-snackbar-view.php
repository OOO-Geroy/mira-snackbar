<?php

/**
 * View
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Mira_Snackbar
 * @subpackage Mira_Snackbar/includes
 */
class Mira_Snackbar_View
{

    function __construct()
    {
    }

    public function top_view()
    {
        $snackbar_id = $this->get_top_snackbar();

        if ($snackbar_id)
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/mira-snackbar-view-snackbar.php';
    }

    public function bot_view()
    {
        $snackbar_id = $this->get_bot_snackbar();
        if ($snackbar_id)
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/mira-snackbar-view-snackbar.php';
    }

    private function get_top_snackbar()
    {
        $top_snackbars = get_posts(array(
            'numberposts'    => 1,
            'fields'         => 'ids',
            'post_type'      => 'mira_snackbar',
            'meta_key'       => 'priority',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'meta_query'     => array(
                'relation'   => 'AND',
                array(
                    'key'    => 'vertical_location',
                    'value'  => 'top',
                ),
                array(
                    'key'    => 'sticky_snackbar',
                    'value'  => '1',
                ),
            ),
        ));

        if (!count($top_snackbars)) {
            $top_snackbars = get_posts(array(
                'numberposts'    => 1,
                'fields'         => 'ids',
                'post_type'      => 'mira_snackbar',
                'meta_key'       => 'priority',
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
                'meta_query'     => array(
                    'relation'   => 'AND',
                    array(
                        'key'    => 'vertical_location',
                        'value'  => 'top',
                        'compare' => '=',
                    ),
                    array(
                        'key'    => 'sticky_snackbar',
                        'value'  => '1',
                        'compare' => '!=',
                    ),
                ),
            ));
        }

        return count($top_snackbars) ? $top_snackbars[0] : null;
    }

    private function get_bot_snackbar()
    {

        $bot_snackbars = get_posts(array(
            'numberposts'    => 1,
            'fields'         => 'ids',
            'post_type'      => 'mira_snackbar',
            'meta_key'       => 'priority',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'meta_query'     => array(
                'relation'   => 'AND',
                array(
                    'key'     => 'vertical_location',
                    'value'   => 'bot',
                ),
                array(
                    'key'     => 'sticky_snackbar',
                    'value'   => '1',
                ),
            ),
        ));

        if (!count($bot_snackbars)) {
            $bot_snackbars = get_posts(array(
                'numberposts'    => 1,
                'fields'         => 'ids',
                'post_type'      => 'mira_snackbar',
                'meta_key'       => 'priority',
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
                'meta_query'     => array(
                    'relation'   => 'AND',
                    array(
                        'key'    => 'vertical_location',
                        'value'  => 'bot',
                        'compare' => '=',
                    ),
                    array(
                        'key'    => 'sticky_snackbar',
                        'value'  => '1',
                        'compare' => '!=',
                    ),
                ),
            ));
        }

        return count($bot_snackbars) ? $bot_snackbars[0] : null;
    }
}
