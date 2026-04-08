@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('todos.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 mb-6 transition group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Back to tasks
        </a>

        @php
            $priorityBadge = ['low' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'medium' => 'bg-amber-50 text-amber-700 ring-amber-200', 'high' => 'bg-red-50 text-red-700 ring-red-200'];
            $statusBadge = ['pending' => 'bg-slate-100 text-slate-600 ring-slate-200', 'in-progress' => 'bg-blue-50 text-blue-700 ring-blue-200', 'done' => 'bg-emerald-50 text-emerald-700 ring-emerald-200'];
            $dueBadge = match($task->due_status ?? '') { 'overdue' => 'bg-red-50 text-red-700 ring-red-200', 'due-today' => 'bg-amber-50 text-amber-700 ring-amber-200', default => 'bg-slate-50 text-slate-600 ring-slate-200' };
        @endphp

        <div class="bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-5 border-b border-slate-100">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl font-bold text-slate-900 leading-snug {{ $task->status === 'done' ? 'line-through text-slate-400' : '' }}">
                            {{ $task->title }}
                        </h1>
                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold ring-1 {{ $priorityBadge[$task->priority] ?? '' }}">
                                {{ ucfirst($task->priority) }} priority
                            </span>
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold ring-1 {{ $statusBadge[$task->status] ?? '' }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('todos.edit', $task) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-xl ring-1 ring-amber-200 transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('todos.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this task?')"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded-xl ring-1 ring-red-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-5">

                @if($task->description)
                    <div>
                        <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Description</h3>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $task->description }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-5">
                    @if($task->due_date)
                        <div>
                            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Due Date</h3>
                            <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold ring-1 {{ $dueBadge }}">
                                📅 {{ $task->due_date->format('l, F d, Y') }}
                            </span>
                        </div>
                    @endif

                    @if($task->tags)
                        <div>
                            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Tags</h3>
                            <div class="flex gap-1.5 flex-wrap">
                                @foreach(explode(',', $task->tags) as $tag)
                                    @if(trim($tag))
                                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded-md text-xs font-medium ring-1 ring-indigo-100">#{{ trim($tag) }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Timestamps --}}
                <div class="pt-4 border-t border-slate-100 flex items-center gap-6">
                    <div>
                        <p class="text-xs text-slate-400">Created</p>
                        <p class="text-xs font-medium text-slate-600">{{ $task->created_at->format('M d, Y · g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Last updated</p>
                        <p class="text-xs font-medium text-slate-600">{{ $task->updated_at->format('M d, Y · g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
