<?php

namespace App\Http\Middleware;

use Closure;

class CheckoutVariablesInSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(
            !(
            $request->has('account') &&
            $request->has('order') &&
            $request->has('narration') &&
            $request->has('amount') &&
            $request->has('redirectURL') &&
            $request->has('cancelURL') &&
            $request->has('signature')
            )

            && 

            !(
                $request->session()->has('account') &&
                $request->session()->has('order') &&
                $request->session()->has('narration') &&
                $request->session()->has('amount') &&
                $request->session()->has('redirectURL') &&
                $request->session()->has('cancelURL') &&
                $request->session()->has('signature')
            )


            ){
            abort(402, '402. Bad request');
        }

        if ( $request->session()->has('order') ) {

            $request->session()->keep(['account', 'order', 'narration', 'amount', 'redirectURL', 'cancelURL', 'signature']);            

        } else {

            $request->session()->flash('account', $request->input('account'));
            $request->session()->flash('order', $request->input('order'));
            $request->session()->flash('narration', $request->input('narration'));
            $request->session()->flash('amount', $request->input('amount'));
            $request->session()->flash('redirectURL', $request->input('redirectURL'));
            $request->session()->flash('cancelURL', $request->input('cancelURL'));
            $request->session()->flash('signature', $request->input('signature'));

        }

        return $next($request);
    }
}
