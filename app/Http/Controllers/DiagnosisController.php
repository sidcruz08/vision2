<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Visit;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function index()
    {
        $diagnoses = Diagnosis::with('visit.patient')->get();
        return view('diagnoses.index', compact('diagnoses'));
    }

    public function create()
    {
        $visits = Visit::with('patient')->get();
        return view('diagnoses.create', compact('visits'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'diagnosis_code' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        Diagnosis::create($data);
        return redirect()->route('diagnoses.index')->with('success', 'Diagnosis created successfully.');
    }

    public function show(Diagnosis $diagnosis)
    {
        $diagnosis->load('visit.patient');
        return view('diagnoses.show', compact('diagnosis'));
    }

    public function edit(Diagnosis $diagnosis)
    {
        $visits = Visit::with('patient')->get();
        return view('diagnoses.edit', compact('diagnosis', 'visits'));
    }

    public function update(Request $request, Diagnosis $diagnosis)
    {
        $data = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'diagnosis_code' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $diagnosis->update($data);
        return redirect()->route('diagnoses.index')->with('success', 'Diagnosis updated successfully.');
    }

    public function destroy(Diagnosis $diagnosis)
    {
        $diagnosis->delete();
        return redirect()->route('diagnoses.index')->with('success', 'Diagnosis deleted successfully.');
    }
}
