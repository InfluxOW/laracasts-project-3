<?php

namespace App\Http\Controllers;

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

        return view('users.show', compact('user', 'actions'));
    }

    public function update(UserProfileRequest $request, User $user)
    {
        $this->authorize($request->user());

        $user->update($request->validated());

        return redirect()->route('profiles.show', $user);
    }
}
