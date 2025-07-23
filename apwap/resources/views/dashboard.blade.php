@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-8">
        <x-dashboard.overview-cards 
            :pets="$pets ?? null"
            :appointments="$appointments ?? null" 
            :orders="$orders ?? null"
        />
    </div>
    
    <div class="mb-8">
        <x-dashboard.analytics :petsAnalytics="$petsAnalytics ?? null" />
    </div>
    
    <div class="mb-8">
        <x-dashboard.planning :weeklySchedule="$weeklySchedule ?? null" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <x-dashboard.weather :weather="$weather ?? null" />
        <x-dashboard.ai-recommendations :aiRecommendations="$aiRecommendations ?? null" />
    </div>
    
    <div class="mb-8">
        <x-dashboard.quick-actions :quickActions="$quickActions ?? null" />
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const progressBars = document.querySelectorAll('.bg-green-500, .bg-blue-500, .bg-orange-500, .bg-purple-500, .bg-yellow-500, .bg-indigo-500, .bg-red-500');
        
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
                bar.style.transition = 'width 1s ease-in-out';
            }, 100);
        });
    });

</script>
@endpush

@push('styles')
<style>
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }

    .hover-scale:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease-in-out;
    }

    .gradient-text {
        background: linear-gradient(45deg, #10b981, #3b82f6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
</push>

