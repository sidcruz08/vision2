<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\ClaimItem;
use Illuminate\Http\Request;

class ClaimItemController extends Controller
{
    public function create(Claim $claim)
    {
        return view('claim_items.create', compact('claim'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'claim_id' => 'required|exists:claims,id',
            'description' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        ClaimItem::create($data);
        return redirect()->route('claims.show', $data['claim_id'])->with('success', 'Claim item added.');
    }
}
