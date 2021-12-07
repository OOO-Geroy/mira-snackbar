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

$list_class = apply_filters('mira_snackbar_el_class', [
    $snackbar_data['vertical_position'],
    $snackbar_data['horizontal_position'],
    $snackbar_data['layout_type']
], 'mira-snackbar-list--');
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<? if (count($snackbar_data['snackbars'])) { 
    
    ?>
    <div class="mira-snackbar-list<?= $list_class ? ' ' . $list_class : '' ?>">
        <? foreach ($snackbar_data['snackbars'] as $snackbar) {
     
            $el_style = apply_filters('mira_snackbar_el_style', [
                'background-color' => $snackbar['background_color'],
                'color' => $snackbar['text_color']
            ]);
            $el_class = apply_filters('mira_snackbar_el_class', [
                'align-' . $snackbar['align_content']
            ], 'mira-snackbar--');
        ?>
            <div class="mira-snackbar-container">
                <div class="mira-snackbar<?= $el_class ? ' ' . $el_class : '' ?>" data-sid="<?= $snackbar['id'] ?>" data-show-after="<?= $snackbar['show_after'] ?>" <? if ($snackbar['background_color'] || $snackbar['text_color']) { ?> style="<?= $el_style ?>" <? } ?>>
                    <div class="mira-snackbar__inner">
                        <div class="mira-snackbar__content">
                            <?= apply_filters('the_content', $snackbar['content']) ?>
                        </div>
                        <? if ($snackbar['show_action_button']) { ?>
                            <div class="mira-snackbar__actions">
                                <?= apply_filters('mira_snackbar_btn', $snackbar['action_button']) ?>
                            </div>
                        <? } ?>
                    </div>
                    <? if (!$snackbar['hide_close_button'] && (!$snackbar['action_button'] || $snackbar['action_button']['action'] !== 'close')) { ?>
                        <div role="button" class="mira-snackbar__close" title="close">
                            <i class="dashicons dashicons-no-alt"></i>
                        </div>
                    <? } ?>
                </div>
                <? if ($snackbar['show_action_button'] && $snackbar['action_button']['action'] == 'popup') {
                    $inner_popup_style = apply_filters('mira_snackbar_el_style', [
                        'max-width' => $snackbar['popup_width'] . 'px',
                    ])
                ?>
                    <div class="mira-snackbar-popup" style="display: none">
                        <div class="mira-snackbar-popup__inner" <? if ($inner_popup_style) { ?> style="<?= $inner_popup_style ?>" <? } ?>>
                            <div class="mira-snackbar-popup__content">
                                <?= apply_filters('the_content', $snackbar['popup_text']) ?>
                            </div>
                            <div role="button" class="mira-snackbar-popup__close" title="close">
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        <? } ?>
    </div>
<? } ?>