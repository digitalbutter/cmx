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
 * Loads the home page.
 *
 * @package cmx
 * @subpackage controllers
 */
 
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/sent.grid.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/bounces.grid.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/drafts.grid.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/scheduled.grid.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($cmx->config['jsUrl'].'mgr/sections/home.js');
$output = '<div id="cmx-panel-home-div"></div>';

return $output;
