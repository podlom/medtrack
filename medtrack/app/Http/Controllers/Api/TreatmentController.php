<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        return Treatment::with(['medications', 'reminders'])->where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data['user_id'] = auth()->id();

        return Treatment::create($data);
    }

    public function show(Treatment $treatment)
    {
        $this->authorizeAccess($treatment);
        return $treatment->load(['medications', 'reminders']);
    }

    public function update(Request $request, Treatment $treatment)
    {
        $this->authorizeAccess($treatment);

        $treatment->update($request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]));

        return $treatment;
    }

    public function destroy(Treatment $treatment)
    {
        $this->authorizeAccess($treatment);
        $treatment->delete();
        return response()->noContent();
    }

    protected function authorizeAccess(Treatment $treatment): void
    {
        abort_if($treatment->user_id !== auth()->id(), 403, 'Unauthorized');
    }
}
