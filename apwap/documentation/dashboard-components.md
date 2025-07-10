# Documentation des Composants Dashboard

Cette documentation explique comment utiliser les composants Blade créés pour modulariser le dashboard.

## Structure des Composants

Tous les composants sont situés dans `/resources/views/components/dashboard/` :

- `overview-cards.blade.php` - Cards de résumé (animaux, RDV, commandes)
- `alerts.blade.php` - Alertes et priorités
- `analytics.blade.php` - Analytics des 6 piliers
- `recent-activities.blade.php` - Timeline des activités récentes
- `reminders.blade.php` - Rappels à venir
- `quick-actions.blade.php` - Actions rapides
- `weather.blade.php` - Météo et impact environnemental
- `ai-recommendations.blade.php` - Recommandations IA
- `planning.blade.php` - Planning de la semaine
- `footer-stats.blade.php` - Statistiques globales

## Utilisation dans le Dashboard

### 1. Vue d'ensemble - Overview Cards

```blade
<x-dashboard.overview-cards 
    :pets="$pets ?? null"
    :appointments="$appointments ?? null" 
    :orders="$orders ?? null"
/>
```

**Données attendues :**
```php
$pets = [
    'count' => 3,
    'activeCount' => 3,
    'wellnessScore' => 87
];

$appointments = [
    'todayCount' => 2,
    'nextAppointments' => ['14h00', '16h30'],
    'status' => 'Aujourd\'hui'
];

$orders = [
    'pendingCount' => 1,
    'deliveryInfo' => 'Livraison 2j',
    'trackingStatus' => 'Tracking actif'
];
```

### 2. Alertes

```blade
<x-dashboard.alerts :alerts="$alerts ?? null" />
```

**Données attendues :**
```php
$alerts = [
    [
        'type' => 'urgent',
        'color' => 'red',
        'icon' => '🔴',
        'title' => 'URGENT: Buddy - Arthrite aggravée',
        'description' => 'Consultation recommandée sous 48h',
        'timeframe' => 'Sous 48h',
        'action' => 'Prendre RDV maintenant'
    ],
    // ... autres alertes
];
```

### 3. Analytics des 6 Piliers

```blade
<x-dashboard.analytics :petsAnalytics="$petsAnalytics ?? null" />
```

**Données attendues :**
```php
$petsAnalytics = [
    'Max' => [
        'name' => 'Max',
        'avatar' => 'M',
        'gradientFrom' => 'blue-500',
        'gradientTo' => 'purple-600',
        'pillars' => [
            ['name' => '🏥 Santé', 'score' => 85, 'color' => 'green'],
            ['name' => '🍽️ Nutrition', 'score' => 92, 'color' => 'blue'],
            // ... autres piliers
        ]
    ],
    // ... autres animaux
];
```

### 4. Activités Récentes

```blade
<x-dashboard.recent-activities :activities="$recentActivities ?? null" />
```

**Données attendues :**
```php
$recentActivities = [
    [
        'description' => 'Repas donné à <strong>Max</strong>',
        'time' => 'Il y a 2 heures',
        'color' => 'green'
    ],
    // ... autres activités
];
```

### 5. Rappels

```blade
<x-dashboard.reminders :reminders="$reminders ?? null" />
```

**Données attendues :**
```php
$reminders = [
    [
        'title' => 'Repas du soir - Max',
        'time' => 'Dans 2 heures',
        'color' => 'green'
    ],
    // ... autres rappels
];
```

### 6. Actions Rapides

```blade
<x-dashboard.quick-actions :quickActions="$quickActions ?? null" />
```

**Données attendues :**
```php
$quickActions = [
    [
        'label' => 'Ajouter note',
        'color' => 'purple',
        'icon' => '<svg>...</svg>' // SVG icon
    ],
    // ... autres actions
];
```

### 7. Météo

```blade
<x-dashboard.weather :weather="$weather ?? null" />
```

