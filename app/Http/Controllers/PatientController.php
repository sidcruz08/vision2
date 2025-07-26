<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_code' => 'required|unique:patients|max:20',
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'nullable',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable'
        ]);

        Patient::create($validated);
        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'patient_code' => 'required|max:20|unique:patients,patient_code,' . $patient->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'nullable',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable'
        ]);

        $patient->update($validated);
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}