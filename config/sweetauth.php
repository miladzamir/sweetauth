<?php
return [
    'registerMethod' => 'otp',
    'validate' => true ,
    'oneTimePassword' => [
        'phone_input' => 'phone',
        'phone_input_page_src' => 'test',
        'code_length' => 4,
        'sms_template' => 'verify',
        'sms_failed_message' => 'Text Messages Are Not Delivered. Try Again',
        'block_user_message' => 'Now Unavailable 4 you. Try Again!',
        'delay_between_request' => 60,
        'delay_count' => 1,
        'delay_unblock' => 60
    ]
];
