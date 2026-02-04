@extends('layouts.app')

@push('styles')
<style>
    .reader-container {
        background: #fff;
        min-height: 100vh;
        padding: 4rem 1rem;
    }
    .reader-content {
        max-width: 800px;
        margin: 0 auto;
        font-family: 'Inter', serif;
        line-height: 2;
        font-size: 1.25rem;
        color: #1e293b;
    }
    .reader-controls {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 1rem 2rem;
        border-radius: 3rem;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        display: flex;
        gap: 2rem;
        align-items: center;
        border: 1px solid #e2e8f0;
        z-index: 100;
    }
    .control-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        color: #64748b;
        transition: color 0.2s;
    }
    .control-btn:hover {
        color: var(--primary-color);
    }
    .btn-read-aloud {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-weight: 700;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="reader-container">
    <div class="reader-content">
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 3rem; text-align: center;">{{ $book->title }}</h1>
        <div id="book-body">
            {!! nl2br(e($book->content)) !!}
        </div>
    </div>
</div>

<div class="reader-controls">
    <button class="control-btn" onclick="adjustFont(-1)">A-</button>
    <button class="control-btn" onclick="adjustFont(1)">A+</button>
    <button id="read-aloud-btn" class="btn-read-aloud">🔊 Read Aloud</button>
</div>
@endsection

@push('scripts')
<script>
    let fontSize = 1.25;
    const content = document.querySelector('.reader-content');
    const readBtn = document.getElementById('read-aloud-btn');
    let synth = window.speechSynthesis;
    let utterance = null;
    let isReading = false;

    function adjustFont(delta) {
        fontSize += delta * 0.1;
        content.style.fontSize = fontSize + 'rem';
    }

    readBtn.addEventListener('click', () => {
        if (isReading) {
            synth.cancel();
            isReading = false;
            readBtn.innerText = '🔊 Read Aloud';
        } else {
            const text = document.getElementById('book-body').innerText;
            utterance = new SpeechSynthesisUtterance(text);
            utterance.onend = () => {
                isReading = false;
                readBtn.innerText = '🔊 Read Aloud';
            };
            synth.speak(utterance);
            isReading = true;
            readBtn.innerText = '🛑 Stop Reading';
        }
    });

    // Cleanup on nav
    window.addEventListener('beforeunload', () => {
        synth.cancel();
    });
</script>
@endpush
