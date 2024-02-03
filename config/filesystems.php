<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'uploads' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
            'url' => '/uploads/',
            'visibility' => 'public',
        ],


        'inputs' => [
            'driver' => 'local',
            'root' => base_path('resources/views/inputs'),
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'audio-books' => [
            'driver' => 'local',
            'root' => public_path('audio-books'),
            'url' => 'gw.test/audio-books',
            'visibility' => 'public',
        ],


        'audio-books-ftp' => [
            'driver' => 'sftp',
            'host' => 'skymoon05.cafe24.com',
            'username' => 'skymoon05',
            'password' => 'nelly2020ftp',

                // Optional FTP Settings...
                'port'     => 22,
                'root' => 'www/audio-books',
                'passive'  => true,
                'timeout'  => 30,
        ],
        'gw-audiobook-sftp' => [
            'driver' => 'sftp',
            'host' => 'gwenglish.synology.me',
            'username' => 'gwadmin',
            'password' => 'Gwadmin1500',
            'permPublic' => 0755,
            'visibility' => 'public',

                // Optional FTP Settings...
                'port'     => 2212,
                'root' => '/web/audio/',
                'passive'  => true,
                'timeout'  => 30,

            'cache' => [
                'store' => 'file',
                'expire' => 600,
                'prefix' => 'audiobook-sftp',
            ],
        ],

        'audio-books-thumbnails' => [
            'driver' => 'local',
            'root' => public_path('audio-books-thumbnails'),
            'url' => '/audio-books-thumbnails',
            'visibility' => 'public',
        ],

        'audio-books-thumbnails-ftp' => [
            'driver' => 'sftp',
            'host' => 'skymoon05.cafe24.com',
            'username' => 'skymoon05',
            'password' => 'nelly2020ftp',
            'url' => '/audio-books-thumbnails',

                // Optional FTP Settings...
                'port'     => 22,
                'root' => 'www/audio-books-thumbnails',
                'passive'  => true,
                'timeout'  => 30,
        ],

        'sftp' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST'),
         
            // Settings for basic authentication...
            'username' => env('SFTP_USERNAME'),
            'password' => env('SFTP_PASSWORD'),
         
            // Settings for SSH key based authentication with encryption password...
            'privateKey' => env('SFTP_PRIVATE_KEY'),
            'passphrase' => env('SFTP_PASSPHRASE'),
         
            // Optional SFTP Settings...
            // 'hostFingerprint' => env('SFTP_HOST_FINGERPRINT'),
            // 'maxTries' => 4,
            // 'passphrase' => env('SFTP_PASSPHRASE'),
            // 'port' => env('SFTP_PORT', 22),
            // 'root' => env('SFTP_ROOT', ''),
            // 'timeout' => 30,
            // 'useAgent' => true,
        ],

    ],

];
