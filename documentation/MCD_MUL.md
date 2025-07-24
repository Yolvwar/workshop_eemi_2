## 🗄️ **Modèle Conceptuel de Données (MCD)**

```mermaid
erDiagram
    USERS {
        uuid id PK
        string first_name
        string last_name
        string email UK
        string phone
        string city
        string preferred_language
        timestamp email_verified_at
        string password
        string remember_token
        timestamps created_at_updated_at
    }

    PETS {
        uuid id PK
        uuid user_id FK
        string name
        string species
        string breed
        date birth_date
        decimal weight
        string gender
        text description
        string avatar
        timestamps created_at_updated_at
    }

    PET_HEALTH_RECORDS {
        uuid id PK
        uuid pet_id FK
        decimal weight_score
        decimal nutrition_score
        decimal exercise_score
        decimal mental_score
        decimal social_score
        decimal medical_score
        text notes
        timestamps created_at_updated_at
    }

    CONSULTATIONS {
        uuid id PK
        uuid user_id FK
        uuid pet_id FK
        string consultation_type
        string urgency_level
        string status
        date scheduled_date
        time scheduled_time
        text symptoms_description
        text notes
        decimal price
        timestamps created_at_updated_at
    }

    VETERINARIANS {
        uuid id PK
        string name
        string specialization
        text bio
        string phone
        string email
        string location
        boolean is_active
        decimal rating
        integer review_count
        decimal consultation_fee
        timestamps created_at_updated_at
    }

    PRODUCTS {
        uuid id PK
        uuid category_id FK
        string name
        string slug UK
        text description
        text short_description
        string sku UK
        string barcode
        string brand
        json tags
        json suitable_for_species
        json suitable_for_ages
        json suitable_for_sizes
        string primary_pillar
        json pillar_benefits
        decimal price
        decimal original_price
        decimal cost_price
        integer stock_quantity
        integer low_stock_threshold
        boolean manage_stock
        decimal weight
        string dimensions
        string status
        boolean featured
        json images
        json videos
        string meta_title
        text meta_description
        string meta_keywords
        boolean shipping_required
        decimal shipping_weight
        string shipping_dimensions
        decimal rating
        integer review_count
        timestamps created_at_updated_at
    }

    PRODUCT_CATEGORIES {
        uuid id PK
        uuid parent_id FK
        string name
        string slug UK
        text description
        string image
        integer sort_order
        boolean is_active
        timestamps created_at_updated_at
    }

    PRODUCT_REVIEWS {
        uuid id PK
        uuid product_id FK
        uuid user_id FK
        integer rating
        text title
        text comment
        boolean verified_purchase
        timestamps created_at_updated_at
    }

    CARTS {
        uuid id PK
        uuid user_id FK
        timestamps created_at_updated_at
    }

    CART_ITEMS {
        uuid id PK
        uuid cart_id FK
        uuid product_id FK
        integer quantity
        decimal price
        timestamps created_at_updated_at
    }

    ORDERS {
        uuid id PK
        uuid user_id FK
        string order_number UK
        string status
        decimal subtotal
        decimal tax_amount
        decimal shipping_amount
        decimal total_amount
        string currency
        json shipping_address
        json billing_address
        string payment_method
        string payment_status
        timestamp shipped_at
        timestamp delivered_at
        text notes
        timestamps created_at_updated_at
    }

    ORDER_ITEMS {
        uuid id PK
        uuid order_id FK
        uuid product_id FK
        integer quantity
        decimal price
        decimal total
        timestamps created_at_updated_at
    }

    USERS ||--o{ PETS : "possede"
    USERS ||--o{ CONSULTATIONS : "demande"
    USERS ||--o{ PRODUCT_REVIEWS : "ecrit"
    USERS ||--o{ CARTS : "a"
    USERS ||--o{ ORDERS : "passe"

    PETS ||--o| PET_HEALTH_RECORDS : "a"
    PETS ||--o{ CONSULTATIONS : "concerne"

    PRODUCT_CATEGORIES ||--o{ PRODUCT_CATEGORIES : "parent_de"
    PRODUCT_CATEGORIES ||--o{ PRODUCTS : "contient"

    PRODUCTS ||--o{ PRODUCT_REVIEWS : "recoit"
    PRODUCTS ||--o{ CART_ITEMS : "dans"
    PRODUCTS ||--o{ ORDER_ITEMS : "commande"

    CARTS ||--o{ CART_ITEMS : "contient"

    ORDERS ||--o{ ORDER_ITEMS : "inclut"

    VETERINARIANS ||--o{ CONSULTATIONS : "conduit"
```

