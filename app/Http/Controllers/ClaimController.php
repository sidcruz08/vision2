<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Visit;
use App\Models\Patient;
use App\Services\VisionService;
use App\Services\ClaimValidator;
use App\Rules\PageCount;
use App\Services\DateValidator;
// use App\Models\Claim;
use App\Models\ClaimDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::with('documents')->get();
        return view('claims.index', compact('claims'));
    }

    public function create()
    {
        return view('claims.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'documents' => ['required', 'array', new PageCount],
            'documents.*' => 'file|mimes:pdf,jpg,png|max:5120',
            'patient_id' => 'required|string|max:50'
        ]);

        $visionService = new VisionService();
        $dateValidator = new DateValidator();

        $processedDocs = collect($request->file('documents'))
            ->map(fn($file) => $visionService->processDocument($file));

        $dates = $processedDocs
            ->flatMap(fn($doc) => $dateValidator->extractDates($doc['text']))
            ->unique()
            ->values();

        $claim = Claim::create([
            'patient_id' => $request->patient_id,
            'documents' => $processedDocs,
            'dates' => $dates,
            'date_valid' => $dateValidator->validateConsistency($dates),
            'status' => 'pending'
        ]);

        return redirect()->back()
            ->with('success', 'Claim submitted successfully!')
            ->with('claim_id', $claim->id);
    }

    // public function create()
    // {
    //     $patient = visit::first();
    //     // return dump($patients);
    //     return view('claims.create', compact('patient'));
    // }

    // public function store(Request $request)
    // {

    //     // Validate input
    //     $validated = $request->validate([
    //         'visit_id' => 'required|integer|exists:visits,id',
    //         'patient_id' => 'required|integer|exists:patients,id',
    //         'claim_number' => 'required|string|max:30|unique:claims',
    //         'claim_date' => 'required|date',
    //         'claim_amount' => 'required|numeric',
    //         'status' => 'required|in:Pending,Approved,Rejected,Partially Approved,Paid',
    //         'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
    //     ]);

    //     // Create the claim
    //     $claim = Claim::create([
    //         'visit_id' => $validated['visit_id'],
    //         'patient_id' => $validated['patient_id'],
    //         'claim_number' => $validated['claim_number'],
    //         'claim_date' => $validated['claim_date'],
    //         'claim_amount' => $validated['claim_amount'],
    //         'status' => $validated['status'],
    //     ]);

    //     // Store each uploaded document
    //     if ($request->hasFile('documents')) {
    //         foreach ($request->file('documents') as $file) {
    //             $path = $file->store('claims', 'public'); // stored in storage/app/public/claims

    //             $claim->documents()->create([
    //                 'file_path' => $path
    //             ]);
    //         }
    //     }

    //     return redirect()->route('claims.index')->with('success', 'Claim and documents uploaded successfully.');
    // }

    


    public function show(Claim $claim)
    {
        return view('claims.show', compact('claim'));
    }

    public function edit(Claim $claim)
    {
        return view('claims.edit', compact('claim'));
    }

    public function update(Request $request, Claim $claim)
    {
        $request->validate([
            'claim_amount' => 'required|numeric',
            'status' => 'required',
        ]);

        $claim->update($request->only(['claim_amount', 'status', 'remarks']));

        return redirect()->route('claims.index')->with('success', 'Claim updated.');
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->route('claims.index')->with('success', 'Claim deleted.');
    }

    public function processClaim(Request $request)
    {
        $request->validate([
            'documents' => ['required', 'array', new PageCount],
            'documents.*' => 'file|mimes:pdf,jpg,png|max:5120',
            'patient_id' => 'required|string'
        ]);

        $visionService = new VisionService();
        $dateValidator = new DateValidator();

        $processed = collect($request->file('documents'))->map(function ($file) use ($visionService) {
            return $visionService->processDocument($file);
        });

        $allDates = $processed->flatMap(fn($doc) => $dateValidator->extractDates($doc['text']))->toArray();

        Claim::create([
            'patient_id' => $request->patient_id,
            'documents' => $processed,
            'dates' => $allDates,
            'date_valid' => $dateValidator->validateConsistency($allDates),
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'date_consistency' => count(array_unique($allDates)) === 1
        ]);
    }
}
