<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Account
    |--------------------------------------------------------------------------
    |
    | The account name expecte to be passed in the checkout request
    |
    */

    'account' => 'lorem',

    /*
    |--------------------------------------------------------------------------
    | Secret key
    |--------------------------------------------------------------------------
    |
    | Secret key used to sign requests
    |
    */
    'secret' => 'ipsum',

    /*
    |--------------------------------------------------------------------------
    | Webhooks
    |--------------------------------------------------------------------------
    |
    | Your webhooks URL, and the number of days the app must try resending
    | webhooks before giving up
    |
    */
    'webhooks_maximum' => [
    	'url' => 'http://example.com',
    	'maximum_resend_days' => 4,
    ],
];
