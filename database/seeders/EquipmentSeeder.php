<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;
use App\Models\EquipmentSpecification;
use App\Models\EquipmentBooking;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Support\Str;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Equipments & Specs
        $equipments = [
            [
                'name'                => 'Total Station',
                'slug'                => 'total-station',
                'brand'               => 'Leica',
                'model'               => 'TS16',
                'accuracy'            => '± 2 mm',
                'description'         => 'Electronic surveying instrument used for measuring angles and distances with high accuracy.',
                'availability_status' => 'in_stock',
                'daily_rate'          => 1500.00,
                'weekly_rate'         => 8500.00,
                'monthly_rate'        => 28000.00,
                'security_deposit'    => 5000.00,
                'gst_percentage'      => 18.00,
                'is_popular'          => true,
                'status'              => true,
                'specs'               => [
                    'Brand'        => 'Leica',
                    'Model'        => 'TS16',
                    'Accuracy'     => '± 2 mm',
                    'Availability' => 'In Stock',
                    'Range'        => 'Up to 500m (Reflectorless)',
                    'Weight'       => '5.3 kg',
                ]
            ],
            [
                'name'                => 'DGPS Receiver',
                'slug'                => 'dgps-receiver',
                'brand'               => 'Trimble',
                'model'               => 'R12i',
                'accuracy'            => '± 8 mm',
                'description'         => 'High-precision differential GPS receiver for RTK land surveying and geospatial mapping.',
                'availability_status' => 'in_stock',
                'daily_rate'          => 2500.00,
                'weekly_rate'         => 14000.00,
                'monthly_rate'        => 45000.00,
                'security_deposit'    => 8000.00,
                'gst_percentage'      => 18.00,
                'is_popular'          => true,
                'status'              => true,
                'specs'               => [
                    'Brand'        => 'Trimble',
                    'Model'        => 'R12i',
                    'Accuracy'     => '± 8 mm',
                    'Channels'     => '672',
                    'Tilt Control' => 'Integrated IMU',
                ]
            ],
            [
                'name'                => 'Drone Survey',
                'slug'                => 'drone-survey',
                'brand'               => 'DJI',
                'model'               => 'Phantom 4 RTK',
                'accuracy'            => '± 1 cm',
                'description'         => 'Mapping drone equipped with RTK module for aerial surveying, photogrammetry, and 3D modeling.',
                'availability_status' => 'in_stock',
                'daily_rate'          => 6000.00,
                'weekly_rate'         => 35000.00,
                'monthly_rate'        => 120000.00,
                'security_deposit'    => 15000.00,
                'gst_percentage'      => 18.00,
                'is_popular'          => true,
                'status'              => true,
                'specs'               => [
                    'Brand'        => 'DJI',
                    'Model'        => 'Phantom 4 RTK',
                    'Flight Time'  => '30 mins',
                    'Camera'       => '20 MP CMOS Sensor',
                ]
            ],
            [
                'name'                => 'LiDAR Scanner',
                'slug'                => 'lidar-scanner',
                'brand'               => 'Faro',
                'model'               => 'Focus Premium',
                'accuracy'            => '± 1 mm',
                'description'         => '3D terrestrial laser scanner for high-speed detailed scanning of buildings, heritage sites, and civil structures.',
                'availability_status' => 'in_stock',
                'daily_rate'          => 8000.00,
                'weekly_rate'         => 48000.00,
                'monthly_rate'        => 160000.00,
                'security_deposit'    => 20000.00,
                'gst_percentage'      => 18.00,
                'is_popular'          => true,
                'status'              => true,
                'specs'               => [
                    'Brand'        => 'Faro',
                    'Model'        => 'Focus Premium',
                    'Scan Range'   => 'Up to 350m',
                    'Speed'        => '2 Million pts/sec',
                ]
            ],
        ];

        foreach ($equipments as $eqData) {
            $specs = $eqData['specs'];
            unset($eqData['specs']);

            $equipment = Equipment::updateOrCreate(
                ['slug' => $eqData['slug']],
                $eqData
            );

            EquipmentSpecification::where('equipment_id', $equipment->id)->delete();
            foreach ($specs as $key => $val) {
                EquipmentSpecification::create([
                    'equipment_id' => $equipment->id,
                    'spec_key'     => $key,
                    'spec_value'   => $val,
                ]);
            }
        }

        // 2. Fetch or Create Customer for Dummy Bookings
        $customer = Customer::first();
        if (!$customer) {
            $customer = Customer::create([
                'name'         => 'Anoop Yadav',
                'phone_no'     => '9876543210',
                'email_id'     => 'anoop@example.com',
                'status'       => 'Active',
            ]);
        }

        $address = CustomerAddress::first();

        // 3. Seed Equipment Bookings
        $sampleBookings = [
            [
                'booking_number'       => 'EQB-20260924-1001',
                'customer_id'          => $customer->id,
                'equipment_id'         => 1, // Total Station
                'rental_duration_days' => 1,
                'daily_rate'           => 1500.00,
                'rental_cost'          => 1500.00,
                'security_deposit'     => 5000.00,
                'gst_amount'           => 270.00,
                'total_amount'         => 6770.00,
                'delivery_type'        => 'site_delivery',
                'address_id'           => $address ? $address->id : null,
                'latitude'             => '26.8467',
                'longitude'            => '80.9462',
                'delivery_address'     => '1A, Amar Shaheed Path, Block E, Utrathiya, Lucknow, Uttar Pradesh 226001',
                'booking_status'       => 'confirmed',
                'payment_status'       => 'paid',
                'payment_method'       => 'upi',
                'razorpay_order_id'    => 'order_NlX12345678',
                'razorpay_payment_id'  => 'pay_NlX87654321',
            ],
            [
                'booking_number'       => 'EQB-20260924-1002',
                'customer_id'          => $customer->id,
                'equipment_id'         => 2, // DGPS Receiver
                'rental_duration_days' => 3,
                'daily_rate'           => 2500.00,
                'rental_cost'          => 7500.00,
                'security_deposit'     => 8000.00,
                'gst_amount'           => 1350.00,
                'total_amount'         => 16850.00,
                'delivery_type'        => 'office_delivery',
                'address_id'           => $address ? $address->id : null,
                'latitude'             => '26.8500',
                'longitude'            => '80.9500',
                'delivery_address'     => 'Hazratganj Office Complex, Park Road, Lucknow, Uttar Pradesh 226001',
                'booking_status'       => 'dispatched',
                'payment_status'       => 'paid',
                'payment_method'       => 'net_banking',
                'razorpay_order_id'    => 'order_NlX23456789',
                'razorpay_payment_id'  => 'pay_NlX98765432',
            ],
            [
                'booking_number'       => 'EQB-20260924-1003',
                'customer_id'          => $customer->id,
                'equipment_id'         => 3, // Drone Survey
                'rental_duration_days' => 7,
                'daily_rate'           => 6000.00,
                'rental_cost'          => 35000.00,
                'security_deposit'     => 15000.00,
                'gst_amount'           => 6300.00,
                'total_amount'         => 56300.00,
                'delivery_type'        => 'site_delivery',
                'address_id'           => $address ? $address->id : null,
                'latitude'             => '26.8600',
                'longitude'            => '80.9600',
                'delivery_address'     => 'Project Site 4B, Gomti Nagar Extension, Lucknow, Uttar Pradesh',
                'booking_status'       => 'delivered',
                'payment_status'       => 'paid',
                'payment_method'       => 'card',
                'razorpay_order_id'    => 'order_NlX34567890',
                'razorpay_payment_id'  => 'pay_NlX09876543',
            ],
            [
                'booking_number'       => 'EQB-20260924-1004',
                'customer_id'          => $customer->id,
                'equipment_id'         => 4, // LiDAR Scanner
                'rental_duration_days' => 1,
                'daily_rate'           => 8000.00,
                'rental_cost'          => 8000.00,
                'security_deposit'     => 20000.00,
                'gst_amount'           => 1440.00,
                'total_amount'         => 29440.00,
                'delivery_type'        => 'self_pickup',
                'address_id'           => null,
                'latitude'             => null,
                'longitude'            => null,
                'delivery_address'     => 'Warehouse Pickup Point',
                'booking_status'       => 'pending',
                'payment_status'       => 'pending',
                'payment_method'       => 'upi',
                'razorpay_order_id'    => 'order_NlX45678901',
                'razorpay_payment_id'  => null,
            ],
        ];

        foreach ($sampleBookings as $bData) {
            EquipmentBooking::updateOrCreate(
                ['booking_number' => $bData['booking_number']],
                $bData
            );
        }
    }
}
