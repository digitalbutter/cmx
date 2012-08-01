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
 * Loads system settings into build
 *
 * @package cmx
 * @subpackage build
 */
$settings = array();

/*
$settings['gallery.']= $modx->newObject('modSystemSetting');
$settings['gallery.']->fromArray(array(
    'key' => 'gallery.',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'gallery',
    'area' => '',
),'',true,true);
*/

$settings['cmx.api_key'] = $modx->newObject('modSystemSetting');
$settings['cmx.api_key']->fromArray(array(
		'key' => 'cmx.api_key',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'Authentication & Base'
),'',true,true);

$settings['cmx.client_id'] = $modx->newObject('modSystemSetting');
$settings['cmx.client_id']->fromArray(array(
		'key' => 'cmx.client_id',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'Authentication & Base'
),'',true,true);

$settings['cmx.use_chunk'] = $modx->newObject('modSystemSetting');
$settings['cmx.use_chunk']->fromArray(array(
		'key' => 'cmx.use_chunk',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'Authentication & Base'
),'',true,true);

$settings['cmx.core_path'] = $modx->newObject('modSystemSetting');
$settings['cmx.core_path']->fromArray(array(
		'key' => 'cmx.core_path',
		'value' => '{core_path}components/cmx/',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'Caching'
),'',true,true);

$settings['cmx.assets_path'] = $modx->newObject('modSystemSetting');
$settings['cmx.assets_path']->fromArray(array(
		'key' => 'cmx.assets_path',
		'value' => '{base_path}assets/components/cmx/',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'Caching'
),'',true,true);

$settings['cmx.assets_url'] = $modx->newObject('modSystemSetting');
$settings['cmx.assets_url']->fromArray(array(
		'key' => 'cmx.assets_url',
		'value' => '{base_url}assets/components/cmx/',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'Caching'
),'',true,true);

$settings['cmx.cache_expiry_limit'] = $modx->newObject('modSystemSetting');
$settings['cmx.cache_expiry_limit']->fromArray(array(
		'key' => 'cmx.cache_expiry_limit',
		'value' => '180',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'Caching'
),'',true,true);

$settings['cmx.cache_expiry_limit'] = $modx->newObject('modSystemSetting');
$settings['cmx.cache_expiry_limit']->fromArray(array(
		'key' => 'cmx.cache_expiry_limit',
		'value' => '180',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'Caching'
),'',true,true);


// tinyMCE settings
$settings['cmx.tiny.buttons1'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.buttons1']->fromArray(array(
		'key' => 'cmx.tiny.buttons1',
		'value' => 'undo,redo,selectall,pastetext,pasteword,charmap,separator,image,modxlink,unlink,media,separator,code,help',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.buttons2'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.buttons2']->fromArray(array(
		'key' => 'cmx.tiny.buttons2',
		'value' => 'bold,italic,underline,strikethrough,sub,sup,separator,bullist,numlist,outdent,indent,separator,justifyleft,justifycenter,justifyright,justifyfull',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.buttons3'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.buttons3']->fromArray(array(
		'key' => 'cmx.tiny.buttons3',
		'value' => 'styleselect,formatselect,separator,styleprops',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.buttons4'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.buttons4']->fromArray(array(
		'key' => 'cmx.tiny.buttons4',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.buttons5'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.buttons5']->fromArray(array(
		'key' => 'cmx.tiny.buttons5',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.custom_plugins'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.custom_plugins']->fromArray(array(
		'key' => 'cmx.tiny.custom_plugins',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.height'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.height']->fromArray(array(
		'key' => 'cmx.tiny.height',
		'value' => '500',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.theme'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.theme']->fromArray(array(
		'key' => 'cmx.tiny.theme',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.custom_plugins'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.custom_plugins']->fromArray(array(
		'key' => 'cmx.tiny.custom_plugins',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.theme_advanced_blockformats'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.theme_advanced_blockformats']->fromArray(array(
		'key' => 'cmx.tiny.theme_advanced_blockformats',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.theme_advanced_css_selectors'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.theme_advanced_css_selectors']->fromArray(array(
		'key' => 'cmx.tiny.theme_advanced_css_selectors',
		'value' => '',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.tiny.width'] = $modx->newObject('modSystemSetting');
$settings['cmx.tiny.width']->fromArray(array(
		'key' => 'cmx.tiny.width',
		'value' => '95%',
		'xtype' => 'textfield',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

$settings['cmx.use_richtext'] = $modx->newObject('modSystemSetting');
$settings['cmx.use_richtext']->fromArray(array(
		'key' => 'cmx.use_richtext',
		'value' => 'true',
		'xtype' => 'boolean',
		'namespace' => 'cmx',
		'area' => 'TinyMCE'
),'',true,true);

return $settings;