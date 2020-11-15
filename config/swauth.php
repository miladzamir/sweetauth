<?php

return [
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
        'step2' => ['required', 'numeric'],
        'step3' => ['required', 'min:6', 'confirmed']
    ],
    'orange' => [
        'template' => 'verify'
    ],
    'mainConfig' => [
        'messages' => [
            'failedSendSms' => 'some message to return',
            'unBanAt' => 'you are baned, spam protection detected after :10: second',
            'nextRequestAt' => 'To many request send. Try Again :10: second',
            'outOfScope' => 'out of accept range retry',
            'invalidVerify' => 'the token is invalid!!!',
            'OutOfPasswordScope' => 'too late for send password retry!',
        ],
        'delayBetweenRequest' => 60,
        'delayAllowedRequest' => 10,
        'scopeRange' => 20,
        'passwordScopeRange' => 20,
        'codeLength' => 4,
        'redirectLocation' => 'home'
    ]

];
