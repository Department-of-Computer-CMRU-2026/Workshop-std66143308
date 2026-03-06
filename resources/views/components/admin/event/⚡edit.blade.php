<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Event;

new class extends Component
{
    public Event $event;

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('required|string|max:255')]
    public string $speaker = '';

    #[Validate('required|string|max:255')]
    public string $location = '';

    #[Validate('required|integer|min:1')]
    public int $total_seats = 10;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->title = $event->title;
        $this->speaker = $event->speaker;
        $this->location = $event->location;
        $this->total_seats = $event->total_seats;
    }

    public function save()
    {
        $this->validate();

        $this->event->update([
            'title' => $this->title,
            'speaker' => $this->speaker,
            'location' => $this->location,
            'total_seats' => $this->total_seats,
        ]);

        return $this->redirectRoute('admin.events.index', navigate: true);
    }
};
?>

<x-layouts::app title="Edit Event">
    <div class="max-w-xl mx-auto">
        <flux:heading size="xl" level="1" class="mb-6">Edit Event</flux:heading>

        <form wire:submit="save" class="space-y-6">
            <flux:input wire:model="title" label="Event Title" placeholder="e.g. Laravel Advanced Concepts" required />
            <flux:input wire:model="speaker" label="Speaker Name" required />
            <flux:input wire:model="location" label="Location / Room" required />
            <flux:input wire:model="total_seats" type="number" min="1" label="Total Seats" required />

            <div class="flex gap-2">
                <flux:button type="submit" variant="primary">Update Event</flux:button>
                <flux:button :href="route('admin.events.index')" wire:navigate>Cancel</flux:button>
            </div>
        </form>
    </div>
</x-layouts::app>