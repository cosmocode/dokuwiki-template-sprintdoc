<?php
if(!defined('DOKU_INC')) die();

if($conf['hereyouare']): ?>


    <h6 class="sr-only" role="heading" aria-level="2"><?php echo tpl_getLang('head_breadcrumb') ?></h6>
    <p><?php
        tpl_youarehere();
        \dokuwiki\template\sprintdoc\Template::getInstance()->breadcrumbSuffix();
    ?></p>


<?php endif ?>
