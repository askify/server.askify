<?php

namespace App\Http\Controllers\Core;

use App\User;
use App\Question;
use App\Core\QuestionFeed;
use App\Http\Resources\UserResource;
use App\Http\Controllers\ResourceController;

use Illuminate\Http\Request;

class UserController extends ResourceController
{
    protected $model = User::class;
    protected $modelResource = UserResource::class;

    public function questionsFeed(Request $request, $id)
    {
        // user should be an expert?
        $roles = $request->get('roles', 4);
        $user = User::whereRoles($roles)->find($id);

        if (!$user) {
            return jresponse([]);
        }

        $with = $request->get('with', []);
        $withCount = $request->get('withCount', []);
        $builder = Question::with($with)->withCount($withCount);

        $qf = new QuestionFeed($user);
        $res = $qf->get($request, $builder);

        return jresponse($res);
    }
}
