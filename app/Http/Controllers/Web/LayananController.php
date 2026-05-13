<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::with(['services' => function($q) {
            $q->where('is_active', true);
        }])->get();

        $allServices = Service::where('is_active', true)->with('category')->latest()->get();

        return view('djoki.layanan.index', compact('categories', 'allServices'));
    }
}
