@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                    Results for <span class="text-indigo-600">"{{ $q }}"</span>
                </h1>
                <p class="text-sm text-slate-500 mt-0.5">{{ $results->count() }} result{{ $results->count() !== 1 ? 's' : '' }} found</p>
            </div>
            <a href="{{ route('todos.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 transition group">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                All tasks
            </a>
        </div>

        <div class="space-y-3">
            @forelse($results as $task)
                <div class="group bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm hover:shadow-md hover:ring-indigo-200 transition-all duration-200 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-semibold text-slate-900 mb-1">
                                {!! str_ireplace($q, '<mark class="bg-yellow-200 rounded px-0.5">' . e($q) . '</mark>', e($task->title)) !!}
                            </h3>

                            @if($task->description)
                                <p class="text-sm text-slate-500 line-clamp-2">{{ Str::limit($task->description, 150) }}</p>
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

                        <div class="flex items-center gap-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
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
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 py-20 text-center">
                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z"/>
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">No results for "{{ $q }}"</p>
                    <p class="text-slate-400 text-sm mt-1">Try a different search term</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
