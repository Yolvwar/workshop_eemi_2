<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Données d'exemple pour les composants du dashboard
        $data = [
            // Vue d'ensemble - Cards
            'pets' => [
                'count' => 3,
                'activeCount' => 3,
                'wellnessScore' => 87
            ],
            'appointments' => [
                'todayCount' => 2,
                'nextAppointments' => ['14h00', '16h30'],
                'status' => 'Aujourd\'hui'
            ],
            'orders' => [
                'pendingCount' => 1,
                'deliveryInfo' => 'Livraison 2j',
                'trackingStatus' => 'Tracking actif'
            ],

            // Alertes
            'alerts' => [
                [
                    'type' => 'urgent',
                    'color' => 'red',
                    'icon' => '🔴',
                    'title' => 'URGENT: Buddy - Arthrite aggravée',
                    'description' => 'Consultation recommandée sous 48h',
                    'timeframe' => 'Sous 48h',
                    'action' => 'Prendre RDV maintenant'
                ],
                [
                    'type' => 'warning',
                    'color' => 'yellow',
                    'icon' => '🟡',
                    'title' => 'ATTENTION: Max - Stress thermique',
                    'description' => 'Température Dubai élevée (32°C)',
                    'timeframe' => 'Température élevée',
                    'action' => 'Voir recommandations'
                ],
                [
                    'type' => 'info',
                    'color' => 'blue',
                    'icon' => '🔵',
                    'title' => 'INFO: Luna - Toilettage prévu demain',
                    'description' => 'Rappel: Préparer brosse spéciale',
                    'timeframe' => 'Rappel',
                    'action' => 'Voir checklist'
                ]
            ],

            // Analytics des 6 piliers
            'petsAnalytics' => [
                'Max' => [
                    'name' => 'Max',
                    'avatar' => 'M',
                    'gradientFrom' => 'blue-500',
                    'gradientTo' => 'purple-600',
                    'pillars' => [
                        ['name' => '🏥 Santé', 'score' => 85, 'color' => 'green'],
                        ['name' => '🍽️ Nutrition', 'score' => 92, 'color' => 'blue'],
                        ['name' => '🏃 Activité', 'score' => 78, 'color' => 'orange'],
                        ['name' => '🧠 Mental', 'score' => 88, 'color' => 'purple'],
                        ['name' => '🌡️ Environnement', 'score' => 65, 'color' => 'yellow'],
                        ['name' => '👥 Social', 'score' => 90, 'color' => 'indigo']
                    ]
                ],
                'Buddy' => [
                    'name' => 'Buddy',
                    'avatar' => 'B',
                    'gradientFrom' => 'green-500',
                    'gradientTo' => 'teal-600',
                    'pillars' => [
                        ['name' => '🏥 Santé', 'score' => 45, 'color' => 'red'],
                        ['name' => '🍽️ Nutrition', 'score' => 88, 'color' => 'blue'],
                        ['name' => '🏃 Activité', 'score' => 60, 'color' => 'orange'],
                        ['name' => '🧠 Mental', 'score' => 75, 'color' => 'purple'],
                        ['name' => '🌡️ Environnement', 'score' => 82, 'color' => 'yellow'],
                        ['name' => '👥 Social', 'score' => 95, 'color' => 'indigo']
                    ]
                ],
                'Luna' => [
                    'name' => 'Luna',
                    'avatar' => 'L',
                    'gradientFrom' => 'pink-500',
                    'gradientTo' => 'rose-600',
                    'pillars' => [
                        ['name' => '🏥 Santé', 'score' => 95, 'color' => 'green'],
                        ['name' => '🍽️ Nutrition', 'score' => 90, 'color' => 'blue'],
                        ['name' => '🏃 Activité', 'score' => 85, 'color' => 'orange'],
                        ['name' => '🧠 Mental', 'score' => 92, 'color' => 'purple'],
                        ['name' => '🌡️ Environnement', 'score' => 88, 'color' => 'yellow'],
                        ['name' => '👥 Social', 'score' => 80, 'color' => 'indigo']
                    ]
                ]
            ],

            // Activités récentes
            'recentActivities' => [
                [
                    'description' => 'Repas donné à <strong>Max</strong>',
                    'time' => 'Il y a 2 heures',
                    'color' => 'green'
                ],
                [
                    'description' => 'Promenade avec <strong>Luna</strong>',
                    'time' => 'Il y a 4 heures',
                    'color' => 'blue'
                ],
                [
                    'description' => 'Médicament donné à <strong>Buddy</strong>',
                    'time' => 'Il y a 6 heures',
                    'color' => 'purple'
                ],
                [
                    'description' => 'Séance de jeu avec <strong>Max</strong>',
                    'time' => 'Hier',
                    'color' => 'orange'
                ]
            ],

            // Rappels
            'reminders' => [
                [
                    'title' => 'Repas du soir - Max',
                    'time' => 'Dans 2 heures',
                    'color' => 'green'
                ],
                [
                    'title' => 'Médicament - Buddy',
                    'time' => 'Dans 4 heures',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Toilettage - Luna',
                    'time' => 'Demain 10h',
                    'color' => 'purple'
                ]
            ],

            // Actions rapides
            'quickActions' => [
                [
                    'label' => 'Ajouter note',
                    'color' => 'purple',
                    'icon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>'
                ],
                [
                    'label' => 'Voir dossiers',
                    'color' => 'orange',
                    'icon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.89.52l1.11 2.18a1 1 0 00.89.53H20a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>'
                ],
                [
                    'label' => 'Planifier RDV',
                    'color' => 'green',
                    'icon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"></path></svg>'
                ],
                [
                    'label' => 'Commander',
                    'color' => 'blue',
                    'icon' => '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>'
                ]
            ],

            // Météo
            'weather' => [
                'temperature' => '32°C',
                'description' => 'Ensoleillé',
                'location' => 'Dubai',
                'iconColor' => 'yellow',
                'icon' => '<svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 8a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
                'alertTitle' => 'Température élevée',
                'alertSubtitle' => 'Risque de stress thermique',
                'alertColor' => 'orange',
                'recommendations' => [
                    [
                        'title' => 'Recommandations',
                        'description' => 'Éviter les sorties entre 11h-16h',
                        'icon' => '⚠️',
                        'color' => 'orange'
                    ],
                    [
                        'title' => 'Hydratation',
                        'description' => 'Vérifier l\'eau fraîche disponible',
                        'icon' => '💧',
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Confort',
                        'description' => 'Privilégier les espaces climatisés',
                        'icon' => '🌡️',
                        'color' => 'green'
                    ]
                ]
            ],

            // Recommandations IA
            'aiRecommendations' => [
                [
                    'title' => 'Optimisation nutrition',
                    'description' => 'Ajuster les portions de Max selon son activité réduite par la chaleur',
                    'fromColor' => 'blue',
                    'toColor' => 'purple',
                    'borderColor' => 'blue',
                    'iconColor' => 'blue',
                    'titleColor' => 'blue',
                    'descriptionColor' => 'blue',
                    'icon' => '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 11-8.9-8.9 5 5 0 018.9 8.9z"></path></svg>'
                ],
                [
                    'title' => 'Suivi Buddy',
                    'description' => 'Programmer un bilan sanguin pour évaluer l\'évolution de l\'arthrite',
                    'fromColor' => 'green',
                    'toColor' => 'teal',
                    'borderColor' => 'green',
                    'iconColor' => 'green',
                    'titleColor' => 'green',
                    'descriptionColor' => 'green',
                    'icon' => '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>'
                ],
                [
                    'title' => 'Planning optimal',
                    'description' => 'Matin idéal pour les activités physiques avec Luna',
                    'fromColor' => 'purple',
                    'toColor' => 'pink',
                    'borderColor' => 'purple',
                    'iconColor' => 'purple',
                    'titleColor' => 'purple',
                    'descriptionColor' => 'purple',
                    'icon' => '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"></path></svg>'
                ]
            ],

            // Planning de la semaine
            'weeklySchedule' => [
                'Aujourd\'hui' => [
                    'color' => 'blue',
                    'items' => [
                        [
                            'title' => 'RDV vétérinaire - Buddy',
                            'time' => '14h00',
                            'icon' => '🏥',
                            'color' => 'red'
                        ],
                        [
                            'title' => 'Repas spécial - Max',
                            'time' => '16h30',
                            'icon' => '🍽️',
                            'color' => 'green'
                        ],
                        [
                            'title' => 'Séance jeu - Luna',
                            'time' => '18h00',
                            'icon' => '🎾',
                            'color' => 'purple'
                        ]
                    ]
                ],
                'Demain' => [
                    'color' => 'purple',
                    'items' => [
                        [
                            'title' => 'Toilettage - Luna',
                            'time' => '10h00',
                            'icon' => '✂️',
                            'color' => 'blue'
                        ],
                        [
                            'title' => 'Promenade - Max & Buddy',
                            'time' => '17h00',
                            'icon' => '🏃',
                            'color' => 'orange'
                        ]
                    ]
                ],
                'Cette semaine' => [
                    'color' => 'green',
                    'items' => [
                        [
                            'title' => 'Contrôle traitement - Buddy',
                            'time' => 'Vendredi',
                            'icon' => '💊',
                            'color' => 'yellow'
                        ],
                        [
                            'title' => 'Livraison croquettes',
                            'time' => 'Samedi',
                            'icon' => '📦',
                            'color' => 'indigo'
                        ]
                    ]
                ]
            ],

            // Statistiques globales
            'wellnessAverage' => '87%',
            'activitiesToday' => 5,
            'pendingReminders' => 3,
            'urgentAlerts' => 1,
            'lastUpdate' => Carbon::now()->format('d/m/Y H:i')
        ];

        return view('dashboard', $data);
    }
}
