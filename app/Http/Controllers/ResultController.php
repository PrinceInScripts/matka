<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Result;
use App\Models\WalletTransactions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function getContext(Request $request)
{
    return Result::where([
        'game_id' => $request->game_id,
        'session' => $request->session,
        'result_date' => $request->result_date,
    ])->first();
}


public function saveDraft(Request $request)
{
    Result::updateOrCreate(
        [
          'game_id' => $request->game_id,
          'session' => $request->session,
          'result_date' => $request->result_date,
        ],
        [
          'open_panna' => $request->open_panna,
          'open_digit' => $request->open_digit,
          'close_panna' => $request->close_panna,
          'close_digit' => $request->close_digit,
          'status' => 'draft'
        ]
    );
}


public function previewWinners($resultId)
{
    $result = Result::findOrFail($resultId);

    return Bid::whereMatchResult($result)
              ->calculateWinnings()
              ->get();
}

public function winners(Result $result)
{
    DB::transaction(function () use ($result) {

  if ($result->status === 'declared') {
      throw new Exception("Already declared");
  }

  $winners = Bid::whereMatchResult($result)->get();

  foreach ($winners as $win) {
      WalletTransactions::credit($win->user_id, $win->winning_amount);
  }

  $result->update(['status' => 'declared']);
});


}

}
