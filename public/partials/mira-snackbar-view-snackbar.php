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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<? if (count($snackbar_data['snackbars'])) { ?>
    <div class="mira-snackbar-list 
    mira-snackbar-list--<?= $snackbar_data['vertical_position'] ?? 'top' ?> 
    mira-snackbar-list--<?= $snackbar_data['horizontal_location'] ?? 'fullwidth' ?>
    mira-snackbar-list--<?= $snackbar_data['layout_type'] ?? 'fixed' ?>
    ">
        <? foreach ($snackbar_data['snackbars'] as $snackbar) { ?>
            <div class="mira-snackbar" 
            <? if ($snackbar['background_color'] || $snackbar['text_color']) { ?> style="
            <? if ($snackbar['background_color']) { ?> background-color: <?= $snackbar['background_color'] ?>;<? } ?>
            <? if ($snackbar['text_color']) { ?> color: <?= $snackbar['text_color'] ?>; <? } ?>
            "<? } ?>>
                <div class="mira-snackbar__inner">
                    <?= $snackbar['content'] ?>
                </div>
                <div role="button" class="mira-snackbar__close" title="close">
                    <i class="dashicons dashicons-no-alt"></i>
                </div>
                <? if ($snackbar['show_extra_text']) { ?>
                    <div class="mira-snackbar__extra">
                        <?= $snackbar['extra_text'] ?>
                    </div>
                <? } ?>
            </div>
        <? } ?>
    </div>
<? } ?>