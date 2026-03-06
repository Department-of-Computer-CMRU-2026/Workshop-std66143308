<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Flux;

class Dashboard extends Component
{
    public $events = [];
    public $registeredEventIds = [];
    public $registeredCount = 0;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $user = Auth::user()->load('events');
        $this->events = Event::withCount('users')->latest()->get();
        $this->registeredEventIds = $user->events->pluck('id')->toArray();
        $this->registeredCount = $user->events->count();
    }

    public function toggleRegistration(Event $event)
    {
        $user = Auth::user();
        $isRegistered = $user->events->contains($event->id);

        if ($isRegistered) {
            $user->events()->detach($event->id);
            session()->flash('status', 'Successfully unregistered from ' . $event->title);
        }
        else {
            if ($user->events->count() >= 3) {
                session()->flash('error', 'You can only register for a maximum of 3 events.');
                return;
            }
            $event->loadCount('users');
            if ($event->users_count >= $event->total_seats) {
                session()->flash('error', 'This event is closed.');
                return;
            }
            $user->events()->attach($event->id);
            session()->flash('status', 'Successfully registered for ' . $event->title);
        }
        $this->loadData();
    }

    public function render()
    {
        return view('dashboard');
    }
}
?>
