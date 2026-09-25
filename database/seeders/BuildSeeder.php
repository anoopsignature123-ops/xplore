<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuildCategory;
use App\Models\Builder;
use App\Models\BuilderService;
use App\Models\BuilderCertification;
use App\Models\BuilderServiceArea;
use App\Models\BuilderPortfolio;
use App\Models\BuilderCompletedProject;
use App\Models\BuilderReview;
use App\Models\BuilderInquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BuildSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories
        $categoriesData = [
            ['name' => 'Architect', 'slug' => 'architect'],
            ['name' => 'Civil Contractor', 'slug' => 'civilContractor'],
            ['name' => 'Structural Engineer', 'slug' => 'structuralEngineer'],
            ['name' => 'Interior Designer', 'slug' => 'interiorDesigner'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = BuildCategory::updateOrCreate(
                ['slug' => $c['slug']],
                ['name' => $c['name'], 'status' => true]
            );
        }

        // 2. Seed Builder 1: Skyline Architects (Matching Pages 4, 5, 6, 7 of screenshots)
        $builder1 = Builder::updateOrCreate(
            ['email' => 'info@skylinearchitects.com'],
            [
                'category_id'      => $categories['architect']->id,
                'name'             => 'Rahul Mehta',
                'firm_name'        => 'Skyline Architects',
                'slug'             => 'skyline-architects',
                'password'         => Hash::make('123456'),
                'phone'            => '+91 9876543210',
                'location'         => 'Lucknow',
                'address'          => 'Hazratganj, Lucknow',
                'website'          => 'www.skylinearchitects.com',
                'about'            => 'Leading architecture firm specializing in residential, commercial, and 3D visualization projects.',
                'experience_years' => 12,
                'projects_count'   => 120,
                'rating'           => 4.8,
                'is_verified'      => true,
                'status'           => true,
            ]
        );

        // Builder 1 Services
        BuilderService::where('builder_id', $builder1->id)->delete();
        foreach (['Residential Design', 'Commercial Design', '3D Elevation', 'Site Planning'] as $sName) {
            BuilderService::create(['builder_id' => $builder1->id, 'service_name' => $sName]);
        }

        // Builder 1 Certifications
        BuilderCertification::where('builder_id', $builder1->id)->delete();
        foreach (['COA Registered', 'GST Registered', 'ISO Certified'] as $cName) {
            BuilderCertification::create(['builder_id' => $builder1->id, 'certification_name' => $cName]);
        }

        // Builder 1 Service Areas
        BuilderServiceArea::where('builder_id', $builder1->id)->delete();
        foreach (['Lucknow', 'Kanpur', 'Ayodhya'] as $area) {
            BuilderServiceArea::create(['builder_id' => $builder1->id, 'city_name' => $area]);
        }

        // Builder 1 Completed Projects
        BuilderCompletedProject::where('builder_id', $builder1->id)->delete();
        BuilderCompletedProject::create([
            'builder_id'    => $builder1->id,
            'project_title' => 'Luxury Villa',
            'location'      => 'Lucknow',
            'area_details'  => '4500 sqft luxury villa',
        ]);

        // Builder 1 Reviews
        BuilderReview::where('builder_id', $builder1->id)->delete();
        BuilderReview::create([
            'builder_id'    => $builder1->id,
            'customer_name' => 'Amit Singh',
            'rating'        => 5.0,
            'review_text'   => 'Excellent architect and professional team.',
            'status'        => true,
        ]);

        // 3. Seed Builder 2: Amit Sharma / Sharma Constructions (Matching Page 1 of screenshots)
        $builder2 = Builder::updateOrCreate(
            ['email' => 'sharmaconstructions@example.com'],
            [
                'category_id'      => $categories['civilContractor']->id,
                'name'             => 'Amit Sharma',
                'firm_name'        => 'Sharma Constructions',
                'slug'             => 'sharma-constructions',
                'password'         => Hash::make('123456'),
                'phone'            => '+91 9988776655',
                'location'         => 'Delhi',
                'address'          => 'Connaught Place, Delhi',
                'website'          => 'www.sharmaconstructions.com',
                'about'            => 'Premier civil contracting firm delivering top-quality RCC work, structural building, and turnkey projects across North India.',
                'experience_years' => 15,
                'projects_count'   => 200,
                'rating'           => 4.6,
                'is_verified'      => true,
                'status'           => true,
            ]
        );

        // Builder 2 Services
        BuilderService::where('builder_id', $builder2->id)->delete();
        foreach (['RCC Work', 'Turnkey Projects', 'Foundation Building', 'Material Contracting'] as $sName) {
            BuilderService::create(['builder_id' => $builder2->id, 'service_name' => $sName]);
        }

        // Builder 2 Certifications
        BuilderCertification::where('builder_id', $builder2->id)->delete();
        foreach (['CPWD Registered', 'GST Registered', 'Safety Certified'] as $cName) {
            BuilderCertification::create(['builder_id' => $builder2->id, 'certification_name' => $cName]);
        }

        // Builder 2 Service Areas
        BuilderServiceArea::where('builder_id', $builder2->id)->delete();
        foreach (['Delhi', 'Noida', 'Gurgaon'] as $area) {
            BuilderServiceArea::create(['builder_id' => $builder2->id, 'city_name' => $area]);
        }

        // 4. Seed Sample Inquiries
        BuilderInquiry::updateOrCreate(
            ['customer_phone' => '9876543210', 'builder_id' => $builder1->id],
            [
                'customer_name'  => 'Sunil Verma',
                'customer_phone' => '9876543210',
                'customer_email' => 'sunil@example.com',
                'message'        => 'Looking for 3D elevation and site planning for my plot in Lucknow.',
                'inquiry_type'   => 'call',
                'status'         => 'pending',
            ]
        );
    }
}
