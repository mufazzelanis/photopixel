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
        // Admin account for the Filament panel (/admin). firstOrCreate() — unlike
        // updateOrCreate() — leaves an already-existing row completely untouched,
        // so re-running `db:seed` later can never silently reset the live admin
        // password out from under you.
        User::firstOrCreate(
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
            RoleSeeder::class,
        ]);

        // Media attachments don't trip the content-model cache observers.
        Cache::flush();
    }
}
