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
 * Create an Item
 * 
 * @package cmx
 * @subpackage processors
 */
$alreadyExists = $modx->getObject('cmxItem',array(
    'name' => $_POST['name'],
));
if ($alreadyExists) {
    $modx->error->addField('name',$modx->lexicon('cmx.item_err_ae'));
}

if ($modx->error->hasError()) {
    return $modx->error->failure();
}

$item = $modx->newObject('cmxItem');
$item->fromArray($_POST);

if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('cmx.item_err_save'));
}

return $modx->error->success('',$item);