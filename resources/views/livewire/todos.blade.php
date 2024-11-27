<?php

use App\Mail\TodoCreated;
use App\Models\Todo;
use Illuminate\Support\Facades\Mail;
use function Livewire\Volt\{state, with};

state(['task']);

with([
    'todos' => fn() => auth()->user()->todos
]);

$add = function () {
    $todo = auth()->user()->todos()->create([
        'task' => $this->task
    ]);

    Mail::to(auth()->user())
        ->queue(new TodoCreated($todo));

    $this->task = '';
};

$delete = fn(Todo $todo) => $todo->delete();

?>

<div>
    <form wire:submit="add">
        <input style="color: black" type="text" name="" id="" wire:model="task">
        <button type="submit">Adicionar todo</button>
    </form>

    <div>
        @foreach($todos as $todo)
            <div>
                {{ $todo->task }}
                <button wire:click="delete({{ $todo->id }})">❌</button>
            </div>
        @endforeach
    </div>
</div>
