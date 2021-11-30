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
            <div class="mira-snackbar" <? if ($snackbar['background_color'] || $snackbar['text_color']) { ?> style="<?= $el_style ?>" <? } ?>>
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