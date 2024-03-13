<?php

namespace App\Cryptos\Encryptors;

use App\Constant\Encrypts\EducationEncryptedFields;

class EducationEncryptor extends BaseEncrypt
{
    public function encrypt(array $data): array
    {
        return $this->baseEncrypt(EducationEncryptedFields::all(), $data);
    }
}
