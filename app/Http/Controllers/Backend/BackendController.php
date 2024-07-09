<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\User;
use App\Models\Transaction;

class BackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $menu = Food::take(10)->get();;
        $user = User::all();
        $foodCount = Food::count();
        $userCount = User::count();
        $transactionCount = Transaction::count();
        $CustomerCount = Transaction::select('name')
        ->distinct()
        ->count('name');
        //$slider_menu = Food::where('on_slider',true)->get();
        return view('backend.index',
                     compact('menu','user','userCount','transactionCount','foodCount','CustomerCount')
                    );
    }
}
