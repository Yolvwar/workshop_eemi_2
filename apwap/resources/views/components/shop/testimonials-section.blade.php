@props(['testimonials'])

<div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 mb-8">
    <h2 class="text-2xl font-semibold mb-6 flex items-center">
        💬 Témoignages clients
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($testimonials as $testimonial)
        <div class="bg-white/20 backdrop-blur-md rounded-xl p-4">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                    {{ substr($testimonial['name'], 0, 1) }}
                </div>
                <div>
                    <h4 class="font-semibold">{{ $testimonial['name'] }}</h4>
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < $testimonial['rating']; $i++)
                        ⭐
                        @endfor
                    </div>
                </div>
            </div>
            <p class="text-sm opacity-70">{{ $testimonial['comment'] }}</p>
        </div>
        @endforeach
    </div>
</div>
