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
        $snackbars_data = $this->get_snackbar_data($this->get_top_snackbars());
        foreach ($snackbars_data as $snackbar_data) {
            if (count($snackbar_data['snackbars'])) {
                $snackbar_data['vertical_position'] = 'top';
                require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/mira-snackbar-view-snackbar.php';
            }
        }
    }

    public function bot_view()
    {
        $snackbars_data = $this->get_snackbar_data($this->get_bot_snackbars());
        foreach ($snackbars_data as $snackbar_data) {
            if (count($snackbar_data['snackbars'])) {
                $snackbar_data['vertical_position'] = 'bot';
                require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/mira-snackbar-view-snackbar.php';
            }
        }
    }

    private function get_top_snackbars()
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

        return count($top_snackbars) ? $top_snackbars : [];
    }

    private function get_bot_snackbars()
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

        return count($bot_snackbars) ? $bot_snackbars : [];
    }

    private function get_snackbar_data($snackbar_ids)
    {
        $snackbars = $this->gen_snackbar_obj($snackbar_ids);

        return array_map(function ($horizontal_position) use ($snackbars) {
            return $this->gen_snackbar_pos_obj($snackbars, $horizontal_position);
        }, ['fullwidth', 'left', 'right']);
    }

    private function gen_snackbar_pos_obj($snackbars, $horizontal_position)
    {
        return [
            'horizontal_position' => $horizontal_position,
            'snackbars' => array_filter($snackbars, function ($snackbar) use ($horizontal_position) {
                return $snackbar['horizontal_location'] == $horizontal_position;
            }),
        ];
    }


    private function gen_snackbar_obj($snackbar_ids)
    {
        return array_map(function ($snackbar_id) {
            return [
                'content' => get_the_content(null, false, $snackbar_id),
                'layout_type' => get_field('layout_type', $snackbar_id),
                'vertical_location' => get_field('vertical_location', $snackbar_id),
                'horizontal_location' => get_field('horizontal_location', $snackbar_id),
                'sticky_snackbar' => get_field('sticky_snackbar', $snackbar_id),
                'show_extra_text' => get_field('show_extra_text', $snackbar_id),
                'extra_text' => get_field('extra_text', $snackbar_id)
            ];
        }, $snackbar_ids);
    }
}