---

## 🏗️ **Diagramme UML de Classes**

```mermaid
classDiagram
    class User {
        +UUID id
        +String firstName
        +String lastName
        +String email
        +String phone
        +String city
        +String preferredLanguage
        +DateTime emailVerifiedAt
        +String password
        +pets() Collection
        +consultations() Collection
        +reviews() Collection
        +cart() Cart
        +orders() Collection
    }

    class Pet {
        +UUID id
        +UUID userId
        +String name
        +String species
        +String breed
        +Date birthDate
        +Decimal weight
        +String gender
        +String description
        +String avatar
        +user() User
        +healthRecord() PetHealthRecord
        +consultations() Collection
        +getAge() Integer
        +getHealthScore() Decimal
    }

    class PetHealthRecord {
        +UUID id
        +UUID petId
        +Decimal weightScore
        +Decimal nutritionScore
        +Decimal exerciseScore
        +Decimal mentalScore
        +Decimal socialScore
        +Decimal medicalScore
        +String notes
        +pet() Pet
        +getOverallScore() Decimal
        +getScoresArray() Array
    }

    class Consultation {
        +UUID id
        +UUID userId
        +UUID petId
        +String consultationType
        +String urgencyLevel
        +String status
        +Date scheduledDate
        +Time scheduledTime
        +String symptomsDescription
        +String notes
        +Decimal price
        +user() User
        +pet() Pet
        +veterinarian() Veterinarian
    }

    class Veterinarian {
        +UUID id
        +String name
        +String specialization
        +String bio
        +String phone
        +String email
        +String location
        +Boolean isActive
        +Decimal rating
        +Integer reviewCount
        +Decimal consultationFee
        +consultations() Collection
    }

    class Product {
        +UUID id
        +UUID categoryId
        +String name
        +String slug
        +String description
        +String sku
        +String brand
        +Array suitableForSpecies
        +String primaryPillar
        +Decimal price
        +Decimal originalPrice
        +Integer stockQuantity
        +Boolean featured
        +Array images
        +Decimal rating
        +category() ProductCategory
        +reviews() Collection
        +cartItems() Collection
        +orderItems() Collection
        +isInStock() Boolean
        +hasDiscount() Boolean
        +getImageUrl() String
    }

    class ProductCategory {
        +UUID id
        +UUID parentId
        +String name
        +String slug
        +String description
        +String image
        +Integer sortOrder
        +Boolean isActive
        +parent() ProductCategory
        +children() Collection
        +products() Collection
    }

    class ProductReview {
        +UUID id
        +UUID productId
        +UUID userId
        +Integer rating
        +String title
        +String comment
        +Boolean verifiedPurchase
        +product() Product
        +user() User
    }

    class Cart {
        +UUID id
        +UUID userId
        +user() User
        +items() Collection
        +getTotal() Decimal
        +getItemCount() Integer
        +addItem() Void
        +removeItem() Void
        +clear() Void
    }

    class CartItem {
        +UUID id
        +UUID cartId
        +UUID productId
        +Integer quantity
        +Decimal price
        +cart() Cart
        +product() Product
        +getTotal() Decimal
    }

    class Order {
        +UUID id
        +UUID userId
        +String orderNumber
        +String status
        +Decimal subtotal
        +Decimal totalAmount
        +JSON shippingAddress
        +String paymentStatus
        +DateTime shippedAt
        +user() User
        +items() Collection
        +getTotalItems() Integer
        +markAsShipped() Void
        +markAsDelivered() Void
    }

    class OrderItem {
        +UUID id
        +UUID orderId
        +UUID productId
        +Integer quantity
        +Decimal price
        +Decimal total
        +order() Order
        +product() Product
    }

    User ||--o{ Pet : owns
    User ||--o{ Consultation : requests
    User ||--o{ ProductReview : writes
    User ||--|| Cart : has
    User ||--o{ Order : places

    Pet ||--|| PetHealthRecord : has
    Pet ||--o{ Consultation : involves

    ProductCategory ||--o{ ProductCategory : parentOf
    ProductCategory ||--o{ Product : contains

    Product ||--o{ ProductReview : receives
    Product ||--o{ CartItem : inCart
    Product ||--o{ OrderItem : ordered

    Cart ||--o{ CartItem : contains
    Order ||--o{ OrderItem : includes

    Veterinarian ||--o{ Consultation : conducts
```

---