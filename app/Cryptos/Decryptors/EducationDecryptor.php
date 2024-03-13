<?php

namespace App\Cryptos\Decryptors;

use App\Constant\Encrypts\EducationEncryptedFields;
use App\Models\Education;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EducationDecryptor extends BaseDecrypt
{
    public function decrypt(Education $resume): Education|Model
    {
        return $this->baseDecrypt(EducationEncryptedFields::all(), $resume);
    }

    /**
     * @param  Collection|Education[]  $resumes
     */
    public function decryptAll(Collection|array $resumes): Collection
    {
        return $this->baseDecryptAll(EducationEncryptedFields::all(), $resumes);
    }
}
