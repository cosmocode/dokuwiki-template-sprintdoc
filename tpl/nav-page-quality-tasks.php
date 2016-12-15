<?php
    if (!defined('DOKU_INC')) die();
?>

<?php
    $doplugin = plugin_load('helper','do');
    if ($doplugin !== null) {
        echo "<ul>";
        $tasks = $doplugin->getPageTaskCount();
        $num = $tasks[count];
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
        echo "</ul>";
    }


/*


$out = '<div class="plugin__do_pagetasks" title="' . $title . '"><span class="' . $class . '">';
$out .= $count['undone'];
$out .= '</span></div>';

if($return) return $out;
echo $out;*/
