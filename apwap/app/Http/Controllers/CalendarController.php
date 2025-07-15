<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function getEvents(Request $request)
    {
        $events = Event::whereBetween('start', [
            $request->start,
            $request->end
        ])->get();

        return response()->json($events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start->format('Y-m-d\TH:i:s'),
                'end' => $event->end ? $event->end->format('Y-m-d\TH:i:s') : null,
                'color' => $event->color,
                'allDay' => $event->all_day
            ];
        }));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'color' => 'nullable|string',
            'all_day' => 'boolean'
        ]);

        $event = Event::create([
            'title' => $request->title,
            'start' => Carbon::parse($request->start),
            'end' => $request->end ? Carbon::parse($request->end) : null,
            'color' => $request->color ?? '#3788d8',
            'all_day' => $request->all_day ?? false
        ]);

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start->format('Y-m-d\TH:i:s'),
            'end' => $event->end ? $event->end->format('Y-m-d\TH:i:s') : null,
            'color' => $event->color,
            'allDay' => $event->all_day
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'color' => 'nullable|string',
            'all_day' => 'boolean'
        ]);

        $event->update([
            'title' => $request->title,
            'start' => Carbon::parse($request->start),
            'end' => $request->end ? Carbon::parse($request->end) : null,
            'color' => $request->color,
            'all_day' => $request->all_day ?? false
        ]);

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start->format('Y-m-d\TH:i:s'),
            'end' => $event->end ? $event->end->format('Y-m-d\TH:i:s') : null,
            'color' => $event->color,
            'allDay' => $event->all_day
        ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
}