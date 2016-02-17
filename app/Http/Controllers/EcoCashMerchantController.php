<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\EcoCashNumberFormRequest;
use App\Http\Requests\EcoCashMerchantSMSSyncFormRequest;

use App\Checkout;
use App\Transfer;

class EcoCashMerchantController extends Controller
{

    private $gateway = 'ecocashmerchant';

    public function index() {
    	return view('details');
    }

    public function collect(EcoCashNumberFormRequest $request) {
    	return redirect('ecocash/confirm')
    		->with('phone_number', $request->input('phone_number'));
    }

    public function confirm(Request $request) {
    	return view('confirm');
    }

    public function submit(EcoCashNumberFormRequest $request) {
    	//This one creates entries in checkouts table only
    	//Check if transfer arrived
    	$checkout = Checkout::create([
    		'order' => $request->input('order'),
	        'amount' => $request->input('amount'),
	        'gateway' => $this->gateway,
	        'phone_number' => $request->input('phone_number'),
	        'redirect_url' => $request->input('redirectURL'),
	        'cancel_url' => $request->input('cancelURL'),
    	]);
    	return view('done', ['redirect' => $checkout->cancel_url]);
    }

    public function inbox(EcoCashMerchantSMSSyncFormRequest $request)
    {
		if (!$details = $this->isEcoCashMerchantMessage($request->input('message'))) {
            return $this->smsSyncResponse(true);
        }

        if (!Transfer::create([
            'gateway' => $this->gateway,
            'phone_number' => $details->phone_number,
            'transaction_code' => $details->transaction_code,
            'amount' => $details->amount,
            'sender_name' => $details->sender_name,
            'balance' => $details->balance,
            ])) {

            return $this->smsSyncResponse(false);
        }

        return $this->smsSyncResponse(true);
    }

    private function isEcoCashMerchantMessage($msg)
	{
		$pattern = "/You have received [^0-9 ]?([0-9]{1,3}\.[0-9]{2}) from ([0-9]+) -(.+)\. Approval Code: (.+).".
					" New wallet balance: [^0-9 ]?([0-9]{1,3}\.[0-9]{2})/";
		if (!preg_match($pattern, $msg, $output_array)) return false;
		$details = new \StdClass();
		$details->amount = $output_array[1];
		$details->phone_number = $output_array[2];
		$details->sender_name = $output_array[3];
		$details->transaction_code = $output_array[4];
		$details->balance = $output_array[5];
		return $details;
	}

    private function smsSyncResponse($success = true, $message = null)
	{		
		return response()
            ->json([
                    'payload' => [
                        'success' => $success,
                        'error' => $message,
                    ]
                ])
            ->header('Cache-Control', 'no-cache, must-revalidate') // HTTP/1.1
            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
	}
}
