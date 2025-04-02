<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
        ]);
    
        Patient::create($request->all());
    
        return redirect()->route('patients.index')->with('success', 'Patient added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
    return view('patients.edit', compact('patient'));
    }  


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required|integer',
            'gender' => 'required',
        ]);
    
        $patient->update($request->all());
    
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
    $patient->delete();

    return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }

}
