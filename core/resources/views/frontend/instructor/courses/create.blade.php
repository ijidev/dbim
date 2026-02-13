@extends('layouts.app')

@section('title', 'Create New Course')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<style>
    body { font-family: 'Lexend', sans-serif; }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .form-input {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .form-input:focus {
        background: white;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(23, 84, 207, 0.1);
        outline: none;
    }
</style>
@endpush

@section('content')
<div class="flex bg-[#f8fafc] min-h-screen">
    <!-- Sidebar -->
    <aside class="hidden lg:flex flex-col w-64 bg-white border-r border-gray-200 sticky top-16 h-[calc(100vh-64px)]">
        <div class="p-8 pb-4">
            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Instructor Menu</h2>
            <nav class="space-y-1">
                <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">dashboard</span>
                    Dashboard
                </a>
               <a href="{{ route('instructor.courses.index') }}" class="flex items-center gap-3 px-4 py-3 bg-primary text-white rounded-xl text-sm font-black transition-all">
                    <span class="material-symbols-outlined text-lg">book_2</span>
                    Courses
                </a>
                <a href="{{ route('instructor.students.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">group</span>
                    Students
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 lg:p-12">
        <div class="max-w-3xl mx-auto">
            <div class="mb-12">
                <a href="{{ route('instructor.courses.index') }}" class="text-sm font-bold text-slate-400 hover:text-primary flex items-center gap-2 mb-4">
                    <span class="material-symbols-outlined text-lg">arrow_back</span> Back to Courses
                </a>
                <h1 class="text-3xl font-black text-slate-900">Create New Course</h1>
                <p class="text-slate-500 mt-2">Design your curriculum and upload your spiritual content.</p>
            </div>

            @if($errors->any())
                <div class="mb-8 p-6 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-sm font-bold">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Course Title *</label>
                        <input type="text" name="title" class="form-input" placeholder="e.g., Kingdom Business Fundamentals" value="{{ old('title') }}" required>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Category</label>
                        <select name="category" class="form-input">
                            <option value="General">General</option>
                            <option value="Business">Business</option>
                            <option value="Spiritual">Spiritual</option>
                            <option value="Leadership">Leadership</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Description *</label>
                        <textarea name="description" class="form-input" rows="5" placeholder="What will students learn in this course?" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Price ($)</label>
                            <input type="number" name="price" class="form-input" placeholder="0 for free" value="{{ old('price', 0) }}" min="0" step="0.01">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Thumbnail</label>
                            <label class="flex flex-col items-center justify-center w-full h-14 border-2 border-dashed border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-all">
                                <span class="text-xs font-bold text-slate-500">Choose Image File</span>
                                <input type="file" name="thumbnail" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative size-6 border-2 border-slate-200 rounded-lg group-hover:border-primary transition-all">
                            <input type="checkbox" name="is_published" value="1" class="peer absolute inset-0 opacity-0 cursor-pointer">
                            <div class="absolute inset-0 bg-primary rounded-md opacity-0 peer-checked:opacity-100 flex items-center justify-center transition-all scale-50 peer-checked:scale-100">
                                <span class="material-symbols-outlined text-white text-base">check</span>
                            </div>
                        </div>
                        <span class="text-sm font-black text-slate-600">Publish Immediately</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="h-14 px-10 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                        Create Course
                    </button>
                    <a href="{{ route('instructor.courses.index') }}" class="h-14 px-10 bg-white border border-slate-200 rounded-2xl flex items-center justify-center font-black text-sm hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
