<?php

// $campaign= array(
// 	'title' => "Title"
// );
/* var campaign = " . $modx->toJSON($campaign) . "; */

$campaignid = $modx->getOption('id', $_REQUEST, '0');
$campaign = array();

if ($campaignid !== '0') {
	$corePath = $modx->getOption('cmx.core_path',null,$modx->getOption('core_path').'components/cmx/');
    // CM Create Send Handler
if (!$modx->loadClass('CMHandler',$corePath.'model/cmx/',true,true)) {
    $modx->log(modX::LOG_LEVEL_ERROR,'[CMx] Could not load CMHandler class.');
    return '';
}
	$campaign = require_once($modx->getOption('processorsPath',$modx->cmx->config,$corePath.'processors/').'mgr/campaign_form/load.php');
}

$modx->regClientCSS($cmx->config['cssUrl'].'superboxselect.css');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/SuperBoxSelect.js');

$modx->regClientStartupScript(MODX_MANAGER_URL . "assets/modext/util/datetime.js");
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/edit.panel.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/drafts.grid.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/sections/edit.js');

// Thanks to Mark Hamstra's code from the Gallery CMP
/* If we want to use Tiny, we'll need some extra files. */
$useTiny = $modx->getOption('cmx.use_richtext',$cmx->config,false);
if ($useTiny) {
    $tinyCorePath = $modx->getOption('tiny.core_path',null,$modx->getOption('core_path').'components/tinymce/');
    if (file_exists($tinyCorePath.'tinymce.class.php')) {

        /* First fetch the cmx+tiny specific settings */
        $cb1 = $modx->getOption('cmx.tiny.buttons1');
        $cb2 = $modx->getOption('cmx.tiny.buttons2');
        $cb3 = $modx->getOption('cmx.tiny.buttons3');
        $cb4 = $modx->getOption('cmx.tiny.buttons4');
        $cb5 = $modx->getOption('cmx.tiny.buttons5');
        $plugins = $modx->getOption('cmx.tiny.custom_plugins');
        $theme = $modx->getOption('cmx.tiny.theme');
        $bfs = $modx->getOption('cmx.tiny.theme_advanced_blockformats');
        $css = $modx->getOption('cmx.tiny.theme_advanced_css_selectors');

        /* If the settings are empty, override them with the generic tinymce settings. */
        $tinyProperties = array(
            'height' => $modx->getOption('cmx.tiny.height',null,200),
            'width' => $modx->getOption('cmx.tiny.width',null,400),
            'tiny.custom_buttons1' => (!empty($cb1)) ? $cb1 : $modx->getOption('tiny.custom_buttons1'),
            'tiny.custom_buttons2' => (!empty($cb2)) ? $cb2 : $modx->getOption('tiny.custom_buttons2'),
            'tiny.custom_buttons3' => (!empty($cb3)) ? $cb3 : $modx->getOption('tiny.custom_buttons3'),
            'tiny.custom_buttons4' => (!empty($cb4)) ? $cb4 : $modx->getOption('tiny.custom_buttons4'),
            'tiny.custom_buttons5' => (!empty($cb5)) ? $cb5 : $modx->getOption('tiny.custom_buttons5'),
            'tiny.custom_plugins' => (!empty($plugins)) ? $plugins : $modx->getOption('tiny.custom_plugins'),
            'tiny.editor_theme' => (!empty($theme)) ? $theme : $modx->getOption('tiny.editor_theme'),
            'tiny.theme_advanced_blockformats' => (!empty($bfs)) ? $bfs : $modx->getOption('tiny.theme_advanced_blockformats'),
            'tiny.css_selectors' => (!empty($css)) ? $css : $modx->getOption('tiny.css_selectors'),
        );
        
        require_once $tinyCorePath.'tinymce.class.php'; 
        $tiny = new TinyMCE($modx,$tinyProperties);
        $tiny->setProperties($tinyProperties);
        $html = $tiny->initialize();
        $modx->regClientHTMLBlock($html);
    }
}

$modx->regClientStartupHTMLBlock(
"
<script>
    var campaign = ".$modx->toJSON($campaign).";
</script>
");

$output = '<div id="cmx-panel-edit-div"></div>';

return $output;