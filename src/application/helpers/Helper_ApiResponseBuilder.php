<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function BuildErrorResponse($httpCode, $errorCode, $message)
{
	http_response_code($httpCode);
	$info['error']['code'] = $errorCode;
	$info['error']['message'] = $message;
	return json_encode($info);
}

function BuildSuccessResponse($message)
{
	http_response_code(200);
	$info['message'] = $message;
	return json_encode($info);
}