<?php

return [
    'title' => 'Регистрация',

    'fields' => [

        'email' => [
            'label' => 'Адрес электронной почты',
        ],

        'name' => [
            'label' => 'Имя',
        ],

        'password' => [
            'label' => 'Пароль',
        ],

        'password_confirmation' => [
            'label' => 'Подтверждение пароля',
        ],

        'city' => [
            'label' => 'Город'
        ]

    ],

    'buttons' => [

        'submit' => [
            'label' => 'Зарегистрироваться',
        ],
        'cancel' => [
            'label' => 'У меня уже есть аккаунт'
        ]

    ],
];