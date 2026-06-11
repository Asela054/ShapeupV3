<div class="page-header">
    <h2 class="page-title">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5
                     a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Leave Deductions
    </h2>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <button class="btn-create" onclick="openModal('addLeaveModal')">+ Add Leave Deduction</button>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table display nowrap" id="leaveTable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th><th>JOB CATEGORY</th><th>REMUNERATION NAME</th>
                    <th>DAY COUNT</th><th>AMOUNT</th><th>ACTION</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{{-- ── Add Leave Deduction Modal ── --}}
<div class="modal-overlay" id="addLeaveModal">
    <div class="modal-box">
        <div class="modal-header">
            <span>Add Leave Deduction</span>
            <button onclick="closeModal('addLeaveModal')">&times;</button>
        </div>
        <form method="POST" action="{{ route('organization.leave.store') }}">
            @csrf
            <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Job Category</label>
                    <select name="job_id" class="form-input">
                        <option value="">Select Job Category</option>
                        @foreach(\App\Models\JobCategory::orderBy('category')->get() as $jc)
                            <option value="{{ $jc->id }}">{{ $jc->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Remuneration / Type</label>
                    <select name="remuneration_id" class="form-input">
                        <option value="">Select Remuneration</option>
                        <option value="1">ATTENDANCE ALLOWANCE</option>
                        <option value="2">ADJUSTMENT</option>
                        <option value="3">FESTIVAL ADVANCE</option>
                        <option value="4">WELFARE</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Day Count</label>
                    <input type="number" step="0.01" name="day_count" class="form-input">
                </div>
                <div>
                    <label class="form-label">Amount</label>
                    <input type="number" step="0.01" name="amount" class="form-input">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('addLeaveModal')"
                        style="margin-right:10px;">Cancel</button>
                <button type="submit" class="btn-add">+ Add</button>
            </div>
        </form>
    </div>
</div>

<script>
$(function () {
    $('#leaveTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('organization.leave.data') }}",
        columns: [
            { data: 'id' },
            { data: 'job_category' },
            { data: 'remuneration_name' },
            { data: 'day_count' },
            { data: 'amount' },
            { data: 'action', orderable: false, searchable: false },
        ],
        dom: '<"dt-top-bar"Blf>rt<"dt-bottom-bar"ip>',
        buttons: [
            { extend: 'csv',   text: '&#128196; CSV',   className: 'dt-btn dt-btn-green',
              exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'pdf',   text: '&#128196; PDF',   className: 'dt-btn dt-btn-red',
              exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'print', text: '&#128424; Print', className: 'dt-btn dt-btn-blue',
              exportOptions: { columns: ':not(:last-child)' } },
        ],
        lengthMenu: [[10,25,50,100],[10,25,50,100]],
        pageLength: 25,
        order: [[0,'asc']],
    });
});
</script>