<?php
//'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
return [
    'registerMethod' => 'otp',
    'validateRules' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'unique:users'],
    'validateRulesForget' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'exists:users,phone'],
    'tokenValidateRules' => ['required', 'numeric'],
    'completeRegisterRules' => ['required' ,'min:6' , 'confirmed'],
    'oneTimePassword' => [
        'phone_input' => 'phone',
        'token_input' => 'token',
        'password_input' => 'password',
        'phone_input_page_src' => 'register',
        'register_route_name' => 'auth',
        'verify_route_name' => 'verify',
        'complete_register_route_name' => 'register',
        'code_length' => 4,
        'sms_template' => 'verify',
        'sms_failed_message' => 'Text Messages Are Not Delivered. Try Again',
        'block_user_message' => 'Spam protection detected!!!! after :10: second',
        'delay_between_request' => 60,
        'delay_count' => 60,
        'delay_unblock' => 10,
        'delay_allowed' => 5,
        'delay_allowed_message' => 'wait :5: second to next request',
        'accept_token_scope' => 20,
        'accept_token_scope_message' => 'زمان مجاز وارد کردن کد به پایان رسید دوباره !',
        'wrong_token_message' => 'code is wrong try a again!'
    ]
];
