<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Factory as ValidationFactory;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class CheckoutAuthenticator
{
    protected $config;
    protected $validationFactory;

    /**
     * @param Illuminate\Support\Facades\Config $config
     * @param \Illuminate\Validation\Factory $validationFactory
     */
    public function __construct(Config $config, ValidationFactory $validationFactory)
    {
        $this->config = app('config');//@todo
        //@todo Move this to app bootstrap
        $validationFactory->extend('checkout_account', function ($attribute, $value, $parameters) {
            return ($value === $this->config->get('checkouts.account'));
        });
    }

    private function validationRules()
    {
        return [
            'account' => 'required|checkout_account',
            'order' => 'required',
            'amount' => 'required|numeric|between:0.01,10000',
            'redirectURL' => 'required|url',
            'cancelURL' => 'required|url',
            'signature' => 'required'
        ];
    }

    private function validationMessages()
    {
        return [
            //@todo: Fill these in
        ];
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $account = $request->session()->get('account');
        $order = $request->session()->get('order');
        $narration = $request->session()->get('narration');
        $amount = $request->session()->get('amount');
        $redirectURL = $request->session()->get('redirectURL');
        $cancelURL = $request->session()->get('cancelURL');
        $signature = $request->session()->get('signature');

        $validator = app('validator')->make([
                'account' => $account,
                'order' => $order,
                'amount' => $amount,
                'redirectURL' => $redirectURL,
                'cancelURL' => $cancelURL,
                'signature' => $signature,
            ],
            $this->validationRules() ); //, $this->validationMessages());
        
        if ($validator->fails()) {
            throw new NotAcceptableHttpException();
        }

        $hashString = $account.$order.$narration.$amount.$redirectURL.$cancelURL.$this->config->get('checkouts.secret');
        $hash = strtoupper(hash('sha512', $hashString));

        if ($signature !== $hash) {
            throw new NotAcceptableHttpException();
        }

        //Validate data types & signature
        return $next($request);
    }
}
