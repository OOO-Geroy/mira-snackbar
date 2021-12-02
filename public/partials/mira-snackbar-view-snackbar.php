<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Mira_Snackbar
 * @subpackage Mira_Snackbar/public/partials
 * @var $snackbar_data
 */

$list_class = apply_filters('mira_snackbar_list_class', [
    $snackbar_data['vertical_position'],
    $snackbar_data['horizontal_position'],
    $snackbar_data['layout_type']
]);
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<? if (count($snackbar_data['snackbars'])) { ?>
    <div class="mira-snackbar-list <?= $list_class ?>">
        <? foreach ($snackbar_data['snackbars'] as $snackbar) {
            $el_style = apply_filters('mira_snackbar_el_style', [
                'background-color' => $snackbar['background_color'],
                'color' => $snackbar['text_color']
            ]);
        ?>
            <div class="mira-snackbar" data-sid="<?= $snackbar['id'] ?>" data-show-after="<?= $snackbar['show_after'] ?>" <? if ($snackbar['background_color'] || $snackbar['text_color']) { ?> style="<?= $el_style ?>" <? } ?>>
                <div class="mira-snackbar__inner">
                    <div class="mira-snackbar__content">
                        <?= $snackbar['content'] ?>
                    </div>
                    <? if ($snackbar['show_action_button']) { ?>
                        <div class="mira-snackbar__actions">
                            <? if ($snackbar['action_button']['type'] == 'expand') { ?>
                                <div role="button" class="mira-snackbar__btn"><?= $snackbar['action_button']['text'] ?></div>
                            <? } elseif ($snackbar['action_button']['type'] == 'link') {
                                $link_url = $snackbar['action_button']['link']['url'];
                                $link_title = $snackbar['action_button']['link']['title'];
                                $link_target = $snackbar['action_button']['link']['target'] ? $snackbar['action_button']['link']['target'] : '_self';
                            ?>
                                <a class="mira-snackbar__btn mira-snackbar__btn--link" href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"><?= esc_html($link_title); ?></a>
                            <? } ?>
                        </div>
                    <? } ?>
                </div>
                <? if (!$snackbar['hide_close_button'] && (!$snackbar['action_button'] || $snackbar['action_button']['type'] !== 'close')) { ?>
                    <div role="button" class="mira-snackbar__close" title="close">
                        <i class="dashicons dashicons-no-alt"></i>
                    </div>
                <? } ?>
                <? if ($snackbar['show_action_button'] && $snackbar['action_button']['action'] == 'expand') { ?>
                    <div class="mira-snackbar__extra">
                        <?= $snackbar['extra_text'] ?>
                    </div>
                <? } ?>
            </div>
        <? } ?>
    </div>
<? } ?>