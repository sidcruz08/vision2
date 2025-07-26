<?php

return [
    'max_sessions' => 150,
    'allowed_medications' => [
        'epoetin_alpha' => ['2000IU', '4000IU', '10000IU'],
        'epoetin_beta' => ['5000IU', '10000IU'],
        'iron_sucrose' => ['20mg/mL']
    ],
    'dialyzer_rules' => [
        'max_units' => 32,
        'max_reuse' => 5
    ],
    'required_signatures' => ['patient', 'facility_representative', 'witness'],
    'signature_regions' => [
        1 => [
            'patient' => [
                'x_min' => 0.65,
                'y_min' => 0.75,
                'x_max' => 0.85,
                'y_max' => 0.85
            ]
        ],
        2 => [
            'facility_representative' => [
                'x_min' => 0.65,
                'y_min' => 0.86,
                'x_max' => 0.85,
                'y_max' => 0.96
            ],
            'witness' => [
                'x_min' => 0.65,
                'y_min' => 0.97,
                'x_max' => 0.85,
                'y_max' => 1.0
            ]
        ]
    ],
    'date_formats' => ['Y-m-d', 'm/d/Y', 'd/m/Y']
];