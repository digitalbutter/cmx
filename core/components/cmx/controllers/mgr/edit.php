<?php

// $campaign= array(
// 	'title' => "Title"
// );

// $modx->regClientStartupHTMLBlock(
// "
// <script>
// 	var campaign = " . $modx->toJSON($campaign) . ";
// </script>
// "

// );

$modx->regClientCSS($cmx->config['cssUrl'].'superboxselect.css');
// $modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/SuperBoxSelect.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/SuperBoxSelect.js');


$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/edit.panel.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/drafts.grid.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/sections/edit.js');
$output = '<div id="cmx-panel-home-div"></div>';

return $output;