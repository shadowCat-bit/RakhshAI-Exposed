<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    // users list
    public function list(Request $request) {
        $search = $request->get('search', null);
        $sortby = $request->get('sortby', null);

        $users = User::query()
            ->select([
                'users.*',
                'user_success_payment.sum_tr',
                'user_success_payment.total_tr',
                'user_total_messages.total_msg',
                'user_total_convs.total_conv'
            ])
            ->with(['userToken'])
            ->leftJoin('user_success_payment', 'user_success_payment.user_id', 'users.id')
            ->leftJoin('user_total_messages', 'user_total_messages.user_id', 'users.id')
            ->leftJoin('user_total_convs', 'user_total_convs.user_id', 'users.id')
            ->when($search, function ($query) use ($search) {
                $query->whereMobile($search);
            })
            ->when($sortby == 'max_chats', function ($query) {
                $query->orderBy('total_msg', 'desc');
            })
            ->when($sortby == 'max_tokens', function ($query) {
                $query
                    ->leftJoin('user_tokens', 'users.id', '=', 'user_tokens.user_id')
                    ->orderBy('user_tokens.remaining_tokens', 'desc');
            })
            ->when($sortby == 'max_payment', function ($query) {
                $query->orderBy('sum_tr', 'desc');
            })
            ->when(!$sortby, function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->paginate(24);

        $users = $users->appends(['sortby' => $sortby]);

        $userIds = $users->pluck('id')->toArray();

        $userCount = User::count();

        return view('admin.users.list', compact('users', 'userCount'));
    }

    // public function list_old(Request $request) {
    //     $search = $request->get('search', null);
    //     $sortby = $request->get('sortby', null);

    //     $users = User::query()
    //         ->with(['userToken'])
    //         ->when($search, function ($query) use ($search) {
    //             $query->whereMobile($search);
    //         })
    //         ->withCount(['conversations', 'conversations as conversation_messages_count' => function ($query) {
    //             $query->join('conversation_messages', 'conversations.id', '=', 'conversation_messages.conversation_id');
    //         }, 'transactions' => function ($query) {
    //             $query->where('tr_status', '=', 'success');
    //         }])
    //         ->withSum(['transactions' => function ($query) {
    //             $query->where('tr_status', '=', 'success');
    //         }], 'tr_amount')
    //         ->when($sortby == 'max_chats', function ($query) {
    //             $query->orderBy('conversation_messages_count', 'desc');
    //         })
    //         ->when($sortby == 'max_tokens', function ($query) {
    //             $query
    //                 ->leftJoin('user_tokens', 'users.id', '=', 'user_tokens.user_id')
    //                 ->orderBy('user_tokens.remaining_tokens', 'desc');
    //         })
    //         ->when($sortby == 'max_payment', function ($query) {
    //             $query->orderBy('transactions_sum_tr_amount', 'desc');
    //         })
    //         ->when(!$sortby, function ($query) {
    //             $query->orderBy('id', 'desc');
    //         })
    //         ->paginate(20);

    //     $users = $users->appends(['sortby' => $sortby]);

    //     $userCount = User::count();

    //     return view('admin.users.list', compact('users', 'userCount'));
    // }
}
