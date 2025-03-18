<?php

namespace App\Http\Controllers;

use App\Domains\Operations\Models\Operation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $operations = Operation::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($op) {
                return [
                    'created_at' => $op->created_at->format('d.m.Y H:i'),
                    'type' => $op->type,
                    'amount' => $op->amount,
                    'description' => $op->description,
                ];
            });

        return response()->json([
            'balance' => $user->balance,
            'operations' => $operations,
        ]);
    }
}
