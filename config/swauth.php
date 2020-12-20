<?php

return [
    'table' => [
        'users' => [
            'table' => 'users',
            'username' => 'phone',
            'viewRouteNames' => [
                'client.register' => [
                    'validations' => [
                        'required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'unique:users'
                    ],
                    'session' => 'st1',
                    'nextRoute' => 'client.verify'
                ],
                'client.verify' => [
                    'validations' => [
                        'required', 'required', 'numeric'
                    ],
                    'session' => ['old' =>'st1','new' =>'st2'],
                    'prevRoute' => 'client.register',
                    'nextRoute' => 'client.completeRegister'
                ],
                'client.completeRegister' => [
                    'validations' => [
                        ['required', 'min:6', 'confirmed'],
                        ['required']
                    ],
                    'session' => ['old' =>'st2','new' =>'st2'],
                    'prevRoute' => 'client.register'
                ],

                'client.forget' =>[
                    'validations' => [
                        'required', 'required', 'numeric'
                    ],
                    'session' => 'st11',
                    'nextRoute' => 'client.verifyForget'
                ],
                'client.verifyForget'=> [
                    'validations' => [
                        'required', 'required', 'numeric'
                    ],
                    'session' => ['old' =>'st11','new' =>'st22'],
                    'prevRoute' => 'client.forget',
                    'nextRoute' => 'client.restorePassword'
                ],
                'client.restorePassword' => [
                    'validations' => [
                        'required', 'min:6', 'confirmed'
                    ],
                    'session' => ['old' =>'st22','new' =>'st33'],
                    'prevRoute' => 'client.forget'
                ],
            ],
            'inputs' => [
                'step1' => 'phone',
                'step2' => 'token',
                'step3' => ['password', 'name']
            ],
            'guard' => 'web',
            'redirectLocation' => 'home'
        ],
        'consultants' => [
            'table' => 'consultants',
            'username' => 'phone',
            'viewRouteNames' => [
                'consultant.register' => [
                    'validations' => [
                        'required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'numeric', 'unique:users'
                    ],
                    'session' => 'st1',
                    'nextRoute' => 'consultant.verify'
                ],
                'consultant.verify' => [
                    'validations' => [
                        'required', 'required', 'numeric'
                    ],
                    'session' => ['old' =>'st1','new' =>'st2'],
                    'prevRoute' => 'consultant.register',
                    'nextRoute' => 'consultant.completeRegister'
                ],
                'consultant.completeRegister' => [
                    'validations' => [
                        ['required', 'min:6', 'confirmed'],
                        ['required']
                    ],
                    'session' => ['old' =>'st2','new' =>'st2'],
                    'prevRoute' => 'client.register'
                ],

                'consultant.forget' =>[
                    'validations' => [
                        'required', 'required', 'numeric'
                    ],
                    'session' => 'st11',
                    'nextRoute' => 'consultant.verifyForget'
                ],
                'consultant.verifyForget'=> [
                    'validations' => [
                        'required', 'required', 'numeric'
                    ],
                    'session' => ['old' =>'st11','new' =>'st22'],
                    'prevRoute' => 'consultant.forget',
                    'nextRoute' => 'consultant.restorePassword'
                ],
                'consultant.restorePassword' => [
                    'validations' => [
                        'required', 'min:6', 'confirmed'
                    ],
                    'session' => ['old' =>'st22','new' =>'st33'],
                    'prevRoute' => 'consultant.forget'
                ],
            ],
            'inputs' => [
                'step1' => 'phone',
                'step2' => 'token',
                'step3' => ['password', 'name']
            ],
            'guard' => 'web',
            'redirectLocation' => 'home'
        ],
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
        'codeLength' => 4
    ]

];
