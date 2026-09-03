<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account for the Filament panel (/admin).
        User::updateOrCreate(
            ['email' => 'admin@photofixzone.com'],
            [
                'name' => 'Pixel Graphic Studio Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        );

        $this->call([
            ThemeSeeder::class,
            SiteSettingSeeder::class,
            SectionSeeder::class,
            NavigationSeeder::class,
            FooterSeeder::class,
            ContentSeeder::class,
            ServiceSeeder::class,
            SocialProofSeeder::class,
            WorkSampleCategorySeeder::class,
            ServicePortfolioLinkSeeder::class,
            PricingSeeder::class,
            FaqSeeder::class,
            BlogSeeder::class,
            SeoMetaSeeder::class,
            AboutPageSeeder::class,
            FreeTrialPageSeeder::class,
            MediaSeeder::class,
        ]);

        // Media attachments don't trip the content-model cache observers.
        Cache::flush();
    }
}
