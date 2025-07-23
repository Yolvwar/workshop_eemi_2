<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index($pet)
    {
        $events = Event::where('pets_id', $pet)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start->format('Y-m-d\TH:i:s'),
                    'end' => $event->end ? $event->end->format('Y-m-d\TH:i:s') : null,
                    'color' => $event->color,
                    'allDay' => $event->all_day
                ];
            });

        // Add this line to debug
        \Log::info('Events for pet ' . $pet, ['events' => $events->toArray()]);

        return view('calendar.index', compact('pet', 'events'));
    }

    public function getEvents(Request $request, $pet)
    {
        $events = Event::where('pet_id', $pet)
            ->whereBetween('start', [
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

    public function store(Request $request, $pet = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'color' => 'nullable|string',
            'all_day' => 'boolean'
        ]);

        $data = [
            'title' => $request->title,
            'start' => Carbon::parse($request->start),
            'end' => $request->end ? Carbon::parse($request->end) : null,
            'color' => $request->color ?? '#3788d8',
            'all_day' => $request->all_day ?? false
        ];

        if ($pet) {
            $data['pet_id'] = $pet;
        }

        $event = Event::create($data);

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start->format('Y-m-d\TH:i:s'),
            'end' => $event->end ? $event->end->format('Y-m-d\TH:i:s') : null,
            'color' => $event->color,
            'allDay' => $event->all_day
        ]);
    }


    public function update(Request $request, $pet, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after:start',
            'color' => 'nullable|string',
            'all_day' => 'boolean'
        ]);

        // Vous pouvez ajouter ici une vérification que l'événement appartient bien à l'animal $pet.

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

    public function destroy($pet, Event $event)
    {
        // Vous pouvez vérifier ici que l'événement appartient bien à l'animal $pet.
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
}
