<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProviderStatistic;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderStatisticController extends Controller
{
    public function show($providerId, Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && $user->id != $providerId) {
            abort(403);
        }
        $stat = ProviderStatistic::firstOrCreate(['provider_id' => $providerId]);
        $provider = User::findOrFail($providerId);

        return view('djoki.provider-statistics.show', compact('stat', 'provider'));
    }
}
