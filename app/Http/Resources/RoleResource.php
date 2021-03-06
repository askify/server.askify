<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        $res = parent::toArray($request);
        $formatted = [];

        // dates
        humanizeDate($this, $res, [
            'deleted_at',
            'created_at',
            'updated_at'
        ]);

        return array_merge($res, $formatted);
    }
}
