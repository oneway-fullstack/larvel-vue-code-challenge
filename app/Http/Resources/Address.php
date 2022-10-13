<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Address extends JsonResource
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
            'address'               => $this->address,
            'city'                  => $this->city,
            'country'               => $this->country,
            'postal_code'           => $this->postal_code,
            'owner_name'            => $this->owner ? $this->owner->name : '',
            'number_of_cars'        => count($this->cars)
        ];
    }
}
