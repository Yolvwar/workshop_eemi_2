import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    let currentEvent = null;

    // Configuration du calendrier
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        selectMirror: true,
        editable: true,
        dayMaxEvents: true,

        // Charger les événements
        events: function (fetchInfo, successCallback, failureCallback) {
            fetch(`/calendar/events?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`)
                .then(response => response.json())
                .then(events => successCallback(events))
                .catch(error => failureCallback(error));
        },

        // Sélection d'une plage de dates
        select: function (selectionInfo) {
            openModal();
            document.getElementById('eventStart').value = selectionInfo.startStr.slice(0, 16);
            document.getElementById('eventEnd').value = selectionInfo.endStr.slice(0, 16);
        },

        // Clic sur un événement
        eventClick: function (clickInfo) {
            currentEvent = clickInfo.event;
            openModal(true);

            document.getElementById('eventTitle').value = clickInfo.event.title;
            document.getElementById('eventStart').value = clickInfo.event.startStr.slice(0, 16);
            document.getElementById('eventEnd').value = clickInfo.event.endStr ? clickInfo.event.endStr.slice(0, 16) : '';
            document.getElementById('eventColor').value = clickInfo.event.backgroundColor || '#3788d8';
            document.getElementById('eventAllDay').checked = clickInfo.event.allDay;
        },

        // Déplacer un événement
        eventDrop: function (dropInfo) {
            updateEvent(dropInfo.event);
        },

        // Redimensionner un événement
        eventResize: function (resizeInfo) {
            updateEvent(resizeInfo.event);
        }
    });

    calendar.render();

    // Gestion du formulaire
    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const eventData = {
            title: document.getElementById('eventTitle').value,
            start: document.getElementById('eventStart').value,
            end: document.getElementById('eventEnd').value,
            color: document.getElementById('eventColor').value,
            all_day: document.getElementById('eventAllDay').checked
        };

        if (currentEvent) {
            // Mise à jour
            updateEventAPI(currentEvent.id, eventData);
        } else {
            // Création
            createEvent(eventData);
        }
    });

    // Suppression d'événement
    document.getElementById('deleteBtn').addEventListener('click', function () {
        if (currentEvent && confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
            deleteEvent(currentEvent.id);
        }
    });

    // Fonctions utilitaires
    function openModal(isEdit = false) {
        document.getElementById('eventModal').classList.remove('hidden');
        document.getElementById('modalTitle').textContent = isEdit ? 'Modifier l\'événement' : 'Ajouter un événement';
        document.getElementById('deleteBtn').classList.toggle('hidden', !isEdit);

        if (!isEdit) {
            document.getElementById('eventForm').reset();
            document.getElementById('eventColor').value = '#3788d8';
            currentEvent = null;
        }
    }

    window.closeModal = function () {
        document.getElementById('eventModal').classList.add('hidden');
        currentEvent = null;
    }

    function createEvent(eventData) {
        fetch('/calendar/events', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(eventData)
        })
            .then(response => response.json())
            .then(event => {
                calendar.addEvent(event);
                closeModal();
            })
            .catch(error => console.error('Erreur:', error));
    }

    function updateEventAPI(eventId, eventData) {
        fetch(`/calendar/events/${eventId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(eventData)
        })
            .then(response => response.json())
            .then(event => {
                currentEvent.setProp('title', event.title);
                currentEvent.setStart(event.start);
                currentEvent.setEnd(event.end);
                currentEvent.setProp('backgroundColor', event.color);
                closeModal();
            })
            .catch(error => console.error('Erreur:', error));
    }

    function updateEvent(event) {
        const eventData = {
            title: event.title,
            start: event.startStr,
            end: event.endStr,
            color: event.backgroundColor,
            all_day: event.allDay
        };

        updateEventAPI(event.id, eventData);
    }

    function deleteEvent(eventId) {
        fetch(`/calendar/events/${eventId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(() => {
                currentEvent.remove();
                closeModal();
            })
            .catch(error => console.error('Erreur:', error));
    }
});