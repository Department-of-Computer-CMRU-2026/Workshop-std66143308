<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'AI and the Future of Web Development',
                'speaker' => 'John Doe',
                'location' => 'Main Auditorium',
                'total_seats' => 50,
            ],
            [
                'title' => 'Laravel 12 Masterclass',
                'speaker' => 'Taylor Otwell',
                'location' => 'Room 101',
                'total_seats' => 30,
            ],
            [
                'title' => 'Modern UI Patterns with Flux',
                'speaker' => 'Caleb Porzio',
                'location' => 'Innovation Lab',
                'total_seats' => 20,
            ],
            [
                'title' => 'Full-Stack Performance Optimization',
                'speaker' => 'Jane Smith',
                'location' => 'Conference Hall B',
                'total_seats' => 40,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