**Données attendues :**
```php
$weather = [
    'temperature' => '32°C',
    'description' => 'Ensoleillé',
    'location' => 'Dubai',
    'iconColor' => 'yellow',
    'icon' => '<svg>...</svg>',
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
        // ... autres recommandations
    ]
];
```

### 8. Recommandations IA

```blade
<x-dashboard.ai-recommendations :aiRecommendations="$aiRecommendations ?? null" />
```

**Données attendues :**
```php
$aiRecommendations = [
    [
        'title' => 'Optimisation nutrition',
        'description' => 'Ajuster les portions...',
        'fromColor' => 'blue',
        'toColor' => 'purple',
        'borderColor' => 'blue',
        'iconColor' => 'blue',
        'titleColor' => 'blue',
        'descriptionColor' => 'blue',
        'icon' => '<svg>...</svg>'
    ],
    // ... autres recommandations
];
```

### 9. Planning

```blade
<x-dashboard.planning :weeklySchedule="$weeklySchedule ?? null" />
```

**Données attendues :**
```php
$weeklySchedule = [
    'Aujourd\'hui' => [
        'color' => 'blue',
        'items' => [
            [
                'title' => 'RDV vétérinaire - Buddy',
                'time' => '14h00',
                'icon' => '🏥',
                'color' => 'red'
            ],
            // ... autres événements
        ]
    ],
    // ... autres jours
];
```

### 10. Footer avec Statistiques

```blade
<x-dashboard.footer-stats 
    :wellnessAverage="$wellnessAverage ?? null"
    :activitiesToday="$activitiesToday ?? null"
    :pendingReminders="$pendingReminders ?? null"
    :urgentAlerts="$urgentAlerts ?? null"
    :lastUpdate="$lastUpdate ?? null"
/>
```

**Données attendues :**
```php
$wellnessAverage = '87%';
$activitiesToday = 5;
$pendingReminders = 3;
$urgentAlerts = 1;
$lastUpdate = '01/12/2024 14:30';
```

## Contrôleur de Dashboard

Le `DashboardController` fourni dans `/app/Http/Controllers/DashboardController.php` contient un exemple complet de données pour alimenter tous les composants.

## Couleurs Tailwind Supportées

Les composants supportent les couleurs Tailwind CSS suivantes :
- `red`, `yellow`, `green`, `blue`, `purple`, `pink`, `indigo`, `orange`, `teal`, `emerald`, `gray`

## Personnalisation

### Ajout de nouveaux composants

1. Créer un nouveau fichier dans `/resources/views/components/dashboard/`
2. Utiliser la convention de nommage Blade `<x-dashboard.nom-composant>`
3. Passer les données depuis le contrôleur

### Modification des styles

Tous les composants utilisent les classes Tailwind CSS avec le thème iOS moderne :
- Couleurs douces et arrondies
- Ombres subtiles
- Espacements cohérents
- Animations fluides

### Données par défaut

Chaque composant inclut des données par défaut qui s'affichent si aucune donnée n'est passée depuis le contrôleur, permettant un développement et des tests facilités.

## Configuration de la Route

Assurez-vous d'avoir la route configurée dans `/routes/web.php` :

```php
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
```

## Performance et Optimisation

- Les composants sont légers et optimisés
- Les données sont passées uniquement si nécessaire
- Utilisez la mise en cache pour les données qui changent peu (météo, analytics)
- Implémentez la mise à jour en temps réel avec Livewire ou du JavaScript pour les données dynamiques

## Extensions Possibles

1. **Livewire** : Convertir les composants en composants Livewire pour l'interactivité
2. **Vue.js** : Intégrer Vue.js pour des animations avancées
3. **WebSockets** : Mise à jour en temps réel des données
4. **API** : Connecter à des APIs externes (météo, IoT, etc.)
5. **Progressive Web App** : Transformer en PWA pour mobile
