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
    }

    public function store(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $subscribable = $this->identifyModel($type, $id);
        $user->subscribeTo($subscribable);

        return redirect()->back();
    }

    public function destroy(Request $request, string $type, int $id)
    {
        $user = $request->user();
        $subscribable = $this->identifyModel($type, $id);
        $user->unsubscribeFrom($subscribable);

        return redirect()->back();
    }
}
