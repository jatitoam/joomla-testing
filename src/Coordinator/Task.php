<?php
/**
 * @package     Joomla\Testing
 * @subpackage  Coordinator
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Coordinator;

use Symfony\Component\Process\Process;

/**
 * Class Task
 * @package Joomla\Testing\Coordinator
 */
class Task
{
	private $codeceptionTask;
	private $server;
	private $client;

	/**
	 * names of the methods from the Selection List which change the task flag
	 */
	const EXECUTE = "execute";
	const ASSIGN = "assign";
	const FAIL   = "fail";

	/**
	 * Task constructor.
	 * @param $codeceptionTask
	 * @param $server
	 * @param $client
	 */
	public function __construct($codeceptionTask, $server)
	{
		$this->codeceptionTask = $codeceptionTask;
		$this->server = $server;
	}

	/**
	 * runs the Task
	 * redirects the stdout and stderror to the log in order to make it async
	 * @param $client
	 */
	public function run($client)
	{
//		echo "Inside Task -> run: Task is run - $this->codeceptionTask, on client $client\n";
		$command = JPATH_BASE . "/vendor/bin/robo run:client-task $this->codeceptionTask $this->server $client >>" .JPATH_BASE. "/coordinator.log 2>&1 &";
		$process = new Process($command);
		$process->setTimeout(3600);
		$process->run();
//		echo "Inside Task -> run: after process start\n";
	}

	/**
	 * @return mixed
	 */
	public function getTask()
	{
		return $this->codeceptionTask;
	}

}