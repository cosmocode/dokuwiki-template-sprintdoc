<?php
if(!defined('DOKU_INC')) die();

$tabs = \dokuwiki\template\sprintdoc\Template::getInstance()->getMetaBoxTabs();

?>
<div class="tab-container">
    <ul class="meta-tabs">
        <li class="a11y">&nbsp;</li>
        <?php
        foreach($tabs as $tab) {
            if (empty($tab['tab']) || trim($tab['tab']) === '') {
                continue;
            }
            echo '<li class="' . $tab['id'] . '">';
            echo '<a href="#' . $tab['id'] . '" aria-expanded="false">';
            echo '<span class="prefix">';
            echo $tab['label'];
            if($tab['count'] !== null) {
                echo ' <span class="num">' . $tab['count'] . '</span>';
            }
            echo '</span>';
            echo '</a>';
            echo '</li>';
        }
        ?>
    </ul>

    <div class="meta-content">
        <div class="box-content">
            <?php
            foreach($tabs as $tab) {
                if (empty($tab['tab']) || trim($tab['tab']) === '') {
                    continue;
                }
                echo '<div id="' . $tab['id'] . '" class="tab-pane" aria-hidden="true">';
                echo $tab['tab'];
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
