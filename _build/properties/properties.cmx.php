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
 * Properties for the cmx snippet.
 *
 * @package cmx
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'prop_cmx.tpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'Item',
        'lexicon' => 'cmx:properties',
    ),
    array(
        'name' => 'sortBy',
        'desc' => 'prop_cmx.sortby_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'name',
        'lexicon' => 'cmx:properties',
    ),
    array(
        'name' => 'sortDir',
        'desc' => 'prop_cmx.sortdir_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'ASC',
        'lexicon' => 'cmx:properties',
    ),
    array(
        'name' => 'limit',
        'desc' => 'prop_cmx.limit_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 5,
        'lexicon' => 'cmx:properties',
    ),
    array(
        'name' => 'outputSeparator',
        'desc' => 'prop_cmx.outputseparator_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'cmx:properties',
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => 'prop_cmx.toplaceholder_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => true,
        'lexicon' => 'cmx:properties',
    ),
/*
    array(
        'name' => '',
        'desc' => 'prop_cmx.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'cmx:properties',
    ),
    */
);

return $properties;