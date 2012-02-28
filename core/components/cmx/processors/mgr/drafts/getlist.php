<?php

$cm = new CMHandler($modx);

$list = $cm->getDraftCampaigns();
$list = $cm->searchResults($list, '');
$list = $cm->sortResults($list, $sort, $dir);
$count = $cm->getCount();

return $this->outputArray($list,$count);