<?php

$campaignId = $modx->getOption('id', $_REQUEST, null);
$recipients = $modx->getOption('recipients', $_REQUEST, null);

$recipients = explode(',',$recipients);

FB::log($campaignId);
FB::log($recipients);


$cm = new CMHandler($modx);

$response = $cm->sendPreview($campaignId, $recipients);

FB::log($response);

return $modx->error->success('Successfully sent',$success);