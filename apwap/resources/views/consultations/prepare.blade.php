@extends('layouts.app')

@section('title', 'Préparation Consultation')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('consultations.index') }}" class="text-gray-600 hover:text-gray-800">
                ← Retour aux consultations
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mt-4">📋 Préparation RDV {{ $consultation->pet->name }}</h1>
        <div class="text-gray-600 mt-2">
            📅 {{ $consultation->scheduled_at->format('l j F Y \à H\hi') }} • 
            @if($consultation->mode === 'home_visit')
                🏠 À domicile
            @elseif($consultation->mode === 'teleconsultation')
                💻 Téléconsultation
            @else
                🏥 APWAP Clinic JLT
            @endif
            • 👨‍⚕️ {{ $consultation->veterinarian->name }}
        </div>
    </div>

    <form action="{{ route('consultations.prepare.save', $consultation) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Documents Obligatoires -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">✅ Documents Obligatoires</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($checklist['documents'] as $key => $label)
                        <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                            <input type="checkbox" 
                                   id="doc_{{ $key }}" 
                                   name="documents[{{ $key }}]" 
                                   value="1"
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="doc_{{ $key }}" class="flex-1 text-gray-700">
                                ✅ {{ $label }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Questionnaire Complété -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">📝 Questionnaire Complété</h2>
            </div>
            <div class="p-6 space-y-6">
                @foreach($checklist['questionnaire'] as $key => $label)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center space-x-3 mb-3">
                            <input type="checkbox" 
                                   id="quest_{{ $key }}" 
                                   name="questionnaire[{{ $key }}]" 
                                   value="1"
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="quest_{{ $key }}" class="font-medium text-gray-900">
                                ✅ {{ $label }}
                            </label>
                        </div>
                        <textarea name="questionnaire_details[{{ $key }}]" 
                                  rows="3" 
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Décrivez en détail..."></textarea>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Médias Préparés -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">📸 Médias Préparés</h2>
                <p class="text-gray-600 text-sm mt-1">Téléchargez photos et vidéos qui pourraient aider le vétérinaire</p>
            </div>
            <div class="p-6 space-y-6">
                @foreach($checklist['media'] as $key => $label)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center space-x-3 mb-3">
                            <input type="checkbox" 
                                   id="media_{{ $key }}" 
                                   name="media[{{ $key }}]" 
                                   value="1"
                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="media_{{ $key }}" class="font-medium text-gray-900">
                                ✅ {{ $label }}
                            </label>
                        </div>
                        <input type="file" 
                               name="media_files[{{ $key }}][]" 
                               multiple 
                               accept="image/*,video/*"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-gray-500 text-xs mt-1">Formats acceptés: JPG, PNG, MP4, MOV (max 10MB par fichier)</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Médicaments & Suppléments -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">💊 Médicaments & Suppléments</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="current_medications" class="block text-sm font-medium text-gray-700 mb-2">
                        ✅ Liste complète actuelle
                    </label>
                    <textarea name="current_medications" 
                              id="current_medications"
                              rows="3" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Listez tous les médicaments et suppléments actuels avec les dosages..."></textarea>
                </div>

                <div>
                    <label for="medication_schedule" class="block text-sm font-medium text-gray-700 mb-2">
                        ✅ Posologie et horaires
                    </label>
                    <textarea name="medication_schedule" 
                              id="medication_schedule"
                              rows="3" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Détaillez les horaires de prise et les dosages..."></textarea>
                </div>

                <div>
                    <label for="medication_effects" class="block text-sm font-medium text-gray-700 mb-2">
                        ✅ Effets observés
                    </label>
                    <textarea name="medication_effects" 
                              id="medication_effects"
                              rows="3" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Décrivez les effets positifs ou secondaires observés..."></textarea>
                </div>

                <div>
                    <label for="medication_questions" class="block text-sm font-medium text-gray-700 mb-2">
                        ✅ Questions spécifiques
                    </label>
                    <textarea name="medication_questions" 
                              id="medication_questions"
                              rows="3" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Questions que vous souhaitez poser au vétérinaire concernant les médicaments..."></textarea>
                </div>
            </div>
        </div>

        <!-- Objectifs Consultation -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">🎯 Objectifs Consultation</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <input type="checkbox" 
                               id="obj_evaluation" 
                               name="objectives[evaluation]" 
                               value="1"
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="obj_evaluation" class="text-gray-700">
                            ✅ Évaluation nutritionnelle
                        </label>
                    </div>
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <input type="checkbox" 
                               id="obj_climate" 
                               name="objectives[climate]" 
                               value="1"
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="obj_climate" class="text-gray-700">
                            ✅ Adaptation climat Dubai
                        </label>
                    </div>
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <input type="checkbox" 
                               id="obj_digestion" 
                               name="objectives[digestion]" 
                               value="1"
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="obj_digestion" class="text-gray-700">
                            ✅ Optimisation digestion
                        </label>
                    </div>
                    <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                        <input type="checkbox" 
                               id="obj_preventive" 
                               name="objectives[preventive]" 
                               value="1"
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="obj_preventive" class="text-gray-700">
                            ✅ Planning soins préventifs
                        </label>
                    </div>
                </div>

                <div>
                    <label for="custom_objectives" class="block text-sm font-medium text-gray-700 mb-2">
                        Objectifs personnalisés
                    </label>
                    <textarea name="custom_objectives" 
                              id="custom_objectives"
                              rows="3" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Autres points que vous souhaitez aborder pendant la consultation..."></textarea>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        ⏰ Temps restant: <span id="countdown" class="font-medium"></span>
                    </div>
                    <div class="flex space-x-4">
                        <button type="button" class="text-blue-600 hover:text-blue-700 font-medium" onclick="sendToVeterinarian()">
                            📧 Envoyer au vétérinaire
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors font-medium">
                            💾 Sauvegarder Préparation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const consultationTime = new Date('{{ $consultation->scheduled_at->toISOString() }}');
    const countdownElement = document.getElementById('countdown');
    
    function updateCountdown() {
        const now = new Date();
        const timeDiff = consultationTime - now;
        
        if (timeDiff > 0) {
            const hours = Math.floor(timeDiff / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            
            if (hours > 24) {
                const days = Math.floor(hours / 24);
                countdownElement.textContent = `${days} jour(s) ${hours % 24}h ${minutes}min`;
            } else {
                countdownElement.textContent = `${hours}h ${minutes}min`;
            }
        } else {
            countdownElement.textContent = 'Consultation en cours ou passée';
        }
    }
    
    updateCountdown();
    setInterval(updateCountdown, 60000);
    
    let autoSaveTimer;
    const form = document.querySelector('form');
    const formElements = form.querySelectorAll('input, textarea, select');
    
    formElements.forEach(element => {
        element.addEventListener('change', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(autoSave, 2000);
        });
    });
    
    function autoSave() {
        const formData = new FormData(form);
        formData.append('auto_save', '1');
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                showNotification('Préparation sauvegardée automatiquement', 'success');
            }
        }).catch(error => {
            console.error('Auto-save failed:', error);
        });
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});

function sendToVeterinarian() {
    if (confirm('Voulez-vous envoyer cette préparation au vétérinaire ?')) {
        const form = document.querySelector('form');
        const formData = new FormData(form);
        formData.append('send_to_vet', '1');
        
        fetch('{{ route("consultations.prepare.send", $consultation) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                alert('Préparation envoyée au vétérinaire avec succès !');
            } else {
                alert('Erreur lors de l\'envoi. Veuillez réessayer.');
            }
        }).catch(error => {
            console.error('Send failed:', error);
            alert('Erreur lors de l\'envoi. Veuillez réessayer.');
        });
    }
}
</script>
@endsection
