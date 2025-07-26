<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PatientController;
use App\Models\Patient;
use App\Models\Visit;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with('patient')->get();
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('visits.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'visit_type' => 'required|in:Outpatient,Inpatient,Emergency',
            'reason' => 'nullable',
            'doctor_name' => 'nullable',
            'status' => 'required|in:Ongoing,Completed,Cancelled',
        ]);

        Visit::create($data);
        return redirect()->route('visits.index')->with('success', 'Visit created successfully.');
    }

    public function show(Visit $visit)
    {
        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        $patients = Patient::all();
        return view('visits.edit', compact('visit', 'patients'));
    }

    public function update(Request $request, Visit $visit)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'visit_type' => 'required|in:Outpatient,Inpatient,Emergency',
            'reason' => 'nullable',
            'doctor_name' => 'nullable',
            'status' => 'required|in:Ongoing,Completed,Cancelled',
        ]);

        $visit->update($data);
        return redirect()->route('visits.index')->with('success', 'Visit updated successfully.');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')->with('success', 'Visit deleted successfully.');
    }
}
