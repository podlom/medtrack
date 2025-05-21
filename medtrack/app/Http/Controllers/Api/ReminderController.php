<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index()
    {
        return Reminder::whereHas('treatment', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'treatment_id' => 'required|exists:treatments,id',
            'remind_at' => 'required|date_format:H:i',
            'method' => 'required|in:email,sms,push',
            'is_active' => 'boolean',
        ]);

        return Reminder::create($data);
    }

    public function show(Reminder $reminder)
    {
        $this->authorizeAccess($reminder);
        return $reminder;
    }

    public function update(Request $request, Reminder $reminder)
    {
        $this->authorizeAccess($reminder);
        $reminder->update($request->validate([
            'remind_at' => 'sometimes|required|date_format:H:i',
            'method' => 'sometimes|required|in:email,sms,push',
            'is_active' => 'sometimes|boolean',
        ]));

        return $reminder;
    }

    public function destroy(Reminder $reminder)
    {
        $this->authorizeAccess($reminder);
        $reminder->delete();
        return response()->noContent();
    }

    protected function authorizeAccess(Reminder $reminder): void
    {
        abort_if($reminder->treatment->user_id !== auth()->id(), 403, 'Unauthorized');
    }
}
