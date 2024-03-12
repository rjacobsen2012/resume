<?php

namespace App\Cryptos\Decryptors;

use App\Constant\ResumeEncryptedFields;

class ResumeEncryptor
{
    public function encrypt(array $data): array
    {
        foreach (ResumeEncryptedFields::all() as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = encrypt($data[$field]);
            }
        }

        return $data;
    }
}
