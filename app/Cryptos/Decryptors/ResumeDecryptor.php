<?php

namespace App\Cryptos\Decryptors;

use App\Constant\Encrypts\ResumeEncryptedFields;
use App\Models\Resume;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ResumeDecryptor extends BaseDecrypt
{
    public function __construct(
        protected ExampleDecryptor $exampleDecryptor,
        protected ExperienceDecryptor $experienceDecryptor,
        protected EducationDecryptor $educationDecryptor,
    ) {}

    public function decrypt(Resume $resume): Resume|Model
    {
        /** @var Resume $resume */
        $resume = $this->baseDecrypt(ResumeEncryptedFields::all(), $resume);
        $resume->examples = $this->exampleDecryptor->decryptAll($resume->examples);
        $resume->experiences = $this->experienceDecryptor->decryptAll($resume->experiences);
        $resume->educations = $this->educationDecryptor->decryptAll($resume->educations);
        return $resume;
    }

    /**
     * @param  Collection|Resume[]  $resumes
     */
    public function decryptAll(Collection|array $resumes): Collection
    {
        return $this->baseDecryptAll(ResumeEncryptedFields::all(), $resumes);
    }
}
