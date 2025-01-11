<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function jsonResponse($result)
    {
        $response = $result->toArray();
        return [
            'data' => $result->getCollection(),
            'pagination' => [
                'total' => $result->total(),
                'count' => $result->count(),
                'per_page' => $result->perPage(),
                'current_page' => $result->currentPage(),
                'total_pages' => $result->lastPage(),
                'from' => $response['from'],
                'to' => $response['to']
            ]
        ];
    }
}
