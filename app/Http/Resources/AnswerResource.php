<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    public function toArray($request)
    {
        $res = parent::toArray($request);
        $formatted = [];

        if ( isset($res['user']) ) {
            $user = new UserResource($this->user);
            $formatted['user'] = $user->toArray($request);
        }
        if ( isset($res['question']) ) {
            $question = new QuestionResource($this->question);
            $formatted['question'] = $question->toArray($request);
        }

        // FIXME: this is messy and shouldn't be here, but it works so...
        // check if viewable by user
        $aUser = user($request, false);
        if ($aUser) {
            $uid = $aUser->id;

            // did i vote for this answer?
            // include deleted oness ;)
            $vote = $this->votes()
                ->withTrashed()
                ->where('user_id', $uid)
                ->first();

            $formatted['vote'] = $vote;

            // viewable
            if (isset($res['transactions_viewable'])) {
                $viewable = $uid == $res['user_id'] ||
                    $res['privated_at'] === null ||
                    count($res['transactions_viewable']) > 0;

                $formatted['is_viewable'] = $viewable;
            }
        }

        // dates
        humanizeDate($this, $res, [
            'deleted_at',
            'created_at',
            'updated_at',
            'is_best_at'
        ], true);

        return array_merge($res, $formatted);
    }
}
