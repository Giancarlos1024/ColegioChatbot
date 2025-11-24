<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Space;   // ✅
use Illuminate\Http\Request;

class EspacioController extends Controller
{
    public function index(Request $request)
    {
        $query = Space::query();

        if ($request->has('state')) {
            $query->where('state', $request->state);
        }

        return response()->json([
            'data' => $query->get()
        ]);
    }
}
