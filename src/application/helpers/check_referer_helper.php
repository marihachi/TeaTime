<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function CheckReferer($ua)
{
	if ($ua->is_referral() || $ua->referrer() === "")
	{
		echo BuildErrorResponse(403, 107, "Invalid referer.");
		return false;
	}
	return true;
}