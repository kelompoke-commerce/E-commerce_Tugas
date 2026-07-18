<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name'     => 'Admin Libas',
            'email'    => 'admin@libascafe.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '081234567890',
            'is_active'=> true,
        ]);

        // Demo customer
        User::create([
            'name'     => 'Pelanggan Demo',
            'email'    => 'customer@libascafe.com',
            'password' => Hash::make('customer123'),
            'role'     => 'customer',
            'phone'    => '089876543210',
            'address'  => 'Jl. Contoh No. 1, Jakarta',
            'is_active'=> true,
        ]);

        // Categories
        $kopi = Category::create([
            'name'        => 'Kopi',
            'slug'        => 'kopi',
            'description' => 'Minuman berbasis kopi pilihan terbaik',
            'icon'        => '☕',
            'is_active'   => true,
            'sort_order'  => 1,
        ]);

        $nonKopi = Category::create([
            'name'        => 'Non Kopi',
            'slug'        => 'non-kopi',
            'description' => 'Minuman segar tanpa kopi',
            'icon'        => '🧃',
            'is_active'   => true,
            'sort_order'  => 2,
        ]);

        $cemilan = Category::create([
            'name'        => 'Cemilan',
            'slug'        => 'cemilan',
            'description' => 'Snack dan makanan ringan pendamping',
            'icon'        => '🍪',
            'is_active'   => true,
            'sort_order'  => 3,
        ]);

        // Kopi products
        $kopiProducts = [
            ['name' => 'Americano', 'price' => 18000, 'description' => 'Espresso dengan air panas, rasa kopi murni yang kuat dan bold.', 'is_featured' => true],
            ['name' => 'Cappuccino', 'price' => 22000, 'description' => 'Espresso dengan steamed milk dan milk foam yang creamy.', 'is_featured' => true],
            ['name' => 'Latte', 'price' => 24000, 'description' => 'Espresso dengan susu steamed yang lebih banyak, lembut dan ringan.', 'is_featured' => false],
            ['name' => 'Espresso', 'price' => 15000, 'description' => 'Shot espresso murni, pekat dan aromatic.', 'is_featured' => false],
            ['name' => 'Cold Brew', 'price' => 25000, 'description' => 'Kopi diseduh dingin selama 12 jam, smooth dan less acidic.', 'is_featured' => true],
            ['name' => 'Kopi Susu Gula Aren', 'price' => 20000, 'description' => 'Kopi susu dengan manis legit gula aren khas nusantara.', 'is_featured' => true],
            ['name' => 'Vietnam Drip', 'price' => 22000, 'description' => 'Kopi vietnam dengan susu kental manis, manis dan kuat.', 'is_featured' => false],
            ['name' => 'Flat White', 'price' => 23000, 'description' => 'Ristretto dengan microfoam susu, kuat dan smooth.', 'is_featured' => false],
        ];

        foreach ($kopiProducts as $p) {
            Product::create([
                'category_id' => $kopi->id,
                'name'        => $p['name'],
                'slug'        => Str::slug($p['name']),
                'description' => $p['description'],
                'price'       => $p['price'],
                'stock'       => rand(20, 100),
                'is_available'=> true,
                'is_featured' => $p['is_featured'],
            ]);
        }

        // Non-Kopi products
        $nonKopiProducts = [
            ['name' => 'Matcha Latte', 'price' => 25000, 'description' => 'Teh hijau Jepang premium dengan steamed milk yang creamy.', 'is_featured' => true],
            ['name' => 'Taro Latte', 'price' => 24000, 'description' => 'Minuman talas ungu dengan susu, manis dan berwarna cantik.', 'is_featured' => true],
            ['name' => 'Coklat Panas', 'price' => 20000, 'description' => 'Dark chocolate premium diseduh panas, kaya rasa coklat.', 'is_featured' => false],
            ['name' => 'Strawberry Smoothie', 'price' => 22000, 'description' => 'Blend strawberry segar dengan yogurt, segar dan asam manis.', 'is_featured' => false],
            ['name' => 'Blue Ocean', 'price' => 23000, 'description' => 'Minuman butterfly pea flower dengan lemon, cantik dan menyegarkan.', 'is_featured' => true],
            ['name' => 'Lemon Tea', 'price' => 16000, 'description' => 'Teh dengan perasan lemon segar, dingin dan menyegarkan.', 'is_featured' => false],
        ];

        foreach ($nonKopiProducts as $p) {
            Product::create([
                'category_id' => $nonKopi->id,
                'name'        => $p['name'],
                'slug'        => \Illuminate\Support\Str::slug($p['name']),
                'description' => $p['description'],
                'price'       => $p['price'],
                'stock'       => rand(20, 100),
                'is_available'=> true,
                'is_featured' => $p['is_featured'],
            ]);
        }

        // Cemilan products
        $cemilanProducts = [
            ['name' => 'Croissant Butter', 'price' => 18000, 'description' => 'Croissant renyah berlapis mentega, cocok dengan kopi pagi.', 'is_featured' => true],
            ['name' => 'Roti Bakar Coklat', 'price' => 15000, 'description' => 'Roti bakar tebal dengan lelehan coklat dan taburan keju.', 'is_featured' => false],
            ['name' => 'Cookies Oat', 'price' => 12000, 'description' => 'Cookies oatmeal crispy dengan chocolate chip, 2 pcs.', 'is_featured' => false],
            ['name' => 'Banana Bread', 'price' => 20000, 'description' => 'Cake pisang moist dan lembut dengan aroma vanilla.', 'is_featured' => true],
            ['name' => 'French Fries', 'price' => 20000, 'description' => 'Kentang goreng crispy dengan saus tomat dan mayonaise.', 'is_featured' => false],
            ['name' => 'Sandwich Club', 'price' => 25000, 'description' => 'Sandwich isi tuna mayo, telur, selada dan tomat.', 'is_featured' => true],
        ];

        foreach ($cemilanProducts as $p) {
            Product::create([
                'category_id' => $cemilan->id,
                'name'        => $p['name'],
                'slug'        => \Illuminate\Support\Str::slug($p['name']),
                'description' => $p['description'],
                'price'       => $p['price'],
                'stock'       => rand(20, 100),
                'is_available'=> true,
                'is_featured' => $p['is_featured'],
            ]);
        }
    }
}
