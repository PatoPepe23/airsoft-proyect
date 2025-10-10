<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'day' => $this->fecha,
            'players' => $this->plazas,
            'alquiler' => $this->alquiler,
            'shift' => $this->shift,
            'state' => $this->cancelled,
            'created_at' => $this->created_at->toDateString()
        ];
    }
}
