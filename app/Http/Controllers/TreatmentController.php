<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Diagnosis;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = Treatment::with('diagnosis.visit.patient')->get();
        return view('treatments.index', compact('treatments'));
    }

    public function create()
    {
        $diagnoses = Diagnosis::with('visit.patient')->get();
        return view('treatments.create', compact('diagnoses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'treatment_type' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        Treatment::create($request->all());
        return redirect()->route('treatments.index')->with('success', 'Treatment created successfully.');
    }

    public function show(Treatment $treatment)
    {
        $treatment->load('diagnosis.visit.patient');
        return view('treatments.show', compact('treatment'));
    }

    public function edit(Treatment $treatment)
    {
        $diagnoses = Diagnosis::with('visit.patient')->get();
        return view('treatments.edit', compact('treatment', 'diagnoses'));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $request->validate([
            'diagnosis_id' => 'required|exists:diagnoses,id',
            'treatment_type' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $treatment->update($request->all());
        return redirect()->route('treatments.index')->with('success', 'Treatment updated successfully.');
    }

    public function destroy(Treatment $treatment)
    {
        $treatment->delete();
        return redirect()->route('treatments.index')->with('success', 'Treatment deleted successfully.');
    }
}
