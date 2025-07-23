<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Veterinarian;
use App\Models\Pet;
use App\Models\ConsultationReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class ConsultationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Dashboard des consultations
     */
    public function index()
    {
        $user = Auth::user();
        
        $upcomingConsultations = Consultation::where('user_id', $user->id)
            ->upcoming()
            ->with(['pet', 'veterinarian'])
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->take(5)
            ->get();

        $urgentConsultations = Consultation::where('user_id', $user->id)
            ->where('priority', 'urgent')
            ->where('status', '!=', 'completed')
            ->with(['pet', 'veterinarian'])
            ->orderBy('priority', 'desc')
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get();

        $monthlyStats = $this->getMonthlyStats($user->id);

        $pets = Pet::where('user_id', $user->id)->get();
        $petReminders = $this->getPetReminders($pets);

        return view('consultations.index', compact(
            'upcomingConsultations',
            'urgentConsultations',
            'monthlyStats',
            'petReminders'
        ));
    }

    /**
     * Afficher le formulaire de création de rendez-vous
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $pets = Pet::where('user_id', $user->id)->get();
        
        $selectedPet = null;
        if ($request->has('pet_id')) {
            $selectedPet = $pets->where('id', $request->pet_id)->first();
        }

        $veterinarians = Veterinarian::active()->get();
        
        $consultationTypes = [
            'general' => ['name' => 'Consultation générale', 'duration' => 45, 'price' => 300],
            'vaccination' => ['name' => 'Vaccination', 'duration' => 30, 'price' => 200],
            'dental' => ['name' => 'Soins dentaires', 'duration' => 60, 'price' => 500],
            'analysis' => ['name' => 'Analyses & tests', 'duration' => 30, 'price' => 400],
            'behavior' => ['name' => 'Conseil comportement', 'duration' => 45, 'price' => 350],
            'emergency' => ['name' => 'Urgence', 'duration' => 60, 'price' => 800],
        ];

        return view('consultations.create', compact(
            'pets',
            'selectedPet',
            'veterinarians',
            'consultationTypes'
        ));
    }

    /**
     * Enregistrer une nouvelle consultation
     */
    public function store(Request $request)
    {
        Log::info('Consultation store called', $request->all());
        
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'veterinarian_id' => 'nullable|exists:veterinarians,id',
            'type' => 'required|in:general,vaccination,dental,analysis,behavior,emergency,teleconsultation',
            'mode' => 'required|in:in_clinic,home_visit,teleconsultation',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'symptoms_description' => 'nullable|string',
            'urgency_level' => 'required|in:low,medium,high,urgent,emergency',
        ]);

        Log::info('Validation passed', $validated);

        $pet = Pet::findOrFail($validated['pet_id']);
        
        if (!$validated['veterinarian_id']) {
            $veterinarian = Veterinarian::active()->first();
            if (!$veterinarian) {
                return back()->withErrors(['veterinarian_id' => 'Aucun vétérinaire disponible pour le moment.']);
            }
            $validated['veterinarian_id'] = $veterinarian->id;
        } else {
            $veterinarian = Veterinarian::findOrFail($validated['veterinarian_id']);
        }

        $scheduledDateTime = Carbon::parse($validated['scheduled_at']);
        $scheduledDate = $scheduledDateTime->format('Y-m-d');
        $scheduledTime = $scheduledDateTime->format('H:i:s');

        $consultationTypes = [
            'general' => 300,
            'vaccination' => 200,
            'dental' => 500,
            'analysis' => 400,
            'behavior' => 350,
            'emergency' => 800,
            'teleconsultation' => 150,
        ];

        $baseCost = $consultationTypes[$validated['type']];
        $totalCost = $baseCost;

        if ($validated['mode'] === 'home_visit') {
            $totalCost += 100;
        }

        $consultation = Consultation::create([
            'user_id' => Auth::id(),
            'pet_id' => $validated['pet_id'],
            'veterinarian_id' => $validated['veterinarian_id'],
            'type' => $validated['type'],
            'mode' => $validated['mode'],
            'scheduled_date' => $scheduledDate,
            'scheduled_time' => $scheduledTime,
            'total_cost' => $totalCost,
            'priority' => $validated['urgency_level'],
            'symptoms' => $validated['symptoms_description'],
            'status' => 'scheduled',
        ]);

        Log::info('Consultation created', ['id' => $consultation->id]);

        return redirect()->route('consultations.show', $consultation)
            ->with('success', 'Votre rendez-vous a été programmé avec succès!');
    }

    /**
     * Afficher une consultation
     */
    public function show(Consultation $consultation)
    {
        $this->authorize('view', $consultation);
        
        $consultation->load(['pet', 'veterinarian']);
        
        $additionalInfo = [
            'documents' => [
                'health_record' => 'Carnet de santé',
                'last_analysis' => 'Dernières analyses',
                'vaccination_certificate' => 'Certificat vaccins',
                'insurance' => 'Assurance active',
                'apwap_history' => 'Historique APWAP',
            ],
            'questionnaire' => [
                'symptoms' => 'Symptômes détaillés',
                'behavior_changes' => 'Changements comportement',
                'recent_feeding' => 'Alimentation récente',
                'physical_activity' => 'Activité physique',
                'environment_stress' => 'Environnement/stress',
            ],
            'media' => [
                'behavior_photos' => 'Photos comportement',
                'gait_video' => 'Vidéo démarche',
                'stool_photo' => 'Photo selles (si nécessaire)',
                'weight_evolution' => 'Évolution poids',
            ],
        ];
        
        return view('consultations.show', compact('consultation', 'additionalInfo'));
    }

    /**
     * Afficher le formulaire d'édition d'une consultation
     */
    public function edit(Consultation $consultation)
    {
        $this->authorize('update', $consultation);
        
        $user = Auth::user();
        $pets = Pet::where('user_id', $user->id)->get();
        $veterinarians = Veterinarian::active()->get();
        
        $consultationTypes = [
            'general' => ['name' => 'Consultation générale', 'duration' => 45, 'price' => 300],
            'vaccination' => ['name' => 'Vaccination', 'duration' => 30, 'price' => 200],
            'dental' => ['name' => 'Soins dentaires', 'duration' => 60, 'price' => 500],
            'analysis' => ['name' => 'Analyses & tests', 'duration' => 30, 'price' => 400],
            'behavior' => ['name' => 'Conseil comportement', 'duration' => 45, 'price' => 350],
            'emergency' => ['name' => 'Urgence', 'duration' => 60, 'price' => 800],
            'teleconsultation' => ['name' => 'Téléconsultation', 'duration' => 20, 'price' => 150],
        ];

        return view('consultations.edit', compact('consultation', 'pets', 'veterinarians', 'consultationTypes'));
    }

    /**
     * Mettre à jour une consultation
     */
    public function update(Request $request, Consultation $consultation)
    {
        $this->authorize('update', $consultation);
        
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'veterinarian_id' => 'nullable|exists:veterinarians,id',
            'type' => 'required|in:general,vaccination,dental,analysis,behavior,emergency,teleconsultation',
            'mode' => 'required|in:in_clinic,home_visit,teleconsultation',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'symptoms_description' => 'nullable|string',
            'urgency_level' => 'required|in:low,medium,high,urgent,emergency',
        ]);

        if (!$validated['veterinarian_id']) {
            $veterinarian = Veterinarian::active()->first();
            if (!$veterinarian) {
                return back()->withErrors(['veterinarian_id' => 'Aucun vétérinaire disponible pour le moment.']);
            }
            $validated['veterinarian_id'] = $veterinarian->id;
        }

        $scheduledDateTime = Carbon::parse($validated['scheduled_at']);
        $scheduledDate = $scheduledDateTime->format('Y-m-d');
        $scheduledTime = $scheduledDateTime->format('H:i:s');

        $consultationTypes = [
            'general' => 300,
            'vaccination' => 200,
            'dental' => 500,
            'analysis' => 400,
            'behavior' => 350,
            'emergency' => 800,
            'teleconsultation' => 150,
        ];

        $baseCost = $consultationTypes[$validated['type']];
        $totalCost = $baseCost;

        if ($validated['mode'] === 'home_visit') {
            $totalCost += 100;
        }

        $consultation->update([
            'pet_id' => $validated['pet_id'],
            'veterinarian_id' => $validated['veterinarian_id'],
            'type' => $validated['type'],
            'mode' => $validated['mode'],
            'scheduled_date' => $scheduledDate,
            'scheduled_time' => $scheduledTime,
            'total_cost' => $totalCost,
            'priority' => $validated['urgency_level'],
            'symptoms' => $validated['symptoms_description'],
        ]);

        return redirect()->route('consultations.show', $consultation)
            ->with('success', 'Consultation mise à jour avec succès!');
    }

    /**
     * Préparer une consultation
     */
    public function prepare(Consultation $consultation)
    {
        $this->authorize('view', $consultation);
        
        $consultation->load(['pet', 'veterinarian']);
        
        $checklist = [
            'documents' => [
                'health_record' => 'Carnet de santé',
                'last_analysis' => 'Dernières analyses',
                'vaccination_certificate' => 'Certificat vaccins',
                'insurance' => 'Assurance active',
                'apwap_history' => 'Historique APWAP',
            ],
            'questionnaire' => [
                'symptoms' => 'Symptômes détaillés',
                'behavior_changes' => 'Changements comportement',
                'recent_feeding' => 'Alimentation récente',
                'physical_activity' => 'Activité physique',
                'environment_stress' => 'Environnement/stress',
            ],
            'media' => [
                'behavior_photos' => 'Photos comportement',
                'gait_video' => 'Vidéo démarche',
                'stool_photo' => 'Photo selles (si nécessaire)',
                'weight_evolution' => 'Évolution poids',
            ],
        ];

        return view('consultations.prepare', compact('consultation', 'checklist'));
    }

    /**
     * Interface de téléconsultation
     */
    public function teleconsultation(Consultation $consultation)
    {
        $this->authorize('view', $consultation);
        
        if ($consultation->mode !== 'teleconsultation') {
            abort(404);
        }

        $consultation->load(['pet', 'veterinarian']);

        return view('consultations.teleconsultation', compact('consultation'));
    }

    /**
     * Démarrer une consultation
     */
    public function start(Consultation $consultation)
    {
        $this->authorize('view', $consultation);
        
        $consultation->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Terminer une consultation
     */
    public function complete(Consultation $consultation)
    {
        $this->authorize('view', $consultation);
        
        $consultation->update([
            'status' => 'completed',
            'ended_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Annuler une consultation
     */
    public function cancel(Consultation $consultation)
    {
        $this->authorize('update', $consultation);
        
        if (!$consultation->canBeCancelled()) {
            return back()->with('error', 'Cette consultation ne peut plus être annulée.');
        }

        $consultation->update(['status' => 'cancelled']);

        return redirect()->route('consultations.index')
            ->with('success', 'Consultation annulée avec succès.');
    }

    /**
     * Centre d'urgences
     */
    public function emergency()
    {
        $emergencyVeterinarians = Veterinarian::emergencyAvailable()->get();
        $emergencyClinics = $this->getEmergencyClinics();

        return view('consultations.emergency', compact(
            'emergencyVeterinarians',
            'emergencyClinics'
        ));
    }

    /**
     * Historique des consultations
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        
        $query = Consultation::where('user_id', $user->id)
            ->with(['pet', 'veterinarian']);

        if ($request->filled('pet_id')) {
            $query->where('pet_id', $request->pet_id);
        }

        if ($request->filled('year')) {
            $query->whereYear('scheduled_date', $request->year);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $consultations = $query->orderBy('scheduled_date', 'desc')
            ->orderBy('scheduled_time', 'desc')
            ->paginate(15);
        
        $pets = Pet::where('user_id', $user->id)->get();
        $years = Consultation::where('user_id', $user->id)
            ->selectRaw('EXTRACT(YEAR FROM scheduled_date) as year')
            ->distinct()
            ->pluck('year');

        return view('consultations.history', compact('consultations', 'pets', 'years'));
    }

    /**
     * Obtenir les statistiques mensuelles
     */
    private function getMonthlyStats($userId)
    {
        $currentMonth = now()->startOfMonth();
        
        $consultations = Consultation::where('user_id', $userId)
            ->where('scheduled_date', '>=', $currentMonth)
            ->get();

        return [
            'total_consultations' => $consultations->count(),
            'emergency_consultations' => $consultations->where('priority', 'urgent')->count(),
            'total_cost' => $consultations->sum('total_cost'),
            'average_satisfaction' => $consultations->whereNotNull('user_rating')->avg('user_rating'),
            'average_wait_time' => 15,
        ];
    }

    /**
     * Obtenir les rappels pour les animaux
     */
    private function getPetReminders($pets)
    {
        $reminders = [];
        
        foreach ($pets as $pet) {
        }

        return $reminders;
    }

    /**
     * Obtenir les cliniques d'urgence
     */
    private function getEmergencyClinics()
    {
        return [
            [
                'name' => 'APWAP Emergency Center (JLT)',
                'distance' => '12min',
                'phone' => '+971-4-XXX-XXXX',
                'available_24_7' => true,
            ],
            [
                'name' => 'Dubai Animal Hospital (DIFC)',
                'distance' => '18min',
                'phone' => '+971-4-XXX-YYYY',
                'specialists' => true,
            ],
            [
                'name' => 'Emergency Vet Dubai (Marina)',
                'distance' => '8min',
                'phone' => '+971-4-XXX-ZZZZ',
                'closest' => true,
            ],
        ];
    }
}
