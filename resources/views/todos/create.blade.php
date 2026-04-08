@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Back link --}}
        <a href="{{ route('todos.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 mb-6 transition group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Back to tasks
        </a>

        <div class="bg-white rounded-2xl ring-1 ring-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                <h1 class="text-lg font-bold text-slate-900">Create New Task</h1>
                <p class="text-sm text-slate-500 mt-0.5">Fill in the details below to add a new task.</p>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('todos.store') }}" class="space-y-5">
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               placeholder="What needs to be done?"
                               class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @error('title') border-red-400 bg-red-50 @enderror">
                        @error('title')
                            <p class="text-red-600 text-xs mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                        <textarea name="description" rows="4" placeholder="Add more context or notes…"
                                  class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                    </div>

                    {{-- Due Date + Priority --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Due Date</label>
                            <input type="date" name="due_date" value="{{ old('due_date') }}" min="{{ now()->toDateString() }}"
                                   class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            @error('due_date')
                                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Priority</label>
                            <select name="priority"
                                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🔴 High</option>
                            </select>
                        </div>
                    </div>

                    {{-- Status + Tags --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                            <select name="status"
                                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="in-progress" {{ old('status') == 'in-progress' ? 'selected' : '' }}>🔄 In Progress</option>
                                <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>✅ Done</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags') }}" placeholder="work, personal, urgent"
                                   class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-xs text-slate-400 mt-1">Separate tags with commas</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2.5 rounded-xl shadow-sm transition-all duration-150">
                            Create Task
                        </button>
                        <a href="{{ route('todos.index') }}"
                           class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
