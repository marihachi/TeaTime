<?php
function CheckReferer($ua)
{
	if ($ua->is_referral() || $ua->referrer() === "")
	{
		http_response_code(403);
		$info['error']['code'] = 107;
		$info['error']['message'] = "Invalid referer.";
		echo json_encode($info);
		return false;
	}
	return true;
}