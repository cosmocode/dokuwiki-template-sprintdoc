<?php

if (!defined('DOKU_INC')) die();

/** @var \helper_plugin_do $doPlugin */
$doPlugin = plugin_load('helper', 'do');
/** @var \helper_plugin_qc $qcPlugin */
$qcPlugin = plugin_load('helper', 'qc');
/** @var \action_plugin_starred $starredPlugin */
$starredPlugin = plugin_load('action', 'starred');
/** @var \helper_plugin_quicksubscribe $quickSubPlugin */
$quickSubPlugin = plugin_load('helper', 'quicksubscribe');
/** @var \helper_plugin_approve_tpl $approvePlugin */
$approvePlugin = plugin_load('helper', 'approve_tpl');

$items = [];


if ($qcPlugin && $qcPlugin->shouldShow()) {
    $qcPrefix = tpl_getLang('quality_trigger');
    // filled by javascript
    $items[] = '<li class="plugin_qc"><strong class="sr-out">' . hsc($qcPrefix) . ':</strong><a href="#"></a></li>';
}


if ($doPlugin !== null) {
    $count = $doPlugin->getPageTaskCount();
    $num = (int) $count['count'];
    $title = '';

    if ($num == 0) { // no tasks - does not exist do in plug-in
        $class = 'do_none';
        $title = tpl_getLang('tasks_page_none');
    } elseif ($count['undone'] == 0) { // all tasks done
        $class = 'do_done';
        $title = $doPlugin->getLang('title_alldone');
    } elseif ($count['late'] == 0) { // open tasks but none late
        $class = 'do_undone';
        $title = sprintf(tpl_getLang('tasks_page_intime'), $count['undone']);
    } else { // late tasks
        $class = 'do_late';
        $title = sprintf(tpl_getLang('tasks_page_late'), $count['undone'], $count['late']);
    }

    $items[] = '<li class="plugin_do_pagetasks">' .
        '<span title="' . hsc($title) . '" class="' . $class . '">' .
        inlineSVG(DOKU_PLUGIN . 'do/pix/clipboard-text.svg') .
        '</span>' .
        '<span class="num">' . (int) $count['undone'] . '</span>' .
        '</li>';
}

if ($starredPlugin !== null) {
    $items[] = '<li class="plugin_starred">' . $starredPlugin->tpl_starred(false, false) . '</li>';
}

if ($quickSubPlugin !== null) {
    $items[] = '<li class="plugin_quicksubscribe">' . $quickSubPlugin->tpl_subscribe() . '</li>';
}

if ($approvePlugin !== null && $approvePlugin->shouldDisplay()) {
    global $ACT;
    $items[] = '<li class="plugin_approve">' .
        '<span class="plugin_approve-icon">' . inlineSVG(DOKU_PLUGIN . 'approve/admin.svg') . '</span>' .
        '<div class="plugin_approve-banner-content">' .
        $approvePlugin->banner($ACT) .
        '</div>' .
        '</li>';
}

if (!empty($items)) {
    echo '<ul class="page-attributes">' . implode('', $items) . '</ul>';
}
