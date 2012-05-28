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
 * cmx Connector
 *
 * @package cmx
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('cmx.core_path',null,$modx->getOption('core_path').'components/cmx/');
require_once $corePath.'model/cmx/cmx.class.php';
$modx->cmx = new cmx($modx);

// FirePHP
require_once $corePath.'library/FirePHPCore/fb.php';
// $firephp = FirePHP::getInstance(true);
FB::setEnabled(false);

// CM Create Send Handler
if (!$modx->loadClass('CMHandler',$corePath.'model/cmx/',true,true)) {
    $modx->log(modX::LOG_LEVEL_ERROR,'[CMx] Could not load CMHandler class.');
    return '';
}

$modx->lexicon->load('cmx:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->cmx->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));