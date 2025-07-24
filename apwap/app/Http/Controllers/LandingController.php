<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Veterinarian;
use App\Models\Consultation;
use App\Models\Pet;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pets' => Pet::count(),
            'total_consultations' => Consultation::count(),
            'total_veterinarians' => Veterinarian::where('is_active', true)->count(),
            'satisfaction_rate' => 98,
        ];

        $featuredVeterinarians = Veterinarian::where('is_active', true)
            ->orderByDesc('rating')
            ->take(3)
            ->get();

        $recentTestimonials = [
            [
                'name' => 'Sarah Al-Mansouri',
                'pet' => 'Max (Golden Retriever)',
                'rating' => 5,
                'comment' => 'Service exceptionnel ! Dr. Wilson a pris un soin incroyable de Max. La consultation à domicile était parfaite.',
                'location' => 'Dubai Marina'
            ],
            [
                'name' => 'Ahmed Hassan',
                'pet' => 'Luna (Chat Persan)',
                'rating' => 5,
                'comment' => 'La téléconsultation a sauvé la vie de Luna. Diagnostic rapide et traitement efficace. Merci APWAP !',
                'location' => 'Downtown Dubai'
            ],
            [
                'name' => 'Emma Johnson',
                'pet' => 'Buddy (Labrador)',
                'rating' => 5,
                'comment' => 'Équipe professionnelle, clinique moderne. Buddy adore ses visites chez APWAP !',
                'location' => 'JLT'
            ]
        ];

        return view('landing.index', compact('stats', 'featuredVeterinarians', 'recentTestimonials'));
    }
}
