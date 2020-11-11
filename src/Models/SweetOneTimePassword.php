<?php

namespace MiladZamir\SweetAuth\Models;

use Illuminate\Database\Eloquent\Model;

class SweetOneTimePassword extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['phone', 'token', 'is_verify', 'is_block',
        'request_times', 'last_send_status', 'step', 'last_step_complete_at', 'last_sms_send_at'];

    /**
     * @var string[]
     */
    protected $dates = ['last_send_at' , 'last_step_complete_at'];

    public function getLastSendAt()
    {
        return $this->last_send_at->timestamp;
    }

}
