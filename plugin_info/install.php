<?php
/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

// Fonction exécutée automatiquement après l'installation du plugin
function speedtestByOokla_install()
{
	$cron = cron::byClassAndFunction('speedtestByOokla', 'update');
	if (!is_object($cron)) {
		$cron = new cron();
		$cron->setClass('speedtestByOokla');
		$cron->setFunction('update');
		$cron->setEnable(1);
		$cron->setDeamon(0);
		$cron->setSchedule('* * * * *');
		$cron->setTimeout(2);
		$cron->save();
	}
}

// Fonction exécutée automatiquement après la mise à jour du plugin
function speedtestByOokla_update()
{
	$cron = cron::byClassAndFunction('speedtestByOokla', 'update');
	if (!is_object($cron)) {
		$cron = new cron();
	}
	$cron->setClass('speedtestByOokla');
	$cron->setFunction('update');
	$cron->setEnable(1);
	$cron->setDeamon(0);
	$cron->setSchedule('* * * * *');
	$cron->setTimeout(2);
	$cron->save();

	foreach (eqLogic::byType('speedtestByOokla') as $eqLogic) {
		if ($eqLogic->getDisplay('widgetTmpl') == 1) {
			foreach (($eqLogic->getCmd('info')) as $cmd) {
				if ($cmd->getLogicalId() == 'download') {
					$cmd->setTemplate('dashboard', 'speedtestByOokla::download');
					$cmd->setTemplate('mobile', 'speedtestByOokla::download');
				} else if ($cmd->getLogicalId() == 'upload') {
					$cmd->setTemplate('dashboard', 'speedtestByOokla::upload');
					$cmd->setTemplate('mobile', 'speedtestByOokla::upload');
				} else if ($cmd->getLogicalId() == 'ping') {
					$cmd->setTemplate('dashboard', 'speedtestByOokla::ping');
					$cmd->setTemplate('mobile', 'speedtestByOokla::ping');
				}
				$cmd->save();
			}
		}
		$eqLogic->setDisplay('widgetTmpl', null);
		$eqLogic->setDisplay('advanceWidgetParametercolorWidgetNamedashboard-default', null);
		$eqLogic->setDisplay('advanceWidgetParametercolorWidgetNamemobile-default', null);
		$eqLogic->setDisplay('advanceWidgetParameterbgWidgetNamedashboard-default', null);
		$eqLogic->setDisplay('advanceWidgetParameterbgWidgetNamedashboard', null);
		$eqLogic->setDisplay('advanceWidgetParameterbgWidgetNamemobile-default', null);
		$eqLogic->setDisplay('advanceWidgetParameterbgWidgetNamemobile', null);
		$eqLogic->setDisplay('advanceWidgetParametercolorEqLogicdashboard-default', null);
		$eqLogic->setDisplay('advanceWidgetParametercolorEqLogicmobile-default', null);
		$eqLogic->setDisplay('advanceWidgetParameterbgEqLogicdashboard-default', null);
		$eqLogic->setDisplay('advanceWidgetParameterbgEqLogicdashboard', null);
		$eqLogic->setDisplay('advanceWidgetParameterbgEqLogicmobile-default', null);
		$eqLogic->setDisplay('advanceWidgetParameterbgEqLogicmobile', null);
		$eqLogic->setDisplay('advanceWidgetParametercmdNamedashboard-default', null);
		$eqLogic->setDisplay('advanceWidgetParametercmdNamemobile-default', null);
		$eqLogic->setDisplay('advanceWidgetParametertimeWidgetdashboard-default', null);
		$eqLogic->setDisplay('advanceWidgetParametertimeWidgetmobile-default', null);
		$eqLogic->save();
	}
}

// Fonction exécutée automatiquement après la suppression du plugin
function speedtestByOokla_remove()
{
	$cron = cron::byClassAndFunction('speedtestByOokla', 'update');
	if (is_object($cron)) {
		$cron->remove();
	}
}
