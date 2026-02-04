@extends('admin.layouts.app')

@section('title', 'Add Financial Record')

@section('content')
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Add New Entry</h2>
        <p style="color: #64748b; margin: 0.25rem 0 0;">Record income or expense in the church ledger</p>
    </div>

    <div style="max-width: 800px;">
        <div class="data-card" style="padding: 2rem;">
            <form action="{{ route('admin.finance.ledger.store') }}" method="POST">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Transaction Type</label>
                        <select name="type" id="typeSelect" class="form-input" required onchange="updateCategories()">
                            <option value="income">Income (Coming In)</option>
                            <option value="expense">Expense (Going Out)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select name="category" id="categorySelect" class="form-input" required>
                            {{-- Populated by JS --}}
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Amount (₦)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" class="form-input" placeholder="0.00" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input type="date" name="entry_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description / Note</label>
                    <textarea name="description" class="form-input" rows="4" placeholder="Optional details (e.g. 'January Utility Bill', 'Building Offering')"></textarea>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">💾 Save Entry</button>
                    <a href="{{ route('admin.finance.ledger') }}" class="btn btn-outline" style="padding: 0.75rem 2rem;">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const categories = @json($categories);

        function updateCategories() {
            const type = document.getElementById('typeSelect').value;
            const categorySelect = document.getElementById('categorySelect');
            
            categorySelect.innerHTML = '';
            
            categories[type].forEach(cat => {
                const option = document.createElement('option');
                option.value = cat;
                option.textContent = cat;
                categorySelect.appendChild(option);
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', updateCategories);
    </script>
@endsection
