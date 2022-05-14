<?php
declare(strict_types=1);

return [
    'MixerApi.JwtAuth' => [

        /*
         * The algorithm you'll use to generate JWTs. Either HS256 or RS256.
         */
        'alg' => 'HS256',

        /*
         * This is only required if you are using HS256, it can be left empty otherwise. This can be the value of your
         * applications `Security.salt` or any other string such as something generated by openssl and loaded from
         * your file system with file_get_contents().
         */
        'secret' => null, // \Cake\Core\Configure::read('Security.salt'),

        /*
         * An array of public/private key pairs. This can be left empty if you are not using HS256.
         */
        'keys' => [
            [
                /*
                 * The Key ID can be any unique identifier
                 */
                'kid' => '2022-05-01',

                /*
                 * Contents of the public key file
                 */
                'public' => file_get_contents(CONFIG . 'keys' . DS . '1' . DS . 'public.pem'),

                /*
                 * Contents of the private key file
                 */
                'private' => file_get_contents(CONFIG . 'keys' . DS . '1' . DS . 'private.pem'),
            ]
        ]
    ]
];