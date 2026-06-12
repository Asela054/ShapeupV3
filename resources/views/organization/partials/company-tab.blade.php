<div class="page-header">
    <h2 class="page-title">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9
                     0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0
                     011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        Company
    </h2>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <button class="btn-create" onclick="openModal('addCompanyModal')">+ Add Company</button>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table display nowrap" id="companyTable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th><th>NAME</th><th>CODE</th><th>LOGO</th>
                    <th>ADDRESS</th><th>CONTACT NO</th><th>EPF NO</th>
                    <th>ETF NO</th><th>REF NO</th><th>VAT NO</th>
                    <th>SVAT NO</th><th>ACTION</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{{-- ── Add Company Modal ── --}}
<div class="modal-overlay" id="addCompanyModal">
    <div class="modal-box" style="max-width:700px; max-height:85vh; overflow-y:auto;">
        <div class="modal-header">
            <span>Add New Company</span>
            <button onclick="closeModal('addCompanyModal')">&times;</button>
        </div>
        <form method="POST" action="{{ route('organization.company.store') }}"
              enctype="multipart/form-data">
            @csrf
            <div style="padding:20px; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div><label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-input" required></div>
                <div><label class="form-label">Code *</label>
                    <input type="text" name="code" class="form-input" required></div>
                <div style="grid-column:span 2;"><label class="form-label">Address</label>
                    <input type="text" name="address" class="form-input"></div>
                <div><label class="form-label">Mobile</label>
                    <input type="text" name="mobile" class="form-input"></div>
                <div><label class="form-label">Landline</label>
                    <input type="text" name="land" class="form-input"></div>
                <div><label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input"></div>
                <div><label class="form-label">Domain Name</label>
                    <input type="text" name="domain_name" class="form-input"></div>
                <div><label class="form-label">EPF No</label>
                    <input type="text" name="epf" class="form-input"></div>
                <div><label class="form-label">ETF No</label>
                    <input type="text" name="etf" class="form-input"></div>
                <div><label class="form-label">Ref No</label>
                    <input type="text" name="ref_no" class="form-input"></div>
                <div><label class="form-label">VAT No</label>
                    <input type="text" name="vat_reg_no" class="form-input"></div>
                <div><label class="form-label">SVAT No</label>
                    <input type="text" name="svat_no" class="form-input"></div>
                <div><label class="form-label">Zone Code</label>
                    <input type="text" name="zone_code" class="form-input"></div>
                <div><label class="form-label">Bank Account Name</label>
                    <input type="text" name="bank_account_name" class="form-input"></div>
                <div><label class="form-label">Bank Account No</label>
                    <input type="text" name="bank_account_number" class="form-input"></div>
                <div><label class="form-label">Branch Code</label>
                    <input type="text" name="bank_account_branch_code" class="form-input"></div>
                <div><label class="form-label">Employer Number</label>
                    <input type="text" name="employer_number" class="form-input"></div>
                <div><label class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-input"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('addCompanyModal')"
                        style="margin-right:10px;">Cancel</button>
                <button type="submit" class="btn-add">+ Add</button>
            </div>
        </form>
    </div>
</div>

<script>
$(function () {
    $('#companyTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('organization.company.data') }}",
        columns: [
            { data: 'id',         width: '50px' },
            { data: 'name' },
            { data: 'code',       width: '80px' },
            { data: 'logo',       orderable: false, searchable: false, width: '60px' },
            { data: 'address' },
            { data: 'contact_no', width: '110px' },
            { data: 'epf',        width: '90px' },
            { data: 'etf',        width: '90px' },
            { data: 'ref_no',     width: '90px' },
            { data: 'vat_reg_no', width: '90px' },
            { data: 'svat_no',    width: '90px' },
            { data: 'action',     orderable: false, searchable: false, width: '100px' },
        ],
        dom: '<"dt-top-bar"Blf>rt<"dt-bottom-bar"ip>',
        buttons: [
            { extend: 'csv',   text: '&#128196; CSV',   className: 'dt-btn dt-btn-green',
              exportOptions: { columns: ':not(:last-child):not(:nth-child(4))' } },
            { extend: 'pdf',   text: '&#128196; PDF',   className: 'dt-btn dt-btn-red',
              exportOptions: { columns: ':not(:last-child):not(:nth-child(4))' } },
            { extend: 'print', text: '&#128424; Print', className: 'dt-btn dt-btn-blue',
              exportOptions: { columns: ':not(:last-child)' } },
        ],
        lengthMenu: [[10,25,50,100],[10,25,50,100]],
        pageLength: 25,
        order: [[0,'asc']],
    });
});
</script>