@extends('layouts.instructor')

@section('title', 'Edit Course - ' . $course->title)

@section('instructor_content')
<div class="max-w-3xl mx-auto">
    <div class="mb-12">
        <a href="{{ route('instructor.courses.index') }}" class="text-sm font-bold text-slate-400 hover:text-primary flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-lg">arrow_back</span> Back to Courses
        </a>
        <h1 class="text-3xl font-black text-slate-900">Edit Course</h1>
        <p class="text-slate-500 mt-2">Update your course details and settings.</p>
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

    <form action="{{ route('instructor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="bg-white p-10 rounded-[2rem] border border-slate-100 shadow-sm space-y-8">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-slate-400">Course Title *</label>
                <input type="text" name="title" class="w-full h-14 bg-slate-50 border-none rounded-xl px-6 text-sm font-black focus:ring-2 focus:ring-primary/20" value="{{ old('title', $course->title) }}" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                 <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-slate-400">Category</label>
                    <select name="category" class="w-full h-14 bg-slate-50 border-none rounded-xl px-6 text-sm font-black focus:ring-2 focus:ring-primary/20 appearance-none">
                        <option value="General" {{ $course->category == 'General' ? 'selected' : '' }}>General</option>
                        <option value="Business" {{ $course->category == 'Business' ? 'selected' : '' }}>Business</option>
                        <option value="Spiritual" {{ $course->category == 'Spiritual' ? 'selected' : '' }}>Spiritual</option>
                        <option value="Leadership" {{ $course->category == 'Leadership' ? 'selected' : '' }}>Leadership</option>
                    </select>
                </div>
                <div>
                     <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-slate-400">Price ($)</label>
                    <input type="number" name="price" class="w-full h-14 bg-slate-50 border-none rounded-xl px-6 text-sm font-black focus:ring-2 focus:ring-primary/20" value="{{ old('price', $course->price) }}" min="0" step="0.01">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-slate-400">Description *</label>
                <textarea name="description" class="w-full bg-slate-50 border-none rounded-2xl p-6 text-sm font-medium focus:ring-2 focus:ring-primary/20 min-h-[160px]" required>{{ old('description', $course->description) }}</textarea>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 text-slate-400">Thumbnail</label>
                <div class="flex items-center gap-6">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/'.$course->thumbnail) }}" class="size-20 rounded-2xl object-cover border border-slate-100">
                    @endif
                    <label class="flex-1 flex flex-col items-center justify-center h-20 border-2 border-dashed border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Change Image</span>
                        <input type="file" name="thumbnail" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>

            <label class="flex items-center gap-4 cursor-pointer group p-4 bg-slate-50 rounded-2xl">
                <div class="relative size-6 border-2 border-slate-200 rounded-lg group-hover:border-primary transition-all">
                    <input type="checkbox" name="is_published" value="1" class="peer absolute inset-0 opacity-0 cursor-pointer" {{ $course->is_published ? 'checked' : '' }}>
                    <div class="absolute inset-0 bg-primary rounded-md opacity-0 peer-checked:opacity-100 flex items-center justify-center transition-all scale-50 peer-checked:scale-100">
                        <span class="material-symbols-outlined text-white text-base">check</span>
                    </div>
                </div>
                <span class="text-sm font-black text-slate-700">Course is Published</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="h-14 px-10 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                Save Changes
            </button>
            <a href="{{ route('instructor.courses.content', $course->id) }}" class="h-14 px-10 bg-blue-50 text-primary border border-blue-100 rounded-2xl flex items-center justify-center font-black text-sm hover:bg-blue-100 transition-all">
                Manage Curriculum
            </a>
        </div>
    </form>
</div>
@endsection
