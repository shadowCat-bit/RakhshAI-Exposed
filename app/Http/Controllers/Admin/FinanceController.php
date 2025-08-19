<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Image;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceController extends Controller {

    // purchased packages list
    public function purchased(Request $request) {
        $search = $request->get('search', null);

        $items = Transaction::query()
            ->with(['user'])
            ->whereTrStatus('success');
        if ($search) {
            $items = $items->whereHas('user', function ($query) use ($search) {
                $query->where('mobile', '=', $search);
            });
        }
        $items = $items
            ->orderBy('id', 'desc')
            ->paginate(50);

        $count = Transaction::whereTrStatus('success')->count();

        $items = $items->appends(['search' => $search]);

        return view('admin.finance.purchased', compact('items', 'count'));
    }

    // purchased period packages list
    public function purchasedPeriod(Request $request) {
        $fromDate = $request->get('from_date', null);
        $toDate = $request->get('to_date', null);

        if ($fromDate and $toDate) {
            $fromDate = Carbon::parse($fromDate)->toDateString();
            $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();
        } else {
            $fromDate = Carbon::now()->startOfMonth()->toDateString();
            $toDate = Carbon::now()->endOfDay()->toDateTimeString();
        }

        $info = ['ZALV1' => 0, 'ZALV2' => 0, 'SHZ1' => 0, 'SHZ2' => 0, 'USERS' => 0];

        $totalSell = Transaction::query()
            ->whereTrStatus('success')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('tr_amount');
        $totalSell = number_format($totalSell, 0, '', ',');

        $info['ZALV1'] = Conversation::query()
            ->withTrashed()
            ->whereVersion('1')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('total_tokens');
        $info['ZALV1'] = number_format($info['ZALV1'], 0, '', ',');

        $info['ZALV2'] = Conversation::query()
            ->withTrashed()
            ->whereVersion('2')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->sum('total_tokens');
        $info['ZALV2'] = number_format($info['ZALV2'], 0, '', ',');

        $info['SHZ1'] = Image::query()
            ->withTrashed()
            ->whereVersion('1')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();
        $info['SHZ1'] = number_format($info['SHZ1'], 0, '', ',');

        $info['SHZ2'] = Image::query()
            ->withTrashed()
            ->whereVersion('2')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();
        $info['SHZ2'] = number_format($info['SHZ2'], 0, '', ',');

        $info['USERS'] = User::query()
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->count();
        $info['USERS'] = number_format($info['USERS'], 0, '', ',');

        $toDate = Carbon::parse($toDate)->toDateString();

        return view('admin.finance.purchased-period', compact('fromDate', 'toDate', 'totalSell', 'info'));
    }
}
