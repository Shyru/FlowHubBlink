<?php
/**
 * This file is part of FlowHubBlink.
 * Please check the file LICENSE.md for information about the license.
 *
 * @copyright Daniel Haas 2015
 * @author Daniel Haas <daniel@file-factory.de>
 */

namespace Shyru\FlowHubBlink\Blink;
use Httpful\Request;


/**
 * Please add documentation for Controller!
 */
class Controller
{
	private $baseUrl;
	private $blinkId;

	const LED_A=1;
	const LED_B=2;


	function __construct($_blinkId)
	{
		$this->baseUrl="http://localhost:8934/blink1/";
		$this->blinkId=$_blinkId;

	}

	function setColor($_led,$_color,$_time=0.8)
	{
		$url=$this->baseUrl."fadeToRGB?id=$this->blinkId&ledn=$_led&rgb=".urlencode($_color)."&time=$_time";
		$response=Request::get($url)->send();
		//var_dump($response);
	}
} 