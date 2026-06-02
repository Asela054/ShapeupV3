<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        $userId = (int) $request->input('userId', 1);

        $accounts = Account::query()
            ->select(['idtbl_account', 'accountno', 'accountname'])
            ->where('status', 1)
            ->where('tbl_user_idtbl_user', $userId)
            ->get()
            ->map(fn ($row) => [
                'account_id' => (string) $row->idtbl_account,
                'accountno' => $row->accountno,
                'accountname' => $row->accountname,
            ]);

        return response()->json($accounts);
    }
}
