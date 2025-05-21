<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index()
    {
        return Medication::with('treatment')->whereHas('treatment', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'treatment_id' => 'required|exists:treatments,id',
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'times_per_day' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
        ]);

        return Medication::create($data);
    }

    public function show(Medication $medication)
    {
        $this->authorizeAccess($medication);
        return $medication;
    }

    public function update(Request $request, Medication $medication)
    {
        $this->authorizeAccess($medication);
        $medication->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
            'dosage' => 'sometimes|required|string|max:100',
            'times_per_day' => 'sometimes|required|integer|min:1',
            'instructions' => 'nullable|string',
        ]));

        return $medication;
    }

    public function destroy(Medication $medication)
    {
        $this->authorizeAccess($medication);
        $medication->delete();
        return response()->noContent();
    }

    protected function authorizeAccess(Medication $medication): void
    {
        abort_if($medication->treatment->user_id !== auth()->id(), 403, 'Unauthorized');
    }
}
