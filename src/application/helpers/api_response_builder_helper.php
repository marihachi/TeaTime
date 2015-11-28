<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function BuildErrorResponse($httpCode, $errorCode, $data)
{
	http_response_code($httpCode);

	$res['error']['code'] = $errorCode;
	
	if (is_array($data))
		$res['error'][] = $data;
	else
		$res['error']['message'] = $data;
		
	return json_encode($res);
}

function BuildSuccessResponse($data)
{
	http_response_code(200);

	if (is_array($data))
		$res = $data;
	else
		$res["message"] = $data;

	return json_encode($res);
}

function IsSuccessResponse($json)
{
	$res = json_decode($json, true);
	return !array_key_exists("error", $res);
}