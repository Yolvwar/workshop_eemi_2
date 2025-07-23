@extends('layouts.app')

@section('title', 'Téléconsultation')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">💻 Téléconsultation avec {{ $consultation->veterinarian->name }}</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span id="consultation-status" class="flex items-center">
                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                            EN DIRECT
                        </span>
                        <span id="consultation-timer">--:-- restantes</span>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button id="extend-consultation" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        ⏰ Prolonger +10min
                    </button>
                    <button id="end-consultation" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                        🔚 Terminer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Zone vidéo principale -->
            <div class="lg:col-span-3">
                <div class="bg-black rounded-lg overflow-hidden aspect-video relative">
                    <!-- Vidéo du vétérinaire -->
                    <div id="veterinarian-video" class="w-full h-full bg-gray-800 flex items-center justify-center">
                        <div class="text-center text-white">
                            <div class="text-6xl mb-4">👨‍⚕️</div>
                            <p class="text-lg">{{ $consultation->veterinarian->name }}</p>
                            <p class="text-sm text-gray-300">Connexion en cours...</p>
                        </div>
                    </div>
                    
                    <!-- Votre vidéo (petite fenêtre) -->
                    <div id="user-video" class="absolute bottom-4 right-4 w-32 h-24 bg-gray-700 rounded-lg border-2 border-white overflow-hidden">
                        <div class="w-full h-full bg-gray-600 flex items-center justify-center text-white text-xs">
                            Votre vidéo
                        </div>
                    </div>

                    <!-- Contrôles vidéo -->
                    <div class="absolute bottom-4 left-4 flex space-x-2">
                        <button id="toggle-mic" class="w-10 h-10 bg-gray-800 bg-opacity-75 rounded-full flex items-center justify-center text-white hover:bg-opacity-100 transition-opacity">
                            🎤
                        </button>
                        <button id="toggle-camera" class="w-10 h-10 bg-gray-800 bg-opacity-75 rounded-full flex items-center justify-center text-white hover:bg-opacity-100 transition-opacity">
                            📷
                        </button>
                        <button id="take-photo" class="w-10 h-10 bg-gray-800 bg-opacity-75 rounded-full flex items-center justify-center text-white hover:bg-opacity-100 transition-opacity">
                            📸
                        </button>
                    </div>
                </div>

                <!-- Citation du vétérinaire -->
                <div class="mt-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                    <div class="flex items-start space-x-3">
                        <div class="text-2xl">👨‍⚕️</div>
                        <div>
                            <p id="vet-message" class="text-blue-800 font-medium">
                                "Montrez-moi comment {{ $consultation->pet->name }} mange. La posture est importante pour détecter l'inconfort."
                            </p>
                            <p class="text-blue-600 text-sm mt-1">{{ $consultation->veterinarian->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar d'information -->
            <div class="space-y-6">
                <!-- Info consultation -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🎯 Consultation {{ ucfirst($consultation->type) }} {{ $consultation->pet->name }}</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Symptômes signalés:</span>
                            <p class="text-gray-600">{{ $consultation->symptoms_description ?? 'Aucun symptôme spécifique mentionné' }}</p>
                        </div>
                        @if($consultation->pet->weight)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Poids actuel:</span>
                            <span class="font-medium">{{ $consultation->pet->weight }}kg</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Température:</span>
                            <span class="font-medium">38.5°C (normale)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Activité:</span>
                            <span class="font-medium">Normale ce matin</span>
                        </div>
                    </div>
                </div>

                <!-- Chat -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">💬 Chat & Outils</h3>
                    
                    <!-- Messages -->
                    <div id="chat-messages" class="h-48 overflow-y-auto border border-gray-200 rounded-lg p-3 mb-4 text-sm">
                        <div class="mb-2">
                            <span class="font-medium text-blue-600">Dr. {{ $consultation->veterinarian->name }}:</span>
                            <p class="text-gray-700">Bonjour ! Je suis ravi de pouvoir vous aider aujourd'hui avec {{ $consultation->pet->name }}.</p>
                        </div>
                        <div class="mb-2">
                            <span class="font-medium text-blue-600">Dr. {{ $consultation->veterinarian->name }}:</span>
                            <p class="text-gray-700">📝 J'ai noté les symptômes. C'est très léger selon vos descriptions.</p>
                        </div>
                        <div class="mb-2 text-center text-gray-500 text-xs">
                            📋 Questionnaire digestif envoyé
                        </div>
                        <div class="mb-2 text-center text-gray-500 text-xs">
                            📸 Photos du comportement demandées
                        </div>
                        <div class="mb-2 text-center text-gray-500 text-xs">
                            💊 Prescription en cours de préparation
                        </div>
                    </div>

                    <!-- Zone de saisie -->
                    <div class="flex space-x-2">
                        <input type="text" 
                               id="chat-input" 
                               placeholder="Tapez votre message..."
                               class="flex-1 border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                        <button id="send-message" class="bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 transition-colors text-sm">
                            📤
                        </button>
                    </div>
                </div>

                <!-- Outils rapides -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🛠️ Outils</h3>
                    <div class="space-y-2">
                        <button class="w-full text-left px-3 py-2 text-sm bg-gray-50 hover:bg-gray-100 rounded-md transition-colors">
                            📋 Questionnaire santé
                        </button>
                        <button class="w-full text-left px-3 py-2 text-sm bg-gray-50 hover:bg-gray-100 rounded-md transition-colors">
                            📸 Prendre photo
                        </button>
                        <button class="w-full text-left px-3 py-2 text-sm bg-gray-50 hover:bg-gray-100 rounded-md transition-colors">
                            📄 Partager documents
                        </button>
                        <button class="w-full text-left px-3 py-2 text-sm bg-gray-50 hover:bg-gray-100 rounded-md transition-colors">
                            🏥 Programmer visite
                        </button>
                    </div>
                </div>

                <!-- Urgence -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-red-800 mb-2">🚨 Urgence</h3>
                    <p class="text-red-700 text-sm mb-3">Si la situation devient urgente, cliquez ici pour une intervention immédiate.</p>
                    <button class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors text-sm font-medium">
                        🚑 Demander urgence
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const consultationDuration = {{ $consultation->duration_minutes ?? 20 }};
    const startTime = new Date('{{ $consultation->started_at ?? now() }}');
    const timerElement = document.getElementById('consultation-timer');
    
    function updateTimer() {
        const now = new Date();
        const elapsed = Math.floor((now - startTime) / 1000 / 60);
        const remaining = consultationDuration - elapsed;
        
        if (remaining > 0) {
            timerElement.textContent = `${remaining} min restantes`;
        } else {
            timerElement.textContent = 'Temps dépassé';
            timerElement.classList.add('text-red-600', 'font-bold');
        }
    }
    
    updateTimer();
    setInterval(updateTimer, 60000);
    
    const chatInput = document.getElementById('chat-input');
    const sendButton = document.getElementById('send-message');
    const chatMessages = document.getElementById('chat-messages');
    
    function sendMessage() {
        const message = chatInput.value.trim();
        if (message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'mb-2';
            messageDiv.innerHTML = `
                <span class="font-medium text-gray-900">Vous:</span>
                <p class="text-gray-700">${message}</p>
            `;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            fetch('{{ route("consultations.teleconsultation.chat", $consultation) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            });
            
            chatInput.value = '';
        }
    }
    
    sendButton.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    let micEnabled = true;
    let cameraEnabled = true;
    
    document.getElementById('toggle-mic').addEventListener('click', function() {
        micEnabled = !micEnabled;
        this.style.backgroundColor = micEnabled ? 'rgba(0,0,0,0.75)' : 'rgba(239,68,68,0.75)';
        this.textContent = micEnabled ? '🎤' : '🔇';
    });
    
    document.getElementById('toggle-camera').addEventListener('click', function() {
        cameraEnabled = !cameraEnabled;
        this.style.backgroundColor = cameraEnabled ? 'rgba(0,0,0,0.75)' : 'rgba(239,68,68,0.75)';
        this.textContent = cameraEnabled ? '📷' : '📹';
        
        const userVideo = document.getElementById('user-video');
        if (!cameraEnabled) {
            userVideo.innerHTML = '<div class="w-full h-full bg-gray-800 flex items-center justify-center text-white text-xs">Caméra désactivée</div>';
        }
    });
    
    document.getElementById('extend-consultation').addEventListener('click', function() {
        if (confirm('Prolonger la consultation de 10 minutes ?')) {
            fetch('{{ route("consultations.teleconsultation.extend", $consultation) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    alert('Consultation prolongée de 10 minutes');
                    location.reload();
                }
            });
        }
    });
    
    document.getElementById('end-consultation').addEventListener('click', function() {
        if (confirm('Voulez-vous vraiment terminer la consultation ?')) {
            fetch('{{ route("consultations.complete", $consultation) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    window.location.href = '{{ route("consultations.show", $consultation) }}';
                }
            });
        }
    });
    
    setTimeout(() => {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'mb-2';
        messageDiv.innerHTML = `
            <span class="font-medium text-blue-600">Dr. {{ $consultation->veterinarian->name }}:</span>
            <p class="text-gray-700">Je vois que {{ $consultation->pet->name }} semble en bonne forme générale. Pouvez-vous me montrer comment il se comporte quand il mange ?</p>
        `;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }, 5000);
});
</script>
@endsection
