<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HelpQuestion;

class HelpQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'question' => 'Meri property ki utility mapping ka status kya hai?',
                'status' => 'Active',
            ],
            [
                'question' => 'Utility mapping complete hone me kitna time lagta hai?',
                'status' => 'Active',
            ],
            [
                'question' => 'Survey report aur final mapping report kab milegi?',
                'status' => 'Active',
            ],
            [
                'question' => 'Agar mapping report me koi issue ya error ho to kya karna hoga?',
                'status' => 'Active',
            ],
            [
                'question' => 'Utility mapping ke liye kaun-kaun se documents required hain?',
                'status' => 'Active',
            ],
            [
                'question' => 'Meri booking ya survey schedule ko reschedule kaise kar sakta hoon?',
                'status' => 'Active',
            ],
            [
                'question' => 'Survey engineer kab site visit karega aur visit ki confirmation kaise milegi?',
                'status' => 'Active',
            ],
            [
                'question' => 'Utility mapping ki pricing, quotation ya payment details kya hain?',
                'status' => 'Active',
            ],
            [
                'question' => 'Kya aap underground utilities (water, gas, electric, telecom, sewer) ki mapping provide karte hain?',
                'status' => 'Active',
            ],
            [
                'question' => 'Customer support se contact kaise kar sakta hoon agar mujhe additional help chahiye?',
                'status' => 'Active',
            ]
        ];

        foreach ($questions as $questionData) {
            HelpQuestion::create($questionData);
        }
    }
}
