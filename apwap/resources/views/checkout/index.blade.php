@extends('layouts.shop')

@section('title', 'Commande - Boutique APWAP')
@section('page-title', 'Finaliser ma commande')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Progress bar -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                        <span class="text-sm font-medium text-emerald-600">Panier</span>
                    </div>
                    <div class="flex-1 h-1 bg-emerald-200 mx-4 rounded-full">
                        <div class="h-1 bg-emerald-600 rounded-full" style="width: 50%"></div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-medium">2</div>
                        <span class="text-sm font-medium text-emerald-600">Commande</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-4 rounded-full"></div>
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">3</div>
                        <span class="text-sm font-medium text-gray-600">Confirmation</span>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Formulaire de commande -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Informations de livraison -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            🚚 Informations de Livraison
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                                <input type="text" name="shipping_first_name" value="{{ auth()->user()->first_name }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                                <input type="text" name="shipping_last_name" value="{{ auth()->user()->last_name }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="shipping_email" value="{{ auth()->user()->email }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse ligne 1 *</label>
                                <input type="text" name="shipping_address_line_1" placeholder="Numéro et nom de rue" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse ligne 2</label>
                                <input type="text" name="shipping_address_line_2" placeholder="Appartement, bâtiment, étage..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                                <select name="shipping_city" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="Dubai" selected>Dubai</option>
                                    <option value="Abu Dhabi">Abu Dhabi</option>
                                    <option value="Sharjah">Sharjah</option>
                                    <option value="Ajman">Ajman</option>
                                    <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                                    <option value="Fujairah">Fujairah</option>
                                    <option value="Umm Al Quwain">Umm Al Quwain</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                                <input type="text" name="shipping_postal_code" placeholder="00000"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pays *</label>
                                <select name="shipping_country" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="UAE" selected>Émirats Arabes Unis</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                                <input type="tel" name="shipping_phone" value="{{ auth()->user()->phone }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Instructions de livraison</label>
                                <textarea name="delivery_notes" rows="3" placeholder="Instructions spéciales pour le livreur..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Options de livraison -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            📦 Options de Livraison
                        </h2>
                        
                        <div class="space-y-4">
                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                <input type="radio" name="delivery_type" value="standard" class="mt-1 text-emerald-600" checked>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">Livraison standard</span>
                                        <span class="font-semibold text-gray-900">{{ $cart->subtotal >= 500 ? 'Gratuite' : '25 AED' }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Livraison demain entre 9h et 18h</p>
                                </div>
                            </label>
                            
                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                <input type="radio" name="delivery_type" value="express" class="mt-1 text-emerald-600">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">Livraison express</span>
                                        <span class="font-semibold text-gray-900">50 AED</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Livraison aujourd'hui entre 14h et 16h</p>
                                </div>
                            </label>
                            
                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                <input type="radio" name="delivery_type" value="scheduled" class="mt-1 text-emerald-600">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">Livraison programmée</span>
                                        <span class="font-semibold text-gray-900">Gratuite</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Choisissez votre créneau (vendredi 10h-12h)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Méthode de paiement -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            💳 Méthode de Paiement
                        </h2>
                        
                        <div class="space-y-4">
                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                <input type="radio" name="payment_method" value="card" class="mt-1 text-emerald-600" checked>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">💳 Carte bancaire</span>
                                        <div class="flex space-x-2">
                                            <img src="/images/visa.png" alt="Visa" class="h-6">
                                            <img src="/images/mastercard.png" alt="Mastercard" class="h-6">
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Paiement sécurisé SSL</p>
                                </div>
                            </label>
                            
                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                <input type="radio" name="payment_method" value="apple_pay" class="mt-1 text-emerald-600">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">🍎 Apple Pay</span>
                                        <span class="text-sm text-gray-600">Rapide et sécurisé</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Touch ID ou Face ID</p>
                                </div>
                            </label>
                            
                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                <input type="radio" name="payment_method" value="wallet" class="mt-1 text-emerald-600">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">📱 Wallet Digital Emirates</span>
                                        <span class="text-sm text-emerald-600">Cashback 2%</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Portefeuille numérique local</p>
                                </div>
                            </label>
                            
                            <label class="flex items-start space-x-3 p-4 border border-gray-200 rounded-lg hover:border-emerald-300 transition-colors cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer" class="mt-1 text-emerald-600">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-medium text-gray-900">🏦 Virement bancaire</span>
                                        <span class="text-sm text-green-600">-3% de réduction</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Délai de traitement: 24h</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Options supplémentaires -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            🎁 Options Supplémentaires
                        </h2>
                        
                        <div class="space-y-4">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="eco_packaging" value="1" class="text-emerald-600">
                                <div class="flex-1">
                                    <span class="font-medium text-gray-900">📦 Emballage écologique (+15 AED)</span>
                                    <p class="text-sm text-gray-600">Emballage biodégradable et recyclable</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="gift_message" value="1" class="text-emerald-600">
                                <div class="flex-1">
                                    <span class="font-medium text-gray-900">💌 Message personnalisé (inclus)</span>
                                    <p class="text-sm text-gray-600">Ajoutez un message cadeau personnalisé</p>
                                </div>
                            </label>
                            
                            <div id="gift-message-input" class="hidden ml-6">
                                <textarea name="gift_message_text" rows="3" placeholder="Votre message cadeau..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                            </div>
                            
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="company_invoice" value="1" class="text-emerald-600">
                                <div class="flex-1">
                                    <span class="font-medium text-gray-900">📄 Facture société (disponible)</span>
                                    <p class="text-sm text-gray-600">Facture avec détails de l'entreprise</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="recurring_order" value="1" class="text-emerald-600">
                                <div class="flex-1">
                                    <span class="font-medium text-gray-900">🔄 Commande récurrente (-10%)</span>
                                    <p class="text-sm text-gray-600">Livraison automatique tous les mois</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Notes de commande -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">📝 Notes de Commande</h2>
                        <textarea name="customer_notes" rows="4" placeholder="Commentaires ou instructions spéciales..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                    </div>
                </div>

                <!-- Résumé de commande -->
                <div class="mt-8 lg:mt-0">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">📋 Résumé de Commande</h3>
                        
                        <!-- Articles -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart->items as $item)
                            <div class="flex items-center space-x-3 py-2 border-b border-gray-100 last:border-b-0">
                                @if($item->product->images && count($item->product->images) > 0)
                                <img src="{{ $item->product->images[0] }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded-lg">
                                @else
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-lg">📦</span>
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 text-sm">{{ Str::limit($item->product->name, 30) }}</h4>
                                    <p class="text-xs text-gray-600">Qté: {{ $item->quantity }}</p>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $item->total_price }} AED</span>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Calculs -->
                        <div class="space-y-3 mb-6 border-t pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sous-total</span>
                                <span class="font-medium">{{ $cart->subtotal }} AED</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Livraison</span>
                                <span class="font-medium" id="shipping-cost">
                                    @if($cart->subtotal >= 500)
                                    <span class="text-green-600">Gratuite</span>
                                    @else
                                    25 AED
                                    @endif
                                </span>
                            </div>
                            
                            @if($cart->discount_amount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Réduction</span>
                                <span>-{{ $cart->discount_amount }} AED</span>
                            </div>
                            @endif
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Taxes</span>
                                <span class="font-medium">{{ $cart->tax_amount }} AED</span>
                            </div>
                            
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total</span>
                                    <span id="total-amount">{{ $cart->total_amount }} AED</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3">
                            <!-- Acceptation des conditions -->
                            <label class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                <input type="checkbox" name="terms_accepted" value="1" required class="mt-1 text-emerald-600">
                                <span class="text-sm text-gray-700">
                                    J'accepte les <a href="#" class="text-emerald-600 hover:underline">conditions générales de vente</a> 
                                    et la <a href="#" class="text-emerald-600 hover:underline">politique de confidentialité</a> *
                                </span>
                            </label>
                            
                            <button type="submit" class="w-full bg-emerald-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-emerald-700 transition-colors">
                                ✅ Confirmer la commande
                            </button>
                            
                            <a href="{{ route('cart.index') }}" class="block w-full bg-gray-100 text-gray-700 py-2 px-6 rounded-lg font-medium text-center hover:bg-gray-200 transition-colors">
                                ← Retour au panier
                            </a>
                        </div>

                        <!-- Garanties -->
                        <div class="mt-6 space-y-2 text-xs text-gray-600">
                            <div class="flex items-center space-x-2">
                                <span>🔒</span>
                                <span>Paiement sécurisé 256-bit SSL</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span>🛡️</span>
                                <span>Protection acheteur garantie</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span>📞</span>
                                <span>Support 24/7 disponible</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const giftMessageCheckbox = document.querySelector('input[name="gift_message"]');
        const giftMessageInput = document.getElementById('gift-message-input');
        
        giftMessageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                giftMessageInput.classList.remove('hidden');
            } else {
                giftMessageInput.classList.add('hidden');
            }
        });

        const shippingMethods = document.querySelectorAll('input[name="delivery_type"]');
        const shippingCostElement = document.getElementById('shipping-cost');
        const totalAmountElement = document.getElementById('total-amount');
        
        shippingMethods.forEach(method => {
            method.addEventListener('change', function() {
                let shippingCost = 0;
                let shippingText = '';
                
                if (this.value === 'standard') {
                    if ({{ $cart->subtotal }} >= 500) {
                        shippingText = '<span class="text-green-600">Gratuite</span>';
                    } else {
                        shippingCost = 25;
                        shippingText = '25 AED';
                    }
                } else if (this.value === 'express') {
                    shippingCost = 50;
                    shippingText = '50 AED';
                } else if (this.value === 'scheduled') {
                    shippingText = '<span class="text-green-600">Gratuite</span>';
                }
                
                shippingCostElement.innerHTML = shippingText;
                
                const subtotal = {{ $cart->subtotal }};
                const discount = {{ $cart->discount_amount }};
                const tax = {{ $cart->tax_amount }};
                const newTotal = subtotal + shippingCost - discount + tax;
                
                totalAmountElement.textContent = newTotal + ' AED';
            });
        });

        const form = document.getElementById('checkout-form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                alert('Veuillez remplir tous les champs obligatoires');
                return;
            }
            
            if (confirm('Êtes-vous sûr de vouloir passer cette commande ?')) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = '⏳ Traitement en cours...';
                submitBtn.disabled = true;
                
                form.submit();
            }
        });

        const formInputs = form.querySelectorAll('input, select, textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                localStorage.setItem('checkout_' + this.name, this.value);
            });
            
            const savedValue = localStorage.getItem('checkout_' + input.name);
            if (savedValue && !input.value) {
                input.value = savedValue;
            }
        });
    });
</script>
@endpush
@endsection
