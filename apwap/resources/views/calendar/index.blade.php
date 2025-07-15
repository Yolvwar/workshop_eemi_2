@extends('layouts.app')
@section('title', 'Mon Calendrier')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Mon Calendrier</h1>

        <!-- Calendrier -->
        <div id="calendar" class="bg-white rounded-lg shadow-lg p-4 relative z-10"></div>

        <!-- Modal pour ajouter/éditer un événement -->
        <div id="eventModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-[9999]">
            <div
                class="bg-white p-6 rounded-lg w-96 max-w-md mx-4 shadow-xl relative z-[10000] max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-xl font-bold mb-4">Ajouter un événement</h2>

                <form id="eventForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                        <input type="text" id="eventTitle"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                        <input type="datetime-local" id="eventStart"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                        <input type="datetime-local" id="eventEnd"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                        <input type="color" id="eventColor"
                            class="w-full h-10 p-1 border border-gray-300 rounded-lg cursor-pointer" value="#3788d8">
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="eventAllDay"
                                class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Toute la journée</span>
                        </label>
                    </div>

                    <div class="flex gap-2 justify-end">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                            Annuler
                        </button>
                        <button type="button" id="deleteBtn"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 hidden transition-colors">
                            Supprimer
                        </button>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Forcer le z-index de la modal */
        #eventModal {
            z-index: 9999 !important;
        }

        #eventModal>div {
            z-index: 10000 !important;
        }

        /* Réduire le z-index du calendrier si nécessaire */
        .fc {
            z-index: 1 !important;
        }

        /* S'assurer que les éléments FullCalendar ne dépassent pas */
        .fc-popover {
            z-index: 9998 !important;
        }

        .fc-daygrid-event {
            z-index: 1 !important;
        }

        /* Améliorer l'apparence de l'input color */
        input[type="color"] {
            -webkit-appearance: none;
            border: none;
            cursor: pointer;
        }

        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
        }

        input[type="color"]::-webkit-color-swatch {
            border: none;
            border-radius: 4px;
        }
    </style>
@endsection