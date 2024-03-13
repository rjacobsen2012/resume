<?php

namespace App\Cryptos\Decryptors;

use App\Constant\Encrypts\ExampleEncryptedFields;
use App\Models\Example;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ExampleDecryptor extends BaseDecrypt
{
    public function decrypt(Example $resume): Example|Model
    {
        return $this->baseDecrypt(ExampleEncryptedFields::all(), $resume);
    }

    /**
     * @param  Collection|Example[]  $resumes
     */
    public function decryptAll(Collection|array $resumes): Collection
    {
        return $this->baseDecryptAll(ExampleEncryptedFields::all(), $resumes);
    }
}