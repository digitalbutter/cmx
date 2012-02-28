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
 * Resolve creating db tables
 *
 * @package cmx
 * @subpackage build
 */
// if ($object->xpdo) {
//     switch ($options[xPDOTransport::PACKAGE_ACTION]) {
//         case xPDOTransport::ACTION_INSTALL:
//             $modx =& $object->xpdo;
//             $modelPath = $modx->getOption('cmx.core_path',null,$modx->getOption('core_path').'components/cmx/').'model/';
//             $modx->addPackage('cmx',$modelPath);

//             $manager = $modx->getManager();

//             $manager->createObjectContainer('cmxItem');

//             break;
//         case xPDOTransport::ACTION_UPGRADE:
//             break;
//     }
// }
return true;