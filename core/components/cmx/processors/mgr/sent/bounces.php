<?php

/**
 * Get a list of Bounces
 *
 * @package cmx
 * @subpackage processors
 */

$refresh = $modx->getOption('refresh', $_REQUEST, false);
$campaign_id = $modx->getOption('campaign_id',$_REQUEST,0);
$sent_date = $modx->getOption('sent_date',$_REQUEST,0);
$count = $modx->getOption('count',$_REQUEST,0);
$isLimit = !empty($_REQUEST['limit']);
$start = (int)$modx->getOption('start',$_REQUEST,0);
$limit = (int)$modx->getOption('limit',$_REQUEST,20);
$sort = $modx->getOption('sort',$_REQUEST,null);
$dir = $modx->getOption('dir',$_REQUEST,null);

$page_number = (int)floor($start / $limit) + 1;

$cm = new CMHandler($modx);

$list = $cm->getCampaignBounces($campaign_id,$sent_date,1,$limit,$sort,$dir);

return $this->outputArray($list, $count);
