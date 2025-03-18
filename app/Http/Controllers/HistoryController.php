<?php

namespace App\Http\Controllers;

use App\Domains\Operations\Models\Operation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $query = Operation::where('user_id', Auth::id());

        if ($request->has('search')) {
            $query->where('description', 'like', '%' . $request->get('search') . '%');
        }


        if ($request->has('sort') && $request->get('sort') === 'date') {

            $query->orderBy('created_at', $request->get('direction', 'desc'));
        } else {
            $query->latest();
        }

        $operations = $query->paginate(10);

        return view('history', compact('operations'));
    }
}
