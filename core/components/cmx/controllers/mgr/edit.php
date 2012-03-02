<?php

// $campaign= array(
// 	'title' => "Title"
// );
/* var campaign = " . $modx->toJSON($campaign) . "; */

$modx->regClientStartupHTMLBlock(
"
<script>
	var mode = '" . $modx->getOption('mode', $_REQUEST, 'new') . "';
</script>
");

$modx->regClientCSS($cmx->config['cssUrl'].'superboxselect.css');
// $modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/SuperBoxSelect.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/SuperBoxSelect.js');

$modx->regClientStartupScript(MODX_MANAGER_URL . "assets/modext/util/datetime.js");
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/edit.panel.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/drafts.grid.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/sections/edit.js');
$output = '<div id="cmx-panel-edit-div"></div>';

return $output;