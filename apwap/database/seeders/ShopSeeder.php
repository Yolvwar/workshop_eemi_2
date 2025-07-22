<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\User;
use App\Models\Pet;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductReview;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->createCategories();
        $this->createProducts();
        $this->createTestData();
    }

    /**
     * Créer les catégories de produits
     */
    private function createCategories()
    {
        // Catégories principales
        $mainCategories = [
            [
                'name' => 'Nutrition & Alimentation',
                'description' => '2,400+ produits • Livraison réfrigérée',
                'children' => ['Croquettes', 'Pâtées', 'Suppléments', 'Friandises', 'Alimentation spécialisée']
            ],
            [
                'name' => 'Santé & Hygiène', 
                'description' => '1,800+ produits • Conseils vétérinaires',
                'children' => ['Médicaments', 'Soins', 'Premiers secours', 'Antiparasitaires', 'Hygiène dentaire']
            ],
            [
                'name' => 'Jouets & Accessoires',
                'description' => '3,200+ produits • Dernières nouveautés',
                'children' => ['Jouets interactifs', 'Laisses & Colliers', 'Sacs de transport', 'Gamelles', 'Distributeurs']
            ],
            [
                'name' => 'Confort & Lifestyle',
                'description' => '1,600+ produits • Design premium',
                'children' => ['Lits & Coussins', 'Maisons & Niches', 'Fontaines', 'Tapis rafraîchissants', 'Mobilier']
            ],
            [
                'name' => 'Éducation & Dressage',
                'description' => '800+ produits • Méthodes approuvées',
                'children' => ['Sifflets', 'Clickers', 'Guides dressage', 'Récompenses', 'Colliers dressage']
            ],
            [
                'name' => 'Toilettage & Beauté',
                'description' => '1,200+ produits • Qualité professionnelle',
                'children' => ['Shampoings', 'Brosses', 'Tondeuses', 'Parfums', 'Accessoires toilettage']
            ]
        ];

        foreach ($mainCategories as $index => $categoryData) {
            $category = ProductCategory::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
                'sort_order' => $index + 1,
                'is_active' => true
            ]);

            // Créer les sous-catégories
            foreach ($categoryData['children'] as $childIndex => $childName) {
                ProductCategory::create([
                    'name' => $childName,
                    'parent_id' => $category->id,
                    'sort_order' => $childIndex + 1,
                    'is_active' => true
                ]);
            }
        }
    }

    /**
     * Créer les produits
     */
    private function createProducts()
    {
        $categories = ProductCategory::whereNotNull('parent_id')->get();
        
        $products = [
            // NUTRITION & ALIMENTATION - Croquettes
            [
                'name' => 'Croquettes Royal Canin Border Collie Adult 12kg',
                'category' => 'Croquettes',
                'price' => 320,
                'description' => 'Alimentation spécialement formulée pour Border Collie adulte. Soutient l\'énergie élevée et maintient un poids idéal. Enrichi en EPA/DHA pour la santé du pelage.',
                'short_description' => 'Croquettes spécialisées Border Collie',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Adulte'],
                'suitable_for_sizes' => ['Moyen', 'Grand'],
                'primary_pillar' => 'Nutrition',
                'featured' => true,
                'stock' => 50,
                'rating' => 4.6,
                'reviews' => 89
            ],
            [
                'name' => 'Croquettes Hill\'s Science Diet Chiot 15kg',
                'category' => 'Croquettes',
                'price' => 280,
                'description' => 'Nutrition équilibrée pour chiots en croissance. Formule avec DHA pour le développement du cerveau et des yeux. Antioxydants pour un système immunitaire fort.',
                'short_description' => 'Croquettes premium pour chiots en croissance',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Chiot'],
                'suitable_for_sizes' => ['Petit', 'Moyen', 'Grand'],
                'primary_pillar' => 'Nutrition',
                'stock' => 35,
                'rating' => 4.7,
                'reviews' => 156
            ],
            [
                'name' => 'Croquettes Orijen Chat Six Fish 5.4kg',
                'category' => 'Croquettes',
                'price' => 420,
                'original_price' => 450,
                'description' => 'Alimentation biologique appropriée pour chats. 85% d\'ingrédients de poisson frais, sans céréales. Formule riche en protéines pour tous les âges.',
                'short_description' => 'Croquettes biologiques aux six poissons',
                'suitable_for_species' => ['Chat'],
                'suitable_for_ages' => ['Chiot', 'Adulte', 'Senior'],
                'primary_pillar' => 'Nutrition',
                'featured' => true,
                'stock' => 28,
                'rating' => 4.9,
                'reviews' => 203
            ],
            [
                'name' => 'Croquettes Purina Pro Plan Senior 7+ 14kg',
                'category' => 'Croquettes',
                'price' => 295,
                'description' => 'Formule spécialement conçue pour chiens seniors de 7 ans et plus. Soutient la fonction cognitive et la mobilité articulaire.',
                'short_description' => 'Nutrition adaptée aux chiens seniors',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Senior'],
                'suitable_for_sizes' => ['Moyen', 'Grand'],
                'primary_pillar' => 'Nutrition',
                'stock' => 42,
                'rating' => 4.5,
                'reviews' => 78
            ],

            // NUTRITION & ALIMENTATION - Pâtées
            [
                'name' => 'Pâtée Royal Canin Digestive Care Chat 12x85g',
                'category' => 'Pâtées',
                'price' => 85,
                'description' => 'Pâtée thérapeutique pour chats avec troubles digestifs. Formule hautement digestible avec prébiotiques. Recommandée par les vétérinaires.',
                'short_description' => 'Pâtée digestive pour chats sensibles',
                'suitable_for_species' => ['Chat'],
                'suitable_for_ages' => ['Adulte', 'Senior'],
                'primary_pillar' => 'Nutrition',
                'stock' => 65,
                'rating' => 4.4,
                'reviews' => 92
            ],
            [
                'name' => 'Pâtée Hill\'s Prescription Diet Chien Rénale 12x370g',
                'category' => 'Pâtées',
                'price' => 120,
                'description' => 'Alimentation thérapeutique pour chiens avec problèmes rénaux. Faible en phosphore et protéines de haute qualité.',
                'short_description' => 'Pâtée thérapeutique rénale',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Adulte', 'Senior'],
                'primary_pillar' => 'Nutrition',
                'stock' => 25,
                'rating' => 4.6,
                'reviews' => 45
            ],

            // NUTRITION & ALIMENTATION - Suppléments
            [
                'name' => 'Suppléments Articulations Senior Plus',
                'category' => 'Suppléments',
                'price' => 240,
                'description' => 'Complément alimentaire premium pour chiens seniors. Formule avancée avec glucosamine, chondroïtine et MSM. Soutient la mobilité et réduit l\'inflammation articulaire.',
                'short_description' => 'Suppléments pour articulations senior',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Senior'],
                'primary_pillar' => 'Santé',
                'stock' => 30,
                'rating' => 4.7,
                'reviews' => 156
            ],
            [
                'name' => 'Oméga-3 Pelage Brillant Chat & Chien 90 capsules',
                'category' => 'Suppléments',
                'price' => 85,
                'description' => 'Supplément d\'huile de poisson riche en EPA et DHA. Améliore la santé du pelage, réduit les inflammations et soutient la fonction cognitive.',
                'short_description' => 'Oméga-3 pour pelage brillant',
                'suitable_for_species' => ['Chien', 'Chat'],
                'suitable_for_ages' => ['Adulte', 'Senior'],
                'primary_pillar' => 'Santé',
                'stock' => 55,
                'rating' => 4.3,
                'reviews' => 78
            ],

            // NUTRITION & ALIMENTATION - Friandises
            [
                'name' => 'Friandises Éducatives Poulet & Riz 500g',
                'category' => 'Friandises',
                'price' => 35,
                'description' => 'Friandises naturelles parfaites pour l\'éducation. Sans colorants ni conservateurs artificiels. Taille idéale pour récompenses.',
                'short_description' => 'Friandises naturelles d\'éducation',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Chiot', 'Adulte'],
                'suitable_for_sizes' => ['Petit', 'Moyen', 'Grand'],
                'primary_pillar' => 'Éducation',
                'stock' => 85,
                'rating' => 4.8,
                'reviews' => 167
            ],
            [
                'name' => 'Bâtonnets Dentaires Chien Moyen 28 pièces',
                'category' => 'Friandises',
                'price' => 42,
                'description' => 'Bâtonnets à mâcher pour l\'hygiène dentaire. Réduisent le tartre et rafraîchissent l\'haleine. Texture spéciale pour nettoyer les dents.',
                'short_description' => 'Friandises hygiène dentaire',
                'suitable_for_species' => ['Chien'],
                'suitable_for_sizes' => ['Moyen'],
                'primary_pillar' => 'Santé',
                'stock' => 45,
                'rating' => 4.5,
                'reviews' => 89
            ],

            // SANTÉ & HYGIÈNE - Soins
            [
                'name' => 'Shampooing Hypoallergénique Peaux Sensibles 250ml',
                'category' => 'Soins',
                'price' => 28,
                'description' => 'Shampooing doux pour animaux à peau sensible. Formule sans parfum, sans paraben. Apaise les irritations et hydrate en profondeur.',
                'short_description' => 'Shampooing pour peaux sensibles',
                'suitable_for_species' => ['Chien', 'Chat'],
                'primary_pillar' => 'Santé',
                'stock' => 75,
                'rating' => 4.6,
                'reviews' => 134
            ],
            [
                'name' => 'Spray Nettoyant Oreilles 100ml',
                'category' => 'Soins',
                'price' => 22,
                'description' => 'Solution nettoyante douce pour l\'hygiène auriculaire. Prévient les infections et élimine le cérumen. Formule vétérinaire.',
                'short_description' => 'Nettoyant oreilles vétérinaire',
                'suitable_for_species' => ['Chien', 'Chat'],
                'primary_pillar' => 'Santé',
                'stock' => 60,
                'rating' => 4.4,
                'reviews' => 67
            ],

            // JOUETS & ACCESSOIRES - Jouets interactifs
            [
                'name' => 'Jouets Mental Stimulation Pack',
                'category' => 'Jouets interactifs',
                'price' => 150,
                'description' => 'Pack de 5 jouets de stimulation mentale pour chiens intelligents. Puzzles alimentaires, balles distributeur et jouets interactifs. Idéal pour Border Collie.',
                'short_description' => 'Pack jouets stimulation mentale',
                'suitable_for_species' => ['Chien'],
                'primary_pillar' => 'Éducation',
                'featured' => true,
                'stock' => 35,
                'rating' => 4.7,
                'reviews' => 92
            ],
            [
                'name' => 'Puzzle Alimentaire Nina Ottosson Niveau 2',
                'category' => 'Jouets interactifs',
                'price' => 85,
                'description' => 'Puzzle interactif de difficulté moyenne. Stimule l\'intelligence et ralentit la prise alimentaire. Design suédois robuste et lavable.',
                'short_description' => 'Puzzle alimentaire niveau intermédiaire',
                'suitable_for_species' => ['Chien'],
                'suitable_for_sizes' => ['Petit', 'Moyen'],
                'primary_pillar' => 'Éducation',
                'stock' => 28,
                'rating' => 4.8,
                'reviews' => 145
            ],
            [
                'name' => 'Balle Distributrice de Friandises Interactive',
                'category' => 'Jouets interactifs',
                'price' => 32,
                'description' => 'Balle robuste qui distribue des friandises pendant le jeu. Stimule l\'activité physique et mentale. Matériau non-toxique ultra-résistant.',
                'short_description' => 'Balle distributrice interactive',
                'suitable_for_species' => ['Chien'],
                'suitable_for_sizes' => ['Moyen', 'Grand'],
                'primary_pillar' => 'Éducation',
                'stock' => 65,
                'rating' => 4.5,
                'reviews' => 178
            ],

            // JOUETS & ACCESSOIRES - Laisses & Colliers
            [
                'name' => 'Harnais Support Senior Comfort',
                'category' => 'Laisses & Colliers',
                'price' => 180,
                'description' => 'Harnais de support ergonomique pour chiens seniors. Aide à la mobilité avec poignée de support. Matériaux respirants et rembourrés.',
                'short_description' => 'Harnais de support pour chiens seniors',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Senior'],
                'primary_pillar' => 'Mobilité',
                'stock' => 20,
                'rating' => 4.5,
                'reviews' => 78
            ],
            [
                'name' => 'Laisse Rétractable Premium 5m Chien Moyen',
                'category' => 'Laisses & Colliers',
                'price' => 65,
                'description' => 'Laisse rétractable haut de gamme avec système de freinage progressif. Poignée ergonomique antidérapante. Résiste jusqu\'à 25kg.',
                'short_description' => 'Laisse rétractable premium 5m',
                'suitable_for_species' => ['Chien'],
                'suitable_for_sizes' => ['Moyen'],
                'primary_pillar' => 'Mobilité',
                'stock' => 45,
                'rating' => 4.6,
                'reviews' => 123
            ],
            [
                'name' => 'Collier GPS Tracker Waterproof',
                'category' => 'Laisses & Colliers',
                'price' => 320,
                'original_price' => 380,
                'description' => 'Collier GPS intelligent avec suivi en temps réel. Application mobile, zones de sécurité, batterie 7 jours. Étanche IP67.',
                'short_description' => 'Collier GPS intelligent étanche',
                'suitable_for_species' => ['Chien', 'Chat'],
                'suitable_for_sizes' => ['Moyen', 'Grand'],
                'primary_pillar' => 'Sécurité',
                'featured' => true,
                'stock' => 15,
                'rating' => 4.8,
                'reviews' => 89
            ],

            // JOUETS & ACCESSOIRES - Gamelles
            [
                'name' => 'Gamelle Anti-Glouton Acier Inoxydable',
                'category' => 'Gamelles',
                'price' => 45,
                'description' => 'Gamelle avec obstacles intégrés pour ralentir la prise alimentaire. Acier inoxydable alimentaire, base antidérapante. Facile à nettoyer.',
                'short_description' => 'Gamelle anti-glouton inox',
                'suitable_for_species' => ['Chien', 'Chat'],
                'suitable_for_sizes' => ['Petit', 'Moyen'],
                'primary_pillar' => 'Nutrition',
                'stock' => 55,
                'rating' => 4.7,
                'reviews' => 167
            ],

            // CONFORT & LIFESTYLE - Lits & Coussins
            [
                'name' => 'Matelas Orthopédique Memory Foam',
                'category' => 'Lits & Coussins',
                'price' => 520,
                'description' => 'Matelas orthopédique haut de gamme avec mousse à mémoire de forme. Parfait pour chiens seniors ou avec problèmes articulaires. Housse amovible et lavable.',
                'short_description' => 'Matelas orthopédique memory foam',
                'suitable_for_species' => ['Chien'],
                'suitable_for_sizes' => ['Grand'],
                'primary_pillar' => 'Confort',
                'stock' => 12,
                'rating' => 4.8,
                'reviews' => 43
            ],
            [
                'name' => 'Coussin Apaisant Anti-Stress Chat',
                'category' => 'Lits & Coussins',
                'price' => 85,
                'description' => 'Coussin rond en fausse fourrure ultra-douce. Design apaisant qui réduit l\'anxiété. Lavable en machine, fond antidérapant.',
                'short_description' => 'Coussin anti-stress apaisant',
                'suitable_for_species' => ['Chat'],
                'primary_pillar' => 'Confort',
                'stock' => 35,
                'rating' => 4.9,
                'reviews' => 234
            ],

            // CONFORT & LIFESTYLE - Tapis rafraîchissants
            [
                'name' => 'Tapis Rafraîchissant ChillPad Pro',
                'category' => 'Tapis rafraîchissants',
                'price' => 280,
                'original_price' => 320,
                'description' => 'Tapis gel rafraîchissant premium conçu spécifiquement pour les climats chauds comme Dubai. Gel médical non-toxique, activation par pression, refroidissement jusqu\'à 8h. Parfait pour chiens de 15-35kg.',
                'short_description' => 'Tapis rafraîchissant professionnel pour climat Dubai',
                'suitable_for_species' => ['Chien'],
                'suitable_for_sizes' => ['Moyen', 'Grand'],
                'primary_pillar' => 'Lifestyle',
                'featured' => true,
                'stock' => 25,
                'rating' => 4.8,
                'reviews' => 124
            ],

            // CONFORT & LIFESTYLE - Fontaines
            [
                'name' => 'Fontaine Eau Intelligente SmartFlow',
                'category' => 'Fontaines',
                'price' => 350,
                'description' => 'Fontaine intelligente avec filtration UV et capteurs. Encourage l\'hydratation, filtre en continu. Application mobile pour suivi consommation.',
                'short_description' => 'Fontaine intelligente avec app mobile',
                'suitable_for_species' => ['Chien', 'Chat'],
                'primary_pillar' => 'Santé',
                'featured' => true,
                'stock' => 18,
                'rating' => 4.9,
                'reviews' => 45
            ],
            [
                'name' => 'Fontaine Céramique Design Fleur de Lotus',
                'category' => 'Fontaines',
                'price' => 165,
                'description' => 'Fontaine en céramique artisanale design fleur de lotus. Circulation silencieuse, filtre charbon actif. Capacité 2.5L, idéale pour chats.',
                'short_description' => 'Fontaine céramique design lotus',
                'suitable_for_species' => ['Chat'],
                'primary_pillar' => 'Lifestyle',
                'stock' => 22,
                'rating' => 4.6,
                'reviews' => 87
            ],

            // CONFORT & LIFESTYLE - Mobilier
            [
                'name' => 'Arbre à Chat Premium Tower',
                'category' => 'Mobilier',
                'price' => 680,
                'description' => 'Arbre à chat luxueux 180cm de hauteur. 6 niveaux, 3 niches, griffoirs sisal premium. Design moderne adapté aux intérieurs Dubai.',
                'short_description' => 'Arbre à chat premium 180cm',
                'suitable_for_species' => ['Chat'],
                'primary_pillar' => 'Lifestyle',
                'stock' => 8,
                'rating' => 4.6,
                'reviews' => 34
            ],
            [
                'name' => 'Griffoir Design Moderne Carton Ondulé',
                'category' => 'Mobilier',
                'price' => 45,
                'description' => 'Griffoir écologique en carton ondulé recyclable. Design moderne s\'intégrant parfaitement au salon. Avec herbe à chat incluse.',
                'short_description' => 'Griffoir écologique design',
                'suitable_for_species' => ['Chat'],
                'primary_pillar' => 'Lifestyle',
                'stock' => 65,
                'rating' => 4.3,
                'reviews' => 156
            ],

            // TOILETTAGE & BEAUTÉ - Shampoings
            [
                'name' => 'Shampooing Professional Pelage Long',
                'category' => 'Shampoings',
                'price' => 38,
                'description' => 'Shampooing professionnel spécialement formulé pour pelages longs. Démêle, nourrit et apporte brillance. Enrichi en huile d\'argan.',
                'short_description' => 'Shampooing pelage long à l\'argan',
                'suitable_for_species' => ['Chien', 'Chat'],
                'primary_pillar' => 'Beauté',
                'stock' => 45,
                'rating' => 4.7,
                'reviews' => 89
            ],

            // TOILETTAGE & BEAUTÉ - Brosses
            [
                'name' => 'Kit Toilettage Professionnel Luna',
                'category' => 'Brosses',
                'price' => 450,
                'original_price' => 520,
                'description' => 'Kit complet de toilettage pour chats Persans. Inclut brosses spécialisées, démêloir, shampooing hypoallergénique et guide d\'utilisation.',
                'short_description' => 'Kit toilettage complet pour chats à poils longs',
                'suitable_for_species' => ['Chat'],
                'primary_pillar' => 'Lifestyle',
                'stock' => 15,
                'rating' => 4.9,
                'reviews' => 67
            ],
            [
                'name' => 'Brosse Auto-Nettoyante FURminator',
                'category' => 'Brosses',
                'price' => 85,
                'description' => 'Brosse révolutionnaire qui élimine 90% des poils morts. Bouton d\'éjection automatique des poils. Réduit la mue jusqu\'à 99%.',
                'short_description' => 'Brosse auto-nettoyante anti-mue',
                'suitable_for_species' => ['Chien', 'Chat'],
                'primary_pillar' => 'Beauté',
                'stock' => 35,
                'rating' => 4.8,
                'reviews' => 234
            ],

            // ÉDUCATION & DRESSAGE - Clickers
            [
                'name' => 'Clicker Dressage Professionnel avec Dragonne',
                'category' => 'Clickers',
                'price' => 15,
                'description' => 'Clicker ergonomique pour éducation positive. Son clair et précis, dragonne incluse. Méthode approuvée par les comportementalistes.',
                'short_description' => 'Clicker éducation positive pro',
                'suitable_for_species' => ['Chien'],
                'primary_pillar' => 'Éducation',
                'stock' => 95,
                'rating' => 4.5,
                'reviews' => 167
            ],

            // ÉDUCATION & DRESSAGE - Récompenses
            [
                'name' => 'Mix Friandises Éducation 3 Saveurs 300g',
                'category' => 'Récompenses',
                'price' => 28,
                'description' => 'Mélange de friandises haute valeur pour l\'éducation. 3 saveurs irrésistibles : saumon, poulet, bœuf. Taille micro pour récompenses fréquentes.',
                'short_description' => 'Mix friandises éducation 3 saveurs',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Chiot', 'Adulte'],
                'primary_pillar' => 'Éducation',
                'stock' => 75,
                'rating' => 4.8,
                'reviews' => 198
            ],

            // NUTRITION & ALIMENTATION - Alimentation spécialisée
            [
                'name' => 'Alimentation Hypoallergénique Hills',
                'category' => 'Alimentation spécialisée',
                'price' => 280,
                'description' => 'Alimentation vétérinaire hypoallergénique pour chats sensibles. Formule hydrolysée, facilement digestible. Recommandée par les vétérinaires.',
                'short_description' => 'Alimentation hypoallergénique chat',
                'suitable_for_species' => ['Chat'],
                'primary_pillar' => 'Nutrition',
                'stock' => 25,
                'rating' => 4.4,
                'reviews' => 67
            ],
            [
                'name' => 'Croquettes Diabète Chien Hill\'s w/d 12kg',
                'category' => 'Alimentation spécialisée',
                'price' => 340,
                'description' => 'Alimentation thérapeutique pour chiens diabétiques et en surpoids. Faible en gras, riche en fibres. Aide à réguler la glycémie.',
                'short_description' => 'Croquettes thérapeutiques diabète',
                'suitable_for_species' => ['Chien'],
                'suitable_for_ages' => ['Adulte', 'Senior'],
                'primary_pillar' => 'Nutrition',
                'stock' => 18,
                'rating' => 4.6,
                'reviews' => 34
            ],

            // SANTÉ & HYGIÈNE - Antiparasitaires
            [
                'name' => 'Pipettes Anti-Puces Advantage II Chien 4x1ml',
                'category' => 'Antiparasitaires',
                'price' => 65,
                'description' => 'Pipettes anti-puces efficaces 4 semaines. Tue puces adultes, larves et œufs. Résistant à l\'eau, application simple.',
                'short_description' => 'Pipettes anti-puces 4 semaines',
                'suitable_for_species' => ['Chien'],
                'suitable_for_sizes' => ['Moyen'],
                'primary_pillar' => 'Santé',
                'stock' => 42,
                'rating' => 4.7,
                'reviews' => 156
            ],

            // SANTÉ & HYGIÈNE - Premiers secours
            [
                'name' => 'Trousse Premier Secours Animaux Complète',
                'category' => 'Premiers secours',
                'price' => 95,
                'description' => 'Trousse complète premier secours pour animaux. Comprend bandages, désinfectant, ciseaux, thermomètre digital et guide d\'urgence.',
                'short_description' => 'Kit premier secours complet',
                'suitable_for_species' => ['Chien', 'Chat'],
                'primary_pillar' => 'Santé',
                'stock' => 28,
                'rating' => 4.8,
                'reviews' => 67
            ],

            // JOUETS & ACCESSOIRES - Sacs de transport
            [
                'name' => 'Sac Transport Avion Homologué IATA Chat',
                'category' => 'Sacs de transport',
                'price' => 185,
                'description' => 'Sac de transport homologué IATA pour voyage en avion. Ventilation optimale, matériaux robustes. Dimensions cabine standard.',
                'short_description' => 'Sac transport avion homologué',
                'suitable_for_species' => ['Chat'],
                'primary_pillar' => 'Transport',
                'stock' => 15,
                'rating' => 4.6,
                'reviews' => 45
            ],

            // JOUETS & ACCESSOIRES - Distributeurs
            [
                'name' => 'Distributeur Automatique Croquettes WiFi',
                'category' => 'Distributeurs',
                'price' => 450,
                'original_price' => 520,
                'description' => 'Distributeur automatique connecté WiFi. Programmation via app mobile, contrôle à distance. Caméra intégrée, capacité 6kg.',
                'short_description' => 'Distributeur automatique connecté',
                'suitable_for_species' => ['Chien', 'Chat'],
                'primary_pillar' => 'Technologie',
                'featured' => true,
                'stock' => 8,
                'rating' => 4.9,
                'reviews' => 23
            ]
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category'])->first();
            if (!$category) continue;

            Product::create([
                'name' => $productData['name'],
                'category_id' => $category->id,
                'price' => $productData['price'],
                'original_price' => $productData['original_price'] ?? null,
                'description' => $productData['description'],
                'short_description' => $productData['short_description'],
                'suitable_for_species' => $productData['suitable_for_species'] ?? [],
                'suitable_for_ages' => $productData['suitable_for_ages'] ?? [],
                'suitable_for_sizes' => $productData['suitable_for_sizes'] ?? [],
                'primary_pillar' => $productData['primary_pillar'],
                'featured' => $productData['featured'] ?? false,
                'stock_quantity' => $productData['stock'],
                'rating' => $productData['rating'],
                'review_count' => $productData['reviews'],
                'status' => 'active',
                'brand' => $this->getRandomBrand(),
                'images' => $this->generateProductImages(),
                'shipping_required' => true,
                'weight' => rand(100, 5000) / 100, // Poids entre 1kg et 50kg
            ]);
        }

        // Ajouter des produits générés automatiquement pour avoir plus de variété
        $this->createAdditionalProducts($categories);
    }

    /**
     * Créer des produits supplémentaires générés automatiquement
     */
    private function createAdditionalProducts($categories)
    {
        $faker = Faker::create();
        
        // Templates de produits par catégorie
        $productTemplates = [
            'Croquettes' => [
                'prefixes' => ['Croquettes', 'Alimentation', 'Nutrition'],
                'brands' => ['Royal Canin', 'Hill\'s', 'Purina', 'Eukanuba', 'Orijen'],
                'suffixes' => ['Premium', 'Adult', 'Senior', 'Chiot', 'Light', 'Sensitive'],
                'price_range' => [180, 450],
                'primary_pillar' => 'Nutrition'
            ],
            'Pâtées' => [
                'prefixes' => ['Pâtée', 'Terrine', 'Mousse'],
                'brands' => ['Royal Canin', 'Hill\'s', 'Whiskas', 'Sheba'],
                'suffixes' => ['Délicate', 'Gourmet', 'Sensitive', 'Adult'],
                'price_range' => [25, 150],
                'primary_pillar' => 'Nutrition'
            ],
            'Jouets interactifs' => [
                'prefixes' => ['Jouet', 'Puzzle', 'Balle'],
                'brands' => ['Kong', 'Nina Ottosson', 'Trixie', 'Outward Hound'],
                'suffixes' => ['Interactif', 'Mental', 'Distributeur', 'Stimulation'],
                'price_range' => [25, 180],
                'primary_pillar' => 'Éducation'
            ],
            'Lits & Coussins' => [
                'prefixes' => ['Lit', 'Coussin', 'Matelas'],
                'brands' => ['Trixie', 'Ferplast', 'Karlie', 'Hunter'],
                'suffixes' => ['Confort', 'Moelleux', 'Orthopédique', 'Memory'],
                'price_range' => [45, 350],
                'primary_pillar' => 'Confort'
            ],
            'Shampoings' => [
                'prefixes' => ['Shampooing', 'Bain'],
                'brands' => ['Virbac', 'Douxo', 'Allermyl', 'Dermoscent'],
                'suffixes' => ['Hypoallergénique', 'Adoucissant', 'Purifiant', 'Nourrissant'],
                'price_range' => [22, 85],
                'primary_pillar' => 'Beauté'
            ],
            'Brosses' => [
                'prefixes' => ['Brosse', 'Peigne', 'Démêloir'],
                'brands' => ['FURminator', 'Trixie', 'Show Tech', 'Chris Christensen'],
                'suffixes' => ['Professional', 'Anti-mue', 'Démêlant', 'Finition'],
                'price_range' => [18, 120],
                'primary_pillar' => 'Beauté'
            ]
        ];

        foreach ($categories as $category) {
            if (!isset($productTemplates[$category->name])) continue;
            
            $template = $productTemplates[$category->name];
            $numProducts = rand(3, 8); // 3 à 8 produits par catégorie

            for ($i = 0; $i < $numProducts; $i++) {
                $prefix = $faker->randomElement($template['prefixes']);
                $brand = $faker->randomElement($template['brands']);
                $suffix = $faker->randomElement($template['suffixes']);
                
                $name = "{$prefix} {$brand} {$suffix}";
                if ($category->name === 'Croquettes' || $category->name === 'Pâtées') {
                    $name .= ' ' . $faker->randomElement(['3kg', '5kg', '12kg', '15kg', '400g', '800g']);
                }
                
                // Ajouter un identifiant unique pour éviter les doublons de slug
                $name .= ' ' . $faker->randomElement(['Pro', 'Plus', 'Extra', 'Premium', 'Classic', 'Advanced']) . ' ' . $faker->numberBetween(100, 999);

                $price = rand($template['price_range'][0], $template['price_range'][1]);
                $originalPrice = $faker->boolean(30) ? round($price * 1.2) : null;

                $species = $faker->randomElement([
                    ['Chien'],
                    ['Chat'], 
                    ['Chien', 'Chat']
                ]);

                $ages = $faker->randomElement([
                    ['Chiot', 'Adulte', 'Senior'],
                    ['Adulte'],
                    ['Senior'],
                    ['Chiot'],
                    ['Adulte', 'Senior']
                ]);

                $sizes = $faker->randomElement([
                    ['Petit', 'Moyen', 'Grand'],
                    ['Moyen', 'Grand'],
                    ['Petit'],
                    ['Grand']
                ]);

                Product::create([
                    'name' => $name,
                    'category_id' => $category->id,
                    'price' => $price,
                    'original_price' => $originalPrice,
                    'description' => $this->generateProductDescription($category->name, $brand),
                    'short_description' => $faker->sentence(6),
                    'suitable_for_species' => $species,
                    'suitable_for_ages' => $ages,
                    'suitable_for_sizes' => $sizes,
                    'primary_pillar' => $template['primary_pillar'],
                    'featured' => $faker->boolean(15), // 15% chance d'être en vedette
                    'stock_quantity' => rand(5, 95),
                    'rating' => round($faker->randomFloat(1, 3.8, 5.0), 1),
                    'review_count' => rand(5, 250),
                    'status' => 'active',
                    'brand' => $brand,
                    'images' => $this->generateProductImages(),
                    'shipping_required' => true,
                    'weight' => rand(50, 3000) / 100,
                ]);
            }
        }
    }

    /**
     * Générer une description de produit
     */
    private function generateProductDescription($categoryName, $brand)
    {
        $descriptions = [
            'Croquettes' => [
                "Alimentation complète et équilibrée de la marque {$brand}. Formule élaborée avec des ingrédients de première qualité pour répondre aux besoins nutritionnels spécifiques.",
                "Croquettes premium {$brand} riches en protéines de haute qualité. Favorise une digestion optimale et maintient un pelage brillant.",
                "Nutrition scientifiquement formulée par {$brand}. Contient tous les nutriments essentiels pour une santé optimale au quotidien."
            ],
            'Pâtées' => [
                "Délicieuse pâtée {$brand} préparée avec des ingrédients sélectionnés. Texture onctueuse que les animaux adorent.",
                "Alimentation humide {$brand} riche en saveurs naturelles. Excellente source d'hydratation avec une appétence remarquable.",
                "Recette gourmande {$brand} élaborée pour satisfaire les palais les plus exigeants. Formule équilibrée et digestible."
            ],
            'Jouets interactifs' => [
                "Jouet intelligent {$brand} conçu pour stimuler l'esprit et divertir. Favorise l'activité physique et mentale.",
                "Accessoire de jeu {$brand} innovant qui occupe et éduque. Matériaux résistants et sécurisés pour des heures de plaisir.",
                "Jeu interactif {$brand} qui développe les capacités cognitives. Design ergonomique adapté à tous les niveaux."
            ],
            'Lits & Coussins' => [
                "Couchage confortable {$brand} offrant un repos réparateur. Matériaux de qualité supérieure pour un confort optimal.",
                "Lit douillet {$brand} au design moderne et fonctionnel. Housse lavable et matériaux hypoallergéniques.",
                "Espace de repos {$brand} ergonomique qui s'adapte parfaitement. Support optimal pour les articulations."
            ],
            'Shampoings' => [
                "Produit de toilettage {$brand} professionnel pour un pelage éclatant. Formule douce respectueuse de la peau sensible.",
                "Shampooing {$brand} aux actifs naturels nourrissants. Nettoie en profondeur tout en préservant l'équilibre cutané.",
                "Soin lavant {$brand} spécialement développé pour les besoins spécifiques. Résultat professionnel à domicile."
            ],
            'Brosses' => [
                "Outil de toilettage {$brand} professionnel pour un brossage efficace. Élimine les poils morts et démêle en douceur.",
                "Brosse {$brand} ergonomique au design innovant. Stimule la circulation et distribue les huiles naturelles.",
                "Accessoire de beauté {$brand} indispensable pour l'entretien quotidien. Résultats visibles dès la première utilisation."
            ]
        ];

        $categoryDescriptions = $descriptions[$categoryName] ?? [
            "Produit de qualité {$brand} conçu pour répondre aux besoins spécifiques. Fabrication soignée et matériaux premium."
        ];

        return Faker::create()->randomElement($categoryDescriptions);
    }

    /**
     * Obtenir une marque aléatoire
     */
    private function getRandomBrand()
    {
        $brands = ['Royal Canin', 'Hill\'s', 'Purina Pro Plan', 'APWAP Premium', 'Eukanuba', 'Orijen', 'Wellness', 'Blue Buffalo'];
        return $brands[array_rand($brands)];
    }

    /**
     * Générer des images de produit fictives
     */
    private function generateProductImages()
    {
        return [
            'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=500',
            'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=500',
            'https://images.unsplash.com/photo-1585664811087-47f65abbad64?w=500'
        ];
    }

    /**
     * Créer des données de test pour l'e-commerce
     */
    private function createTestData()
    {
        $faker = Faker::create();

        // Créer un utilisateur de test s'il n'existe pas
        $user = User::firstOrCreate(
            ['email' => 'test@apwap.com'],
            [
                'id' => Str::uuid(),
                'first_name' => 'Ahmed',
                'last_name' => 'Al Maktoum',
                'phone' => '+971501234567',
                'city' => 'Dubai',
                'country' => 'UAE',
                'language' => 'fr',
                'timezone' => 'Asia/Dubai',
                'currency' => 'AED',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Créer des animaux pour l'utilisateur de test
        $pets = [
            [
                'name' => 'Max',
                'species' => 'dog',
                'breed' => 'Border Collie',
                'birth_date' => now()->subYears(3),
                'weight' => 25.5,
            ],
            [
                'name' => 'Luna',
                'species' => 'cat',
                'breed' => 'Persan',
                'birth_date' => now()->subYears(2),
                'weight' => 4.2,
            ],
            [
                'name' => 'Buddy',
                'species' => 'dog',
                'breed' => 'Golden Retriever',
                'birth_date' => now()->subYears(8),
                'weight' => 32.0,
            ],
        ];

        $createdPets = [];
        foreach ($pets as $petData) {
            $pet = Pet::firstOrCreate(
                ['user_id' => $user->id, 'name' => $petData['name']],
                [
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'species' => $petData['species'],
                    'breed' => $petData['breed'],
                    'birth_date' => $petData['birth_date'],
                    'weight' => $petData['weight'],
                    'gender' => $faker->randomElement(['male', 'female']),
                    'color' => $faker->colorName(),
                    'is_active' => true,
                ]
            );
            $createdPets[] = $pet;
        }

        // Récupérer quelques produits pour les exemples
        $products = Product::take(5)->get();
        
        if ($products->count() > 0) {
            // Créer un panier avec quelques articles
            $cart = Cart::firstOrCreate(
                ['user_id' => $user->id, 'status' => 'active'],
                [
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'status' => 'active',
                    'items_count' => 0,
                    'subtotal' => 0,
                    'total_amount' => 0,
                ]
            );

            // Ajouter des articles au panier si pas déjà présents
            if ($cart->items()->count() === 0) {
                $cartItems = [
                    ['product' => $products[0], 'quantity' => 1, 'pet' => $createdPets[0] ?? null],
                    ['product' => $products[1], 'quantity' => 2, 'pet' => $createdPets[1] ?? null],
                ];

                $totalSubtotal = 0;
                foreach ($cartItems as $itemData) {
                    $totalPrice = $itemData['product']->price * $itemData['quantity'];
                    
                    CartItem::create([
                        'id' => Str::uuid(),
                        'cart_id' => $cart->id,
                        'product_id' => $itemData['product']->id,
                        'pet_id' => $itemData['pet']->id ?? null,
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['product']->price,
                        'total_price' => $totalPrice,
                    ]);
                    
                    $totalSubtotal += $totalPrice;
                }

                // Mettre à jour le panier
                $cart->update([
                    'items_count' => count($cartItems),
                    'subtotal' => $totalSubtotal,
                    'total_amount' => $totalSubtotal,
                ]);
            }

            // Créer une commande exemple
            $existingOrder = Order::where('user_id', $user->id)->first();
            if (!$existingOrder) {
                $order = Order::create([
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'order_number' => 'AP2024-' . str_pad($faker->numberBetween(1000, 9999), 4, '0', STR_PAD_LEFT),
                    'status' => 'shipped',
                    'payment_status' => 'paid',
                    'subtotal' => 750,
                    'shipping_amount' => 0,
                    'tax_amount' => 0,
                    'total_amount' => 750,
                    'shipping_first_name' => $user->first_name,
                    'shipping_last_name' => $user->last_name,
                    'shipping_address_line_1' => 'Dubai Marina, Building 123',
                    'shipping_address_line_2' => 'Apt 45A',
                    'shipping_city' => 'Dubai',
                    'shipping_postal_code' => '00000',
                    'shipping_phone' => $user->phone,
                    'shipping_method' => 'standard',
                    'payment_method' => 'card',
                    'placed_at' => now()->subDays(2),
                    'confirmed_at' => now()->subDays(2)->addHour(),
                    'shipped_at' => now()->subDay(),
                    'estimated_delivery_date' => now()->addDay(),
                ]);

                // Créer les articles de la commande
                foreach ($products->take(3) as $index => $product) {
                    OrderItem::create([
                        'id' => Str::uuid(),
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'pet_id' => $createdPets[$index % count($createdPets)]->id ?? null,
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'quantity' => 1,
                        'unit_price' => $product->price,
                        'total_price' => $product->price,
                    ]);
                }
            }

            // Créer quelques avis produits
            foreach ($products->take(3) as $product) {
                $existingReview = ProductReview::where('product_id', $product->id)
                    ->where('user_id', $user->id)
                    ->first();
                
                if (!$existingReview) {
                    ProductReview::create([
                        'id' => Str::uuid(),
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                        'rating' => $faker->numberBetween(4, 5),
                        'title' => 'Très bon produit pour mon animal',
                        'review' => $faker->text(200),
                        'is_verified_purchase' => true,
                        'is_approved' => true,
                        'helpful_votes' => $faker->numberBetween(0, 20),
                        'total_votes' => $faker->numberBetween(0, 25),
                    ]);
                }
            }
        }

        $this->command->info('Test data created successfully!');
        $this->command->info('- Test user: test@apwap.com / password');
        $this->command->info('- ' . count($createdPets) . ' pets created');
        $this->command->info('- Cart and order examples created');
    }
}
