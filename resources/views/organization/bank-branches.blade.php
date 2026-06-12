@extends('layouts.app')
@section('title', 'Bank Branches — ' . $bank->bank)

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/organization.css') }}">
@endpush

@section('content')

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-danger">{{ session('error') }}</div>
@endif

<div class="page-header">
    <h2 class="page-title">
        <svg width="26" height="26" fill="none" viewBox="0 0 24 24"
             stroke="#4a5568" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
        </svg>
        Bank Branches &mdash; {{ $bank->bank }}
        <span style="font-size:0.85rem; font-weight:500; color:#718096; margin-left:6px;">
            (Code: {{ $bank->code }})
        </span>
    </h2>
    <a href="{{ route('organization.index', ['tab' => 'bank']) }}" class="back-link">
        ← Back to Banks
    </a>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <button class="btn-create" onclick="openModal('addBranchModal')">+ Add Branch</button>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table display nowrap" id="branchTable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>BRANCH CODE</th>
                    <th>BRANCH NAME</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($branches as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->code }}</td>
                    <td>{{ $b->branch }}</td>
                    <td>
                        {{-- Edit --}}
                        <button class="btn-edit"
                            onclick="openEditBranchModal(
                                {{ $b->id }},
                                '{{ addslashes($b->code) }}',
                                '{{ addslashes($b->branch) }}',
                                '{{ url('organization/bank-branch') }}'
                            )">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0
                                       002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828
                                       15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        {{-- Delete --}}
                        <button class="btn-delete"
                            onclick="confirmAction(
                                '{{ route('organization.bankbranch.destroy', $b->id) }}',
                                'Delete branch: {{ addslashes($b->branch) }}?'
                            )">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0
                                       01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0
                                       00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Add Branch Modal ── --}}
<div class="modal-overlay" id="addBranchModal">
    <div class="modal-box" style="max-width:420px;">
        <div class="modal-header">
            <span>Add Branch — {{ $bank->bank }}</span>
            <button onclick="closeModal('addBranchModal')">&times;</button>
        </div>
        <form method="POST" action="{{ route('organization.bankbranch.store') }}">
            @csrf
            <input type="hidden" name="bank_id" value="{{ $bank->id }}">
            <div style="padding:20px; display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label class="form-label">Branch Code</label>
                    <input type="text" name="code" class="form-input" maxlength="3">
                </div>
                <div>
                    <label class="form-label">Branch Name *</label>
                    <input type="text" name="branch" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('addBranchModal')"
                        style="margin-right:10px;">Cancel</button>
                <button type="submit" class="btn-add">+ Add Branch</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Edit Branch Modal ── --}}
<div class="modal-overlay" id="editBranchModal">
    <div class="modal-box" style="max-width:420px;">
        <div class="modal-header">
            <span>Edit Branch</span>
            <button onclick="closeModal('editBranchModal')">&times;</button>
        </div>
        <form method="POST" id="editBranchForm" action="">
            @csrf
            @method('PUT')
            <div style="padding:20px; display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label class="form-label">Branch Code</label>
                    <input type="text" name="code" id="editBranchCode" class="form-input" maxlength="3">
                </div>
                <div>
                    <label class="form-label">Branch Name *</label>
                    <input type="text" name="branch" id="editBranchName" class="form-input" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('editBranchModal')"
                        style="margin-right:10px;">Cancel</button>
                <button type="submit" class="btn-add">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Confirm Delete Modal ── --}}
@include('organization.partials.confirm-modal')

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="{{ asset('js/organization.js') }}"></script>
    <script>
    $(function () {
        $('#branchTable').DataTable({
            dom: '<"dt-top-bar"Blf>rt<"dt-bottom-bar"ip>',
            buttons: [
                { extend: 'csv',   text: '&#128196; CSV',   className: 'dt-btn dt-btn-green',
                  exportOptions: { columns: [0,1,2] } },
                { extend: 'pdf',   text: '&#128196; PDF',   className: 'dt-btn dt-btn-red',
                  exportOptions: { columns: [0,1,2] } },
                { extend: 'print', text: '&#128424; Print', className: 'dt-btn dt-btn-blue',
                  exportOptions: { columns: [0,1,2] } },
            ],
            lengthMenu: [[10,25,50,100],[10,25,50,100]],
            pageLength: 25,
            order: [[0,'asc']],
            language: { emptyTable: 'No branches found for this bank.' },
        });
    });
    </script>
@endpush