<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuildService;
use App\Models\BuildServiceFaq;
use App\Models\BuildCategory;

class BuildServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Get category IDs
        $cats = BuildCategory::pluck('id', 'name')->toArray();

        // Helper: get ID by partial name match
        $catId = function (string $name) use ($cats) {
            foreach ($cats as $k => $v) {
                if (stripos($k, $name) !== false) return $v;
            }
            // fallback: first category
            return array_values($cats)[0] ?? 1;
        };

        $services = [
            // ── ARCHITECT ──────────────────────────────────────────────
            [
                'category'    => 'Architect',
                'title'       => 'Complete 2D House Planning & Layout',
                'short_desc'  => 'Custom Vastu-compliant architectural floor plans & working drawings.',
                'price'       => 2499,
                'price_type'  => 'fixed',
                'duration'    => '2-3 Days',
                'rating'      => 4.9,
                'total_reviews'=> 128,
                'sort_order'  => 1,
                'tags'        => ['Vastu Compliant', '2 Revisions Included', 'CAD DWG File'],
                'overview'    => 'Get professional Vastu-compliant floor plans for your dream home. Our expert architects design customized layouts that maximize space utilization while ensuring complete Vastu compliance. All drawings are provided in CAD DWG format for seamless execution.',
                'deliverables'=> [
                    'Floor plan (2D layout) with room dimensions',
                    'Vastu analysis report',
                    'CAD DWG + PDF files',
                    '2 free revision rounds',
                    'Structural grid plan',
                ],
                'what_you_get'=> [
                    'Vastu-compliant room placements',
                    'Proper ventilation & sunlight planning',
                    'Dedicated architect consultation call',
                    'Fast 2-3 day delivery',
                ],
                'execution_steps' => [
                    ['title' => 'Requirements Collection', 'description' => 'Share plot dimensions, family size, and special requirements.'],
                    ['title' => 'Design Draft', 'description' => 'Architect creates initial 2D layout within 24 hours.'],
                    ['title' => 'Review & Revisions', 'description' => 'Up to 2 revision rounds to perfect your plan.'],
                    ['title' => 'Final Delivery', 'description' => 'CAD DWG + PDF files delivered to your account.'],
                ],
                'faqs' => [
                    ['q' => 'How many revisions are included?', 'a' => '2 free revision rounds are included. Additional revisions can be purchased at ₹500 per revision.'],
                    ['q' => 'What information do I need to provide?', 'a' => 'Plot dimensions, number of floors, number of bedrooms, and any special requirements like pooja room, study room etc.'],
                    ['q' => 'In what format will I receive the plans?', 'a' => 'You will receive CAD DWG files and PDF files via email and app download.'],
                ],
            ],
            [
                'category'    => 'Architect',
                'title'       => '3D Front Elevation & Exterior Design',
                'short_desc'  => 'Ultra-realistic 3D rendering of building exterior with modern materials.',
                'price'       => 3999,
                'price_type'  => 'fixed',
                'duration'    => '3-5 Days',
                'rating'      => 4.8,
                'total_reviews'=> 95,
                'sort_order'  => 2,
                'tags'        => ['Day & Night Views', '4K Ultra HD Renders', 'Material Palette'],
                'overview'    => 'Visualize your dream home before construction begins. Our 3D artists create photorealistic exterior renders that show exactly how your building will look — complete with landscaping, materials, lighting effects, and day/night views.',
                'deliverables'=> [
                    '4 exterior views (Front, Back, 2 Sides)',
                    'Day & Night render variants',
                    '4K Ultra HD resolution images',
                    'Material and color palette sheet',
                    'Editable project file',
                ],
                'what_you_get'=> [
                    'Photorealistic 4K renders',
                    'Multiple viewing angles',
                    'Day and night lighting simulation',
                    'Virtual walkthrough (optional add-on)',
                ],
                'execution_steps' => [
                    ['title' => 'Reference Sharing', 'description' => 'Share floor plans, elevation sketches, and material preferences.'],
                    ['title' => '3D Modelling', 'description' => 'Artist builds the 3D model of your building in 2 days.'],
                    ['title' => 'Rendering & Lighting', 'description' => 'High-quality renders with realistic lighting are generated.'],
                    ['title' => 'Final Delivery', 'description' => '4K images delivered in 3-5 days.'],
                ],
                'faqs' => [
                    ['q' => 'Do I need architectural drawings to get a 3D render?', 'a' => 'Yes, you need to provide floor plans and elevation sketches. We can help create these if needed.'],
                    ['q' => 'Can I choose the exterior materials and colors?', 'a' => 'Yes, our designer will share a material palette for you to choose from, or you can specify your preferences.'],
                ],
            ],
            [
                'category'    => 'Architect',
                'title'       => 'Full Architectural Working Drawings',
                'short_desc'  => 'Complete drawing set for building permission and construction.',
                'price'       => 8999,
                'price_type'  => 'fixed',
                'duration'    => '7-10 Days',
                'rating'      => 4.9,
                'total_reviews'=> 64,
                'sort_order'  => 3,
                'tags'        => ['Municipality Approved', 'Structural Drawings', 'MEP Layout'],
                'overview'    => 'Complete set of architectural and structural drawings required for building permission approval from local municipality. Includes all plans, sections, elevations, and structural details.',
                'deliverables'=> [
                    'Floor plans (all floors)',
                    'Section drawings (2 sections)',
                    'Elevation drawings (4 sides)',
                    'Site plan & key plan',
                    'Structural drawings',
                    'Plumbing & electrical layout',
                ],
                'what_you_get'=> [
                    'Municipality-ready drawing set',
                    'Structural engineer coordination',
                    'Plumbing & electrical layout included',
                    '3 free revision rounds',
                ],
                'execution_steps' => [
                    ['title' => 'Survey & Site Data', 'description' => 'Collect plot measurements and local bylaw requirements.'],
                    ['title' => 'Preliminary Design', 'description' => 'First draft ready in 3-4 days for your review.'],
                    ['title' => 'Revisions & Approval', 'description' => 'Up to 3 revision rounds to finalize the design.'],
                    ['title' => 'Final Drawing Set', 'description' => 'Complete AutoCAD and PDF set delivered in 7-10 days.'],
                ],
                'faqs' => [
                    ['q' => 'Are these drawings accepted by the municipality?', 'a' => 'Yes, drawings are prepared as per local building bylaws and NBC standards, ready for submission.'],
                    ['q' => 'Do I need to visit your office?', 'a' => 'No, everything is done remotely. We collect all information online.'],
                ],
            ],

            // ── CIVIL CONTRACTOR ──────────────────────────────────────
            [
                'category'    => 'Civil Contractor',
                'title'       => 'Complete Turnkey Home Construction',
                'short_desc'  => 'End-to-end residential building construction with premium branded materials.',
                'price'       => 1650,
                'price_type'  => 'per_sqft',
                'duration'    => '6-9 Months',
                'rating'      => 4.9,
                'total_reviews'=> 142,
                'sort_order'  => 1,
                'tags'        => ['Premium Materials', 'Milestone Payments', '5-Year Warranty'],
                'overview'    => 'Experience stress-free home building from foundation to final key handover. High-grade materials (Tata/Jindal steel, UltraTech cement), dedicated on-site supervision, and strict milestone-based payment safety.',
                'deliverables'=> [
                    'Foundation, RCC Framework, Brick Masonry & Plastering',
                    'Branded Steel (Fe 550D) & Grade 43/53 Portland Cement',
                    'Vitrified Tile Flooring (Kajaria/Somany) & Granite Kitchen Counter',
                    'Bathroom Fixtures (Jaguar/Hindware) & Concealed Plumbing',
                    'Internal & External Plastic Emulsion Paint (Asian Paints)',
                ],
                'what_you_get'=> [
                    'Dedicated Civil Engineer on-site daily',
                    'Weekly progress video & photo updates via app',
                    'Lab test reports for steel tensile strength and concrete cube tests',
                    '5-Year warranty against structural defects',
                ],
                'execution_steps' => [
                    ['title' => 'Site Inspection & Soil Check', 'description' => 'Admin assigns a vetted civil contractor who visits the plot for technical site inspection.'],
                    ['title' => 'BOQ & Milestone Contract', 'description' => 'Receive a transparent Bill of Quantities with zero hidden charges.'],
                    ['title' => 'Milestone-wise Execution', 'description' => 'Construction progresses phase-by-phase (Plinth → Slab → Finishing).'],
                ],
                'faqs' => [
                    ['q' => 'How does milestone payment work?', 'a' => 'You pay only when each milestone is completed and verified by our quality inspector. Milestones include: Foundation (20%), Slab (30%), Brick Work (20%), Finishing (20%), Handover (10%).'],
                    ['q' => 'What brands of materials are used?', 'a' => 'We use Tata/Jindal steel, UltraTech/ACC cement, Kajaria/Somany tiles, Asian Paints, and Jaguar/Hindware sanitary fittings.'],
                    ['q' => 'Is the 5-year warranty included?', 'a' => 'Yes, a 5-year structural warranty against cracks, seepage, and foundation issues is included for all turnkey projects.'],
                ],
            ],
            [
                'category'    => 'Civil Contractor',
                'title'       => 'Foundation & Plinth Beam Work',
                'short_desc'  => 'Strong isolated or combined foundation with anti-termite treatment.',
                'price'       => 350,
                'price_type'  => 'per_sqft',
                'duration'    => '2-3 Weeks',
                'rating'      => 4.7,
                'total_reviews'=> 89,
                'sort_order'  => 2,
                'tags'        => ['Anti-Termite Treatment', 'Soil Testing', 'RCC Foundation'],
                'overview'    => 'The foundation is the most critical part of any building. Our expert civil contractors perform thorough soil testing, design appropriate foundation type (isolated/strip/raft), and construct it with premium concrete mix.',
                'deliverables'=> [
                    'Soil bearing capacity test report',
                    'Foundation type recommendation',
                    'Excavation & PCC (Plain Cement Concrete) layer',
                    'RCC Foundation & Plinth Beam',
                    'Anti-termite chemical treatment',
                ],
                'what_you_get'=> [
                    'Certified soil test report',
                    'Cube test for concrete strength verification',
                    'Anti-termite treatment certificate',
                    'Foundation completion certificate',
                ],
                'execution_steps' => [
                    ['title' => 'Soil Testing', 'description' => 'Soil samples collected and sent to certified lab.'],
                    ['title' => 'Design & Excavation', 'description' => 'Foundation design as per soil report, followed by excavation.'],
                    ['title' => 'PCC & RCC Work', 'description' => 'Laying PCC bed and constructing RCC foundation with plinth beam.'],
                    ['title' => 'Treatment & Backfilling', 'description' => 'Anti-termite treatment and earth backfilling completed.'],
                ],
                'faqs' => [
                    ['q' => 'Why is soil testing important?', 'a' => 'Soil testing determines the load-bearing capacity of the soil, which decides the foundation type and depth required for your building.'],
                    ['q' => 'How long does foundation work take?', 'a' => 'Typically 2-3 weeks depending on plot size and foundation type. Curing time of 28 days is mandatory after casting.'],
                ],
            ],

            // ── INTERIOR DESIGNER ─────────────────────────────────────
            [
                'category'    => 'Interior Designer',
                'title'       => 'Complete Home Interior Design',
                'short_desc'  => 'Full home interior with modular kitchen, wardrobes & premium finishes.',
                'price'       => 850,
                'price_type'  => 'per_sqft',
                'duration'    => '45-60 Days',
                'rating'      => 4.8,
                'total_reviews'=> 112,
                'sort_order'  => 1,
                'tags'        => ['Modular Kitchen', '3D Design Preview', '10-Year Warranty'],
                'overview'    => 'Transform your empty house into a dream home with our full interior design package. From modular kitchen and wardrobes to false ceiling, lighting design, wall panelling, and premium flooring — we handle everything.',
                'deliverables'=> [
                    'Modular kitchen with premium hardware (Hettich/Hafele)',
                    'Bedroom wardrobes with soft-close mechanisms',
                    'POP/gypsum false ceiling with LED lighting',
                    'TV unit & living room furniture',
                    'Bathroom accessories & fittings',
                ],
                'what_you_get'=> [
                    '3D visualisation before work begins',
                    'Dedicated interior designer assigned',
                    'Weekly site visit reports',
                    '10-year warranty on modular furniture',
                ],
                'execution_steps' => [
                    ['title' => 'Design Consultation', 'description' => 'Designer visits site and understands your style preferences.'],
                    ['title' => '3D Design Presentation', 'description' => 'Complete 3D walkthrough of your designed home shared in 7 days.'],
                    ['title' => 'Material Selection', 'description' => 'Visit our partner showrooms to select laminates, tiles, and hardware.'],
                    ['title' => 'Execution & Handover', 'description' => 'Work completed in 45-60 days with regular progress updates.'],
                ],
                'faqs' => [
                    ['q' => 'Do you provide 3D designs before execution?', 'a' => 'Yes, a complete 3D walkthrough of your home is provided before any work begins, so you know exactly what to expect.'],
                    ['q' => 'What is included in the warranty?', 'a' => '10-year warranty on modular kitchen and wardrobe structures. 2-year warranty on hardware and fittings.'],
                ],
            ],

            // ── ELECTRICAL CONTRACTOR ─────────────────────────────────
            [
                'category'    => 'Electrical Contractor',
                'title'       => 'Complete Home Wiring & Electrical',
                'short_desc'  => 'Full electrical wiring, MCB panel, earthing & power points for new homes.',
                'price'       => 45,
                'price_type'  => 'per_sqft',
                'duration'    => '7-14 Days',
                'rating'      => 4.7,
                'total_reviews'=> 76,
                'sort_order'  => 1,
                'tags'        => ['ISI Marked Wires', 'MCB Panel', 'Earthing Included'],
                'overview'    => 'Complete concealed wiring solution for your new home using ISI-marked FR cables. Includes MCB distribution board, earthing, all power points, switches, and proper load balancing for safe & efficient electricity usage.',
                'deliverables'=> [
                    'Concealed wiring with ISI-marked FR cables (Havells/Polycab)',
                    'MCB distribution board with ELCB protection',
                    'Proper earthing (GI pipe earthing)',
                    'All power points, switches & sockets (Legrand/Schneider)',
                    'AC points, geyser points & heavy appliance circuits',
                ],
                'what_you_get'=> [
                    'Licensed electrical contractor',
                    'Load calculation & phase balancing',
                    'Testing & commissioning certificate',
                    '1-year workmanship warranty',
                ],
                'execution_steps' => [
                    ['title' => 'Electrical Design', 'description' => 'Load calculation and point-by-point electrical layout prepared.'],
                    ['title' => 'Conduit & Casing', 'description' => 'PVC conduits fitted in walls before plastering.'],
                    ['title' => 'Wiring & Panel', 'description' => 'ISI-marked wires pulled and MCB panel installed.'],
                    ['title' => 'Testing & Handover', 'description' => 'Full electrical testing with insulation resistance check.'],
                ],
                'faqs' => [
                    ['q' => 'What brands of wires and switches are used?', 'a' => 'We use Havells or Polycab ISI-marked FR wires and Legrand or Schneider switches as standard. Premium brands available on request.'],
                    ['q' => 'Is earthing mandatory?', 'a' => 'Yes, earthing is mandatory and is included in our package for safety compliance.'],
                ],
            ],

            // ── PLUMBING EXPERT ───────────────────────────────────────
            [
                'category'    => 'Plumbing Expert',
                'title'       => 'Complete Plumbing & Sanitation Work',
                'short_desc'  => 'CPVC/UPVC piping, bathroom fittings & drainage for new construction.',
                'price'       => 35,
                'price_type'  => 'per_sqft',
                'duration'    => '7-12 Days',
                'rating'      => 4.6,
                'total_reviews'=> 58,
                'sort_order'  => 1,
                'tags'        => ['CPVC Hot/Cold Lines', 'SWR Drainage', 'ISI Fixtures'],
                'overview'    => 'Complete plumbing solution for new homes including hot & cold water lines, overhead tank connection, SWR drainage, bathroom fittings, and kitchen plumbing — all with ISI-marked branded pipes and fittings.',
                'deliverables'=> [
                    'CPVC hot & cold water supply lines',
                    'UPVC/SWR drainage system',
                    'Overhead tank & underground sump connection',
                    'All bathroom fittings (Jaquar/Cera)',
                    'Kitchen sink & washing area connection',
                ],
                'what_you_get'=> [
                    'Pressure-tested pipe network',
                    'Anti-clog drainage design',
                    'Licensed plumber with 10+ years experience',
                    '1-year leakage warranty',
                ],
                'execution_steps' => [
                    ['title' => 'Layout Planning', 'description' => 'Plumbing layout designed based on floor plans.'],
                    ['title' => 'Supply Line Installation', 'description' => 'CPVC hot & cold lines laid in walls before plastering.'],
                    ['title' => 'Drainage System', 'description' => 'SWR drainage pipes and toilet connections done.'],
                    ['title' => 'Testing & Commissioning', 'description' => 'Full pressure test to check for leaks before handover.'],
                ],
                'faqs' => [
                    ['q' => 'What type of pipes are used?', 'a' => 'We use CPVC pipes for hot & cold water (Astral/Supreme) and UPVC/SWR pipes for drainage, all ISI-marked.'],
                    ['q' => 'Is the warranty against leakage?', 'a' => 'Yes, 1-year warranty covers all pipe joints and fitting connections against leakage.'],
                ],
            ],

            // ── LANDSCAPE DESIGNER ────────────────────────────────────
            [
                'category'    => 'Landscape Designer',
                'title'       => 'Garden & Landscape Design',
                'short_desc'  => 'Professional garden design with plants, pathways & water features.',
                'price'       => 15000,
                'price_type'  => 'fixed',
                'duration'    => '5-7 Days',
                'rating'      => 4.8,
                'total_reviews'=> 43,
                'sort_order'  => 1,
                'tags'        => ['3D Garden Design', 'Native Plants', 'Drip Irrigation'],
                'overview'    => 'Transform your outdoor space into a beautiful, low-maintenance garden. Our landscape designers create personalized garden plans with native plants, elegant pathways, water features, and drip irrigation systems.',
                'deliverables'=> [
                    '3D landscape design rendering',
                    'Plant selection list with placement guide',
                    'Pathway & paving design',
                    'Drip irrigation layout',
                    'Water feature design (if required)',
                ],
                'what_you_get'=> [
                    'Expert landscape consultant',
                    '3D design before execution',
                    'Native & low-maintenance plant selection',
                    'Seasonal maintenance guide',
                ],
                'execution_steps' => [
                    ['title' => 'Site Visit & Measurement', 'description' => 'Designer visits your site and measures the garden area.'],
                    ['title' => '3D Design Presentation', 'description' => 'Visual garden design with plant layout shared for approval.'],
                    ['title' => 'Execution', 'description' => 'Soil preparation, planting, paving and irrigation done.'],
                    ['title' => 'Final Handover', 'description' => 'Maintenance guide and plant care schedule provided.'],
                ],
                'faqs' => [
                    ['q' => 'What is the minimum garden size you work with?', 'a' => 'We work with gardens as small as 100 sq.ft. For very small spaces, we offer balcony garden packages.'],
                    ['q' => 'Do you provide maintenance services after landscaping?', 'a' => 'Yes, we offer monthly maintenance packages starting from ₹2,000/month.'],
                ],
            ],
        ];

        foreach ($services as $sData) {
            $cid = $catId($sData['category']);

            $service = BuildService::create([
                'category_id'     => $cid,
                'title'           => $sData['title'],
                'short_desc'      => $sData['short_desc'],
                'price'           => $sData['price'],
                'price_type'      => $sData['price_type'],
                'duration'        => $sData['duration'],
                'rating'          => $sData['rating'],
                'total_reviews'   => $sData['total_reviews'],
                'sort_order'      => $sData['sort_order'],
                'tags'            => $sData['tags'],
                'overview'        => $sData['overview'],
                'deliverables'    => $sData['deliverables'],
                'what_you_get'    => $sData['what_you_get'],
                'execution_steps' => $sData['execution_steps'],
                'status'          => 1,
            ]);

            // FAQs
            foreach ($sData['faqs'] as $i => $faq) {
                BuildServiceFaq::create([
                    'build_service_id' => $service->id,
                    'question'         => $faq['q'],
                    'answer'           => $faq['a'],
                    'sort_order'       => $i,
                ]);
            }
        }

        $this->command->info('✅ ' . count($services) . ' Build Services seeded with FAQs.');
    }
}
