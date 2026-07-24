<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Tag;
use App\Models\Slider;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use App\Models\Comment;
use App\Models\NewsletterSubscriber;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ───────── Permissions ─────────
        $permissions = [
            'manage products', 'manage categories', 'manage orders',
            'manage users', 'manage settings', 'view admin dashboard',
        ];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // ───────── Roles ─────────
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $moderator  = Role::firstOrCreate(['name' => 'moderator']);
        $editor     = Role::firstOrCreate(['name' => 'editor']);
        $customerR  = Role::firstOrCreate(['name' => 'customer']);
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());
        $moderator->givePermissionTo(['manage orders', 'view admin dashboard']);
        $editor->givePermissionTo(['manage products', 'manage categories', 'view admin dashboard']);

        // ───────── Users ─────────
        $superAdminUser = User::firstOrCreate(['email' => 'superadmin@nest.com'], [
            'name' => 'Super Admin', 'password' => Hash::make('password'),
            'role' => 'admin', 'email_verified_at' => now(),
        ]);
        $superAdminUser->assignRole('super_admin');

        $adminUser = User::firstOrCreate(['email' => 'admin@nest.com'], [
            'name' => 'Admin User', 'password' => Hash::make('password'),
            'role' => 'admin', 'email_verified_at' => now(),
        ]);
        $adminUser->assignRole('admin');

        $customer = User::firstOrCreate(['email' => 'customer@nest.com'], [
            'name' => 'Customer User', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');

        // extra reviewer users from template
        $devon   = User::firstOrCreate(['email' => 'devon@example.com'], [
            'name' => 'Devon Lane', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);
        $guy     = User::firstOrCreate(['email' => 'guy@example.com'], [
            'name' => 'Guy Hawkins', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);
        $steven  = User::firstOrCreate(['email' => 'steven@example.com'], [
            'name' => 'Steven John', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);
        $kristin = User::firstOrCreate(['email' => 'kristin@example.com'], [
            'name' => 'Kristin Watson', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);
        $jane    = User::firstOrCreate(['email' => 'jane@example.com'], [
            'name' => 'Jane Cooper', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);
        $courtney = User::firstOrCreate(['email' => 'courtney@example.com'], [
            'name' => 'Courtney Henry', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);
        $ralph    = User::firstOrCreate(['email' => 'ralph@example.com'], [
            'name' => 'Ralph Edwards', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);
        $theresa  = User::firstOrCreate(['email' => 'theresa@example.com'], [
            'name' => 'Theresa Webb', 'password' => Hash::make('password'),
            'role' => 'customer', 'email_verified_at' => now(),
        ]);

        // ───────── Categories (11 from homepage carousel + 4 sidebar + mega menu parents) ─────────
        $categoriesData = [
            // Homepage featured categories carousel with images & counts
            ['name' => 'Cake & Milk',     'slug' => 'cake-milk',     'image' => 'assets/imgs/shop/cat-13.png', 'sort_order' => 1,  'description' => '26 items'],
            ['name' => 'Oganic Kiwi',     'slug' => 'oganic-kiwi',   'image' => 'assets/imgs/shop/cat-12.png', 'sort_order' => 2,  'description' => '28 items'],
            ['name' => 'Peach',           'slug' => 'peach',         'image' => 'assets/imgs/shop/cat-11.png', 'sort_order' => 3,  'description' => '14 items'],
            ['name' => 'Red Apple',       'slug' => 'red-apple',     'image' => 'assets/imgs/shop/cat-9.png',  'sort_order' => 4,  'description' => '54 items'],
            ['name' => 'Snack',           'slug' => 'snack',         'image' => 'assets/imgs/shop/cat-3.png',  'sort_order' => 5,  'description' => '56 items'],
            ['name' => 'Vegetables',      'slug' => 'vegetables',    'image' => 'assets/imgs/shop/cat-1.png',  'sort_order' => 6,  'description' => '72 items'],
            ['name' => 'Strawberry',      'slug' => 'strawberry',    'image' => 'assets/imgs/shop/cat-2.png',  'sort_order' => 7,  'description' => '36 items'],
            ['name' => 'Black Plum',      'slug' => 'black-plum',    'image' => 'assets/imgs/shop/cat-4.png',  'sort_order' => 8,  'description' => '123 items'],
            ['name' => 'Custard Apple',   'slug' => 'custard-apple', 'image' => 'assets/imgs/shop/cat-5.png',  'sort_order' => 9,  'description' => '34 items'],
            ['name' => 'Coffee & Tea',    'slug' => 'coffee-tea',    'image' => 'assets/imgs/shop/cat-14.png', 'sort_order' => 10, 'description' => '89 items'],
            ['name' => 'Headphone',       'slug' => 'headphone',     'image' => 'assets/imgs/shop/cat-15.png', 'sort_order' => 11, 'description' => '87 items'],
            // Sidebar filter categories (from shop-grid-left.html)
            ['name' => 'Milks & Dairies',  'slug' => 'milks-dairies',  'image' => null, 'sort_order' => 12, 'description' => null],
            ['name' => 'Coffes & Teas',    'slug' => 'coffes-teas',    'image' => null, 'sort_order' => 13, 'description' => null],
            ['name' => 'Pet Foods',        'slug' => 'pet-foods',      'image' => null, 'sort_order' => 14, 'description' => null],
            ['name' => 'Meats',            'slug' => 'meats',          'image' => null, 'sort_order' => 15, 'description' => null],
            ['name' => 'Fruits',           'slug' => 'fruits',         'image' => null, 'sort_order' => 16, 'description' => null],
            // Mega menu parents
            ['name' => 'Fruit & Vegetables',  'slug' => 'fruit-vegetables',  'image' => null, 'sort_order' => 17, 'description' => null],
            ['name' => 'Breakfast & Dairy',   'slug' => 'breakfast-dairy',   'image' => null, 'sort_order' => 18, 'description' => null],
            ['name' => 'Meat & Seafood',      'slug' => 'meat-seafood',      'image' => null, 'sort_order' => 19, 'description' => null],
            // Search dropdown categories (from header)
            ['name' => 'Wines & Alcohol',     'slug' => 'wines-alcohol',     'image' => null, 'sort_order' => 20, 'description' => null],
            ['name' => 'Clothing & Beauty',   'slug' => 'clothing-beauty',   'image' => null, 'sort_order' => 21, 'description' => null],
            ['name' => 'Fast Food',           'slug' => 'fast-food',         'image' => null, 'sort_order' => 22, 'description' => null],
            ['name' => 'Baking Material',     'slug' => 'baking-material',   'image' => null, 'sort_order' => 23, 'description' => null],
            ['name' => 'Fresh Seafood',       'slug' => 'fresh-seafood',     'image' => null, 'sort_order' => 24, 'description' => null],
            ['name' => 'Noodles & Rice',      'slug' => 'noodles-rice',      'image' => null, 'sort_order' => 25, 'description' => null],
            ['name' => 'Ice Cream',           'slug' => 'ice-cream',         'image' => null, 'sort_order' => 26, 'description' => null],
        ];

        $cats = [];
        foreach ($categoriesData as $c) {
            $cats[$c['slug']] = Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // ───────── Brands (from admin brands page + product cards) ─────────
        $brandsData = [
            // Admin brand page cards with item counts
            ['name' => 'Cardinal',          'slug' => 'cardinal'],
            ['name' => 'BirdFly',           'slug' => 'birdfly'],
            ['name' => 'Cocorico',          'slug' => 'cocorico'],
            ['name' => 'Yogilist',          'slug' => 'yogilist'],
            ['name' => 'Shivakin',          'slug' => 'shivakin'],
            ['name' => 'Acera',             'slug' => 'acera'],
            ['name' => 'Lion Electronics',  'slug' => 'lion-electronics'],
            ['name' => 'TwoHand',           'slug' => 'twohand'],
            ['name' => 'Kiaomin',           'slug' => 'kiaomin'],
            ['name' => 'Nokine',            'slug' => 'nokine'],
            // Product card vendor/brand labels
            ['name' => 'NestFood',          'slug' => 'nestfood'],
            ['name' => 'Stouffer',          'slug' => 'stouffer'],
            ['name' => 'StarKist',          'slug' => 'starkist'],
            ['name' => 'Hodo Foods',        'slug' => 'hodo-foods'],
            ['name' => 'Old El Paso',       'slug' => 'old-el-paso'],
            ['name' => 'Progresso',         'slug' => 'progresso'],
            ['name' => 'Yoplait',           'slug' => 'yoplait'],
            ['name' => 'Tyson',             'slug' => 'tyson'],
            ['name' => 'Nature Food',       'slug' => 'nature-food'],
            ['name' => 'Maruchan Ramen',    'slug' => 'maruchan-ramen'],
            ['name' => 'Red Baron Pizza',   'slug' => 'red-baron-pizza'],
            ['name' => 'Dove Promises',     'slug' => 'dove-promises'],
            ['name' => 'Lindt Grocery',     'slug' => 'lindt-grocery'],
            ['name' => 'Country Crock',     'slug' => 'country-crock'],
        ];

        $brands = [];
        foreach ($brandsData as $b) {
            $brands[$b['slug']] = Brand::firstOrCreate(['slug' => $b['slug']], $b);
        }

        // ───────── Tags ─────────
        $tagsData = ['Organic', 'Snack', 'Brown', 'Vegetable', 'Fruit', 'Dairy', 'Meat', 'Frozen', 'Beverage', 'Gluten-Free', 'New', 'Hot', 'Sale'];
        $tags = [];
        foreach ($tagsData as $t) {
            $tags[$t] = Tag::firstOrCreate(['name' => $t], ['slug' => Str::slug($t)]);
        }

        // ───────── Products (every unique product from templates) ─────────
        $productsData = [
            [
                'name' => 'Seeds of Change Organic Quinoa, Brown, & Red Rice',
                'slug' => 'seeds-of-change-organic-quinoa-brown-red-rice',
                'sku' => 'FWM15VKT', 'category' => 'snack', 'brand' => 'nestfood',
                'description' => 'Seeds of Change Organic Quinoa, Brown, & Red Rice. Certified organic, GMO-free, 100% whole grains. Perfect for a healthy meal.',
                'price' => 32.80, 'sale_price' => 28.85, 'stock_quantity' => 8,
                'badge' => 'hot', 'rating' => 4.0, 'review_count' => 32,
                'images' => ['assets/imgs/shop/product-1-1.jpg', 'assets/imgs/shop/product-1-2.jpg'],
                'tags' => ['Snack', 'Organic', 'Brown'],
                'variants' => ['50g', '60g', '80g', '100g', '150g'],
                'is_featured' => true,
            ],
            [
                'name' => 'All Natural Italian-Style Chicken Meatballs',
                'slug' => 'all-natural-italian-style-chicken-meatballs',
                'sku' => 'NMF2468', 'category' => 'vegetables', 'brand' => 'stouffer',
                'description' => 'All Natural Italian-Style Chicken Meatballs. Made with 100% natural ingredients, no artificial flavors or preservatives.',
                'price' => 55.80, 'sale_price' => 52.85, 'stock_quantity' => 12,
                'badge' => 'sale', 'rating' => 3.5, 'review_count' => 18,
                'images' => ['assets/imgs/shop/product-2-1.jpg', 'assets/imgs/shop/product-2-2.jpg'],
                'tags' => ['Meat', 'Natural'],
                'variants' => [],
                'is_featured' => true,
            ],
            [
                'name' => "Angie's Boomchickapop Sweet & Salty Kettle Corn",
                'slug' => 'angies-boomchickapop-sweet-salty-kettle-corn',
                'sku' => 'KVM15VK', 'category' => 'snack', 'brand' => 'starkist',
                'description' => "Angie's Boomchickapop Sweet & Salty Kettle Corn. Non-GMO, whole grain, certified gluten-free.",
                'price' => 52.80, 'sale_price' => 48.85, 'stock_quantity' => 20,
                'badge' => 'new', 'rating' => 4.0, 'review_count' => 24,
                'images' => ['assets/imgs/shop/product-3-1.jpg', 'assets/imgs/shop/product-3-2.jpg'],
                'tags' => ['Snack', 'Organic'],
                'variants' => [],
                'is_featured' => true,
            ],
            [
                'name' => 'Foster Farms Takeout Crispy Classic Buffalo Wings',
                'slug' => 'foster-farms-takeout-crispy-classic-buffalo-wings',
                'sku' => 'FFC7890', 'category' => 'vegetables', 'brand' => 'nestfood',
                'description' => 'Foster Farms Takeout Crispy Classic Buffalo Wings. Fully cooked, just heat and serve.',
                'price' => 19.80, 'sale_price' => 17.85, 'stock_quantity' => 15,
                'badge' => '', 'rating' => 4.0, 'review_count' => 12,
                'images' => ['assets/imgs/shop/product-4-1.jpg', 'assets/imgs/shop/product-4-2.jpg'],
                'tags' => ['Meat', 'Frozen'],
                'variants' => [],
                'is_featured' => true,
            ],
            [
                'name' => 'Blue Diamond Almonds Lightly Salted Vegetables',
                'slug' => 'blue-diamond-almonds-lightly-salted-vegetables',
                'sku' => 'BDA4567', 'category' => 'pet-foods', 'brand' => 'nestfood',
                'description' => 'Blue Diamond Almonds Lightly Salted Vegetables. Excellent source of vitamin E and magnesium.',
                'price' => 25.80, 'sale_price' => 23.85, 'stock_quantity' => 30,
                'badge' => 'best', 'rating' => 4.0, 'review_count' => 20,
                'images' => ['assets/imgs/shop/product-5-1.jpg', 'assets/imgs/shop/product-5-2.jpg'],
                'tags' => ['Snack', 'Organic'],
                'variants' => [],
                'is_featured' => true,
            ],
            [
                'name' => 'Chobani Complete Vanilla Greek Yogurt',
                'slug' => 'chobani-complete-vanilla-greek-yogurt',
                'sku' => 'CHP1234', 'category' => 'hodo-foods', 'brand' => 'nestfood',
                'description' => 'Chobani Complete Vanilla Greek Yogurt. High protein, no added sugar, naturally lactose-free.',
                'price' => 55.80, 'sale_price' => 54.85, 'stock_quantity' => 25,
                'badge' => '', 'rating' => 4.0, 'review_count' => 15,
                'images' => ['assets/imgs/shop/product-6-1.jpg', 'assets/imgs/shop/product-6-2.jpg'],
                'tags' => ['Dairy', 'Organic'],
                'variants' => [],
                'is_featured' => true,
            ],
            [
                'name' => 'Canada Dry Ginger Ale - 2 L Bottle - 200ml - 400g',
                'slug' => 'canada-dry-ginger-ale-2l-bottle',
                'sku' => 'CDG7891', 'category' => 'meats', 'brand' => 'nestfood',
                'description' => 'Canada Dry Ginger Ale - 2 L Bottle. Crisp, refreshing taste with real ginger.',
                'price' => 33.80, 'sale_price' => 32.85, 'stock_quantity' => 40,
                'badge' => '', 'rating' => 4.0, 'review_count' => 8,
                'images' => ['assets/imgs/shop/product-7-1.jpg', 'assets/imgs/shop/product-7-2.jpg'],
                'tags' => ['Beverage'],
                'variants' => ['200ml', '400g', '2L'],
                'is_featured' => false,
            ],
            [
                'name' => 'Encore Seafoods Stuffed Alaskan Salmon',
                'slug' => 'encore-seafoods-stuffed-alaskan-salmon',
                'sku' => 'ESS3214', 'category' => 'snack', 'brand' => 'nestfood',
                'description' => 'Encore Seafoods Stuffed Alaskan Salmon. Premium wild-caught salmon with crab and shrimp stuffing.',
                'price' => 37.80, 'sale_price' => 35.85, 'stock_quantity' => 18,
                'badge' => 'sale', 'rating' => 4.0, 'review_count' => 10,
                'images' => ['assets/imgs/shop/product-8-1.jpg', 'assets/imgs/shop/product-8-2.jpg'],
                'tags' => ['Seafood', 'Frozen'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => "Gorton's Beer Battered Fish Fillets with soft paper",
                'slug' => 'gortons-beer-battered-fish-fillets',
                'sku' => 'GBF6543', 'category' => 'coffes-teas', 'brand' => 'old-el-paso',
                'description' => "Gorton's Beer Battered Fish Fillets. Wild-caught Alaska pollock with a crispy golden batter.",
                'price' => 25.80, 'sale_price' => 23.85, 'stock_quantity' => 22,
                'badge' => 'hot', 'rating' => 4.0, 'review_count' => 14,
                'images' => ['assets/imgs/shop/product-9-1.jpg', 'assets/imgs/shop/product-9-2.jpg'],
                'tags' => ['Seafood', 'Frozen'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => "Haagen-Dazs Caramel Cone Ice Cream Ketchup",
                'slug' => 'haagen-dazs-caramel-cone-ice-cream',
                'sku' => 'HDC9876', 'category' => 'cream', 'brand' => 'tyson',
                'description' => "Haagen-Dazs Caramel Cone Ice Cream. Rich caramel with crunchy chocolate-covered cone pieces.",
                'price' => 24.80, 'sale_price' => 22.85, 'stock_quantity' => 35,
                'badge' => '', 'rating' => 2.0, 'review_count' => 9,
                'images' => ['assets/imgs/shop/product-10-1.jpg', 'assets/imgs/shop/product-10-2.jpg'],
                'tags' => ['Frozen', 'Dairy'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Field Roast Chao Cheese Creamy Original',
                'slug' => 'field-roast-chao-cheese-creamy-original',
                'sku' => 'FRC1122', 'category' => 'hodo-foods', 'brand' => 'nature-food',
                'description' => 'Field Roast Chao Cheese Creamy Original. Plant-based, dairy-free cheese alternative.',
                'price' => 245.80, 'sale_price' => 238.85, 'stock_quantity' => 10,
                'badge' => 'hot', 'rating' => 4.0, 'review_count' => 28,
                'images' => ['assets/imgs/shop/product-11-1.jpg', 'assets/imgs/shop/product-11-2.jpg'],
                'tags' => ['Organic', 'Dairy'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Fresh Organic Mustard Leaves Bell Pepper',
                'slug' => 'fresh-organic-mustard-leaves-bell-pepper',
                'sku' => 'FOM3344', 'category' => 'hodo-foods', 'brand' => 'nature-food',
                'description' => 'Fresh Organic Mustard Leaves with Bell Pepper. Farm-fresh organic greens.',
                'price' => 245.80, 'sale_price' => 238.85, 'stock_quantity' => 15,
                'badge' => 'sale', 'rating' => 4.0, 'review_count' => 16,
                'images' => ['assets/imgs/shop/product-12-1.jpg', 'assets/imgs/shop/product-12-2.jpg'],
                'tags' => ['Organic', 'Vegetable'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Organic Green Bell Pepper',
                'slug' => 'organic-green-bell-pepper',
                'sku' => 'OGP5566', 'category' => 'hodo-foods', 'brand' => 'nature-food',
                'description' => 'Organic Green Bell Pepper. Crunchy, sweet, and perfectly organic.',
                'price' => 245.80, 'sale_price' => 238.85, 'stock_quantity' => 20,
                'badge' => 'new', 'rating' => 4.0, 'review_count' => 22,
                'images' => ['assets/imgs/shop/product-13-1.jpg', 'assets/imgs/shop/product-13-2.jpg'],
                'tags' => ['Organic', 'Vegetable'],
                'variants' => [],
                'is_featured' => false,
            ],
            // ── Deals of the Day ──
            [
                'name' => 'Perdue Simply Smart Organics Gluten Free',
                'slug' => 'perdue-simply-smart-organics-gluten-free',
                'sku' => 'PSO7890', 'category' => 'snack', 'brand' => 'old-el-paso',
                'description' => 'Perdue Simply Smart Organics Gluten Free chicken. Antibiotic-free, USDA Organic.',
                'price' => 26.80, 'sale_price' => 24.85, 'stock_quantity' => 12,
                'badge' => '', 'rating' => 4.0, 'review_count' => 11,
                'images' => ['assets/imgs/banner/banner-6.png'],
                'tags' => ['Organic', 'Gluten-Free'],
                'variants' => [],
                'is_featured' => true,
            ],
            [
                'name' => 'Signature Wood-Fired Mushroom Frozen',
                'slug' => 'signature-wood-fired-mushroom-frozen',
                'sku' => 'SWM1234', 'category' => 'frozen', 'brand' => 'progresso',
                'description' => 'Signature Wood-Fired Mushroom Frozen. Authentic wood-fired flavor, ready in minutes.',
                'price' => 13.80, 'sale_price' => 12.85, 'stock_quantity' => 18,
                'badge' => '', 'rating' => 3.0, 'review_count' => 7,
                'images' => ['assets/imgs/banner/banner-7.png'],
                'tags' => ['Frozen', 'Mushroom'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Simply Lemonade with Raspberry Juice',
                'slug' => 'simply-lemonade-raspberry-juice',
                'sku' => 'SLR5678', 'category' => 'beverage', 'brand' => 'yoplait',
                'description' => 'Simply Lemonade with Raspberry Juice. No artificial flavors or preservatives.',
                'price' => 16.80, 'sale_price' => 15.85, 'stock_quantity' => 45,
                'badge' => '', 'rating' => 3.0, 'review_count' => 9,
                'images' => ['assets/imgs/banner/banner-8.png'],
                'tags' => ['Beverage', 'Fruit'],
                'variants' => [],
                'is_featured' => false,
            ],
            // ── Top Selling / Trending / Recently Added ──
            [
                'name' => 'Nestle Original Coffee-Mate Coffee Creamer',
                'slug' => 'nestle-original-coffee-mate-creamer',
                'sku' => 'NOC9012', 'category' => 'milks-dairies', 'brand' => 'nestfood',
                'description' => 'Nestle Original Coffee-Mate Coffee Creamer. Rich, creamy flavor for your coffee.',
                'price' => 33.80, 'sale_price' => 32.85, 'stock_quantity' => 50,
                'badge' => '', 'rating' => 4.0, 'review_count' => 19,
                'images' => ['assets/imgs/shop/thumbnail-1.jpg'],
                'tags' => ['Dairy', 'Beverage'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Organic Cage-Free Grade A Large Brown Eggs',
                'slug' => 'organic-cage-free-grade-a-large-brown-eggs',
                'sku' => 'OCF3456', 'category' => 'milks-dairies', 'brand' => 'nestfood',
                'description' => 'Organic Cage-Free Grade A Large Brown Eggs. Farm fresh, certified organic.',
                'price' => 33.80, 'sale_price' => 32.85, 'stock_quantity' => 60,
                'badge' => '', 'rating' => 4.0, 'review_count' => 25,
                'images' => ['assets/imgs/shop/thumbnail-4.jpg'],
                'tags' => ['Organic', 'Dairy'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Naturally Flavored Cinnamon Vanilla Light Roast Coffee',
                'slug' => 'naturally-flavored-cinnamon-vanilla-roast-coffee',
                'sku' => 'NFC7890', 'category' => 'coffes-teas', 'brand' => 'nestfood',
                'description' => 'Naturally Flavored Cinnamon Vanilla Light Roast Coffee. Smooth and aromatic.',
                'price' => 33.80, 'sale_price' => 32.85, 'stock_quantity' => 35,
                'badge' => '', 'rating' => 4.0, 'review_count' => 14,
                'images' => ['assets/imgs/shop/thumbnail-6.jpg'],
                'tags' => ['Beverage', 'Organic'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Pepperidge Farm Farmhouse Hearty White Bread',
                'slug' => 'pepperidge-farm-farmhouse-hearty-white-bread',
                'sku' => 'PFF1122', 'category' => 'baking-material', 'brand' => 'nestfood',
                'description' => 'Pepperidge Farm Farmhouse Hearty White Bread. Thick-cut slices, freshly baked taste.',
                'price' => 33.80, 'sale_price' => 32.85, 'stock_quantity' => 40,
                'badge' => '', 'rating' => 4.0, 'review_count' => 11,
                'images' => ['assets/imgs/shop/thumbnail-7.jpg'],
                'tags' => ['Baking'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Organic Frozen Triple Berry Blend',
                'slug' => 'organic-frozen-triple-berry-blend',
                'sku' => 'OFT3344', 'category' => 'fruits', 'brand' => 'nature-food',
                'description' => 'Organic Frozen Triple Berry Blend. Blueberries, raspberries, and blackberries.',
                'price' => 33.80, 'sale_price' => 32.85, 'stock_quantity' => 28,
                'badge' => '', 'rating' => 4.0, 'review_count' => 17,
                'images' => ['assets/imgs/shop/thumbnail-8.jpg'],
                'tags' => ['Organic', 'Frozen', 'Fruit'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Oroweat Country Buttermilk Bread',
                'slug' => 'oroweat-country-buttermilk-bread',
                'sku' => 'OCB5566', 'category' => 'baking-material', 'brand' => 'nestfood',
                'description' => 'Oroweat Country Buttermilk Bread. Soft, fluffy with a homestyle buttermilk taste.',
                'price' => 33.80, 'sale_price' => 32.85, 'stock_quantity' => 32,
                'badge' => '', 'rating' => 4.0, 'review_count' => 8,
                'images' => ['assets/imgs/shop/thumbnail-9.jpg'],
                'tags' => ['Baking'],
                'variants' => [],
                'is_featured' => false,
            ],
            // ── Compare page products ──
            [
                'name' => 'J.Crew Mercantile Women\'s Short Sleeve T-Shirt',
                'slug' => 'jcrew-mercantile-women-short-sleeve-tshirt',
                'sku' => 'JCW7890', 'category' => 'clothing-beauty', 'brand' => 'cardinal',
                'description' => 'J.Crew Mercantile Women\'s Short Sleeve T-Shirt. Soft cotton, relaxed fit.',
                'price' => 14.00, 'sale_price' => 12.00, 'stock_quantity' => 50,
                'badge' => '', 'rating' => 4.5, 'review_count' => 121,
                'images' => ['assets/imgs/shop/product-2-1.jpg'],
                'tags' => ['Clothing'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Amazon Essentials Women\'s Tanks',
                'slug' => 'amazon-essentials-women-tanks',
                'sku' => 'AEW1234', 'category' => 'clothing-beauty', 'brand' => 'cardinal',
                'description' => 'Amazon Essentials Women\'s Tanks. Lightweight, comfortable, perfect for layering.',
                'price' => 15.00, 'sale_price' => 14.00, 'stock_quantity' => 0,
                'badge' => '', 'rating' => 4.5, 'review_count' => 35,
                'images' => ['assets/imgs/shop/product-1-1.jpg'],
                'tags' => ['Clothing'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Amazon Brand - Daily Ritual Women\'s Jersey',
                'slug' => 'amazon-brand-daily-ritual-womens-jersey',
                'sku' => 'ADR5678', 'category' => 'clothing-beauty', 'brand' => 'cardinal',
                'description' => 'Amazon Brand - Daily Ritual Women\'s Jersey. Soft modal fabric, easy care.',
                'price' => 16.00, 'sale_price' => 15.00, 'stock_quantity' => 40,
                'badge' => '', 'rating' => 4.5, 'review_count' => 125,
                'images' => ['assets/imgs/shop/product-3-1.jpg'],
                'tags' => ['Clothing'],
                'variants' => [],
                'is_featured' => false,
            ],
            // ── Related products (from product detail page) ──
            [
                'name' => 'Ulstra Bass Headphone',
                'slug' => 'ulstra-bass-headphone',
                'sku' => 'UBH9012', 'category' => 'headphone', 'brand' => 'lion-electronics',
                'description' => 'Ulstra Bass Headphone. Premium noise-cancelling with deep bass response.',
                'price' => 245.80, 'sale_price' => 238.85, 'stock_quantity' => 15,
                'badge' => 'hot', 'rating' => 4.0, 'review_count' => 30,
                'images' => ['assets/imgs/shop/product-14-1.jpg'],
                'tags' => ['Electronics'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Smart Bluetooth Speaker',
                'slug' => 'smart-bluetooth-speaker',
                'sku' => 'SBS3456', 'category' => 'headphone', 'brand' => 'lion-electronics',
                'description' => 'Smart Bluetooth Speaker. Portable, waterproof, 20-hour battery life.',
                'price' => 145.80, 'sale_price' => 138.85, 'stock_quantity' => 20,
                'badge' => 'best', 'rating' => 4.0, 'review_count' => 45,
                'images' => ['assets/imgs/shop/product-15-1.jpg'],
                'tags' => ['Electronics'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'HomeSpeak 12UEA Goole Speaker',
                'slug' => 'homespeak-12uea-goole-speaker',
                'sku' => 'HS1789', 'category' => 'headphone', 'brand' => 'lion-electronics',
                'description' => 'HomeSpeak 12UEA Goole Speaker. Smart home compatible voice assistant speaker.',
                'price' => 1245.80, 'sale_price' => 738.80, 'stock_quantity' => 8,
                'badge' => 'new', 'rating' => 4.0, 'review_count' => 12,
                'images' => ['assets/imgs/shop/product-16-1.jpg'],
                'tags' => ['Electronics'],
                'variants' => [],
                'is_featured' => false,
            ],
            [
                'name' => 'Dadua Camera 4K 2024EF',
                'slug' => 'dadua-camera-4k-2024ef',
                'sku' => 'DC4K901', 'category' => 'headphone', 'brand' => 'lion-electronics',
                'description' => 'Dadua Camera 4K 2024EF. Professional 4K video camera with image stabilization.',
                'price' => 98.80, 'sale_price' => 89.80, 'stock_quantity' => 6,
                'badge' => 'hot', 'rating' => 4.0, 'review_count' => 8,
                'images' => ['assets/imgs/shop/product-17-1.jpg'],
                'tags' => ['Electronics'],
                'variants' => [],
                'is_featured' => false,
            ],
        ];

        // Resolve category and brand foreign keys from slugs
        $productCategoryMap = [
            'snack'            => 'snack',
            'vegetables'       => 'vegetables',
            'pet-foods'        => 'pet-foods',
            'meats'            => 'meats',
            'hodo-foods'       => 'hodo-foods',
            'cream'            => 'ice-cream',
            'milks-dairies'    => 'milks-dairies',
            'coffes-teas'      => 'coffes-teas',
            'frozen'           => 'snack',
            'beverage'         => 'coffee-tea',
            'baking-material'  => 'baking-material',
            'fruits'           => 'fruits',
            'clothing-beauty'  => 'clothing-beauty',
            'headphone'        => 'headphone',
        ];

        foreach ($productsData as $pData) {
            $catSlug = $productCategoryMap[$pData['category']] ?? $pData['category'];
            $catId   = $cats[$catSlug]->id ?? ($cats['snack']->id ?? 1);
            $brandId = $brands[$pData['brand']]->id ?? null;

            $pTags   = $pData['tags'] ?? [];
            $pBadge  = $pData['badge'] ?? '';
            $pRating = $pData['rating'] ?? 4.0;
            $pReviewCount = $pData['review_count'] ?? 0;
            $pImages = $pData['images'] ?? [];
            $pVariants = $pData['variants'] ?? [];
            $pIsFeatured = $pData['is_featured'] ?? false;

            unset($pData['category'], $pData['brand'], $pData['images'], $pData['tags'],
                  $pData['badge'], $pData['rating'], $pData['review_count'],
                  $pData['variants'], $pData['is_featured']);

            $pData['category_id'] = $catId;
            $pData['brand_id']    = $brandId;
            $pData['is_featured'] = $pIsFeatured;

            $product = Product::firstOrCreate(['slug' => $pData['slug']], $pData);

            // Images
            foreach ($pImages as $idx => $imgPath) {
                ProductImage::firstOrCreate(
                    ['product_id' => $product->id, 'is_primary' => $idx === 0],
                    ['image_path' => $imgPath, 'alt_text' => $product->name, 'sort_order' => $idx]
                );
            }

            // Variants
            foreach ($pVariants as $vName) {
                ProductVariant::firstOrCreate(
                    ['product_id' => $product->id, 'name' => $vName],
                    ['price' => $product->price, 'stock_quantity' => 10, 'sku' => $product->sku . '-' . Str::slug($vName)]
                );
            }

            // Tags pivot
            foreach ($pTags as $tagName) {
                if (isset($tags[$tagName])) {
                    $product->tags()->syncWithoutDetaching([$tags[$tagName]->id]);
                }
            }
        }

        // ───────── Reviews (exact data from admin reviews page) ─────────
        $reviewsData = [
            ['reviewer' => 'devon@example.com',  'product' => 'seeds-of-change-organic-quinoa-brown-red-rice', 'rating' => 3, 'comment' => 'Good quality quinoa but packaging could be better.',          'days_ago' => 400],
            ['reviewer' => 'guy@example.com',     'product' => 'all-natural-italian-style-chicken-meatballs',    'rating' => 4, 'comment' => 'Great taste, my family loves these meatballs!',               'days_ago' => 430],
            ['reviewer' => 'steven@example.com',  'product' => 'angies-boomchickapop-sweet-salty-kettle-corn',   'rating' => 4, 'comment' => 'Delicious popcorn, perfect snack for movie night.',          'days_ago' => 350],
            ['reviewer' => 'kristin@example.com', 'product' => 'foster-farms-takeout-crispy-classic-buffalo-wings','rating' => 5, 'comment' => 'Crispy and flavorful! Best frozen wings I have had.',       'days_ago' => 300],
            ['reviewer' => 'jane@example.com',    'product' => 'blue-diamond-almonds-lightly-salted-vegetables', 'rating' => 3, 'comment' => 'Decent almonds, could use less salt.',                      'days_ago' => 280],
            ['reviewer' => 'courtney@example.com','product' => 'chobani-complete-vanilla-greek-yogurt',          'rating' => 1, 'comment' => 'Not my favorite flavor, too sweet for my liking.',           'days_ago' => 350],
            ['reviewer' => 'ralph@example.com',   'product' => 'canada-dry-ginger-ale-2l-bottle',               'rating' => 2, 'comment' => 'Standard ginger ale, nothing special.',                     'days_ago' => 420],
            ['reviewer' => 'theresa@example.com', 'product' => 'encore-seafoods-stuffed-alaskan-salmon',         'rating' => 5, 'comment' => 'Excellent seafood quality! Restaurant grade at home.',     'days_ago' => 330],
            ['reviewer' => 'devon@example.com',   'product' => 'haagen-dazs-caramel-cone-ice-cream',            'rating' => 3, 'comment' => 'Good ice cream but a bit too expensive.',                  'days_ago' => 370],
            ['reviewer' => 'guy@example.com',     'product' => 'nestle-original-coffee-mate-creamer',           'rating' => 4, 'comment' => 'Perfect for my morning coffee routine.',                   'days_ago' => 310],
            ['reviewer' => 'steven@example.com',  'product' => 'organic-cage-free-grade-a-large-brown-eggs',     'rating' => 5, 'comment' => 'Fresh, organic, and great taste. Highly recommend!',       'days_ago' => 290],
            ['reviewer' => 'kristin@example.com', 'product' => 'organic-frozen-triple-berry-blend',              'rating' => 4, 'comment' => 'Love using these in smoothies and baking.',                'days_ago' => 340],
            ['reviewer' => 'jane@example.com',    'product' => 'ulstra-bass-headphone',                          'rating' => 5, 'comment' => 'Incredible sound quality and comfort for long sessions.',  'days_ago' => 200],
        ];

        foreach ($reviewsData as $rData) {
            $reviewerUser = User::where('email', $rData['reviewer'])->first();
            $reviewProduct = Product::where('slug', $rData['product'])->first();
            if ($reviewerUser && $reviewProduct) {
                Review::firstOrCreate(
                    ['user_id' => $reviewerUser->id, 'product_id' => $reviewProduct->id],
                    [
                        'rating' => $rData['rating'],
                        'comment' => $rData['comment'],
                        'is_approved' => true,
                        'created_at' => now()->subDays($rData['days_ago']),
                    ]
                );
            }
        }

        // ───────── Sliders (from hero banner section) ─────────
        Slider::firstOrCreate(['title' => "Don't miss amazing grocery deals"], [
            'subtitle' => 'Sign up for the daily newsletter',
            'image' => 'assets/imgs/slider/slider-1.png',
            'link' => '/shop',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        Slider::firstOrCreate(['title' => 'Fresh Vegetables Big discount'], [
            'subtitle' => 'Save up to 50% off on your first order',
            'image' => 'assets/imgs/slider/slider-2.png',
            'link' => '/shop',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // ───────── Blog (from blog template pages) ─────────
        $blogCat = BlogCategory::firstOrCreate(['slug' => 'recipes'], [
            'name' => 'Recipes & Cooking',
            'description' => 'Delicious recipes and cooking tips',
        ]);
        $blogCat2 = BlogCategory::firstOrCreate(['slug' => 'health'], [
            'name' => 'Health & Wellness',
            'description' => 'Health tips and nutrition advice',
        ]);

        $blogPost1 = BlogPost::firstOrCreate(['slug' => 'best-healthy-organic-recipes-for-family'], [
            'user_id' => $adminUser->id,
            'blog_category_id' => $blogCat->id,
            'title' => 'Best Healthy Organic Recipes for Your Family Health',
            'excerpt' => 'Discover the best organic recipes to keep your family healthy and energized.',
            'body' => 'Organic foods are richer in antioxidants and essential nutrients. Here are our top picks for healthy weeknight dinners that the whole family will love. From quinoa bowls to fresh vegetable stir-fries, these recipes are quick, easy, and packed with nutrition.',
            'thumbnail' => 'assets/imgs/blog/blog-1.jpg',
            'read_time' => '6 mins',
            'published_at' => now()->subDays(10),
            'is_active' => true,
        ]);

        $blogPost2 = BlogPost::firstOrCreate(['slug' => 'top-10-superfoods-for-daily-nutrition'], [
            'user_id' => $adminUser->id,
            'blog_category_id' => $blogCat2->id,
            'title' => 'Top 10 Superfoods for Daily Nutrition',
            'excerpt' => 'Incorporate these superfoods into your daily diet for maximum health benefits.',
            'body' => 'Superfoods are nutrient-rich foods considered to be especially beneficial for health. From blueberries and kale to salmon and quinoa, these foods pack a nutritional punch.',
            'thumbnail' => 'assets/imgs/blog/blog-2.jpg',
            'read_time' => '5 mins',
            'published_at' => now()->subDays(5),
            'is_active' => true,
        ]);

        // Blog Comments
        Comment::firstOrCreate(
            ['blog_post_id' => $blogPost1->id, 'user_id' => $customer->id],
            ['name' => 'Devon Lane', 'email' => 'devon@example.com',
             'body' => 'This article is extremely helpful! I tried the quinoa recipe and my kids loved it.',
             'is_approved' => true]
        );
        Comment::firstOrCreate(
            ['blog_post_id' => $blogPost1->id, 'user_id' => $guy->id],
            ['name' => 'Guy Hawkins', 'email' => 'guy@example.com',
             'body' => 'Great selection of recipes. The organic ingredients make a real difference in taste.',
             'is_approved' => true]
        );
        Comment::firstOrCreate(
            ['blog_post_id' => $blogPost2->id, 'user_id' => $kristin->id],
            ['name' => 'Kristin Watson', 'email' => 'kristin@example.com',
             'body' => 'I have been adding more superfoods to my diet after reading this. Feeling more energized already!',
             'is_approved' => true]
        );

        // ───────── Newsletter Subscribers ─────────
        NewsletterSubscriber::firstOrCreate(['email' => 'subscriber1@example.com'], [
            'is_active' => true, 'subscribed_at' => now()->subDays(15),
        ]);
        NewsletterSubscriber::firstOrCreate(['email' => 'subscriber2@example.com'], [
            'is_active' => true, 'subscribed_at' => now()->subDays(8),
        ]);
    }
}
