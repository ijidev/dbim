<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StitchTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure an Admin/Instructor exists
        $instructor = \App\Models\User::firstOrCreate(
            ['email' => 'admin@dbim.com'],
            [
                'name' => 'Dr. Julian Foster',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
                'bio' => 'Lead researcher at DBIM with over 15 years in ministerial strategy and digital theology.',
                'headline' => 'Ministerial Strategist',
                'years_ministry' => '15+',
            ]
        );

        // 2. Create the Course
        $course = \App\Models\Course::firstOrCreate(
            ['slug' => 'the-divine-blueprint'],
            [
                'title' => 'The Divine Blueprint: Mastering Ministerial Excellence',
                'description' => 'A comprehensive journey into the core strategies for modern ministerial impact. This course covers everything from digital outreach to spiritual leadership alignment.',
                'instructor_id' => $instructor->id,
                'price' => 25000,
                'is_free' => false,
                'is_published' => true,
                'category' => 'Leadership',
                'type' => 'video',
                'thumbnail' => 'https://images.unsplash.com/photo-1504052434569-70ad5836ab65?auto=format&fit=crop&q=80&w=1000',
            ]
        );

        // 3. Create Modules
        $module1 = \App\Models\Module::firstOrCreate(
            ['course_id' => $course->id, 'title' => 'Foundations of Excellence'],
            ['order' => 1]
        );

        $module2 = \App\Models\Module::firstOrCreate(
            ['course_id' => $course->id, 'title' => 'Advanced Ministerial Strategies'],
            ['order' => 2]
        );

        // 4. Create Lessons for Module 1
        \App\Models\Lesson::firstOrCreate(
            ['module_id' => $module1->id, 'title' => 'The Visionary Leader'],
            [
                'type' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Placeholder video
                'content' => '<p>In this lesson, we explore the fundamental qualities of a visionary leader in the 21st century church.</p>',
                'order' => 1
            ]
        );

        \App\Models\Lesson::firstOrCreate(
            ['module_id' => $module1->id, 'title' => 'Strategic Alignment'],
            [
                'type' => 'video',
                'video_url' => 'https://www.youtube.com/watch?v=9No-FiE9Gwc', 
                'content' => '<p>How to align your ministerial goals with your core spiritual values.</p>',
                'order' => 2
            ]
        );

        // 5. Create Quiz for Module 1
        $quizData = [
            'title' => 'Foundations Assessment',
            'passing_score' => 70,
            'questions' => [
                [
                    'question' => 'What is the primary focus of a visionary leader?',
                    'options' => ['Maintaining status quo', 'Future growth and alignment', 'Purely administrative tasks', 'Individual recognition'],
                    'correct_answer' => 1
                ],
                [
                    'question' => 'How many years of research does Dr. Julian have?',
                    'options' => ['5 years', '10 years', '15 years', '20 years'],
                    'correct_answer' => 2
                ],
                [
                    'question' => 'True or False: Strategic alignment requires spiritual core values.',
                    'options' => ['True', 'False'],
                    'correct_answer' => 0
                ]
            ]
        ];

        \App\Models\Lesson::firstOrCreate(
            ['module_id' => $module1->id, 'title' => 'Foundations Knowledge Check'],
            [
                'type' => 'quiz',
                'content' => json_encode($quizData),
                'order' => 3
            ]
        );
    }
}
