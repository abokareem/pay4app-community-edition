<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

class EcoCashMerchantSMSSyncFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * ProfileFormRequest constructor.
     * @param \Illuminate\Validation\Factory $validationFactory
     */
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend('smssyncpassword', function ($attribute, $value, $parameters) {
            return $this->checkSMSSyncPassword();
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device_id' => 'required',
            'from' => 'required',
            'message' => 'required',
            'message_id' => 'required',
            'sent_timestamp' => 'required|date',
            'secret' => 'required|smssyncpassword'
        ];
    }

    public function checkSMSSyncPassword(){
        if ( $this->request->get('secret') === config('ecocashmerchant.smssync_password') ) {
            return true;
        } else {
            return false;
        }
    }
}
