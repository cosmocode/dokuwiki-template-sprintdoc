<?php
if(!defined('DOKU_INC')) die();

/** @var \helper_plugin_do $doPlugin */
$doPlugin = plugin_load('helper', 'do');
/** @var \helper_plugin_qc $qcPlugin */
$qcPlugin = plugin_load('helper', 'qc');
/** @var \action_plugin_starred $starredPlugin */
$starredPlugin = plugin_load('action', 'starred');

if($doPlugin !== null || $qcPlugin !== null || $starredPlugin !== null) {
    echo '<ul class="page-attributes">';
}


if($qcPlugin && $qcPlugin->shouldShow()) {
    $qcPrefix = tpl_getLang('quality_trigger');
    echo '<li class="plugin_qc"><strong class="sr-out">'.$qcPrefix.':</strong><a href="#"></a></li>'; // filled by javascript
}


if($doPlugin !== null) {
    $count = $doPlugin->getPageTaskCount();
    $num = $count['count'];
    $title = "";

    if($num == 0) { // no tasks - does not exist do in plug-in
        $class = "do_none";
        $title = tpl_getLang('tasks_page_none');
    } elseif($count['undone'] == 0) { // all tasks done
        $class = 'do_done';
        $title = $doPlugin->getLang('title_alldone');
    } elseif($count['late'] == 0) { // open tasks but none late
        $class = 'do_undone';
        $title = sprintf(tpl_getLang('tasks_page_intime'), $count['undone']);
    } else { // late tasks
        $class = 'do_late';
        $title = sprintf(tpl_getLang('tasks_page_late'), $count['undone'], $count['late']);
    }
    $markup = "<li class=\"plugin_do_pagetasks $class\" title=\"$title\"><strong><span class=\"num\">{$count['undone']}</span><span class=\"prefix\">" . tpl_getLang('prefix_tasks_page') . " </span></strong></li>";

    echo $markup;
}

if($starredPlugin !== null) {
    echo '<li class="plugin_starred">';
    $starredPlugin->tpl_starred();
    echo '</li>';
}

if($doPlugin !== null || $qcPlugin !== null || $starredPlugin !== null) {
    echo "</ul>";
}
