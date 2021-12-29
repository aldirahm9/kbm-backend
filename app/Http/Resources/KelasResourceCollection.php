<?php

namespace App\Http\Resources;

use App\Semester;
use Illuminate\Http\Resources\Json\ResourceCollection;

class KelasResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            "meta" => [
                "semester" => Semester::orderBy('semester')->get()
            ]
        ];
    }
}
