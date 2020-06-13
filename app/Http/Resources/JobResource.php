<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'job' => [
                'id' => $this->id,
                'name' => $this->name,
                'category' => $this->categories->pluck('id'),
                'start' => $this->start,
                'end' => $this->end,
                'description' => $this->description,
            ],
            'departement' => $this->departements->toArray()
        ];
    }
}
