<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller {

    public function index() {
        $userCount = User::count();
        $sumPurchased = Transaction::whereTrStatus('success')->sum('tr_amount');
        $sumPurchased = number_format($sumPurchased, 0, ',');

        return view('admin.dashboard', compact('userCount', 'sumPurchased'));
    }
}
