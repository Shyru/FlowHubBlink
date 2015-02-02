<?php
/**
 * This file is part of FlowHubBlink.
 * Please check the file LICENSE.md for information about the license.
 *
 * @copyright Daniel Haas 2015
 * @author Daniel Haas <daniel@file-factory.de>
 */

use Shyru\FlowHubBlink\Blink\Controller;

require_once("autoload.php");


$config=parse_ini_file("flowhubblink.conf",true);
if (isset($config["flowdock"]["led"]))
{
	if (strtoupper($config["flowdock"]["led"])=="A") $config["flowdock"]["led"]=Controller::LED_A;
	else $config["flowdock"]["led"]=Controller::LED_B;
}
else $config["flowdock"]["led"]=Controller::LED_A;


if (isset($config["github"]["led"]))
{
	if (strtoupper($config["github"]["led"])=="A") $config["github"]["led"]=Controller::LED_A;
	else $config["github"]["led"]=Controller::LED_B;
}
else $config["github"]["led"]=Controller::LED_A;

$fdNotificator=new \Shyru\FlowHubBlink\Flowdock\Notificator($config["flowdock"]["auth_token"]);
echo "Counting Flowdock unread...";
$unreadNotifications=$fdNotificator->countUnreadNotifications();
echo " Result: $unreadNotifications ";

$blink=new Controller($config["blink"]["id"]);
if ($unreadNotifications>0)
{
	echo "(Setting color to orange)\n";
	$blink->setColor($config["flowdock"]["led"],"#FF8418");
}
else
{
	echo "(Switching off)\n";
	$blink->setColor($config["flowdock"]["led"],"#000000");
}

echo "Counting Assigned GitHub PullRequests...";
$gitHubCounter=new \Shyru\FlowHubBlink\GitHub\Counter($config["github"]["username"],$config["github"]["password"]);
$numPulls=$gitHubCounter->countAssignedPullRequests();
echo " Result: $numPulls ";
if ($numPulls==0)
{
	echo "(Setting color to green)\n";
	$blink->setColor($config["github"]["led"],"#00FF00");
}
else if ($numPulls>6)
{
	echo "(Setting color to red)\n";
	$blink->setColor($config["github"]["led"],"#FF0000");

}
else if ($numPulls>3)
{
	echo "(Setting color to orange)\n";
	$blink->setColor($config["github"]["led"],"#FF8418");
}
else if ($numPulls>0)
{
	echo "(Setting color to blue)\n";
	$blink->setColor($config["github"]["led"],"#0000FF");

}
else
{
	echo "(Switching off)\n";
	$blink->setColor($config["github"]["led"],"#000000");
}


