<?php

namespace App\Cryptos\Encryptors;

use App\Constant\Encrypts\ResumeEncryptedFields;

class ResumeEncryptor extends BaseEncrypt
{
    public function encrypt(array $data): array
    {
        return $this->baseEncrypt(ResumeEncryptedFields::all(), $data);
    }
}
