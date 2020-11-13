<?php

return [
    'registerMethod' => 'otp',
    'validateRules' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'unique:users'],
    'validateRulesForget' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'exists:users,phone'],
    'tokenValidateRules' => ['required', 'numeric'],
    'completeRegisterRules' => ['required', 'min:6', 'confirmed'],
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
    ],

    'viewRouteNames' => [
        'step1' => ['0' => 'register', '1' => 'forget'],
        'step2' => ['0' => 'verify', '1' => 'verify-forget'],
        'step3' => ['0' => 'complete-register', '1' => 'restore-password'],
        'step4' => ['0' => 'login'],
    ],
    'postRouteNames' => [
        'step1' => ['0' => 'stepYek'],
        'step2' => ['0' => 'stepDo'],
        'step3' => ['0' => 'stepSee'],
        'step4' => ['0' => 'logChar'],
        'step5' => ['0' => 'logout']
    ],
    'inputs' => [
        'step1' => 'phone',
        'step2' => 'token',
        'step3' => ['password', 'password_confirmation'],
        'step4' => ['phone', 'password'],
    ],
    'validations' => [
        'step1' => [
            '0' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'unique:users'],
            '1' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'exists:users,phone']
        ],
        'step2' => ['required', 'numeric']
    ],
    'orange' => [
        'template' => 'verify'
    ],
    'mainConfig' => [
        'messages' => [
            'failedSendSms' => 'some message to return',
            'unBanAt' => 'Spam protection detected after :10: second',
            'nextRequestAt' => 'To many request send. Try Again :10: second',
            'outOfScope' => 'out of accept range retry',
            'invalidVerify' => 'the token is invalid!!!',
        ],
        'delayBetweenRequest' => 60,
        'delayAllowedRequest' => 60,
        'scopeRange' => 60,
        'codeLength' => 4,
    ]

];
