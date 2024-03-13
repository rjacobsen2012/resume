<?php

namespace App\Cryptos\Encryptors;

use App\Constant\Encrypts\ExperienceEncryptedFields;

class ExperienceEncryptor extends BaseEncrypt
{
    public function encrypt(array $data): array
    {
        return $this->baseEncrypt(ExperienceEncryptedFields::all(), $data);
    }
}
