<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Webhooks;

class Callback extends Model
{
    //use SoftDeletes;

    /**
     * Overrides the models boot method.
     */
    public static function boot()
    {
        parent::boot();

        self::created(function ($callback) {
            Webhooks::sendCallback($callback);
        });
    }

    /**
     * Callbacks belong to a Checkout.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checkout()
    {
        return $this->belongsTo('App\Checkout');
    }
}
