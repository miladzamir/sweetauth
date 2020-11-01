<?php
return [
    'registerMethod' => 'otp',
    'validate' => true ,
    'oneTimePassword' => [
        'phone_input' => 'phone',
        'phone_input_page_src' => 'test',
        'code_length' => 4,
        'sms_template' => 'verify',
        'sms_failed_message' => 'Text Messages Are Not Delivered. Try Again'
    ]
];
