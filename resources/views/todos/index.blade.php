@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">My Tasks</h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $tasks->count() }} task{{ $tasks->count() !== 1 ? 's' : '' }} total</p>
            </div>
            <a href="{{ route('todos.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition-all duration-150">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                New Task
            </a>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm p-4 mb-6 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <form action="{{ route('todos.search') }}" method="GET" class="flex-1 flex gap-2">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z"/>
                    </svg>
                    <input type="text" name="q" placeholder="Search tasks…"
                           class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-lg hover:bg-slate-900 transition">Search</button>
            </form>

            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('todos.priority', 'low') }}"
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 hover:bg-emerald-100 transition">Low</a>
                <a href="{{ route('todos.priority', 'medium') }}"
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-700 ring-1 ring-amber-200 hover:bg-amber-100 transition">Medium</a>
                <a href="{{ route('todos.priority', 'high') }}"
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-700 ring-1 ring-red-200 hover:bg-red-100 transition">High</a>
                <a href="{{ route('todos.due.today') }}"
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-blue-50 text-blue-700 ring-1 ring-blue-200 hover:bg-blue-100 transition">Due Today</a>
                <a href="{{ route('todos.index') }}"
                   class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 text-slate-600 ring-1 ring-slate-200 hover:bg-slate-200 transition">All</a>
            </div>
        </div>

        {{-- Task List --}}
        <div class="space-y-3">
            @forelse($tasks as $task)
                @php
                    $priorityDot = ['low' => 'bg-emerald-400', 'medium' => 'bg-amber-400', 'high' => 'bg-red-400'];
                    $priorityBadge = ['low' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'medium' => 'bg-amber-50 text-amber-700 ring-amber-200', 'high' => 'bg-red-50 text-red-700 ring-red-200'];
                    $statusBadge = ['pending' => 'bg-slate-100 text-slate-600 ring-slate-200', 'in-progress' => 'bg-blue-50 text-blue-700 ring-blue-200', 'done' => 'bg-emerald-50 text-emerald-700 ring-emerald-200'];
                    $dueBadge = match($task->due_status ?? '') { 'overdue' => 'bg-red-50 text-red-700 ring-red-200', 'due-today' => 'bg-amber-50 text-amber-700 ring-amber-200', default => 'bg-slate-50 text-slate-600 ring-slate-200' };
                @endphp

                <div class="group bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm hover:shadow-md hover:ring-indigo-200 transition-all duration-200 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            {{-- Priority dot --}}
                            <div class="mt-1.5 shrink-0">
                                <span class="block w-2.5 h-2.5 rounded-full {{ $priorityDot[$task->priority] ?? 'bg-slate-300' }}"></span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1.5">
                                    <h3 class="text-base font-semibold text-slate-900 truncate {{ $task->status === 'done' ? 'line-through text-slate-400' : '' }}">
                                        {{ $task->title }}
                                    </h3>
                                    <span class="px-2 py-0.5 rounded-md text-xs font-medium ring-1 {{ $priorityBadge[$task->priority] ?? 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-md text-xs font-medium ring-1 {{ $statusBadge[$task->status] ?? 'bg-slate-100 text-slate-600 ring-slate-200' }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                    @if($task->due_date)
                                        <span class="px-2 py-0.5 rounded-md text-xs font-medium ring-1 {{ $dueBadge }}">
                                            📅 {{ $task->due_date->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>

                                @if($task->description)
                                    <p class="text-sm text-slate-500 leading-relaxed line-clamp-1">{{ Str::limit($task->description, 120) }}</p>
                                @endif

                                @if($task->tags)
                                    <div class="flex gap-1.5 mt-2 flex-wrap">
                                        @foreach(explode(',', $task->tags) as $tag)
                                            @if(trim($tag))
                                                <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded-md text-xs font-medium ring-1 ring-indigo-100">#{{ trim($tag) }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                            <a href="{{ route('todos.show', $task) }}"
                               class="p-2 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="View">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </a>
                            <a href="{{ route('todos.edit', $task) }}"
                               class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                                </svg>
                            </a>
                            <form action="{{ route('todos.destroy', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Delete this task?')"
                                    class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition" title="Delete">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 py-20 text-center">
                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">No tasks yet</p>
                    <p class="text-slate-400 text-sm mt-1 mb-4">Get started by creating your first task</p>
                    <a href="{{ route('todos.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-indigo-700 transition">
                        Create a task
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
