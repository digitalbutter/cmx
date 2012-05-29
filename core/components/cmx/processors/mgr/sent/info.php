<?php

$cid = $_REQUEST['id'];

$cm = new CMHandler($modx);

$results = $cm->getCampaignSummary($cid);

foreach ($results as $label=>$result) {
	$output[$label] = $result;
}

$count = $cm->getCount();

return $this->outputArray($output, 1);