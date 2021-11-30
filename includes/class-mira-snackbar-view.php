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
        $snackbars_data = $this->get_snackbar_data($this->get_top_snackbars(), 'top');
        foreach ($snackbars_data as $snackbar_data) {
            if (count($snackbar_data['snackbars'])) {
                require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/mira-snackbar-view-snackbar.php';
            }
        }
    }

    public function bot_view()
    {
        $snackbars_data = $this->get_snackbar_data($this->get_bot_snackbars(), 'bot');
        foreach ($snackbars_data as $snackbar_data) {
            if (count($snackbar_data['snackbars'])) {
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

    private function get_snackbar_data($snackbar_ids, $vertical_position)
    {
        $snackbars = $this->gen_snackbar_obj($snackbar_ids);
        $hor_positions = array_keys(get_field_object('field_619e78294f64e')['choices']);
        $layout_types = array_keys(get_field_object('field_619e748e4f64b')['choices']);

        foreach ($hor_positions as $hor_position) {
            foreach ($layout_types as $layout_type) {
                $pairs[] = [$hor_position, $layout_type];
            }
        }

        return array_map(function ($pair) use ($snackbars, $vertical_position) {
            return $this->gen_snackbar_pos_obj($snackbars, $pair[0], $vertical_position, $pair[1]);
        }, $pairs);
    }

    private function gen_snackbar_pos_obj($snackbars, $horizontal_position, $vertical_position, $layout_type)
    {
        if ($layout_type == 'static' || $layout_type == 'sticky') $horizontal_position = 'fullwidth';
        return [
            'horizontal_position' => $horizontal_position,
            'vertical_position' => $vertical_position,
            'layout_type' => $layout_type,
            'snackbars' => array_filter($snackbars, function ($snackbar) use ($horizontal_position, $vertical_position, $layout_type) {
                return $snackbar['horizontal_location'] == $horizontal_position && 
                $snackbar['vertical_location'] == $vertical_position && 
                $snackbar['layout_type'] == $layout_type;
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
                'extra_text' => get_field('extra_text', $snackbar_id),
                'background_color' => get_field('background_color', $snackbar_id),
                'text_color' => get_field('text_color', $snackbar_id)
            ];
        }, $snackbar_ids);
    }
}
