<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <flux:heading size="xl" level="1">Available Events</flux:heading>
        <div>
            <flux:badge color="{{ $registeredCount >= 3 ? 'danger' : 'zinc' }}">
                My Registrations: {{ $registeredCount }} / 3
            </flux:badge>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($events as $event)
            @php
                $isRegistered = in_array($event->id, $registeredEventIds);
                $remainingSeats = max(0, $event->total_seats - $event->users_count);
                $isFull = $remainingSeats <= 0;
            @endphp
            <flux:card>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <flux:heading size="lg">{{ $event->title }}</flux:heading>
                        <flux:subheading class="mt-1">{{ $event->speaker }}</flux:subheading>
                    </div>
                </div>

                <div class="space-y-2 mb-6 text-sm">
                    <div class="flex items-center gap-2">
                        <flux:icon.map-pin class="size-4 text-zinc-500" />
                        <span>{{ $event->location }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <flux:icon.users class="size-4 text-zinc-500" />
                        <span>
                            <span class="{{ $isFull ? 'text-red-500 font-bold' : '' }}">
                                {{ $remainingSeats }}
                            </span> seats remaining (of {{ $event->total_seats }})
                        </span>
                    </div>
                </div>

                <div class="flex justify-end">
                    @if ($isRegistered)
                        <flux:button wire:click="toggleRegistration({{ $event->id }})" variant="danger" wire:loading.attr="disabled">
                            Unregister
                        </flux:button>
                    @else
                        <flux:button wire:click="toggleRegistration({{ $event->id }})" variant="primary" :disabled="$isFull || $registeredCount >= 3" wire:loading.attr="disabled">
                            {{ $isFull ? 'Closed' : 'Register' }}
                        </flux:button>
                    @endif
                </div>
            </flux:card>
        @endforeach
    </div>
</div>
