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
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=1374&auto=format&fit=crop',
                'bio' => 'Lead researcher at DBIM with over 15 years in ministerial strategy and digital theology. Empowering leaders to navigate the modern church landscape.',
                'headline' => 'Ministerial Strategist & Lead Researcher',
                'years_ministry' => '15+',
                'location' => 'Lagos, Nigeria',
                'welcome_video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
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
                'thumbnail' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=1471&auto=format&fit=crop',
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
                'content' => '<p>Test your knowledge.</p>',
                'quiz_data' => json_encode($quizData),
                'order' => 3
            ]
        );

        // 6. Create Books for the Instructor
        if (class_exists(\App\Models\Book::class)) {
            \App\Models\Book::updateOrCreate(
                ['slug' => 'the-divine-strategy'],
                [
                    'title' => 'The Divine Strategy',
                    'description' => 'A masterclass in navigating modern ministerial challenges with spiritual precision.',
                    'author' => $instructor->name,
                    'price' => 5000,
                    'status' => true,
                    'category' => 'Leadership',
                    'cover_image' => 'https://images.unsplash.com/photo-1544648151-1823ed4117ff?auto=format&fit=crop&q=80&w=400',
                ]
            );

            \App\Models\Book::updateOrCreate(
                ['slug' => 'kingdom-impact'],
                [
                    'title' => 'Kingdom Impact',
                    'description' => 'Principles for scaling your ministry in the digital age.',
                    'author' => $instructor->name,
                    'price' => 0,
                    'status' => true,
                    'category' => 'Strategy',
                    'cover_image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=400',
                ]
            );
        }

        // 7. Create a Student User
        $student = \App\Models\User::updateOrCreate(
            ['email' => 'student@dbim.com'],
            [
                'name' => 'John Student',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'student',
            ]
        );

        // 8. Create Meetings
        \App\Models\Meeting::updateOrCreate(
            ['title' => 'Mastering Digital Ministry'],
            [
                'host_id' => $instructor->id,
                'description' => 'A deep dive into digital tools for modern churches.',
                'room_code' => 'DIGITAL101',
                'status' => 'scheduled',
                'scheduled_at' => now()->addDays(2),
                'visibility' => 'public',
                'price' => 25000,
                'type' => 'masterclass',
                'max_participants' => 10,
            ]
        );

        \App\Models\Meeting::updateOrCreate(
            ['title' => 'Personal Mentorship Session'],
            [
                'host_id' => $instructor->id,
                'description' => '1-on-1 ministerial guidance.',
                'room_code' => 'PRIVATE777',
                'status' => 'scheduled',
                'scheduled_at' => now()->addDays(5),
                'visibility' => 'private',
                'price' => 75000,
                'type' => 'mentorship',
                'allowed_student_ids' => json_encode([$student->id]),
            ]
        );
    }
}
