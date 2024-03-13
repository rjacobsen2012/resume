<?php

namespace App\Cryptos\Decryptors;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseDecrypt
{
    protected function baseDecrypt(
        array $fields,
        Model $model
    ): Model {
        foreach ($fields as $field) {
            $value = $model->$field;
            try {
                $value = decrypt($value);
                $model->$field = $value;
            } catch (DecryptException $exception) {

            }
        }

        return $model;
    }

    protected function baseDecryptAll(array $fields, Collection|array $models): Collection
    {
        $decrypted = new Collection();

        foreach ($models as $model) {
            $decrypted->push($this->baseDecrypt($fields, $model));
        }

        return $decrypted;
    }
}
