<?php

namespace Tests;

use Illuminate\Encryption\Encrypter;

/**
 * Generates an application key on-the-fly.
 */
trait GeneratesKey
{
    public function setUpGeneratesKey(): void
    {
        $key = 'base64:'.base64_encode(
            Encrypter::generateKey(config('app.cipher'))
        );

        config()->set('app.key', $key);
    }
}
