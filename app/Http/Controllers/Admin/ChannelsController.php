<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChannelsRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class ChannelsController extends Controller
{
    public function index()
    {
        $channels = Channel::all();

        return view('admin.channels.index', compact('channels'));
    }

    public function create()
    {
        return view('admin.channels.create');
    }

    public function store(ChannelsRequest $request)
    {
        $channel = Channel::create($request->validated());

        flash('Channel has been created')->success();
        return redirect()->route('admin.channels.index');
    }

    public function update(ChannelsRequest $request, Channel $channel)
    {
        $channel->update($request->validated());

        flash('Channel has been updated')->success();
        return redirect()->route('admin.channels.index');
    }

    public function destroy(Request $request, Channel $channel)
    {
        $channel->delete();

        flash('Channel has been deleted')->success();
        return redirect()->route('admin.channels.index');
    }
}
