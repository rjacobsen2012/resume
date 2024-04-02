<?php

namespace App\Cryptos\Encryptors;

abstract class BaseEncrypt
{
    protected function baseEncrypt(array $fields, array $data): array
    {
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = encrypt($data[$field]);
            }
        }

        return $data;
    }
}
