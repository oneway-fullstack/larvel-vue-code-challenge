<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Car extends JsonResource
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
            'make'                  => $this->make,
            'model'                 => $this->model,
            'year'                  => $this->year,
            'owner_id'              => $this->owner ? $this->owner->id : null,
            'owner_name'            => $this->owner ? $this->owner->name : '',
            'address'               => $this->address
        ];
    }
}
