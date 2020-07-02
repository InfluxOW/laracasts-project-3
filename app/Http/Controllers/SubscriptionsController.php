<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

    /**
     * SubscriptionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'destroy');
        $this->middleware('verified')->only('store');
    }

    public function store(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $subscribable = $this->identifyModel($type, $id);
        $user->subscribeTo($subscribable);
    }

    public function destroy(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $subscribable = $this->identifyModel($type, $id);
        $user->unsubscribeFrom($subscribable);
    }
}
