<?php

namespace App\Cryptos\Decryptors;

use App\Constant\Encrypts\ExperienceEncryptedFields;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ExperienceDecryptor extends BaseDecrypt
{
    public function decrypt(Experience $resume): Experience|Model
    {
        return $this->baseDecrypt(ExperienceEncryptedFields::all(), $resume);
    }

    /**
     * @param  Collection|Experience[]  $resumes
     */
    public function decryptAll(Collection|array $resumes): Collection
    {
        return $this->baseDecryptAll(ExperienceEncryptedFields::all(), $resumes);
    }
}