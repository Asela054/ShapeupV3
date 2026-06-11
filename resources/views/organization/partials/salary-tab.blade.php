<div class="page-header">
    <h2 class="page-title">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11
                     0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1
                     M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Salary Adjustments
    </h2>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <button class="btn-create" onclick="openModal('addSalaryModal')">+ Add Salary Adjustment</button>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table display nowrap" id="salaryTable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th><th>ADJUSTMENT TYPE</th><th>EMPLOYEE</th>
                    <th>JOB CATEGORY</th><th>ADD/DEDUCT TYPE</th>
                    <th>ALLOWANCE TYPE</th><th>AMOUNT</th>
                    <th>ALLOW LEAVES</th><th>APPROVED STATUS</th><th>ACTION</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{{-- ── Add Salary Adjustment Modal ── --}}
<div class="modal-overlay" id="addSalaryModal">
    <div class="modal-box">
        <div class="modal-header">
            <span>Add Salary Adjustment</span>
            <button onclick="closeModal('addSalaryModal')">&times;</button>
        </div>
        <form method="POST" action="{{ route('organization.salary.store') }}">
            @csrf
            <div style="padding:20px; display:flex; flex-direction:column; gap:14px;">
                <div>
                    <label class="form-label">Adjustment Type *</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="adjustment_type" value="1"> Employee Wise
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="adjustment_type" value="2"> Job Category Wise
                        </label>
                    </div>
                </div>
                <div>
                    <label class="form-label">Addition / Deduction Type</label>
                    <select name="allowance_type" class="form-input">
                        <option value="">Select Remuneration</option>
                        <option>ATTENDANCE ALLOWANCE</option>
                        <option>MEAL</option>
                        <option>WELFARE</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Allowance Calculation</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="allowance_type" value="Daily" checked> Daily</label>
                        <label class="radio-label"><input type="radio" name="allowance_type" value="Monthly"> Monthly</label>
                        <label class="radio-label"><input type="radio" name="allowance_type" value="Custom"> Custom</label>
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div>
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Allow Leaves</label>
                        <input type="number" name="allowleave" class="form-input">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('addSalaryModal')"
                        style="margin-right:10px;">Cancel</button>
                <button type="submit" class="btn-add">+ Add</button>
            </div>
        </form>
    </div>
</div>

<script>
$(function () {
    $('#salaryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('organization.salary.data') }}",
        columns: [
            { data: 'id' },
            { data: 'adjustment_type' },
            { data: 'employee' },
            { data: 'job_category' },
            { data: 'allowance_type' },
            { data: 'allowance_type' },
            { data: 'amount' },
            { data: 'allowleave' },
            { data: 'approved_status' },
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