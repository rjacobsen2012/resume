<?php

namespace App\Cryptos\Encryptors;

use App\Constant\ResumeEncryptedFields;
use App\Models\Resume;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Collection;

class ResumeDecryptor
{
    public function decrypt(Resume $resume): Resume
    {
        foreach (ResumeEncryptedFields::all() as $field) {
            $value = $resume->$field;
            try {
                $value = decrypt($value);
                $resume->$field = $value;
            } catch (DecryptException $exception) {

            }
        }

        return $resume;
    }

    /**
     * @param  Collection|Resume[]  $resumes
     */
    public function decryptAll(Collection|array $resumes): Collection
    {
        $decrypted = new Collection();

        foreach ($resumes as $resume) {
            $decrypted->push($this->decrypt($resume));
        }

        return $decrypted;
    }
}
