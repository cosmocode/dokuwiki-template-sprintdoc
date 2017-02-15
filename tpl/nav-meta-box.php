<?php
if(!defined('DOKU_INC')) die();
global $lang;

$tabs = array();

$toc = tpl_toc(true);
if($toc) {
    $tabs[] = array(
        'id' => 'spr__tab-toc',
        'label' => $lang['toc'],
        'tab' => $toc,
        'count' => null,
    );
}

/** @var helper_plugin_tagging $tags */
$tags = plugin_load('helper', 'tagging');
if($tags) {
    $tabs[] = array(
        'id' => 'spr__tab-tags',
        'label' => tpl_getLang('tab_tags'),
        'tab' => $tags->tpl_tags(false),
        'count' => null, // FIXME
    );
}

// fixme add magicmatcher info

?>
<div class="tab-container">
    <ul class="meta-tabs">
        <?php
        foreach($tabs as $tab) {
            echo '<li>';
            echo '<a href="#' . $tab['id'] . '" aria-expanded="false">';
            echo '<span class="prefix">';
            echo $tab['label'];
            if($tab['count'] !== null) {
                echo ' <span class="num">' . $tab['count'] . '</span>';
            }
            echo '</span>';
            echo '</li>';
        }
        ?>
    </ul>

    <div class="meta-content">
        <div class="box-content">
            <?php
            foreach($tabs as $tab) {
                echo '<div id="' . $tab['id'] . '" class="tab-pane" aria-hidden="true">';
                echo $tab['tab'];
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
