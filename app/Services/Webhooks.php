<?php

namespace App\Services;

use App\Callback;
use GuzzleHttp\Client;
use \Carbon\Carbon;

class Webhooks {

	public static function sendCallback($callback)
	{
		$client = new Client(['http_errors' => false]);

		try {

			$r = $client->request('POST', 'http://www.topnews.co.zw', [
			    'json' => (object)[
			    	'id' => $callback->id,
			    	'type' => 'payment.success',
			    	'checkout' => $callback->checkout,
			    ]
			]);

			if ($r->getStatusCode() == 200) {
				$callback->sent = true;
				$callback->save();
			}

		} catch (\Exception $e) {
			
		}
		
		//Quit resending after 4 days		
		if ($callback->created_at->diff(Carbon::now())->days > 4 ) {
			$callback->retry = false;
		}

		$callback->increment('tries');
		$callback->save();
	}

	public static function scheduleHandler()
	{
		$callbacks = Callback::where('sent', false)
						->where('retry', true)
						->orderBy('tries', 'asc')
						->take(5);
		foreach ($callbacks as $callback) {
			self::sendCallback($callback);
		}
	}

}
