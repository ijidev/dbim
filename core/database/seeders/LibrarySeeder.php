<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Walking with the Holy Spirit',
                'slug' => 'walking-with-holy-spirit',
                'author' => 'DBIM Leadership',
                'description' => 'A foundational guide for every believer.',
                'content' => "Chapter 1: The Beginning\n\nWalking with the Holy Spirit is not just a destination but a continuous journey of faith. In this book, we explore how to listen to the gentle voice of God...\n\nChapter 2: The Fruits\n\nAs we grow in our relationship, we begin to see the evidence of His presence in our lives through love, joy, and peace...",
                'price' => 0.00,
                'is_free' => true,
                'status' => true,
            ],
            [
                'title' => 'Understanding Spiritual Warfare',
                'slug' => 'understanding-spiritual-warfare',
                'author' => 'Apostle J. Doe',
                'description' => 'Advanced teaching on the hidden battles.',
                'content' => "Spiritual warfare is a reality that many choose to ignore, yet it affects every aspect of our existence. To be victorious, one must understand the weapons of our warfare which are not carnal but mighty through God to the pulling down of strongholds...",
                'price' => 3000.00,
                'is_free' => false,
                'status' => true,
            ],
        ];

        foreach ($books as $book) {
            \App\Models\Book::create($book);
        }
    }
}
