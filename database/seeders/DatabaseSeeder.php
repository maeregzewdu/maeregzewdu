<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lead;
use App\Models\ContactMessage;
use App\Models\Plan;
use App\Models\MyInfo;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Maereg Zewdu',
            'email' => 'founder@maeregzewdu.com',
            'password' => Hash::make('password'),
        ]);

        // Lead::factory(10)->create();
        // ContactMessage::factory(10)->create();

        Plan::create([
            'name' => 'Basic',
            'features' => ['1-page modern website', 'Responsive Design', 'Custom branding', 'Contact form integration', 'Basic SEO'],
            'price' => 4999,
            'status' => 'active'
        ]);
        Plan::create([
            'name' => 'Pro',
            'features' => ['Upto 5 pages', 'Responsive Design', 'Branding + Custom UI/UX', 'Admin Dashboard(if needed)', 'Medium SEO'],
            'price' => 9999,
            'status' => 'active',
            'is_popular' => true
        ]);
        Plan::create([
            'name' => 'Enterprise',
            'features' => ['Unlimited pages', 'Responsive Design', 'Custom Features', 'Google OAuth', 'Advanced SEO'],
            'price' => null,
            'status' => 'inactive'
        ]);

        MyInfo::create([
            'name' => 'Maereg Zewdu',
            'email' => 'info@maeregzewdu.com',
            'phone' => '+251965598182',
            'address' => 'Addis Ababa, Ethiopia'
        ]);

        SocialLink::create([
            'platform' => 'Facebook',
            'url' => 'https://www.facebook.com/maeregzewduu',
            'username' => 'maeregzewduu',
            'icon' => 'ri-facebook-fill',
            'is_active' => true
        ]);
        
        SocialLink::create([
            'platform' => 'Instagram',
            'url' => 'https://www.instagram.com/_maereg',
            'username' => '_maereg',
            'icon' => 'ri-instagram-fill',
            'is_active' => true
        ]);
        
        SocialLink::create([
            'platform' => 'x',
            'url' => 'https://www.x.com/_maereg',
            'username' => '_maereg',
            'icon' => 'ri-twitter-x-fill',
            'is_active' => true
        ]);
        
        SocialLink::create([
            'platform' => 'LinkedIn',
            'url' => 'https://www.linkedin.com/in/maeregzewdu',
            'username' => 'maeregzewdu',
            'icon' => 'ri-linkedin-fill',
            'is_active' => true
        ]);

        SocialLink::create([
            'platform' => 'WhatsApp',
            'url' => 'https://wa.me/251965598182',
            'username' => '251965598182',
            'icon' => 'ri-whatsapp-fill',
            'is_active' => true
        ]);
        
        SocialLink::create([
            'platform' => 'Telegram',
            'url' => 'https://t.me/maeregzewdu',
            'username' => 'maeregzewdu',
            'icon' => 'ri-telegram-fill',
            'is_active' => false
        ]);
        
        SocialLink::create([
            'platform' => 'GitHub',
            'url' => 'https://www.github.com/maeregzewdu',
            'username' => 'maeregzewdu',
            'icon' => 'ri-github-fill',
            'is_active' => false
        ]);
        
        SocialLink::create([
            'platform' => 'YouTube',
            'url' => 'https://www.youtube.com/@maereg_zewdu',
            'username' => 'maereg_zewdu',
            'icon' => 'ri-youtube-fill',
            'is_active' => false
        ]);
    }
}
