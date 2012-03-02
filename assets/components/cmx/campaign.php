<?php

// Returns the campaign content for Campaign Monitor's Servers

$campaignFileId = $_GET['cid'];

if (!is_numeric($campaignFileId)) {
	die();
}

$campaignFile = $campaignFileId.'.html';

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('cmx.core_path',null,$modx->getOption('core_path').'components/cmx/');
require_once $corePath.'model/cmx/cmx.class.php';
$modx->cmx = new cmx($modx);

// CM Create Send Handler
if (!$modx->loadClass('CMHandler',$corePath.'model/cmx/',true,true)) {
    $modx->log(modX::LOG_LEVEL_ERROR,'[CMx] Could not load CMHandler class.');
    return '';
}

$cm = new CMHandler($modx);

$content = $cm->getCampaignCache($campaignFile);

if (is_string($content)) {
	echo $content;
} else {
	echo '';
}