<?php

namespace dokuwiki\template\sprintdoc;

/**
 * Class tpl
 *
 * Provides additional template functions for the dokuwiki template
 * @package dokuwiki\tpl\dokuwiki
 */

class tpl {
  static $icons = array(
              'default' => '00-default_checkbox-blank-circle-outline.svg',
              'edit' => '01-edit_pencil.svg',
              'create' => '02-create_pencil.svg',
              'draft' => '03-draft_android-studio.svg',
              'show' => '04-show_file-document.svg',
              'source' => '05-source_file-xml.svg',
              'revert' => '06-revert_replay.svg',
              'revs' => '07-revisions_history.svg',
              'backlink' => '08-backlink_link-variant.svg',
              'subscribe' => '09-subscribe_email-outline.svg',
              'top' => '10-top_arrow-up.svg',
              'mediaManager' => '11-mediamanager_folder-image.svg',
              'img_backto' => '12-back_arrow-left.svg',
          );

/**
   * Return the HTML for one of the default actions
   *
   * Reimplements parts of tpl_actionlink
   *
   * @param string $action
   * @return string
   */
  static public function pageToolAction($action) {
              $data = tpl_get_action($action);
              if(!is_array($data)) return '';
      global $lang;

      if($data['id'][0] == '#') {
                      $linktarget = $data['id'];
                  } else {
                      $linktarget = wl($data['id'], $data['params'], false, '&');
                  }
      $caption = $lang['btn_' . $data['type']];
      if(strpos($caption, '%s')) {
                      $caption = sprintf($caption, $data['replacement']);
                  }

      $svg = __DIR__ . '/images/tools/' . self::$icons[$data['type']];

      return self::pageToolItem(
                      $linktarget,
                      $caption,
                      $svg,
          array('accesskey' => $data['accesskey'])
              );
  }

/**
   * Return the HTML for a page action
   *
   * Plugins may use this in TEMPLATE_PAGETOOLS_DISPLAY
   *
   * @param string $link The link
   * @param string $caption The label of the action
   * @param string $svg The icon to show
   * @param string[] $args HTML attributes for the item
   * @return string
   */
  static public function pageToolItem($link, $caption, $svg, $args = array()) {
              if(blank($args['title'])) {
                      $args['title'] = $caption;
                  }

      if(!blank($args['accesskey'])) {
                      $args['title'] .= ' [' . strtoupper($args['accesskey']) . ']';
                  }

      if(blank($args['rel'])) {
                      $args['rel'] = 'nofollow';
                  }

      $args['href'] = $link ?: '#';

      $svg = inlineSVG($svg);
      if(!$svg) $svg = inlineSVG(__DIR__ . '/images/tools/' . self::$icons['default']);

      $attributes = buildAttributes($args, true);

      $out = "<a $attributes>";
      $out .= '<span>' . hsc($caption) . '</span>';
      $out .= $svg;
      $out .= '</a>';

      return $out;
  }

    /**
     * Assemble the tools for the current page
     *
     * It also includes the tools for some plugins, if they are installed and enabled. This does currently not trigger
     * any events, but should be adjusted to the standard dokuwiki template, once that has svg-functionality implemented.
     *
     * @return array
     */
    static public function assemblePageTools() {
      $data = array(
          'view'  => 'main-svg',
          'items' => array(
              'edit'      => static::pageToolAction('edit'),
              'revert'    => static::pageToolAction('revert'),
              'revisions' => static::pageToolAction('revisions'),
              'backlink'  => static::pageToolAction('backlink'),
              'subscribe' => static::pageToolAction('subscribe'),
          )
      );

      $data['items'] = array_map(function ($elem) {
          return '<li>' . $elem . '</li>';
      },array_filter($data['items']));

      /**
       * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
       * Begin shims as a temporary solution until the svg-approach is mainlined and the plugins have adapted
       * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
       */
      global $ACT;
      if (act_clean($ACT) === 'show') {
          /** @var \action_plugin_move_rename $move */
          $move = plugin_load('action', 'move_rename');
          if ($move && $move->getConf('pagetools_integration')) {
              $attr = array(
                  'style' => 'background-image: none;',
              );
              $item = \dokuwiki\template\sprintdoc\tpl::pageToolItem('', $move->getLang('renamepage'), __DIR__ . '/images/tools/41-format-paint.svg', $attr);
              $data['items'][] = '<li class="plugin_move_page">' . $item . '</li>';
          }

          /** @var \action_plugin_odt_export $odt */
          $odt = plugin_load('action', 'odt_export');
          if ($odt && $odt->getConf('showexportbutton')) {
              global $ID, $REV;
              $params = array('do' => 'export_odt');
              if ($REV) {
                  $params['rev'] = $REV;
              }
              $attr = array(
                  'class' => 'action export_pdf',
                  'style' => 'background-image: none;',
              );
              $svg = __DIR__ . '/images/tools/43-file-delimeted.svg';
              $item = \dokuwiki\template\sprintdoc\tpl::pageToolItem(wl($ID, $params, false, '&'), $odt->getLang('export_odt_button'), $svg, $attr);
              $data['items'][] = '<li>' . $item . '</li>';
          }

          /** @var \action_plugin_dw2pdf $dw2pdf */
          $dw2pdf = plugin_load('action', 'dw2pdf');
          if ($dw2pdf && $dw2pdf->getConf('showexportbutton')) {
              global $ID, $REV;

              $params = array('do' => 'export_pdf');
              if ($REV) {
                  $params['rev'] = $REV;
              }
              $attr = array(
                  'class' => 'action export_pdf',
                  'style' => 'background-image: none;',
              );
              $svg = __DIR__ . '/images/tools/40-pdf-file.svg';
              $item = \dokuwiki\template\sprintdoc\tpl::pageToolItem(wl($ID, $params, false, '&'), $dw2pdf->getLang('export_pdf_button'), $svg, $attr);
              $data['items'][] = '<li>' . $item . '</li>';
          }
      }
      /**
       * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
       * End of shims
       * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
       */

      $data['items']['top'] = '<li>' . static::pageToolAction('top') . '</li>';
      return $data;
  }
}
