<?php

$cm = new CMHandler($modx);

$list = $cm->getScheduledCampaigns();
$list = $cm->searchResults($list, '');
$list = $cm->sortResults($list, $sort, $dir);
$count = $cm->getCount();

return $this->outputArray($list,$count);