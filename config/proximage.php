<?php

return [

    'defaults' => [

        /*
         * Templates which would be applied to all proxied images.
         *
         * Each template must implement \Coderello\Proximage\Contracts\Template
         */
        'templates' => [
            // \Coderello\Proximage\Templates\DisableProxyingForLocalEnvironmentTemplate::class,
        ],

        /* Url Encoding Type.
         * The default encoding is PHP_QUERY_RFC1738.
         * You can change the encoding here.
         * e.g. PHP_QUERY_RFC3986  
         */
        'http_build_query_enc_type' => PHP_QUERY_RFC1738
    ],

];
