<?php

namespace App\Cryptos\Decryptors;

use App\Constant\Encrypts\ResumeEncryptedFields;
use App\Models\Resume;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ResumeDecryptor extends BaseDecrypt
{
    public function decrypt(Resume $resume): Resume|Model
    {
        return $this->baseDecrypt(ResumeEncryptedFields::all(), $resume);
    }

    /**
     * @param  Collection|Resume[]  $resumes
     */
    public function decryptAll(Collection|array $resumes): Collection
    {
        return $this->baseDecryptAll(ResumeEncryptedFields::all(), $resumes);
    }
}
