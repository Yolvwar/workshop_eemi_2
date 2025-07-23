@extends('layouts.app')
@section('title', 'Mon Calendrier')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <x-heroicon-o-calendar class="w-8 h-8 text-emerald-600" />
                        Mon Calendrier
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ now()->format('F Y') }} • {{ $events->count() }} événement(s)
                    </p>
                </div>
                <button onclick="openModal()"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center gap-2">
                    <x-heroicon-o-plus-circle class="w-5 h-5" />
                    Nouvel Événement
                </button>
            </div>

            <!-- Calendrier -->
            <div id="calendar" class="bg-white rounded-2xl shadow-lg p-6 relative"></div>

            <!-- Modal -->
            <div id="eventModal"
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden relative z-[60]">

                    <!-- En-tête Modal -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h2 id="modalTitle" class="text-xl font-semibold text-gray-900">Nouvel Événement</h2>
                    </div>

                    <!-- Corps Modal -->
                    <form id="eventForm" class="p-6 space-y-6">
                        <div>
                            <label for="eventTitle" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                            <input type="text" id="eventTitle" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                        </div>

                        <div>
                            <label for="eventStart" class="block text-sm font-medium text-gray-700 mb-1">Date de
                                début</label>
                            <input type="datetime-local" id="eventStart" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                        </div>

                        <div>
                            <label for="eventEnd" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                            <input type="datetime-local" id="eventEnd"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors">
                        </div>

                        <div>
                            <label for="eventColor" class="block text-sm font-medium text-gray-700 mb-1">Couleur</label>
                            <input type="color" id="eventColor" value="#10B981"
                                class="w-full h-10 rounded-xl cursor-pointer">
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="eventAllDay"
                                class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <label for="eventAllDay" class="ml-2 text-sm text-gray-700">
                                Toute la journée
                            </label>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                            <button type="button" onclick="closeModal()"
                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors">
                                Annuler
                            </button>
                            <button type="button" id="deleteBtn"
                                class="hidden px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors">
                                <x-heroicon-o-trash class="w-5 h-5" />
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-colors">
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'fr',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    buttonText: {
                        today: 'Aujourd\'hui',
                        month: 'Mois',
                        week: 'Semaine',
                        day: 'Jour'
                    },
                    events: @json($events),
                    editable: true,
                    eventClick: function (info) {
                        // Gestion du clic sur un événement
                    },
                    dateClick: function (info) {
                        openModal();
                        document.getElementById('eventStart').value = info.dateStr + 'T00:00';
                    }
                });
                calendar.render();
            });

            function openModal() {
                document.getElementById('eventModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('eventModal').classList.add('hidden');
                document.getElementById('eventForm').reset();
            }
        </script>
    @endpush

    @push('styles')
        <style>
            .fc {
                font-family: inherit;
            }

            .fc .fc-button-primary {
                @apply bg-emerald-600 border-emerald-600 shadow-sm hover:bg-emerald-700 hover:border-emerald-700 transition-colors;
            }

            .fc .fc-button-primary:disabled {
                @apply bg-emerald-400 border-emerald-400;
            }

            .fc .fc-button-primary:not(:disabled):active,
            .fc .fc-button-primary:not(:disabled).fc-button-active {
                @apply bg-emerald-700 border-emerald-700;
            }

            .fc .fc-daygrid-day.fc-day-today {
                @apply bg-emerald-50;
            }

            .fc .fc-highlight {
                @apply bg-emerald-100;
            }

            .fc .fc-toolbar-title {
                @apply text-xl font-semibold text-gray-900;
            }

            input[type="color"] {
                -webkit-appearance: none;
                border: none;
            }

            input[type="color"]::-webkit-color-swatch-wrapper {
                padding: 0;
            }

            input[type="color"]::-webkit-color-swatch {
                border: none;
                border-radius: 0.75rem;
            }
        </style>
    @endpush
@endsection