<div class="page-header">
    <h2 class="page-title">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 10h18M3 14h18M3 6l9-3 9 3M4 10v10h16V10"/>
        </svg>
        Bank
    </h2>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <button class="btn-create" onclick="openModal('addBankModal')">+ Add Bank</button>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table display nowrap" id="bankTable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CODE</th>
                    <th>BANK NAME</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{{-- ── Add Bank Modal ── --}}
<div class="modal-overlay" id="addBankModal">
    <div class="modal-box" style="max-width:420px;">
        <div class="modal-header">
            <span>Add New Bank</span>
            <button onclick="closeModal('addBankModal')">&times;</button>
        </div>
        <form method="POST" action="{{ route('organization.bank.store') }}">
            @csrf
            <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Bank Name *</label>
                    <input type="text" name="bank" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Code *</label>
                    <input type="text" name="code" class="form-input" required maxlength="4">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('addBankModal')"
                        style="margin-right:10px;">Cancel</button>
                <button type="submit" class="btn-add">+ Add</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Edit Bank Modal ── --}}
<div class="modal-overlay" id="editBankModal">
    <div class="modal-box" style="max-width:420px;">
        <div class="modal-header">
            <span>Edit Bank</span>
            <button onclick="closeModal('editBankModal')">&times;</button>
        </div>
        <form method="POST" id="editBankForm" action="">
            @csrf
            @method('PUT')
            <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Bank Name *</label>
                    <input type="text" name="bank" id="editBankName" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Code *</label>
                    <input type="text" name="code" id="editBankCode" class="form-input" required maxlength="4">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('editBankModal')"
                        style="margin-right:10px;">Cancel</button>
                <button type="submit" class="btn-add">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
$(function () {
    $('#bankTable').DataTable({
        processing: true,
        ajax: { url: '{{ route('organization.banks.data') }}', type: 'GET' },
        columns: [
            { data: 'id',     width: '60px' },
            { data: 'code',   width: '120px' },
            { data: 'name' },
            { data: 'action', orderable: false, searchable: false, width: '160px' },
        ],
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
        order: [[0,'desc']],
        language: { emptyTable: 'No banks found' },
    });
});
</script>