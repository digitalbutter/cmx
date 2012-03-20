<?php

$campaignid = $modx->getOption('id', $_REQUEST, '0');

$cm = new CMHandler($modx);

return $cm->getCampaignCache($campaignid);

