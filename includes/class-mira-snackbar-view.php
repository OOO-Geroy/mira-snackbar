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
    private $exclude = [];

    function __construct()
    {
        $this->exclude = array_map(function ($key) {
            return (int) str_replace('m-snackbar-', '', $key);
        }, array_values(array_filter(array_keys($_COOKIE), function ($key) {
            return str_contains($key, 'm-snackbar-');
        })));
    }

    public function top_view($layout_types = [])
    {
        $snackbars_data = $this->get_snackbar_data($this->get_snackbars('top', $layout_types), 'top');
        foreach ($snackbars_data as $snackbar_data) {
            if (count($snackbar_data['snackbars'])) {
                require plugin_dir_path(dirname(__FILE__)) . 'public/partials/mira-snackbar-view-snackbar.php';
            }
        }
    }

    public function bot_view($layout_types = [])
    {
        $snackbars_data = $this->get_snackbar_data($this->get_snackbars('bot', $layout_types), 'bot');
        foreach ($snackbars_data as $snackbar_data) {
            if (count($snackbar_data['snackbars'])) {
                require plugin_dir_path(dirname(__FILE__)) . 'public/partials/mira-snackbar-view-snackbar.php';
            }
        }
    }

    private function get_snackbars($vertical_location, $layout_types = [])
    {

        $extra_meta = array_map(function ($loaout_type) {
            return [
                'key'     => 'layout_type',
                'value'   => $loaout_type,
            ];
        }, $layout_types);
        $extra_meta['relation'] = 'OR';

        $bot_snackbars = get_posts(array(
            'numberposts'    => 1,
            'fields'         => 'ids',
            'post_type'      => 'mira_snackbar',
            'meta_key'       => 'priority',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'exclude'        => $this->exclude,
            'meta_query'     => array(
                'relation'   => 'AND',
                array(
                    'key'     => 'vertical_location',
                    'value'   => $vertical_location,
                ),
                array(
                    'key'     => 'sticky_snackbar',
                    'value'   => '1',
                ),
                $extra_meta
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
                'exclude'        => $this->exclude,
                'meta_query'     => array(
                    'relation'   => 'AND',
                    array(
                        'key'    => 'vertical_location',
                        'value'  => $vertical_location,
                        'compare' => '=',
                    ),
                    array(
                        'key'    => 'sticky_snackbar',
                        'value'  => '1',
                        'compare' => '!=',
                    ),
                    $extra_meta
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
        $real_hor_pos = $horizontal_position;
        if ($layout_type == 'static' || $layout_type == 'sticky') $real_hor_pos = 'fullwidth';
        return [
            'horizontal_position' => $real_hor_pos,
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
                'id' => $snackbar_id,
                'content' => get_the_content(null, false, $snackbar_id),
                'layout_type' => get_field('layout_type', $snackbar_id),
                'vertical_location' => get_field('vertical_location', $snackbar_id),
                'horizontal_location' => get_field('horizontal_location', $snackbar_id),
                'align_content' => get_field('align_content', $snackbar_id),
                'sticky_snackbar' => get_field('sticky_snackbar', $snackbar_id),
                'show_action_button' => get_field('show_action_button', $snackbar_id),
                'hide_close_button' => get_field('hide_close_button', $snackbar_id),
                'action_button' => get_field('action_button', $snackbar_id),
                'popup_text' => get_field('popup_text', $snackbar_id),
                'popup_width' => get_field('popup_width', $snackbar_id),
                'background_color' => get_field('background_color', $snackbar_id),
                'text_color' => get_field('text_color', $snackbar_id),
                'show_after' => get_field('show_after', $snackbar_id),
                'show_delay' => get_field('show_delay', $snackbar_id) ? (int) get_field('show_delay', $snackbar_id) : 0,
            ];
        }, $snackbar_ids);
    }
}
