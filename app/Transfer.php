<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    //use SoftDeletes;

    /**
     * The fillable properties.
     *
     * @var string[]
     */
    protected $fillable = [
        'gateway',
        'phone_number',
        'transaction_code',
        'amount',
        'sender_name',
        'balance',
    ];

    /**
     * Overrides the models boot method.
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($transfer) {

            
            $gateway = Gateway::where('identification', $transfer->gateway)->firstOrFail();

            //Do a balance audit, @todo: fire event on fail
            if ($gateway->audit) {
                if ( (float)$transfer->balance !== $gateway->balance + $transfer->amount) {
                    return false;
                }
                //Update balance
                $gateway->balance = $transfer->balance;
                $gateway->save();
            }
            
            //Attach transfer to gateway
            $transfer->gateway()->associate($gateway);
            
            //check if a recent checkout matches me
            $checkout = Checkout::where('paid', false)
                            ->where('open', true)
                            ->where('phone_number', $transfer->phone_number)
                            ->where('amount', $transfer->amount)
                            ->orderBy('created_at', 'desc')
                            ->first();
                            //transaction_code for other gateways

            if ($checkout) {

                //mark it paid & close it
                $checkout->paid = true;
                $checkout->open = false;

                //transaction code
                $checkout->transaction_code = $transfer->transaction_code;

                //Save changes
                $checkout->save();

                //create a callback
                $checkout->callback()->create([]);

                //attach me to it
                $transfer->checkout()->associate($checkout);
            
            } else {

                //check for mismatches
                $checkout = Checkout::where('paid', false)
                            ->where('open', true)
                            ->where('phone_number', $transfer->phone_number)
                            ->orderBy('created_at', 'desc')
                            ->first();
                //todo: Mismatch event
            }
            
        });
    }

    /**
     * Transfer can belong to a Checkout.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checkout()
    {
        return $this->belongsTo('App\Checkout');
    }

    /**
     * Transfer can belong to a gateway.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gateway()
    {
        return $this->belongsTo('App\Gateway');
    }

    /*Mutator for date('Y-m-d H:i:s', $_POST['sent_timestamp'])*/
}
