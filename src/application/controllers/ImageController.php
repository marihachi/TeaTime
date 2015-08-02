<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImageController extends CI_Controller
{
	public function status($statusId)
	{
		echo "status: $statusId";
	}

	public function header($screenName)
	{
		echo "header: $screenName";
	}

	public function icon($screenName)
	{
		echo "icon: $screenName";
	}
}