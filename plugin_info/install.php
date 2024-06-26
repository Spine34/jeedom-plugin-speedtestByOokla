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
		if (version_compare(jeedom::version(), '4.4', '>=')) {
			if ($eqLogic->getConfiguration('template') == 'coreWidget') {
				$eqLogic->setDisplay('widgetTmpl', 0);
				$eqLogic->setConfiguration('template', 'speedtestByOoklaLight');
			} else if ($eqLogic->getConfiguration('template') == 'templateWithoutGauges') {
				$eqLogic->setDisplay('widgetTmpl', 1);
				$eqLogic->setConfiguration('template', 'speedtestByOoklaLight');
			}
		} else {
			if ($eqLogic->getConfiguration('template') == 'templateWithoutGauges') {
				$eqLogic->setConfiguration('template', 'speedtestByOoklaWithoutGauges4.3');
			}
		}
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
