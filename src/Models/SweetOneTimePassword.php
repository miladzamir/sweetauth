<?php

namespace MiladZamir\SweetAuth\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SweetOneTimePassword extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['username', 'token', 'is_verify', 'is_block',
        'request_times', 'last_send_status', 'last_step_complete_at', 'last_sms_send_at'];

    /**
     * @var string[]
     */
    protected $dates = ['last_sms_send_at' , 'last_step_complete_at'];

    public function lastSmsSendAt()
    {
        return $this->last_sms_send_at->timestamp;
    }
    public function lasStepCompleteAt()
    {
        return $this->last_step_complete_at->timestamp;
    }

}
