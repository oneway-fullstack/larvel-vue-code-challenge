<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Owner extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @return void
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'first_name'            => $this->first_name,
            'last_name'             => $this->last_name,
            'number_of_addresses'   => count($this->addresses),
            'number_of_cars'        => count($this->cars),
        ];
    }
}
