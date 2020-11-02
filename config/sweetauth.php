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
        'block_user_message' => 'Spam protection detected!!!! after :10: second',
        'delay_between_request' => 60,
        'delay_count' => 3,
        'delay_unblock' => 10,
        'delay_allowed' => 1,
        'delay_allowed_message' => 'wait :1: second to next request'
    ]
];
