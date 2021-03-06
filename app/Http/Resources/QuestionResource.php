<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        $res = parent::toArray($request);
        $formatted = [];

        if ( isset($res['user']) ) {
            $user = new UserResource($this->user);
            $formatted['user'] = $user->toArray($request);
        }
        if ( isset($res['answers']) ) {
            $answers = AnswerResource::collection($this->answers);
            $formatted['answers'] = $answers->toArray($request);
        }
        if ( isset($res['tags']) ) {
            $tags = TagResource::collection($this->tags);
            $formatted['tags'] = $tags->toArray($request);
        }

        // dates
        humanizeDate($this, $res, [
            'deleted_at',
            'created_at',
            'updated_at',
            'urgent_at'
        ], true);

        return array_merge($res, $formatted);
    }
}
