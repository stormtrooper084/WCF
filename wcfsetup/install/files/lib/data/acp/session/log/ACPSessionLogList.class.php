<?php
namespace wcf\data\acp\session\log;
use wcf\data\DatabaseObjectList;

/**
 * Represents a list of session log entries.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2015 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	data.acp.session.log
 * @category	Community Framework
 */
class ACPSessionLogList extends DatabaseObjectList {
	/**
	 * @see	\wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'wcf\data\acp\session\log\ACPSessionLog';
	
	/**
	 * @see	\wcf\data\DatabaseObjectList::readObjects()
	 */
	public function readObjects() {
		if (!empty($this->sqlSelects)) $this->sqlSelects .= ',';
		$this->sqlSelects .= "	user_table.username, acp_session.sessionID AS active,
					(SELECT COUNT(*) FROM wcf".WCF_N."_acp_session_access_log WHERE sessionLogID = ".$this->getDatabaseTableAlias().".sessionLogID) AS accesses";
		
		$this->sqlJoins .= "	LEFT JOIN wcf".WCF_N."_user user_table ON (user_table.userID = ".$this->getDatabaseTableAlias().".userID)
					LEFT JOIN wcf".WCF_N."_acp_session acp_session ON (acp_session.sessionID = ".$this->getDatabaseTableAlias().".sessionID)";
		
		parent::readObjects();
	}
}
