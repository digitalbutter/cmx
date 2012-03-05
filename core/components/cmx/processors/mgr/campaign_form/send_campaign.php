<?php

$campaignId = $modx->getOption('id', $_REQUEST, '');
$confirmationEmail = $modx->getOption('confirmation_email', $_REQUEST, '');
$publishAt = $modx->getOption('publish_at', $_REQUEST, '');

if ($publishAt === '') {
	$publishAt = 'Immediately';
} else {
	$publishAt = str_replace('T',' ',$publishAt);
}
FB::log($_REQUEST);
// $confirmationEmail = 'justin@butter.com.hk';

$schedule = array('ConfirmationEmail'=>$confirmationEmail, 'SendDate'=>$publishAt);

FB::log($campaignId);
FB::log($schedule);


$cm = new CMHandler($modx);

$response = $cm->sendCampaign($campaignId, $schedule);

FB::log($response);

return $modx->error->success('',$response);