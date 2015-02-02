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
 * Small helper class that extends \GitHubIssues to provide a listAllIssues()-method.
 *
 */
class Issues extends \GitHubIssues
{
	/**
	 * List all issues that are assigned to the authenticated user.
	 * (/issues-url)
	 *
	 * @return \GitHubIssue[]
	 */
	public function listAllIssues()
	{
		$data = array();

		return $this->client->request("/issues", 'GET', $data, 200, 'GitHubIssue', true);
	}
} 