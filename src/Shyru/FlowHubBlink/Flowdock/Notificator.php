<?php
/**
 * This file is part of FlowHubBlink.
 * Please check the file LICENSE.md for information about the license.
 *
 * @copyright Daniel Haas 2015
 * @author Daniel Haas <daniel@file-factory.de>
 */

namespace Shyru\FlowHubBlink\Flowdock;
use Httpful\Http;
use Httpful\Request;


/**
 * Counts the number of unread notifications of a user in Flowdock.
 * Unread notifications are unread messages in 1-on-1 chats and unread mentions in
 * all Flows the user has access to.
 *
 */
class Notificator
{
	private $flowDockAuthToken;
	function __construct($_flowDockAuthToken)
	{
		$this->flowDockAuthToken=$_flowDockAuthToken;

	}

	/**
	 * Counts the number of unread notifications.
	 * This makes to calls to the flowdock API:
	 * - One to fetch all subscribed flows and check the unread mentions
	 * - One to fetch all private chats and check the unread mentions
	 *
	 * @return int The number of unread notifications.
	 */
	function countUnreadNotifications()
	{
		$unreadCount=0;


		$flowdockApiUrl = "https://api.flowdock.com/";

		$template = Request::init()
			->method(Http::GET)        // Alternative to Request::post
			->authenticateWithBasic($this->flowDockAuthToken,"")
			->expectsJson();

		Request::ini($template);


		//first count unread mentions in all flows:

		$flowsResponse=Request::get($flowdockApiUrl."/flows")->send();
		$flows=$flowsResponse->body;

		foreach ($flows as $flow)
		{
			if (isset($flow->unread_mentions))
			{
				$unreadCount+=$flow->unread_mentions;
			}
		}

		//now check unread messages in all 1-on-1's:

		$privateChatsResponse = Request::get($flowdockApiUrl."/private")->send();
		$privateChats=$privateChatsResponse->body;

		foreach ($privateChats as $privateChat)
		{
			//echo "Info about private chat ".$privateChat->name.":\n";
			//var_dump($privateChat->activity);
			if (isset($privateChat->activity->mentions))
			{
				$unreadCount+=$privateChat->activity->mentions;
			}
		}

		//var_dump($privateChatsResponse);




		return $unreadCount;

	}
} 