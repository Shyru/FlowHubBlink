<?php
/**
 * This file is part of FlowHubBlink.
 * Please check the file LICENSE.md for information about the license.
 *
 * @copyright Daniel Haas 2015
 * @author Daniel Haas <daniel@file-factory.de>
 */

namespace Shyru\FlowHubBlink\GitHub;


/**
 * Counts the number of assigned GitHub pull-requests.
 */
class Counter
{
	private $username;
	private $password;

	/**
	 * Constructs a new Counter.
	 *
	 * @param string $_username The GitHub username
	 * @param string $_password The GitHub password
	 */
	function __construct($_username,$_password)
	{
		$this->username=$_username;
		$this->password=$_password;
	}

	/**
	 * Counts all assigned pull-requests and returns the number.
	 *
	 * @return int The number of assigned pull-requests.
	 */
	function countAssignedPullRequests()
	{
		$numPulls=0;
		$client=new \GitHubClient();
		$client->setCredentials($this->username,$this->password);


		$issuesApi=new Issues($client);
		$issues=$issuesApi->listAllIssues(); //This currently automatically returns all assigned issues
		//$issues=$client->issues->listIssues("CN-Consult","DiLoc");
		foreach ($issues as $issue)
		{ //since the api automatically only returns assigned issues this may not be necessary but better safe than sorry :-)
			if ($issue->getState()=="open" &&
				$issue->getAssignee() && $issue->getAssignee()->getLogin()==$this->username
				&& $issue->getPullRequest())
			{ //we found an issue that is open, is assigned to ourselves and is a pull-request, so increase the counter
				$numPulls++;
			}
		}
		//var_dump($issues);


		return $numPulls;

	}
} 