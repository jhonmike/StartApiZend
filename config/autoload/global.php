<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'mail' => array(
        'name' => 'mail.dominio.com.br',
        'host' => 'mail.dominio.com.br',
        'port' => 666,
        'connection_class' => 'login',
        'connection_config' => array(
            'username' => 'username',
            'password' => '123456',
            'ssl' => 'tls',
            'from' => 'contact@dominio.com.br'
        )
    )
);
