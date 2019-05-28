<?php
return [
    'search_accuracy_lat'	=> 1,
    'search_accuracy_lng'	=> 2,
    'log_return_default'	=> 5,
    'limits'	=> [
        'low'	=> 50,
        'mid'	=> 500,
    ],
    'prices'	=> [
    
        'low' => [
            'Ristretto' => 2,
            'Espresso'	=> 4,
            'Lungo'	=>	6,
        ],
    
        'mid' => [
            'Ristretto' => 3,
            'Espresso'	=> 6,
            'Lungo'	=>	9,
        ],

        'high' => [
            'Ristretto' => 5,
            'Espresso'	=> 10,
            'Lungo'	=>	15,
        ]
    ],
    'earth_radius' => 6371000,
];
