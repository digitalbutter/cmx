<?php

// // Save selected users
// $pnaelInformation['users'] = $modx->toJSON( $scriptProperties['users'] );
 
// // Get selected users as comma seperate list
// $pnaelInformation['users'] = implode(',',$pnaelInformation['users']);

// $results = array();

// $results[] = array('ListID'=>'1234','Name'=>'Cool List');
// $results[] = array('ListID'=>'5678','Name'=>'Rad List');

// $count = count($results);

// return $this->outputArray($results, $count);

$cm = new CMHandler($modx);

$list = $cm->getLists();
$count = $cm->getCount();

return $this->outputArray($list, $count);