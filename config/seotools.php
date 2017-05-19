<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => "NerfThis", // set false to total remove
            'description'  => 'Comunidade brasileira de Overwatch', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => [
                'overwatch',
                'verme',
                'campeonatos',
                'torneios',
                'inhouse',
                'notícias',
                'ranking',
                'brasileiro',
                'api',
                'stats',
                'estatísticas',
            ],
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => 'overwatch',
            'bing'      => 'overwatch',
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'NerfThis', // set false to total remove
            'description' => 'Comunidade brasileira de Overwatch', // set false to total remove
            'url'         => 'www.watchoverme.com.br',
            'type'        => false,
            'site_name'   => 'NerfThis',
            'images'      => ['http://watchoverme.com.br/img/verme.png'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ],
    ],
];
