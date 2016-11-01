<?php

/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 9/30/2016
 * Time: 10:49 AM
 */
namespace App\Models\Traits; // *** Adjust this to match your model namespace! ***

use Illuminate\Database\Eloquent\Builder;

trait HasCompositePrimaryKey
{
    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        foreach ($this->getKeyName() as $key) {
            if ($this->$key)
                $query->where($key, '=', $this->$key);
            else
                throw new \Exception(__METHOD__ . 'Missing part of the primary key: ' . $key);
        }

        return $query;
    }
}