<?php

use Livewire\Component;
use App\Models\Event;

new class extends Component
{
    public $events = [];
    public $totalEvents = 0;
    public $totalSeats = 0;
    public $totalRegistrations = 0;
    public $remainingSeats = 0;

    public function mount()
    {
        $this->events = Event::with('users')->withCount('users')->get();
        $this->totalEvents = $this->events->count();
        $this->totalSeats = $this->events->sum('total_seats');
        $this->totalRegistrations = $this->events->sum('users_count');
        $this->remainingSeats = max(0, $this->totalSeats - $this->totalRegistrations);
    }
};
?>

<x-layouts::app title="Admin Dashboard">
    <flux:heading size="xl" level="1" class="mb-6">Admin Dashboard</flux:heading>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <flux:card>
            <flux:heading size="sm">Total Events</flux:heading>
            <flux:heading size="xl" class="mt-2">{{ $totalEvents }}</flux:heading>
        </flux:card>
        <flux:card>
            <flux:heading size="sm">Total Seats</flux:heading>
            <flux:heading size="xl" class="mt-2">{{ $totalSeats }}</flux:heading>
        </flux:card>
        <flux:card>
            <flux:heading size="sm">Registered</flux:heading>
            <flux:heading size="xl" class="mt-2 text-blue-600">{{ $totalRegistrations }}</flux:heading>
        </flux:card>
        <flux:card>
            <flux:heading size="sm">Remaining Seats</flux:heading>
            <flux:heading size="xl" class="mt-2 text-green-600">{{ $remainingSeats }}</flux:heading>
        </flux:card>
    </div>

    <flux:heading size="lg" level="2" class="mb-4">Registrations by Event</flux:heading>

    <div class="space-y-6">
        @foreach ($events as $event)
            <flux:card>
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <flux:heading size="md">{{ $event->title }}</flux:heading>
                        <flux:subheading>{{ $event->speaker }} | {{ $event->location }}</flux:subheading>
                    </div>
                    <div>
                        <flux:badge color="{{ $event->users_count >= $event->total_seats ? 'danger' : 'success' }}">
                            {{ $event->users_count }} / {{ $event->total_seats }} Seats
                        </flux:badge>
                    </div>
                </div>

                @if ($event->users->isEmpty())
                    <flux:text class="text-sm text-zinc-500">No registrations yet.</flux:text>
                @else
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Name</flux:table.column>
                            <flux:table.column>Email</flux:table.column>
                            <flux:table.column>Registered At</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @foreach ($event->users as $user)
                                <flux:table.row :key="$user->id">
                                    <flux:table.cell>{{ $user->name }}</flux:table.cell>
                                    <flux:table.cell>{{ $user->email }}</flux:table.cell>
                                    <flux:table.cell>{{ collect([$user->pivot->created_at, now()])->first()->format('M d, Y H:i') }}</flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                @endif
            </flux:card>
        @endforeach
    </div>
</x-layouts::app>