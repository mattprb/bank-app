<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        // Pobierz konto użytkownika, jeśli nie istnieje, utwórz je
        $account = Account::firstOrCreate(
            ['user_id' => Auth::id()],
            ['balance' => 0] // Ustaw saldo na 0, jeśli konto nie istnieje
        );

        return view('dashboard', compact('account'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'recipient_account_id' => 'required|exists:accounts,id',
        ]);

        $senderAccount = Account::where('user_id', Auth::id())->first();
        $recipientAccount = Account::find($request->recipient_account_id);

        if (!$senderAccount || !$recipientAccount) {
            return back()->withErrors(['account_not_found' => 'Nie znaleziono konta nadawcy lub odbiorcy.']);
        }

        if ($senderAccount->balance < $request->amount) {
            return back()->withErrors(['insufficient_funds' => 'Nie masz wystarczających środków.']);
        }

        // Aktualizacja sald
        $senderAccount->balance -= $request->amount;
        $recipientAccount->balance += $request->amount;

        $senderAccount->save();
        $recipientAccount->save();

        return redirect()->route('account.dashboard')->with('success', 'Przelew zakończony pomyślnie!');
    }
}


