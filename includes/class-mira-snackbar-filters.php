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
        add_filter('mira_snackbar_el_class', [$this, 'get_list_class'], 10, 2);
        add_filter('mira_snackbar_el_style', [$this, 'get_el_style'], 10, 1);
        add_filter('mira_snackbar_btn', [$this, 'get_action_btn'], 10, 1);
    }

    public function get_list_class($params, $prefix)
    {
        return implode(' ', array_map(function ($param) use($prefix) {
            return $prefix . $param;
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

    public function get_action_btn($data)
    {
        $style = apply_filters('mira_snackbar_el_style', [
            'background-color' => $data['background_color'],
            'color' => $data['text_color']
        ]);

        if ($data['action'] == 'expand') {
            $btn = '<div role="button" class="mira-snackbar__btn"' . ($style ? ' style="' . $style . '"' : '') . '>' . $data['text'] . '</div>';
        } elseif ($data['action'] == 'link') {
            $link_url = $data['link']['url'];
            $link_title = $data['link']['title'];
            $link_target = $data['link']['target'] ? $data['link']['target'] : '_self';
            $btn = '<a class="mira-snackbar__btn mira-snackbar__btn--link" href="' .  esc_url($link_url)  . '" target="' .  esc_attr($link_target)  . '"' . ($style ? ' style="' . $style . '"' : '') . '>' .  esc_html($link_title)  . '</a>';
        } elseif ($data['action'] == 'close') {
            $btn = '<div role="button" class="mira-snackbar__btn mira-snackbar__btn--close"' . ($style ? ' style="' . $style . '"' : '') . '>' .  $data['text']  . '</div>';
        }

        return $btn;
    }
}
