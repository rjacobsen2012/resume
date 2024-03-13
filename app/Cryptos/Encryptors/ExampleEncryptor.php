<?php

namespace App\Cryptos\Encryptors;

use App\Constant\Encrypts\ExampleEncryptedFields;

class ExampleEncryptor extends BaseEncrypt
{
    public function encrypt(array $data): array
    {
        return $this->baseEncrypt(ExampleEncryptedFields::all(), $data);
    }
}
