@extends('layouts.instructor')

@section('title', 'Publish New Book')
@section('page_title', 'Publish New Book')

@section('instructor_content')
<div class="max-w-6xl mx-auto space-y-10">
    <!-- Step Indicator -->
    <div class="flex items-center justify-center gap-12 max-w-2xl mx-auto mb-16 relative">
        <div class="absolute top-1/2 left-0 w-full h-px bg-slate-100 -translate-y-1/2 -z-10"></div>
        
        <div class="flex flex-col items-center gap-3 bg-background-light px-4">
            <div class="size-10 rounded-full bg-primary text-white flex items-center justify-center font-black shadow-lg shadow-primary/20">1</div>
            <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Metadata</span>
        </div>
        
        <div class="flex flex-col items-center gap-3 bg-background-light px-4 opacity-30">
            <div class="size-10 rounded-full bg-white border-2 border-slate-200 text-slate-400 flex items-center justify-center font-black">2</div>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Chapters</span>
        </div>

        <div class="flex flex-col items-center gap-3 bg-background-light px-4 opacity-30">
            <div class="size-10 rounded-full bg-white border-2 border-slate-200 text-slate-400 flex items-center justify-center font-black">3</div>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Review</span>
        </div>
    </div>

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <a href="{{ route('instructor.library.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-400 hover:text-primary transition-all group mb-2">
                <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                CANCEL
            </a>
            <h1 class="text-3xl font-black text-slate-900 leading-tight tracking-tight">Create New Book <span class="text-slate-300 font-medium mx-3 text-2xl">/</span> <span class="text-slate-400 font-medium">Step 1: Metadata</span></h1>
        </div>
    </div>

    <form action="{{ route('instructor.library.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="bookForm">
        @csrf
        <input type="hidden" name="action" id="formAction" value="save">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left: Book Details -->
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white p-10 rounded-[2.5rem] border border-[#dcdfe5] shadow-sm space-y-10">
                    <h3 class="text-lg font-black text-slate-900 flex items-center gap-3 border-b border-slate-50 pb-8">
                        <span class="material-symbols-outlined text-primary font-bold">book</span>
                        Book Details
                    </h3>

                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label for="title" class="block text-xs font-black text-slate-900 uppercase tracking-widest">Book Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                   class="w-full h-14 px-6 bg-[#f8f9fb] border-none rounded-2xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-bold text-slate-900 placeholder:text-slate-400 placeholder:font-medium" 
                                   placeholder="e.g. Walking in Faith: A Daily Guide" required>
                            @error('title') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label for="author" class="block text-xs font-black text-slate-900 uppercase tracking-widest">Author Name</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">person</span>
                                    <input type="text" name="author" id="author" value="{{ old('author', auth()->user()->name) }}" 
                                           class="w-full h-14 pl-12 pr-6 bg-[#f8f9fb] border-none rounded-2xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-bold text-slate-900 placeholder:text-slate-400" required>
                                </div>
                                @error('author') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-3">
                                <label for="category" class="block text-xs font-black text-slate-900 uppercase tracking-widest">Category</label>
                                <select name="category" id="category" class="w-full h-14 px-6 bg-[#f8f9fb] border-none rounded-2xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-bold text-slate-900 appearance-none">
                                    <option value="" disabled selected>Select a category...</option>
                                    <option value="Theology">Theology</option>
                                    <option value="Devotional">Devotional</option>
                                    <option value="History">History</option>
                                    <option value="Biography">Biography</option>
                                    <option value="Liturgy">Liturgy</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label for="description" class="block text-xs font-black text-slate-900 uppercase tracking-widest">Short Description</label>
                                <span class="text-[10px] font-bold text-slate-400 uppercase" id="descCount">0/300 characters</span>
                            </div>
                            <textarea name="description" id="description" rows="5" maxlength="300"
                                      class="w-full p-6 bg-[#f8f9fb] border-none rounded-3xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium text-slate-600 placeholder:text-slate-400 resize-none leading-relaxed" 
                                      placeholder="Briefly describe what this book is about..." onkeyup="countChars(this)">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Global Price -->
                <div class="bg-white p-10 rounded-[2.5rem] border border-[#dcdfe5] shadow-sm space-y-8">
                     <h3 class="text-lg font-black text-slate-900 flex items-center gap-3 border-b border-slate-50 pb-8">
                        <span class="material-symbols-outlined text-primary font-bold">payments</span>
                        Global Price
                    </h3>

                    <div class="grid grid-cols-2 gap-12 items-end">
                        <div class="space-y-3">
                            <label for="price" class="block text-xs font-black text-slate-900 uppercase tracking-widest">Price Amount (USD)</label>
                            <div class="relative">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-400">$</span>
                                <input type="number" name="price" id="price" value="{{ old('price', '0.00') }}" 
                                       class="w-full h-14 pl-10 pr-6 bg-[#f8f9fb] border-none rounded-2xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-black text-slate-900" 
                                       step="0.01" min="0">
                            </div>
                        </div>
                        
                        <div class="bg-[#f8f9fb] p-4 rounded-2xl border border-slate-50 flex items-center justify-between">
                            <div>
                                <p class="text-[11px] font-black text-slate-900 uppercase tracking-tight">Make this book free</p>
                                <p class="text-[9px] font-bold text-slate-400 leading-none mt-1">For ministry outreach programs</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_free" value="1" class="sr-only peer" checked onchange="togglePrice(this)">
                                <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Writing Goals -->
                <div class="bg-white p-10 rounded-[2.5rem] border border-[#dcdfe5] shadow-sm space-y-8">
                     <h3 class="text-lg font-black text-slate-900 flex items-center gap-3 border-b border-slate-50 pb-8">
                        <span class="material-symbols-outlined text-primary font-bold">flag</span>
                        Writing Goals
                    </h3>

                    <div class="space-y-4">
                        <label for="pages" class="block text-xs font-black text-slate-900 uppercase tracking-widest">Target Page Count</label>
                        <p class="text-[11px] text-slate-500 font-medium mb-4">Set a goal for yourself. 1 page &approx; 275 words.</p>
                        <input type="number" name="pages" id="pages" value="{{ old('pages', 10) }}" 
                               class="w-full h-14 px-6 bg-[#f8f9fb] border-none rounded-2xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-black text-slate-900" 
                               min="1">
                    </div>
                </div>
            </div>

            <!-- Right: Book Cover -->
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white p-10 rounded-[2.5rem] border border-[#dcdfe5] shadow-sm space-y-8">
                    <h3 class="text-lg font-black text-slate-900 flex items-center gap-3 border-b border-slate-50 pb-8">
                        <span class="material-symbols-outlined text-primary font-bold">image</span>
                        Book Cover
                    </h3>
                    
                    <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Upload a high-quality cover image. Recommended ratio 2:3 (e.g. 1600x2400px).</p>

                    <div class="relative w-full aspect-[2/3] bg-[#f8f9fb] rounded-3xl border-2 border-dashed border-slate-200 hover:border-primary/50 transition-all group overflow-hidden flex flex-col items-center justify-center cursor-pointer">
                        <input type="file" name="cover_image" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                        <div class="text-center space-y-4 p-6" id="upload-placeholder">
                            <div class="bg-white p-5 rounded-full shadow-sm inline-block group-hover:scale-110 transition-transform text-primary border border-slate-50">
                                <span class="material-symbols-outlined text-4xl">cloud_upload</span>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-900 uppercase tracking-widest">Click to upload</p>
                                <p class="text-[10px] text-slate-400 font-medium mt-1">or drag and drop SVG, PNG, JPG</p>
                            </div>
                        </div>
                        <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden">
                    </div>

                    <div class="bg-amber-50 p-6 rounded-3xl border border-amber-100 flex items-start gap-4">
                        <span class="material-symbols-outlined text-amber-500">lightbulb</span>
                        <p class="text-[10px] text-amber-900 font-bold leading-relaxed">
                            <span class="uppercase">Tip:</span> Covers with bold, legible typography perform 25% better in the store.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex items-center justify-between pt-10 border-t border-slate-100">
            <button type="button" onclick="submitForm('save')" class="text-sm font-black text-slate-400 hover:text-slate-900 transition-all uppercase tracking-widest">
                Save as Draft
            </button>
            
            <button type="button" onclick="submitForm('next')" class="h-16 px-12 bg-primary text-white rounded-[1.25rem] text-sm font-black shadow-xl shadow-primary/20 hover:scale-105 transition-all flex items-center gap-4">
                NEXT: BUILD CHAPTERS
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('preview').classList.remove('hidden');
                document.getElementById('upload-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePrice(checkbox) {
        const container = document.getElementById('price').parentElement.parentElement;
        if (checkbox.checked) {
            container.classList.add('opacity-30', 'pointer-events-none');
            document.getElementById('price').value = '0.00';
        } else {
            container.classList.remove('opacity-30', 'pointer-events-none');
        }
    }

    function countChars(textarea) {
        document.getElementById('descCount').innerText = textarea.value.length + '/300 characters';
    }

    function submitForm(action) {
        document.getElementById('formAction').value = action;
        document.getElementById('bookForm').submit();
    }
    
    // Initial Price Toggle
    window.onload = () => {
        togglePrice(document.getElementsByName('is_free')[0]);
    }
</script>
@endsection
