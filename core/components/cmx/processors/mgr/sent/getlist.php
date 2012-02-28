<?php
/**
 * Campaign Monitor for MODx
 *
 * Copyright 2012 by Justin Vogel <justin@butter.com.hk>
 *
 * Campaign Monitor for MODx is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Campaign Monitor for MODx is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * cmx; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package cmx
 */
/**
 * Get a list of Items
 *
 * @package cmx
 * @subpackage processors
 */

$isLimit = !empty($_REQUEST['limit']);
$start = $modx->getOption('start',$_REQUEST,0);
$limit = $modx->getOption('limit',$_REQUEST,20);
$sort = $modx->getOption('sort',$_REQUEST,'');
$dir = $modx->getOption('dir',$_REQUEST,'ASC');

// $c = $modx->newQuery('cmxItem');
// $count = $modx->getCount('cmxItem',$c);

// $c->sortby($sort,$dir);
// if ($isLimit) $c->limit($limit,$start);
// $items = $modx->getCollection('cmxItem',$c);

// $list = array();
// foreach ($items as $item) {
//     $itemArray = $item->toArray();
//     $list[]= $itemArray;
// }

$cm = new CMHandler($modx);

$list = $cm->getSentCampaigns();
$list = $cm->searchResults($list, '');
$list = $cm->sortResults($list, $sort, $dir);
$count = $cm->getCount();


return $this->outputArray($list, $count);

