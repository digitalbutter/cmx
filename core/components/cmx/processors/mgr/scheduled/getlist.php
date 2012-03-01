<?php

$refresh = $modx->getOption('refresh', $_REQUEST, false);

$isLimit = !empty($_REQUEST['limit']);
$start = $modx->getOption('start',$_REQUEST,0);
$limit = $modx->getOption('limit',$_REQUEST,20);
$sort = $modx->getOption('sort',$_REQUEST,'');
$dir = $modx->getOption('dir',$_REQUEST,'ASC');

$cm = new CMHandler($modx, $refresh);

$list = $cm->getScheduledCampaigns();
$list = $cm->searchResults($list, '');
$list = $cm->sortResults($list, $sort, $dir);
$count = $cm->getCount();

return $this->outputArray($list,$count);