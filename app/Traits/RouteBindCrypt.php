<?php

namespace App\Traits;

// use App\Models\ExcelFile;
use Illuminate\Support\Facades\Crypt;

trait RouteBindCrypt
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $filed = null)
    {
        return $this::whereIn($this->getKeyName(), [
            $this->decryptStringByField($value),
            $value
        ])->firstOrFail();
    }

    /**
     * This function returns the encrypted ID of the model using Crypt::encrypt().
     * If the model has an assigned ID, it encrypts and returns it; otherwise, it returns null.
     *
     * @return void
     */
    protected function getIdEncryptAttribute()
    {
        $model_id = $this->getKey();

        if ($model_id) {
            return Crypt::encryptString($this->getKey());
        }

        return null;
    }

    private function decryptStringByField (string|int $value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Throwable $th) {
            return $value;
        }
    }
}
