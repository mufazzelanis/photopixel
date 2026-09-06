<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account for the Filament panel (/admin).
        // NOTE: this only runs on a *fresh* install — on an already-seeded database
        // updateOrCreate() matches by email and will not touch an existing password.
        // See the production checklist for rotating the live admin password.
        User::updateOrCreate(
            ['email' => 'admin@pixelgraphicstudio.com'],
            [
                'name' => 'Pixel Graphic Studio Admin',
                'password' => Hash::make(Str::random(24)),
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
            LegalPageSeeder::class,
            MediaSeeder::class,
        ]);

        // Media attachments don't trip the content-model cache observers.
        Cache::flush();
    }
}
