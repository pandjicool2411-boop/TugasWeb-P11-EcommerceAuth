<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 3 akun contoh untuk 3 role =====
        $admin = User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $editor = User::create([
            'name' => 'Editor Toko',
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
            'role' => 'editor',
        ]);

        User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // ===== 6 kategori x 9 produk = 54 produk =====
        $catalog = [
            'Elektronik' => [
                ['Smartphone Samsung Galaxy A55', 5999000],
                ['Xiaomi Redmi Note 13', 2899000],
                ['Laptop ASUS Vivobook 14', 7499000],
                ['Laptop Lenovo IdeaPad Slim 3', 6899000],
                ['Earbuds TWS Bluetooth Pro', 349000],
                ['Smartwatch Amazfit Bip 5', 899000],
                ['Powerbank 20000mAh Fast Charging', 299000],
                ['Speaker Bluetooth JBL Go 3', 549000],
                ['Monitor LG 24 Inch Full HD', 1699000],
            ],
            'Fashion Pria' => [
                ['Kemeja Flannel Lengan Panjang', 159000],
                ['Kaos Polos Cotton Combed 30s', 75000],
                ['Celana Chino Slim Fit', 189000],
                ['Jaket Bomber Waterproof', 279000],
                ['Hoodie Zipper Fleece', 199000],
                ['Sepatu Sneakers Kanvas', 249000],
                ['Ikat Pinggang Kulit Asli', 129000],
                ['Topi Baseball Bordir', 69000],
                ['Jam Tangan Analog Klasik', 325000],
            ],
            'Fashion Wanita' => [
                ['Dress Midi Rayon Motif Bunga', 175000],
                ['Blouse Satin Lengan Balon', 145000],
                ['Rok Plisket Panjang', 119000],
                ['Hijab Pashmina Ceruty Babydoll', 59000],
                ['Cardigan Rajut Oversize', 135000],
                ['Tas Selempang Kulit Sintetis', 189000],
                ['Flat Shoes Nyaman Harian', 155000],
                ['Kalung Stainless Anti Karat', 89000],
                ['Celana Kulot Highwaist', 129000],
            ],
            'Rumah Tangga' => [
                ['Rice Cooker Digital 1.8 Liter', 449000],
                ['Blender Kaca 2 Liter', 329000],
                ['Set Panci Anti Lengket 5 Pcs', 399000],
                ['Dispenser Air Galon Bawah', 899000],
                ['Setrika Uap Portable', 259000],
                ['Lampu LED Bulb 12 Watt (Isi 4)', 99000],
                ['Rak Sepatu Susun 4 Tingkat', 149000],
                ['Set Sprei Katun 160x200', 219000],
                ['Vacuum Cleaner Handheld', 599000],
            ],
            'Olahraga' => [
                ['Matras Yoga Anti Slip 8mm', 129000],
                ['Dumbbell Set Vinyl 10 Kg', 259000],
                ['Sepatu Lari Ringan Breathable', 379000],
                ['Botol Minum Tumbler 1 Liter', 79000],
                ['Raket Badminton Carbon Set', 289000],
                ['Bola Futsal Size 4', 165000],
                ['Skipping Rope Speed Bearing', 49000],
                ['Sarung Tangan Gym Padded', 65000],
                ['Tas Olahraga Duffel Waterproof', 175000],
            ],
            'Buku & Alat Tulis' => [
                ['Novel Laskar Pelangi', 89000],
                ['Buku Filosofi Teras', 98000],
                ['Buku Atomic Habits (Terjemahan)', 108000],
                ['Notebook A5 Hardcover Dotted', 45000],
                ['Pulpen Gel Set 12 Warna', 39000],
                ['Stabilo Highlighter Pastel 6 Pcs', 42000],
                ['Kalkulator Scientific Casio fx-991', 259000],
                ['Buku Belajar Laravel untuk Pemula', 125000],
                ['Agenda Planner 2026 Weekly', 79000],
            ],
        ];

        foreach ($catalog as $categoryName => $products) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => 'Koleksi produk kategori ' . $categoryName,
            ]);

            foreach ($products as [$name, $price]) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $name . ' kualitas terbaik, garansi toko, dan siap dikirim ke seluruh Indonesia.',
                    'price' => $price,
                    'stock' => fake()->numberBetween(0, 100),
                    'is_active' => fake()->boolean(90),
                ]);
            }
        }

        // ===== 20 customer, masing-masing punya 1 alamat utama =====
        $customers = Customer::factory()->count(20)->create();

        foreach ($customers as $customer) {
            Address::factory()->create([
                'customer_id' => $customer->id,
                'is_default' => true,
            ]);
        }

        // ===== Order + item (total dihitung dari item supaya konsisten) =====
        $allProducts = Product::all();

        foreach ($customers as $customer) {
            $address = $customer->addresses()->first();

            for ($i = 0; $i < fake()->numberBetween(1, 3); $i++) {
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'address_id' => $address->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'status' => fake()->randomElement(['pending', 'paid', 'shipped', 'completed', 'cancelled']),
                    'total_amount' => 0,
                ]);

                $total = 0;

                foreach ($allProducts->random(fake()->numberBetween(1, 4)) as $product) {
                    $qty = fake()->numberBetween(1, 3);

                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $product->price,
                    ]);

                    $total += $qty * (float) $product->price;
                }

                $order->update(['total_amount' => $total]);
            }
        }

        // ===== 60 review acak =====
        Review::factory()
            ->count(60)
            ->state(fn () => [
                'product_id' => $allProducts->random()->id,
                'customer_id' => $customers->random()->id,
            ])
            ->create();

        // ===== 3 post contoh (untuk demo PostPolicy) =====
        Post::create([
            'user_id' => $admin->id,
            'title' => 'Pengumuman dari Admin',
            'body' => 'Ini post milik admin.',
        ]);

        Post::create([
            'user_id' => $editor->id,
            'title' => 'Tips Belanja Hemat',
            'body' => 'Ini post milik editor.',
        ]);

        Post::create([
            'user_id' => $editor->id,
            'title' => 'Review Produk Terbaru',
            'body' => 'Ini juga post milik editor.',
        ]);
    }
}