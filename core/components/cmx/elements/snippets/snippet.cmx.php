<?php
/**
 * The base cmx snippet.
 *
 * @package cmx
 */
$cmx = $modx->getService('cmx','cmx',$modx->getOption('cmx.core_path',null,$modx->getOption('core_path').'components/cmx/').'model/cmx/',$scriptProperties);
if (!($cmx instanceof cmx)) return '';

/**
 * Do your snippet code here. This demo grabs 5 items from our custom table.
 */
$tpl = $modx->getOption('tpl',$scriptProperties,'Item');
$sortBy = $modx->getOption('sortBy',$scriptProperties,'name');
$sortDir = $modx->getOption('sortDir',$scriptProperties,'ASC');
$limit = $modx->getOption('limit',$scriptProperties,5);
$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,"\n");

/* build query */
$c = $modx->newQuery('cmxItem');
$c->sortby($sortBy,$sortDir);
$c->limit($limit);
$items = $modx->getCollection('cmxItem',$c);

/* iterate through items */
$list = array();
foreach ($items as $item) {
    $itemArray = $item->toArray();
    $list[] = $cmx->getChunk($tpl,$itemArray);
}

/* output */
$output = implode($outputSeparator,$list);
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);
if (!empty($toPlaceholder)) {
    /* if using a placeholder, output nothing and set output to specified placeholder */
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}


$m = $modx->getManager();
$created = $m->createObjectContainer('cmx');
return $created ? 'Table created.' : 'Table not created.';

/* by default just return output */
return $output;