<?php
declare(strict_types=1);

return [
    'MixerApi.JwtAuth' => [

        /*
         * The algorithm you'll use to generate JWTs.
         * - HMAC: HS256 or HS512
         * - RSA: RS256 or RS512
         */
        'alg' => 'RS256',

        /*
         * This is only required if you are using HMAC, it can be left empty otherwise. The value must be at least
         * 32 characters long.
         */
        'secret' => null,

        /*
         * An array of public/private key pairs. At least one set of keys is required if you're using RSA and they
         * key length must be 2048 bits.
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
