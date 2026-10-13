<?php
/**
 * Xplore Build Module — Complete Test Data Seeder
 * Run: php database/seeders/BuildTestDataSeeder.php  (via artisan)
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\BuildCategory;
use App\Models\BuilderServiceType;
use App\Models\Builder;
use App\Models\BuilderService;
use App\Models\BuilderCertification;
use App\Models\BuilderServiceArea;
use App\Models\BuilderCompletedProject;
use App\Models\BuilderReview;

class BuildTestDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🏗️  Seeding Xplore Build Test Data...');

        // ─── STEP 1: Build Categories ───────────────────────────────────────
        $this->command->info('  → Build Categories...');
        $categories = [
            ['name' => 'Architect',           'slug' => 'architect',           'status' => 1],
            ['name' => 'Civil Contractor',    'slug' => 'civil-contractor',    'status' => 1],
            ['name' => 'Structural Engineer', 'slug' => 'structural-engineer', 'status' => 1],
            ['name' => 'Interior Designer',   'slug' => 'interior-designer',   'status' => 1],
            ['name' => 'Landscape Designer',  'slug' => 'landscape-designer',  'status' => 1],
            ['name' => 'Electrical Contractor','slug'=> 'electrical-contractor','status' => 1],
            ['name' => 'Plumbing Expert',     'slug' => 'plumbing-expert',     'status' => 1],
        ];
        foreach ($categories as $cat) {
            BuildCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
        $this->command->info('    ✔ Categories done');

        // ─── STEP 2: Builder Service Types ──────────────────────────────────
        $this->command->info('  → Service Types (already seeded, verifying)...');
        $serviceTypes = BuilderServiceType::where('status', 1)->get();
        if ($serviceTypes->isEmpty()) {
            $types = [
                ['name' => 'Civil Construction',    'icon' => 'fa-hard-hat',          'status' => 1],
                ['name' => 'Architecture & Design', 'icon' => 'fa-drafting-compass',  'status' => 1],
                ['name' => 'Interior Design',       'icon' => 'fa-paint-roller',      'status' => 1],
                ['name' => 'Electrical Work',       'icon' => 'fa-bolt',              'status' => 1],
                ['name' => 'Plumbing & Sanitation', 'icon' => 'fa-wrench',            'status' => 1],
                ['name' => 'Landscaping',           'icon' => 'fa-tree',              'status' => 1],
                ['name' => 'Renovation & Repair',   'icon' => 'fa-tools',             'status' => 1],
                ['name' => 'Residential Projects',  'icon' => 'fa-home',              'status' => 1],
                ['name' => 'Commercial Projects',   'icon' => 'fa-building',          'status' => 1],
                ['name' => 'Road & Infrastructure', 'icon' => 'fa-road',              'status' => 1],
                ['name' => 'Fire Safety Systems',   'icon' => 'fa-fire-extinguisher', 'status' => 1],
                ['name' => '3D Visualization',      'icon' => 'fa-cubes',             'status' => 1],
            ];
            foreach ($types as $t) BuilderServiceType::firstOrCreate(['name' => $t['name']], $t);
            $serviceTypes = BuilderServiceType::where('status', 1)->get();
        }
        $this->command->info('    ✔ Service types: ' . $serviceTypes->count() . ' active');

        // ─── STEP 3: Test Builders ───────────────────────────────────────────
        $this->command->info('  → Builders with full profile data...');

        $catArch  = BuildCategory::where('slug', 'architect')->first();
        $catCivil = BuildCategory::where('slug', 'civil-contractor')->first();
        $catIntl  = BuildCategory::where('slug', 'interior-designer')->first();
        $catStrct = BuildCategory::where('slug', 'structural-engineer')->first();
        $catElec  = BuildCategory::where('slug', 'electrical-contractor')->first();
        $catPlmb  = BuildCategory::where('slug', 'plumbing-expert')->first();

        $stArch   = BuilderServiceType::where('name', 'Architecture & Design')->first();
        $st3D     = BuilderServiceType::where('name', '3D Visualization')->first();
        $stCivil  = BuilderServiceType::where('name', 'Civil Construction')->first();
        $stIntl   = BuilderServiceType::where('name', 'Interior Design')->first();
        $stReno   = BuilderServiceType::where('name', 'Renovation & Repair')->first();
        $stResd   = BuilderServiceType::where('name', 'Residential Projects')->first();
        $stComm   = BuilderServiceType::where('name', 'Commercial Projects')->first();
        $stElec   = BuilderServiceType::where('name', 'Electrical Work')->first();
        $stPlmb   = BuilderServiceType::where('name', 'Plumbing & Sanitation')->first();
        $stLand   = BuilderServiceType::where('name', 'Landscaping')->first();

        $buildersData = [
            // ── ARCHITECT 1 ──
            [
                'profile' => [
                    'category_id'      => $catArch?->id,
                    'name'             => 'Rahul Mehta',
                    'firm_name'        => 'Skyline Architects',
                    'slug'             => 'skyline-architects',
                    'email'            => 'rahul@skylinearchitects.com',
                    'password'         => Hash::make('password123'),
                    'phone'            => '+91 9876543210',
                    'location'         => 'Lucknow',
                    'address'          => 'Hazratganj, Lucknow, UP 226001',
                    'website'          => 'www.skylinearchitects.com',
                    'about'            => 'Award-winning architecture firm specializing in residential bungalows, villa design, commercial spaces & stunning 3D visualization. COA registered with 18 years of excellence across Uttar Pradesh.',
                    'experience_years' => 18,
                    'projects_count'   => 340,
                    'rating'           => 4.9,
                    'is_verified'      => true,
                    'status'           => true,
                ],
                'services'      => [$stArch, $st3D, $stResd, $stComm],
                'certifications'=> ['COA Registered', 'GST Registered', 'ISO 9001:2015 Certified', 'IGBC Accredited'],
                'service_areas' => ['Lucknow', 'Kanpur', 'Ayodhya', 'Varanasi', 'Prayagraj'],
                'projects'      => [
                    ['title' => 'Royal Garden Villa – Gomti Nagar', 'location' => 'Lucknow', 'area' => '5200 sq.ft | 4 BHK | Vastu Compliant'],
                    ['title' => 'Sunrise Commercial Complex', 'location' => 'Kanpur', 'area' => '22000 sq.ft | G+5 Floors | 2023'],
                    ['title' => 'Heritage Haveli Renovation', 'location' => 'Lucknow', 'area' => '8000 sq.ft | Complete Restoration'],
                ],
                'reviews' => [
                    ['customer_name' => 'Priya Sharma',   'rating' => 5.0, 'review_text' => 'Excellent work! Rahul ji ne hamari dream home ko exactly waise banaya jaise humne socha tha. 3D design dekh ke bahut impressed hua. Highly recommended!'],
                    ['customer_name' => 'Vikash Gupta',   'rating' => 4.8, 'review_text' => 'Very professional team. Timeline pe kaam deliver kiya aur quality exceptional thi. COA certification se bahut confidence mila.'],
                    ['customer_name' => 'Meena Srivastava','rating'=> 5.0, 'review_text' => 'Skyline Architects ne hamara commercial complex bilkul perfect banaya. Cost estimate bhi sahi tha. 100% recommend!'],
                ],
            ],

            // ── ARCHITECT 2 ──
            [
                'profile' => [
                    'category_id'      => $catArch?->id,
                    'name'             => 'Sneha Verma',
                    'firm_name'        => 'Urban Canvas Studio',
                    'slug'             => 'urban-canvas-studio',
                    'email'            => 'sneha@urbancanvas.in',
                    'password'         => Hash::make('password123'),
                    'phone'            => '+91 9988776655',
                    'location'         => 'Lucknow',
                    'address'          => 'Gomti Nagar Extension, Lucknow',
                    'website'          => 'www.urbancanvas.in',
                    'about'            => 'Modern & contemporary architecture firm focused on sustainable design. Specialists in luxury residential, boutique hotels & high-end commercial interiors with Vastu integration.',
                    'experience_years' => 12,
                    'projects_count'   => 180,
                    'rating'           => 4.7,
                    'is_verified'      => true,
                    'status'           => true,
                ],
                'services'      => [$stArch, $st3D, $stIntl, $stResd],
                'certifications'=> ['COA Registered', 'GRIHA Certified', 'GST Registered'],
                'service_areas' => ['Lucknow', 'Sitapur', 'Hardoi', 'Barabanki'],
                'projects'      => [
                    ['title' => 'Lotus Residency – Gomti Nagar Ext.', 'location' => 'Lucknow', 'area' => '3800 sq.ft | 3 BHK Luxury Apt'],
                    ['title' => 'Boutique Hotel Facade Design', 'location' => 'Lucknow', 'area' => 'G+4 | 32 Rooms | 2024'],
                ],
                'reviews' => [
                    ['customer_name' => 'Rohit Pandey',  'rating' => 4.7, 'review_text' => 'Sneha ma\'am ka design sense kamal ka hai. Hamare flat ka 3D bilkul cinematic lag raha tha. Construction ke dauran bhi regular visit ki.'],
                    ['customer_name' => 'Asha Mishra',   'rating' => 4.8, 'review_text' => 'Sustainable design concept bahut acha laga. Sunlight aur ventilation ka dhyan rakha unhone. Paise vasool!'],
                ],
            ],

            // ── CIVIL CONTRACTOR 1 ──
            [
                'profile' => [
                    'category_id'      => $catCivil?->id,
                    'name'             => 'Rajesh Kumar Singh',
                    'firm_name'        => 'BuildRight Constructions',
                    'slug'             => 'buildright-constructions',
                    'email'            => 'rajesh@buildright.in',
                    'password'         => Hash::make('password123'),
                    'phone'            => '+91 9712345678',
                    'location'         => 'Kanpur',
                    'address'          => 'Civil Lines, Kanpur, UP 208001',
                    'website'          => 'www.buildrightconstructions.com',
                    'about'            => 'Leading civil construction company with expertise in RCC construction, turnkey projects, industrial sheds, and colony development. Trusted by 500+ clients across Uttar Pradesh with zero compromise on material quality.',
                    'experience_years' => 22,
                    'projects_count'   => 520,
                    'rating'           => 4.8,
                    'is_verified'      => true,
                    'status'           => true,
                ],
                'services'      => [$stCivil, $stResd, $stComm, $stReno],
                'certifications'=> ['GST Registered', 'ISO 9001:2015', 'PWD Approved Contractor', 'Labour License'],
                'service_areas' => ['Kanpur', 'Lucknow', 'Unnao', 'Fatehpur', 'Hamirpur'],
                'projects'      => [
                    ['title' => 'Shree Ram Colony – 48 Plots', 'location' => 'Kanpur', 'area' => '2.5 Acre | Residential Township | 2023'],
                    ['title' => 'Industrial Warehouse – Phase 1', 'location' => 'Unnao', 'area' => '45000 sq.ft | Pre-engineered Steel'],
                    ['title' => 'Multi-storey Apartment – G+7', 'location' => 'Kanpur', 'area' => '72 Flats | 1/2/3 BHK | 2024'],
                ],
                'reviews' => [
                    ['customer_name' => 'Suresh Agarwal', 'rating' => 4.9, 'review_text' => 'Rajesh bhai ne mera ghar bilkul samay par complete kiya. Concrete quality aur finishing dono lajawab rahi. 100% recommend karunga.'],
                    ['customer_name' => 'Dinesh Patel',   'rating' => 4.7, 'review_text' => 'Industrial warehouse ka kaam bahut professional tarike se hua. Cost overrun ek baar bhi nahi hua. Perfect contractor!'],
                    ['customer_name' => 'Kavita Singh',   'rating' => 4.8, 'review_text' => 'BuildRight ke saath kaam karke bahut acha experience raha. Transparency aur quality dono mein best.'],
                ],
            ],

            // ── CIVIL CONTRACTOR 2 ──
            [
                'profile' => [
                    'category_id'      => $catCivil?->id,
                    'name'             => 'Mohammad Irfan',
                    'firm_name'        => 'Prime Build Solutions',
                    'slug'             => 'prime-build-solutions',
                    'email'            => 'irfan@primebuild.co.in',
                    'password'         => Hash::make('password123'),
                    'phone'            => '+91 9823456780',
                    'location'         => 'Lucknow',
                    'address'          => 'Aliganj, Lucknow, UP 226024',
                    'website'          => '',
                    'about'            => 'Specializing in turnkey residential construction, government projects, and commercial buildings. Strong material sourcing network with competitive rates. Serving Lucknow and surrounding districts for 15+ years.',
                    'experience_years' => 15,
                    'projects_count'   => 280,
                    'rating'           => 4.6,
                    'is_verified'      => true,
                    'status'           => true,
                ],
                'services'      => [$stCivil, $stResd, $stReno],
                'certifications'=> ['GST Registered', 'RERA Registered', 'PWD Approved'],
                'service_areas' => ['Lucknow', 'Raebareli', 'Barabanki', 'Faizabad'],
                'projects'      => [
                    ['title' => 'Government Primary School Renovation', 'location' => 'Raebareli', 'area' => '12 Classrooms | Govt Project | 2023'],
                    ['title' => 'Duplex Villa – Aliganj', 'location' => 'Lucknow', 'area' => '4200 sq.ft | G+1 | Modern Design'],
                ],
                'reviews' => [
                    ['customer_name' => 'Noor Fatima',  'rating' => 4.6, 'review_text' => 'Irfan sahab ki team bahut mehnat se kaam karti hai. Hamare ghar ka kaam deadline se pehle hi complete hua.'],
                    ['customer_name' => 'Arvind Tiwari','rating' => 4.7, 'review_text' => 'Budget ke andar kaam kiya aur quality bhi sahi rahi. Trusted contractor hain ye.'],
                ],
            ],

            // ── INTERIOR DESIGNER ──
            [
                'profile' => [
                    'category_id'      => $catIntl?->id,
                    'name'             => 'Pooja Kapoor',
                    'firm_name'        => 'Elegante Interiors',
                    'slug'             => 'elegante-interiors',
                    'email'            => 'pooja@elegante.in',
                    'password'         => Hash::make('password123'),
                    'phone'            => '+91 9956781234',
                    'location'         => 'Lucknow',
                    'address'          => 'Indira Nagar, Lucknow, UP 226016',
                    'website'          => 'www.eleganteinteriors.in',
                    'about'            => 'Premium interior design studio offering end-to-end home interiors, office spaces, and retail store setups. We blend classic Indian aesthetics with modern minimalism to create timeless spaces your family will love.',
                    'experience_years' => 10,
                    'projects_count'   => 215,
                    'rating'           => 4.9,
                    'is_verified'      => true,
                    'status'           => true,
                ],
                'services'      => [$stIntl, $stReno, $stResd, $stComm],
                'certifications'=> ['GST Registered', 'IID Member', 'ASID Associate'],
                'service_areas' => ['Lucknow', 'Kanpur', 'Agra', 'Mathura', 'Aligarh'],
                'projects'      => [
                    ['title' => 'Modern Minimalist 3BHK – Indira Nagar', 'location' => 'Lucknow', 'area' => '1800 sq.ft | Full Interior | ₹28L Budget'],
                    ['title' => 'Corporate Office – IT Company', 'location' => 'Lucknow', 'area' => '6000 sq.ft | 80 Workstations | 2024'],
                    ['title' => 'Boutique Clothing Store Interior', 'location' => 'Kanpur', 'area' => '1200 sq.ft | Retail Design | 2023'],
                ],
                'reviews' => [
                    ['customer_name' => 'Ankita Gupta',  'rating' => 5.0, 'review_text' => 'Pooja ma\'am ka design sense bilkul unique hai! Hamara ghar dekhke sabhi dost peechhe pad gaye ki interior kahan se karaya. Absolutely stunning work!'],
                    ['customer_name' => 'Sanjay Oberoi', 'rating' => 4.9, 'review_text' => 'Office interior ka kaam exceptional raha. Employees bhi bahut khush hain naye space mein. On-time delivery aur budget mein kaam.'],
                    ['customer_name' => 'Ritu Malhotra', 'rating' => 4.8, 'review_text' => 'Bohot hi professional aur creative team hai. Material selection mein bhi help ki. Recommend karungi!'],
                ],
            ],

            // ── STRUCTURAL ENGINEER ──
            [
                'profile' => [
                    'category_id'      => $catStrct?->id,
                    'name'             => 'Dr. Anil Chaudhary',
                    'firm_name'        => 'StrongBase Structural Consultants',
                    'slug'             => 'strongbase-structural',
                    'email'            => 'anil@strongbase.co.in',
                    'password'         => Hash::make('password123'),
                    'phone'            => '+91 9876009988',
                    'location'         => 'Lucknow',
                    'address'          => 'Vibhuti Khand, Gomti Nagar, Lucknow',
                    'website'          => 'www.strongbasestructural.com',
                    'about'            => 'Senior structural engineering consultants with PhD in Civil Engineering. Expert in high-rise structural design, earthquake-resistant buildings, foundation analysis, soil testing, and structural audits for existing buildings.',
                    'experience_years' => 25,
                    'projects_count'   => 800,
                    'rating'           => 4.8,
                    'is_verified'      => true,
                    'status'           => true,
                ],
                'services'      => [$stCivil, $stComm, $stResd],
                'certifications'=> ['IEI Fellow', 'BIS Empanelled', 'NBCC Panel Engineer', 'GST Registered', 'PhD Civil Engineering – IIT Roorkee'],
                'service_areas' => ['Lucknow', 'Kanpur', 'Allahabad', 'Varanasi', 'Agra', 'Meerut'],
                'projects'      => [
                    ['title' => 'G+12 Residential Tower Structural Design', 'location' => 'Lucknow', 'area' => '1.2 Lakh sq.ft | Earthquake Zone III'],
                    ['title' => 'Multi-Level Car Parking Structure', 'location' => 'Kanpur', 'area' => '800 ECS | 5 Floors | 2023'],
                    ['title' => 'Hospital Building Structural Audit', 'location' => 'Varanasi', 'area' => 'G+6 | 200 Bed Capacity'],
                ],
                'reviews' => [
                    ['customer_name' => 'Alok Mishra', 'rating' => 5.0, 'review_text' => 'Dr. Chaudhary sahab ki structural design ne hamari building ko earthquake mein bhi safe rakha. Unka expertise unparalleled hai.'],
                    ['customer_name' => 'Vinod Saxena', 'rating' => 4.9, 'review_text' => 'Multi-story parking structure ka structural kaam itne confident aur scientific tarike se hua ki hum impressed hain.'],
                ],
            ],

            // ── ELECTRICAL CONTRACTOR ──
            [
                'profile' => [
                    'category_id'      => $catElec?->id,
                    'name'             => 'Sunil Electricals',
                    'firm_name'        => 'PowerPro Electrical Works',
                    'slug'             => 'powerpro-electrical',
                    'email'            => 'sunil@powerpro.in',
                    'password'         => Hash::make('password123'),
                    'phone'            => '+91 9823001122',
                    'location'         => 'Lucknow',
                    'address'          => 'Rajajipuram, Lucknow, UP 226017',
                    'website'          => '',
                    'about'            => 'Licensed electrical contractor specializing in residential wiring, industrial power systems, HT/LT panels, solar power installations, and fire alarm systems. Safety-first approach with ISI certified materials only.',
                    'experience_years' => 14,
                    'projects_count'   => 430,
                    'rating'           => 4.7,
                    'is_verified'      => true,
                    'status'           => true,
                ],
                'services'      => [$stElec, $stResd, $stComm],
                'certifications'=> ['Electrical License A-Class', 'GST Registered', 'ISO 45001 Safety Certified', 'Solar Panel Installer'],
                'service_areas' => ['Lucknow', 'Hardoi', 'Sitapur', 'Unnao', 'Barabanki'],
                'projects'      => [
                    ['title' => 'Solar Grid Installation – Factory', 'location' => 'Unnao', 'area' => '250 KW | Grid Connected | 2024'],
                    ['title' => 'Apartment Complex Electrical – 96 Units', 'location' => 'Lucknow', 'area' => 'Complete HT/LT | Backup DG'],
                ],
                'reviews' => [
                    ['customer_name' => 'Harish Pandey', 'rating' => 4.7, 'review_text' => 'Solar installation ka kaam bahut professional raha. Kaafi bijli bachat ho rahi hai ab. Sunil ji ka response bahut fast tha.'],
                    ['customer_name' => 'Geeta Tripathi', 'rating' => 4.8, 'review_text' => 'Wiring work neat aur certified materials use ki. No shortcuts. Highly trustworthy electrician!'],
                ],
            ],
        ];

        foreach ($buildersData as $data) {
            $builder = Builder::updateOrCreate(
                ['slug' => $data['profile']['slug']],
                $data['profile']
            );

            // Services
            if ($builder->wasRecentlyCreated || $builder->services()->count() === 0) {
                $builder->services()->delete();
                foreach ($data['services'] as $sType) {
                    if ($sType) {
                        $builder->services()->create([
                            'service_type_id' => $sType->id,
                            'service_name'    => $sType->name,
                        ]);
                    }
                }
            }

            // Certifications
            if ($builder->wasRecentlyCreated || $builder->certifications()->count() === 0) {
                $builder->certifications()->delete();
                foreach ($data['certifications'] as $cert) {
                    $builder->certifications()->create(['certification_name' => $cert]);
                }
            }

            // Service Areas
            if ($builder->wasRecentlyCreated || $builder->serviceAreas()->count() === 0) {
                $builder->serviceAreas()->delete();
                foreach ($data['service_areas'] as $city) {
                    $builder->serviceAreas()->create(['city_name' => $city]);
                }
            }

            // Completed Projects
            if ($builder->wasRecentlyCreated || $builder->completedProjects()->count() === 0) {
                $builder->completedProjects()->delete();
                foreach ($data['projects'] as $proj) {
                    $builder->completedProjects()->create([
                        'project_title' => $proj['title'],
                        'location'      => $proj['location'],
                        'area_details'  => $proj['area'],
                    ]);
                }
            }

            // Reviews
            if ($builder->wasRecentlyCreated || $builder->reviews()->count() === 0) {
                $builder->reviews()->delete();
                foreach ($data['reviews'] as $rev) {
                    $builder->reviews()->create([
                        'customer_name' => $rev['customer_name'],
                        'rating'        => $rev['rating'],
                        'review_text'   => $rev['review_text'],
                        'status'        => 1,
                    ]);
                }
            }

            $this->command->info("    ✔ Builder: {$builder->firm_name}");
        }

        $this->command->info('');
        $this->command->info('✅ Xplore Build Test Data Seeded Successfully!');
        $this->command->info('   Categories : ' . BuildCategory::count());
        $this->command->info('   Service Types : ' . BuilderServiceType::count());
        $this->command->info('   Builders  : ' . Builder::count());
    }
}
