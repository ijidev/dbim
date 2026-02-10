@extends('layouts.app')

@section('title', 'Book a Live Session - Grace LMS')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .time-slot-active {
        background-color: var(--primary) !important;
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .step-active {
        background-color: var(--primary) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(23, 84, 207, 0.3);
    }
</style>
@endpush

@section('content')
<main class="flex-1 bg-[#f6f6f8] min-h-screen" x-data="bookingFlow()">
    <!-- Breadcrumbs -->
    <div class="w-full bg-white border-b border-gray-200 px-8 py-4">
        <div class="max-w-7xl mx-auto flex items-center gap-2 text-sm text-gray-500">
            <a class="hover:text-primary transition-colors" href="{{ route('instructors') }}">Instructors</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ route('instructor.profile', $instructor->id) }}">{{ $instructor->name }}</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-bold">Book Session</span>
        </div>
    </div>

    <div class="p-8 max-w-7xl mx-auto w-full">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 mb-2">Book a Live Session</h1>
            <p class="text-slate-500 text-lg font-medium">Schedule time with {{ $instructor->name }} for mentorship or group learning.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left: Form -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Stepper -->
                <div class="flex items-center justify-between relative mb-12">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full -z-10"></div>
                    
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center gap-2 bg-[#f6f6f8] px-2 z-10">
                        <div class="size-10 rounded-full flex items-center justify-center font-bold ring-4 ring-[#f6f6f8] transition-all"
                             :class="step >= 1 ? 'step-active' : 'bg-white border-2 border-gray-300 text-gray-400'">1</div>
                        <span class="text-xs font-bold" :class="step >= 1 ? 'text-primary' : 'text-gray-400'">Date & Time</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center gap-2 bg-[#f6f6f8] px-2 z-10">
                        <div class="size-10 rounded-full flex items-center justify-center font-bold ring-4 ring-[#f6f6f8] transition-all"
                             :class="step >= 2 ? 'step-active' : 'bg-white border-2 border-gray-300 text-gray-400'">2</div>
                        <span class="text-xs font-bold" :class="step >= 2 ? 'text-primary' : 'text-gray-400'">Details</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center gap-2 bg-[#f6f6f8] px-2 z-10">
                        <div class="size-10 rounded-full flex items-center justify-center font-bold ring-4 ring-[#f6f6f8] transition-all"
                             :class="step >= 3 ? 'step-active' : 'bg-white border-2 border-gray-300 text-gray-400'">3</div>
                        <span class="text-xs font-bold" :class="step >= 3 ? 'text-primary' : 'text-gray-400'">Confirm</span>
                    </div>
                </div>

                <!-- Step 1 Content: Date & Time -->
                <template x-if="step === 1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-xl font-bold flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">calendar_month</span>
                                Select Date & Time
                            </h2>
                        </div>
                        <div class="p-6 flex flex-col md:flex-row gap-8">
                            <!-- Simple Calendar Mock -->
                            <div class="flex-1">
                                <label class="block text-sm font-bold text-slate-700 mb-4">Select Date</label>
                                <input type="date" x-model="selectedDate" class="w-full rounded-xl border-gray-200 p-4 focus:ring-primary focus:border-primary font-bold text-slate-900 shadow-sm" min="{{ date('Y-m-d') }}">
                            </div>
                            <!-- Time Slots -->
                            <div class="w-full md:w-56 border-l border-gray-100 md:pl-8">
                                <h3 class="font-bold text-lg mb-4" x-text="selectedDate ? new Date(selectedDate).toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' }) : 'Select Date'"></h3>
                                <div class="grid grid-cols-2 md:grid-cols-1 gap-2 max-h-[300px] overflow-y-auto pr-2">
                                    <template x-for="time in timeSlots">
                                        <button @click="selectedTime = time" 
                                                class="w-full py-3 px-4 rounded-xl border border-gray-200 text-sm font-bold transition-all hover:border-primary hover:text-primary"
                                                :class="selectedTime === time ? 'time-slot-active border-primary' : 'bg-white text-slate-600'">
                                            <span x-text="time"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-slate-50 border-t border-gray-100 text-right">
                             <button @click="nextStep()" 
                                     :disabled="!selectedDate || !selectedTime"
                                     class="bg-primary text-white px-8 py-3 rounded-xl font-black shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                Next Step
                             </button>
                        </div>
                    </div>
                </template>

                <!-- Step 2 Content: Details -->
                <template x-if="step === 2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">description</span>
                                Session Details
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3">Select Session Type</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div @click="sessionType = 'mentorship'; price = 75000" 
                                         class="relative flex items-start p-4 cursor-pointer rounded-xl border-2 transition-all"
                                         :class="sessionType === 'mentorship' ? 'border-primary bg-primary/5' : 'border-gray-200 hover:border-gray-300'">
                                        <div class="flex h-6 items-center">
                                            <div class="size-4 rounded-full border-2 flex items-center justify-center" :class="sessionType === 'mentorship' ? 'border-primary' : 'border-gray-300'">
                                                <div class="size-2 rounded-full bg-primary" x-show="sessionType === 'mentorship'"></div>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <span class="block text-sm font-black text-slate-900">1-on-1 Mentorship</span>
                                            <span class="block text-[10px] text-gray-500 font-medium mt-1">Private 45 min session focusing on your ministry goals.</span>
                                            <span class="block text-sm font-bold text-primary mt-2">₦75,000</span>
                                        </div>
                                    </div>
                                    <div @click="sessionType = 'masterclass'; price = 25000" 
                                         class="relative flex items-start p-4 cursor-pointer rounded-xl border-2 transition-all"
                                         :class="sessionType === 'masterclass' ? 'border-primary bg-primary/5' : 'border-gray-200 hover:border-gray-300'">
                                        <div class="flex h-6 items-center">
                                            <div class="size-4 rounded-full border-2 flex items-center justify-center" :class="sessionType === 'masterclass' ? 'border-primary' : 'border-gray-300'">
                                                <div class="size-2 rounded-full bg-primary" x-show="sessionType === 'masterclass'"></div>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <span class="block text-sm font-black text-slate-900">Group Masterclass</span>
                                            <span class="block text-[10px] text-gray-500 font-medium mt-1">Join a small group session (max 10) on leadership.</span>
                                            <span class="block text-sm font-bold text-primary mt-2">₦25,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Session Title</label>
                                <input type="text" x-model="sessionTitle" class="w-full rounded-xl border-gray-200 p-4 focus:ring-primary focus:border-primary text-sm font-bold" placeholder="e.g., Spiritual Leadership Strategy">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">What would you like to discuss?</label>
                                <textarea x-model="sessionAgenda" class="w-full rounded-xl border-gray-200 p-4 focus:ring-primary focus:border-primary text-sm font-medium" rows="4" placeholder="Briefly describe your goals for this session..."></textarea>
                            </div>
                        </div>
                        <div class="p-6 bg-slate-50 border-t border-gray-100 flex justify-between">
                            <button @click="prevStep()" class="text-slate-500 font-bold hover:text-slate-900">Back</button>
                            <button @click="nextStep()" 
                                    :disabled="!sessionTitle"
                                    class="bg-primary text-white px-8 py-3 rounded-xl font-black shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50">
                                Next Step
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Step 3 Content: Confirm -->
                <template x-if="step === 3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-xl font-bold flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">verified</span>
                                Review & Confirm
                            </h2>
                        </div>
                        <form action="{{ route('meeting.book') }}" method="POST" class="p-6">
                            @csrf
                            <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                            <input type="hidden" name="title" :value="sessionTitle">
                            <input type="hidden" name="description" :value="sessionAgenda">
                            <input type="hidden" name="scheduled_at" :value="selectedDate + ' ' + formatTime(selectedTime)">
                            <input type="hidden" name="type" :value="sessionType">
                            <input type="hidden" name="price" :value="price">

                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex flex-col md:flex-row gap-8">
                                <div class="flex-1 space-y-6">
                                    <div>
                                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Instructor</p>
                                        <div class="flex items-center gap-3 mt-3">
                                            <div class="size-12 rounded-xl bg-slate-200 overflow-hidden border border-white shadow-sm flex-shrink-0">
                                                @if($instructor->avatar)
                                                <img src="{{ asset($instructor->avatar) }}" alt="{{ $instructor->name }}" class="w-full h-full object-cover">
                                                @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400 font-black">
                                                    {{ substr($instructor->name, 0, 1) }}
                                                </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-900">{{ $instructor->name }}</p>
                                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">{{ $instructor->headline ?? 'Lead Mentor' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Date</p>
                                            <p class="font-bold text-slate-900 mt-2 text-sm" x-text="new Date(selectedDate).toLocaleDateString('en-US', { dateStyle: 'full' })"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Time</p>
                                            <p class="font-bold text-slate-900 mt-2 text-sm" x-text="selectedTime"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-px bg-slate-200 hidden md:block"></div>
                                <div class="flex-1 space-y-6">
                                    <div>
                                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Session</p>
                                        <p class="font-black text-lg text-primary mt-2" x-text="sessionTitle"></p>
                                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1" x-text="sessionType === 'mentorship' ? '1-on-1 Mentorship' : 'Group Masterclass'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Total Due</p>
                                        <p class="font-black text-3xl text-slate-900 mt-2">₦<span x-text="price.toLocaleString()"></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-6">
                                <div class="text-xs text-slate-400 flex items-start gap-2 max-w-sm">
                                    <span class="material-symbols-outlined text-sm mt-0.5">info</span>
                                    <span>By confirming, you agree to the Terms of Service. Instructor will be notified to approve your request.</span>
                                </div>
                                <div class="flex items-center gap-4 w-full md:w-auto">
                                    <button type="button" @click="prevStep()" class="text-slate-500 font-bold hover:text-slate-900 px-4">Back</button>
                                    <button type="submit" class="flex-1 md:flex-none bg-primary hover:bg-primary/90 text-white px-10 py-4 rounded-xl font-black transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-3">
                                        Confirm & Book
                                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </template>
            </div>

            <!-- Right: Info -->
            <div class="lg:col-span-4">
                <div class="sticky top-8 space-y-6">
                    <div class="bg-[#0a192f] rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
                         <div class="absolute top-0 right-0 w-32 h-32 bg-primary/20 blur-3xl -z-0"></div>
                        <h3 class="font-black text-xl mb-4 flex items-center gap-2 relative z-10">
                            <span class="material-symbols-outlined text-[#b8860b]">stars</span>
                            Premium Session
                        </h3>
                        <p class="text-sm text-slate-300 mb-6 leading-relaxed relative z-10">You are booking a dedicated time with our lead mentors. This includes:</p>
                        <ul class="space-y-4 mb-8 relative z-10">
                            <li class="flex items-start gap-3 text-sm font-medium">
                                <span class="material-symbols-outlined text-[#b8860b] text-xl shrink-0">check_circle</span>
                                <span>Personalized ministry roadmap strategy</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm font-medium">
                                <span class="material-symbols-outlined text-[#b8860b] text-xl shrink-0">check_circle</span>
                                <span>Tailored resource recommendations</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm font-medium">
                                <span class="material-symbols-outlined text-[#b8860b] text-xl shrink-0">check_circle</span>
                                <span>Follow-up email summary & recording</span>
                            </li>
                        </ul>
                        <div class="border-t border-white/10 pt-6 relative z-10">
                            <div class="flex items-center gap-3 bg-white/5 p-4 rounded-xl">
                                <div class="bg-white/10 p-2 rounded-lg">
                                    <span class="material-symbols-outlined text-white">videocam</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold">Online Session</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Link sent upon approval</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Instructor Availability</h4>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="size-2 bg-emerald-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-black text-slate-700">High availability this week</span>
                        </div>
                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Most mentors respond to booking requests within 1-2 hours on weekdays.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function bookingFlow() {
    return {
        step: 1,
        selectedDate: '',
        selectedTime: '',
        sessionType: 'mentorship',
        sessionTitle: '',
        sessionAgenda: '',
        price: 75000,
        timeSlots: [
            '09:00 AM', '10:00 AM', '11:00 AM',
            '01:00 PM', '02:00 PM', '03:00 PM',
            '04:00 PM', '05:00 PM'
        ],
        nextStep() {
            if (this.step < 3) this.step++;
        },
        prevStep() {
            if (this.step > 1) this.step--;
        },
        formatTime(timeStr) {
            // Converts '11:00 AM' to '11:00:00' for database
            const [time, modifier] = timeStr.split(' ');
            let [hours, minutes] = time.split(':');
            if (hours === '12') hours = '00';
            if (modifier === 'PM') hours = parseInt(hours, 10) + 12;
            return `${hours}:${minutes}:00`;
        }
    }
}
</script>
@endsection
