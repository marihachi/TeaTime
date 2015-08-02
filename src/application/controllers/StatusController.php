<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatusController extends CI_Controller
{
	public function index($statusId)
	{
		echo "statusId: $statusId";
	}
}