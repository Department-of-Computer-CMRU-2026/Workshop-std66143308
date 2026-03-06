<?php

use Livewire\Component;
use App\Models\Event;

new class extends Component
{
    public function delete(Event $event)
    {
        $event->delete();
        $this->dispatch('event-deleted');
    }

    public function with(): array
    {
        return [
            'events' => Event::withCount('users')->latest()->get(),
        ];
    }
};
?>

<x-layouts::app title="Events">
    <div class="flex items-center justify-between w-full mb-6">
        <flux:heading size="xl" level="1">Manage Events</flux:heading>
        <flux:button variant="primary" :href="route('admin.events.create')" wire:navigate icon="plus">New Event</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Event Title</flux:table.column>
            <flux:table.column>Speaker</flux:table.column>
            <flux:table.column>Location</flux:table.column>
            <flux:table.column>Seats</flux:table.column>
            <flux:table.column>Registrations</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($events as $event)
                <flux:table.row :key="$event->id">
                    <flux:table.cell class="font-medium">{{ $event->title }}</flux:table.cell>
                    <flux:table.cell>{{ $event->speaker }}</flux:table.cell>
                    <flux:table.cell>{{ $event->location }}</flux:table.cell>
                    <flux:table.cell>{{ collect([$event->total_seats, 0])->max() }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="success">{{ $event->users_count }} / {{ collect([$event->total_seats, 0])->max() }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class="flex gap-2">
                        <flux:button size="sm" :href="route('admin.events.edit', $event)" wire:navigate icon="pencil"></flux:button>
                        <flux:button size="sm" variant="danger" wire:click="delete({{ $event->id }})" wire:confirm="Are you sure?" icon="trash"></flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</x-layouts::app>