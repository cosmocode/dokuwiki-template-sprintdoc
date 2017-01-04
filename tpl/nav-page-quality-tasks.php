<?php
    if (!defined('DOKU_INC')) die();
?>

<?php
    /** @var \helper_plugin_qc $qc */
    $doPlugin = plugin_load('helper','do');
    
    /** @var \helper_plugin_qc $qc */
    $qc = plugin_load('helper','qc');
    if ($doPlugin !== null ||$qc ) {
        echo "<ul class=\"page-attributes\">";
    }
    if ($qc) {
        echo "<li class=\"plugin__qc do_none\"><a id=\"plugin__qc__link\" aria-expanded=\"false\" href=\"#plugin__qc__wrapper\"><span class=\"prefix\">".tpl_getLang('quality_trigger')."</span><span class=\"num\">0</span></strong></a>";
        $qc->tplErrorCount();
        echo "</li>";
    }
    if ($doPlugin !== null ) {
        $count = $doPlugin->getPageTaskCount();
        $num = $count['count'];
        $title = "";

        if($num == 0){ // no tasks - does not exist do in plug-in
            $class = "do_none";
            $title = tpl_getLang('tasks_page_none');
        } elseif($count['undone'] == 0){ // all tasks done
            $class = 'do_done';
            $title = $this->getLang('title_alldone');
        }elseif($count['late'] == 0) { // open tasks but none late
            $class = 'do_undone';
            $title = sprintf($this->getLang('title_intime'), $count['undone']);
        } else { // late tasks
            $class = 'do_late';
            $title = sprintf($this->getLang('title_late'), $count['undone'], $count['late']);
        }
        $markup = "<li class=\"plugin__do_pagetasks ".$class."\" title=\"'.$title.'\"><strong><span class=\"prefix\">".tpl_getLang('prefix_tasks_page')." </span><span class=\"num\">".$num."</span></strong></li>";

        echo $markup;
    }

    if ($doPlugin !== null ||$qc ) {
        echo "</ul>";
    }

/*


$out = '<div class="plugin__do_pagetasks" title="' . $title . '"><span class="' . $class . '">';
$out .= $count['undone'];
$out .= '</span></div>';

if($return) return $out;
echo $out;*/
