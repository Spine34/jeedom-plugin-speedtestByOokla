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

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class speedtestByOokla extends eqLogic
{
	/*     * *************************Attributs****************************** */

	// Permet de définir les possibilités de personnalisation du widget (en cas d'utilisation de la fonction 'toHtml' par exemple)
	// Tableau multidimensionnel - exemple: array('custom' => true, 'custom::layout' => false)
	public static $_widgetPossibility = array('custom' => true);

	/*
	* Permet de crypter/décrypter automatiquement des champs de configuration du plugin
	* Exemple : "param1" & "param2" seront cryptés mais pas "param3"
	public static $_encryptConfigKey = array('param1', 'param2');
	*/

	/*     * ***********************Methode static*************************** */

	/*
	* Fonction exécutée automatiquement toutes les minutes par Jeedom
	public static function cron() {}
	*/

	/*
	* Fonction exécutée automatiquement toutes les 5 minutes par Jeedom
	public static function cron5() {}
	*/

	/*
	* Fonction exécutée automatiquement toutes les 10 minutes par Jeedom
	public static function cron10() {}
	*/

	/*
	* Fonction exécutée automatiquement toutes les 15 minutes par Jeedom
	public static function cron15() {}
	*/

	/*
	* Fonction exécutée automatiquement toutes les 30 minutes par Jeedom
	public static function cron30() {}
	*/

	/*
	* Fonction exécutée automatiquement toutes les heures par Jeedom
	public static function cronHourly() {}
	*/

	/*
	* Fonction exécutée automatiquement tous les jours par Jeedom
	public static function cronDaily() {}
	*/

	/*
	* Permet de déclencher une action avant modification d'une variable de configuration du plugin
	* Exemple avec la variable "param3"
	public static function preConfig_param3( $value ) {
		// do some checks or modify on $value
		return $value;
	}
	*/

	/*
	* Permet de déclencher une action après modification d'une variable de configuration du plugin
	* Exemple avec la variable "param3"
	public static function postConfig_param3($value) {
		// no return value
	}
	*/

	/*
	* Permet d'indiquer des éléments supplémentaires à remonter dans les informations de configuration
	* lors de la création semi-automatique d'un post sur le forum community
	public static function getConfigForCommunity() {
		// Cette function doit retourner des infos complémentataires sous la forme d'un
		// string contenant les infos formatées en HTML.
		return "les infos essentiel de mon plugin";
	}
	*/

	public static function dependancy_install()
	{
		log::remove(__CLASS__ . '_update');
		return array('script' => dirname(__FILE__) . '/../../resources/install_#stype#.sh ' . jeedom::getTmpFolder(__CLASS__) . '/dependency', 'log' => log::getPathToLog(__CLASS__ . '_update'));
	}

	public static function dependancy_info()
	{
		$return = array();
		$return['log'] = log::getPathToLog(__CLASS__ . '_update');
		$return['progress_file'] = jeedom::getTmpFolder(__CLASS__) . '/dependency';
		if (file_exists(jeedom::getTmpFolder(__CLASS__) . '/dependency')) {
			$return['state'] = 'in_progress';
		} else {
			if (exec(system::getCmdSudo() . system::get('cmd_check') . '-Ec "speedtest"') < 1) {
				$return['state'] = 'nok';
			} else {
				$return['state'] = 'ok';
			}
		}
		return $return;
	}

	public static function update()
	{
		foreach (eqLogic::byType(__CLASS__, true) as $eqLogic) {
			$autorefresh = $eqLogic->getConfiguration('autorefresh');
			if ($autorefresh != '') {
				try {
					$c = new Cron\CronExpression(checkAndFixCron($autorefresh), new Cron\FieldFactory);
					if ($c->isDue()) {
						try {
							$eqLogic->refreshData();
						} catch (Exception $exc) {
							log::add(__CLASS__, 'error', $eqLogic->getHumanName() . ' : Erreur : ' . $exc->getMessage());
						}
					}
				} catch (Exception $exc) {
					log::add(__CLASS__, 'error', $eqLogic->getHumanName() . ' : Expression cron non valide : ' . $autorefresh);
				}
			}
		}
	}

	/*     * *********************Méthodes d'instance************************* */

	// Fonction exécutée automatiquement avant la création de l'équipement
	public function preInsert()
	{
		$this->setIsVisible(1);
		$this->setIsEnable(1);
	}

	// Fonction exécutée automatiquement après la création de l'équipement
	public function postInsert() {}

	// Fonction exécutée automatiquement avant la mise à jour de l'équipement
	public function preUpdate() {}

	// Fonction exécutée automatiquement après la mise à jour de l'équipement
	public function postUpdate() {}

	// Fonction exécutée automatiquement avant la sauvegarde (création ou mise à jour) de l'équipement
	public function preSave() {}

	// Fonction exécutée automatiquement après la sauvegarde (création ou mise à jour) de l'équipement
	public function postSave()
	{
		if (!is_file(dirname(__FILE__) . '/../config/cmd.json')) {
			throw new Exception(__('Fichier cmd.json non trouvé', __FILE__));
		}
		$cmdsArray = json_decode(file_get_contents(dirname(__FILE__) . '/../config/cmd.json'), true);
		$order = 0;
		log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $cmdsArray : ' . json_encode($cmdsArray));
		foreach ($cmdsArray as $cmdArray) {
			log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $cmdArray : ' . json_encode($cmdArray));
			$cmd = $this->getCmd(null, $cmdArray['logicalId']);
			if (!is_object($cmd)) {
				log::add(__CLASS__, 'info', $this->getHumanName() . ' : Commande [' . $cmdArray['name'] . '] créée');
				$cmd = (new speedtestByOoklaCmd);
				if (isset($cmdArray['logicalId'])) {
					$cmd->setLogicalId($cmdArray['logicalId']);
				}
				if (isset($cmdArray['generic_type'])) {
					$cmd->setGeneric_type($cmdArray['generic_type']);
				}
				if (isset($cmdArray['name'])) {
					$cmd->setName($cmdArray['name']);
				}
				$cmd->setOrder($order++);
				if (isset($cmdArray['type'])) {
					$cmd->setType($cmdArray['type']);
				}
				if (isset($cmdArray['subType'])) {
					$cmd->setSubType($cmdArray['subType']);
				}
				$cmd->setEqLogic_id($this->getId());
				if (isset($cmdArray['isHistorized'])) {
					$cmd->setIsHistorized($cmdArray['isHistorized']);
				}
				if (isset($cmdArray['unite'])) {
					$cmd->setUnite($cmdArray['unite']);
				}
				if (isset($cmdArray['configuration'])) {
					foreach ($cmdArray['configuration'] as $key => $value) {
						$cmd->setConfiguration($key, $value);
					}
				}
				if (isset($cmdArray['template'])) {
					foreach ($cmdArray['template'] as $key => $value) {
						$cmd->setTemplate($key, $value);
					}
				}
				if (isset($cmdArray['display'])) {
					foreach ($cmdArray['display'] as $key => $value) {
						$cmd->setDisplay($key, $value);
					}
				}
				if (isset($cmdArray['value'])) {
					$cmd->setValue($this->getCmd(null, $cmdArray['value'])->getId());
				}
				if (isset($cmdArray['isVisible'])) {
					$cmd->setIsVisible($cmdArray['isVisible']);
				}
				$cmd->save();
			}
		}
	}

	// Fonction exécutée automatiquement avant la suppression de l'équipement
	public function preRemove() {}

	// Fonction exécutée automatiquement après la suppression de l'équipement
	public function postRemove() {}

	/*
	* Permet de crypter/décrypter automatiquement des champs de configuration des équipements
	* Exemple avec le champ "Mot de passe" (password)
	public function decrypt() {
		$this->setConfiguration('password', utils::decrypt($this->getConfiguration('password')));
	}
	public function encrypt() {
		$this->setConfiguration('password', utils::encrypt($this->getConfiguration('password')));
	}
	*/

	/*
	* Permet de modifier l'affichage du widget (également utilisable par les commandes)
	public function toHtml($_version = 'dashboard') {}
	*/

	public function refreshData()
	{
		if ($this->getIsEnable() == 1) {
			if ($this->getConfiguration('serverId') == '') {
				$cmd = 'sudo /usr/bin/speedtest --accept-license --accept-gdpr --format=json';
			} else {
				$cmd = 'sudo /usr/bin/speedtest --accept-license --accept-gdpr --format=json --server-id=' . $this->getConfiguration('serverId');
			}
			log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $cmd : ' . $cmd);
			$speedtest = shell_exec($cmd);
			if ($speedtest == false || $speedtest == null) {
				$speedtest = shell_exec($cmd . ' 2>&1');
				// log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $speedtest : ' . $speedtest);
				$speedtests = explode("\n", trim($speedtest));
				// log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $speedtests : ' . json_encode($speedtests));
				foreach ($speedtests as $speedtest) {
					if ($this->getConfiguration('disableError') != 1) {
						log::add(__CLASS__, 'error', $this->getHumanName() . ' : Error shell_exec() : ' . $speedtest);
					} else {
						log::add(__CLASS__, 'warning', $this->getHumanName() . ' : Error shell_exec() : ' . $speedtest);
					}
				}
			} else {
				// log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $speedtest : ' . $speedtest);
				$speedtest = json_decode($speedtest, true);
				$speedtestLog = $speedtest;
				if ($speedtestLog['interface']['internalIp'] != $speedtestLog['interface']['externalIp']) {
					$speedtestLog['interface']['externalIp'] = 'IPv4';
				} else {
					$speedtestLog['interface']['internalIp'] = 'IPv6';
					$speedtestLog['interface']['externalIp'] = 'IPv6';
				}
				log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $speedtest : ' . json_encode($speedtestLog));
				$this->checkAndUpdateCmd('download', $speedtest['download']['bandwidth']);
				$this->checkAndUpdateCmd('upload', $speedtest['upload']['bandwidth']);
				$this->checkAndUpdateCmd('ping', $speedtest['ping']['latency']);
				$this->checkAndUpdateCmd('isp', $speedtest['isp']);
				$this->checkAndUpdateCmd('internalIp', $speedtest['interface']['internalIp']);
				$this->checkAndUpdateCmd('externalIp', $speedtest['interface']['externalIp']);
				$this->checkAndUpdateCmd('server', $speedtest['server']['name'] . ' - ' . $speedtest['server']['location'] . ' (id: ' . $speedtest['server']['id'] . ')');
				$this->checkAndUpdateCmd('timestamp', date('Y-m-d H:i:s', strtotime($speedtest['timestamp'])));
				log::add(__CLASS__, 'info', $this->getHumanName() . ' : Updated commands');
				$serverList = shell_exec('sudo /usr/bin/speedtest --servers');
				// log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $serverList : ' . $serverList);
				$serverList = str_replace('Closest servers:' . "\n" . "\n", '', $serverList);
				$serverLists = explode("\n", trim($serverList));
				// log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $serverLists : ' . json_encode($serverLists));
				foreach ($serverLists as $server) {
					log::add(__CLASS__, 'debug', $this->getHumanName() . ' : $server : ' . $server);
				}
				$this->setConfiguration('serverList', $serverList);
				$this->save();
			}
		}
	}

	/*     * **********************Getteur Setteur*************************** */
}

class speedtestByOoklaCmd extends cmd
{
	/*     * *************************Attributs****************************** */

	/*
	public static $_widgetPossibility = array();
	*/

	/*     * ***********************Methode static*************************** */


	/*     * *********************Methode d'instance************************* */

	/*
	* Permet d'empêcher la suppression des commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
	public function dontRemoveCmd() {
		return true;
	}
	*/

	// Exécution d'une commande
	public function execute($_options = array())
	{
		if ($this->getLogicalId() == 'refresh') {
			$this->getEqLogic()->refreshData();
		}
	}

	/*     * **********************Getteur Setteur*************************** */
}
