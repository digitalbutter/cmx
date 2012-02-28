<?php

$cid = $_REQUEST['id'];

$cm = new CMHandler($modx);

$results = $cm->getCampaignSummary($cid);

// @TODO change this shit
$html = '<table>';
foreach ($results as $label=>$result) {
	$html .= '<tr><td>'.$label.'</td>';
	$html .= '<td>'.$result.'</td></tr>';
}

$html .= '</table';
$output['content'] = $html;
$count = $cm->getCount();

return $this->outputArray($output, 1);