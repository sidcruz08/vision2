<?php

namespace App\Http\Controllers;

use App\Models\ClaimItem;
use App\Models\ClaimDocument;
use Illuminate\Http\Request;

class ClaimDocumentController extends Controller
{
    public function store(Request $request, ClaimItem $claimItem)
    {
        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png,docx|max:2048'
        ]);

        foreach ($request->file('documents') as $file) {
            $path = $file->store('claim_documents', 'public');
            ClaimDocument::create([
                'claim_item_id' => $claimItem->id,
                'filename' => $path,
            ]);
        }

        return redirect()->route('claims.show', $claimItem->claim_id)->with('success', 'Documents uploaded.');
    }
}
