<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkout extends Model
{
    //use SoftDeletes;

    /**
     * The fillable properties.
     *
     * @var string[]
     */
    protected $fillable = [
        'paid',
        'status',
        'order',
        'amount',
        'gateway',
        'phone_number',
        'transaction_code',
        'redirect_url',
        'cancel_url',
        'narration',
    ];

    /**
     * Overrides the models boot method.
     */
    public static function boot()
    {
        parent::boot();

        self::created(function ($checkout) {
            /*
            check if a transfer matches
            if so attach it to me
            create a callback
            */
            $transfer = Transfer::where('phone_number', $checkout->phone_number)
                ->where('gateway', $checkout->gateway)
                ->where('amount', $checkout->amount)
                ->whereNull('checkout_id')->first();
            
            if ($transfer) {

                $checkout->paid = true;
                $checkout->open = false;
                $checkout->transaction_code = $transfer->transaction_code;
                $checkout->transfers()->save($transfer);
                $checkout->callback()->create([]);
                $checkout->save();
            
            } else {

                //Maybe customer transferred already, but a wrong amount
                $existingUnclaimedTransfer = Transfer::where('phone_number', $checkout->phone_number)
                                                ->where('gateway', $checkout->gateway)
                                                ->whereNull('checkout_id')->first();
                if ($existingUnclaimedTransfer) {
                    //todo: Fire Mismatch event
                }

            }
        });
    }

    /**
     * Checkout has a callback.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function callback()
    {
        return $this->hasOne('App\Callback');
    }

    /**
     * Checkout can have more than one transfers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transfers()
    {
        return $this->hasMany('App\Transfer');
    }
}
