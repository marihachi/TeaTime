<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function ApiParamValidate($data, $requireParams)
{
	foreach($requireParams as $requireParam)
	{
		if (!array_key_exists($requireParam, $data))
		{
			echo BuildErrorResponse(400, 101, 'Some required parameters.');
			return false;
		}
	}
	return true;
}