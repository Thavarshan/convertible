<?php

namespace App\Contracts\Services;

interface Client
{
    /**
     * Create new client instance.
     *
     * @param array      $data
     * @param array|null $options
     *
     * @return mixed
     */
    public function make(array $data, ?array $options = null);
}
