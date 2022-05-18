<?php

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
         * 32 characters long, secure, and not be committed to your VCS. You can generate a secure secret using
         * something like `openssl rand -base64 32` or `gpg --gen-random 1 32 | base64`
         */
        'secret' => null, // file_get_contents(CONFIG . 'keys' . DS . 'hmac_secret.txt'),

        /*
         * An array of public/private key pairs. At least one set of keys is required if you're using RSA. The
         * key length must be at least 2048 bits, not be committed to your VCS, and stored securely.
         */
        'keys' => [
            [
                /*
                 * The Key ID can be any unique identifier
                 */
                'kid' => '1',

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
