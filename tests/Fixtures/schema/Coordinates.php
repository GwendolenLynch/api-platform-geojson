<?php

declare(strict_types=1);

return [
    '$ref' => '#/components/schemas/Coordinates',
    'components' => [
        'schemas' => [
            'Coordinates' => [
                'type' => 'array',
                'description' => 'Array of coordinates in the format [longitude, latitude, elevation]',
                'deprecated' => false,
                'items' => [
                    'type' => 'number',
                    'format' => 'float',
                ],
                'minItems' => 2,
                'maxItems' => 3,
                'example' => [
                    100.1,
                    1.2,
                ],
            ],
        ],
    ],
];
