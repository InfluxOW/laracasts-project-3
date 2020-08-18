<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\Http\Requests\UserProfileRequest;
use App\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ProfilesController extends Controller
{
     /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $query = $user->actions()->with('subject')->getQuery();
        $actions = QueryBuilder::for($query)
            ->allowedFilters('created_at')
            ->latest()
            ->paginate(20)
            ->appends(request()->query());
        $achievements = Achievement::all();
        $awarded = $user->achievements;

        return view('users.show', compact('user', 'actions', 'achievements', 'awarded'));
    }

    public function update(UserProfileRequest $request, User $user)
    {
        $this->authorize($user);

        $user->update($request->validated());

        flash('Your profile has been updated')->success();
        return redirect()->route('profiles.show', $user);
    }
}
