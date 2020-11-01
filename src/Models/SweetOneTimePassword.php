<?php

namespace MiladZamir\SweetAuth\Models;

use Illuminate\Database\Eloquent\Model;

class SweetOneTimePassword extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['phone', 'token', 'is_verify', 'is_block', 'request_times', 'last_send_status', 'last_send_at'];

    /**
     * @var string[]
     */
    protected $dates = ['last_send_at'];
}
