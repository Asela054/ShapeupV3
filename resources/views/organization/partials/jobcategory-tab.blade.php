<div class="page-header">
    <h2 class="page-title">
        <svg width="22" height="22" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2
                     0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5
                     a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Job Category
    </h2>
</div>

<div class="table-card">
    <div class="table-toolbar">
        <button class="btn-create" onclick="openModal('addJobCatModal')">+ Add Job Category</button>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table display nowrap" id="jcTable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th><th>CATEGORY</th><th>ANNUAL LEAVES</th><th>CASUAL LEAVES</th>
                    <th>MEDICAL LEAVES</th><th>PAYROLL WORK DAYS</th><th>PAYROLL WORK HOURS</th>
                    <th>OT HOURS</th><th>HOLIDAY OT MIN MINS</th><th>OT DEDUCT %</th>
                    <th>SHIFT HOURS</th><th>WORKING TYPE</th><th>MORNING OT</th>
                    <th>LUNCH DEDUCT</th><th>LUNCH DEDUCT MINS</th><th>HOLIDAY WORK HRS</th>
                    <th>LATE TYPE</th><th>SAT OT TYPE</th><th>CUSTOM SAT OT RATE</th>
                    <th>SUN OT TYPE</th><th>CUSTOM SUN OT RATE</th>
                    <th>SPE DAY 01</th><th>SPE DAY 01 TYPE</th><th>CUSTOM SPE DAY 01 RATE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{{-- ── Add Job Category Modal ── --}}
<div class="modal-overlay" id="addJobCatModal">
    <div class="modal-box" style="max-width:860px; max-height:88vh; overflow-y:auto;">
        <div class="modal-header">
            <span>Add New Job Category</span>
            <button onclick="closeModal('addJobCatModal')">&times;</button>
        </div>
        <form method="POST" action="{{ route('organization.jobcategory.store') }}">
            @csrf
            <div style="padding:20px; display:grid; grid-template-columns:repeat(4,1fr); gap:14px;">

                {{-- Basic fields --}}
                <div><label class="form-label">Category</label>
                    <input type="text" name="category" class="form-input"></div>
                <div><label class="form-label">Annual Leaves</label>
                    <input type="number" name="annual_leaves" class="form-input"></div>
                <div><label class="form-label">Casual Leaves</label>
                    <input type="number" name="casual_leaves" class="form-input"></div>
                <div><label class="form-label">Medical Leaves</label>
                    <input type="number" name="medical_leaves" class="form-input"></div>

                <div><label class="form-label">Payroll Workdays</label>
                    <input type="number" name="emp_payroll_workdays" class="form-input"></div>
                <div><label class="form-label">Payroll Work Hours</label>
                    <input type="number" step="0.01" name="emp_payroll_workhrs" class="form-input"></div>
                <div><label class="form-label">OT Hours (After Shift)</label>
                    <input type="number" step="0.01" name="ot_app_hours" class="form-input"></div>
                <div><label class="form-label">Holiday OT Min Mins</label>
                    <input type="number" name="holiday_ot_minimum_min" class="form-input"></div>

                <div><label class="form-label">Special OT Deduct %</label>
                    <input type="number" step="0.01" name="spe_deduct_pre" class="form-input"></div>
                <div><label class="form-label">Shift Hours</label>
                    <input type="number" step="0.01" name="shift_hours" class="form-input"></div>
                <div><label class="form-label">Holiday Work Hours</label>
                    <input type="number" step="0.01" name="holiday_work_hours" class="form-input"></div>
                <div><label class="form-label">Lunch Deduction Minutes</label>
                    <input type="number" name="lunch_deduct_min" class="form-input"></div>

                {{-- Divider --}}
                <div style="grid-column:span 4;">
                    <div class="form-section-divider">Calculation Settings</div>
                </div>

                <div style="grid-column:span 2;">
                    <label class="form-label">Working Calculation</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="work_hour_date" value="Dates" checked> Dates</label>
                        <label class="radio-label"><input type="radio" name="work_hour_date" value="Hours"> Hours</label>
                    </div>
                </div>
                <div style="grid-column:span 2;">
                    <label class="form-label">Lunch Hours Deduct</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="lunch_deduct_type" value="0" checked> No</label>
                        <label class="radio-label"><input type="radio" name="lunch_deduct_type" value="1"> Yes</label>
                    </div>
                </div>
                <div style="grid-column:span 2;">
                    <label class="form-label">Morning OT Applicable</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="morning_ot" value="0" checked> No</label>
                        <label class="radio-label"><input type="radio" name="morning_ot" value="1"> Yes</label>
                    </div>
                </div>
                <div style="grid-column:span 2;">
                    <label class="form-label">Holiday OT Start</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="holiday_ot_start" value="1" checked> As Act</label>
                        <label class="radio-label"><input type="radio" name="holiday_ot_start" value="2"> Shift Time</label>
                    </div>
                </div>
                <div style="grid-column:span 2;">
                    <label class="form-label">Holiday Lunch Deduct</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="holiday_lunch_deduct" value="0" checked> No</label>
                        <label class="radio-label"><input type="radio" name="holiday_lunch_deduct" value="1"> Yes</label>
                    </div>
                </div>

                {{-- Divider --}}
                <div style="grid-column:span 4;">
                    <div class="form-section-divider">OT Type Settings</div>
                </div>

                <div style="grid-column:span 4;">
                    <label class="form-label">Saturday OT Type</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="saturday_ot_type" value="As Act" checked> As Act</label>
                        <label class="radio-label"><input type="radio" name="saturday_ot_type" value="Custom"> Custom</label>
                        <label class="radio-label"><input type="radio" name="saturday_ot_type" value="Saturday is a working date"> Saturday is a working date</label>
                    </div>
                </div>
                <div id="customSaturdayRate" style="grid-column:span 2; display:none;">
                    <label class="form-label">Custom Saturday OT Rate</label>
                    <input type="number" step="0.01" name="custom_saturday_ot_type" class="form-input" value="1.00">
                </div>

                <div style="grid-column:span 4;">
                    <label class="form-label">Sunday OT Type</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="sunday_ot_type" value="As Act" checked> As Act</label>
                        <label class="radio-label"><input type="radio" name="sunday_ot_type" value="Custom"> Custom</label>
                        <label class="radio-label"><input type="radio" name="sunday_ot_type" value="Sunday is a working date"> Sunday is a working date</label>
                    </div>
                </div>
                <div id="customSundayRate" style="grid-column:span 2; display:none;">
                    <label class="form-label">Custom Sunday OT Rate</label>
                    <input type="number" step="0.01" name="custom_sunday_ot_type" class="form-input" value="2.00">
                </div>

                {{-- Divider --}}
                <div style="grid-column:span 4;">
                    <div class="form-section-divider">Special Day Settings</div>
                </div>

                <div>
                    <label class="form-label">Special Day 01</label>
                    <select name="spe_day_1_day" class="form-input">
                        <option value="">Select Day</option>
                        <option>Monday</option><option>Tuesday</option><option>Wednesday</option>
                        <option>Thursday</option><option>Friday</option><option>Saturday</option>
                        <option>Sunday</option><option value="No Special Day">No Special Day</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Special Day 01 OT Type</label>
                    <select name="spe_day_1_type" class="form-input">
                        <option value="1">1x</option>
                        <option value="2">2x</option>
                        <option value="3">Custom</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Custom Special Day OT Rate</label>
                    <input type="number" step="0.01" name="spe_day_1_rate" class="form-input">
                </div>
                <div></div>

                {{-- Divider --}}
                <div style="grid-column:span 4;">
                    <div class="form-section-divider">Late &amp; Deduction Settings</div>
                </div>

                <div style="grid-column:span 4;">
                    <label class="form-label">Late Type</label>
                    <div class="radio-group">
                        <label class="radio-label"><input type="radio" name="late_type" value="1"> Late Per Minutes</label>
                        <label class="radio-label"><input type="radio" name="late_type" value="2"> Late Leave</label>
                        <label class="radio-label"><input type="radio" name="late_type" value="3"> Custom</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel"
                        onclick="closeModal('addJobCatModal')"
                        style="margin-right:10px;">Cancel</button>
                <button type="submit" class="btn-add">+ Add</button>
            </div>
        </form>
    </div>
</div>

<script>
$(function () {
    $('#jcTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('organization.jobcategory.data') }}",
        scrollX: true,
        columns: [
            { data: 'id',                            width: '50px' },
            { data: 'category' },
            { data: 'annual_leaves',                 width: '110px' },
            { data: 'casual_leaves',                 width: '110px' },
            { data: 'medical_leaves',                width: '110px' },
            { data: 'emp_payroll_workdays',          width: '130px' },
            { data: 'emp_payroll_workhrs',           width: '130px' },
            { data: 'ot_app_hours',                  width: '90px' },
            { data: 'holiday_ot_minimum_min',        width: '150px' },
            { data: 'spe_deduct_pre',                width: '100px' },
            { data: 'shift_hours',                   width: '100px' },
            { data: 'work_hour_date',                width: '110px' },
            { data: 'morning_ot_applicable',         width: '110px' },
            { data: 'lunch_hours_deduct',            width: '110px' },
            { data: 'lunch_deduct_min',              width: '130px' },
            { data: 'holiday_work_hours',            width: '130px' },
            { data: 'late_type',                     width: '100px' },
            { data: 'is_sat_ot_type_as_act',         width: '110px' },
            { data: 'custom_saturday_ot_type',       width: '150px' },
            { data: 'is_sun_ot_type_as_act',         width: '110px' },
            { data: 'custom_sunday_ot_type',         width: '150px' },
            { data: 'special_day_01_day',            width: '120px' },
            { data: 'spe_day_1_type',                width: '140px' },
            { data: 'spe_day_1_rate',                width: '160px' },
            { data: 'action', orderable: false, searchable: false, width: '100px' },
        ],
        dom: '<"dt-top-bar"Blf>rt<"dt-bottom-bar"ip>',
        buttons: [
            { extend: 'csv',   text: '&#128196; CSV',   className: 'dt-btn dt-btn-green',
              exportOptions: { columns: ':not(:last-child)' } },
            { extend: 'pdf',   text: '&#128196; PDF',   className: 'dt-btn dt-btn-red',
              exportOptions: { columns: ':not(:last-child)' },
              customize: function(doc){ doc.defaultStyle.fontSize = 6; } },
            { extend: 'print', text: '&#128424; Print', className: 'dt-btn dt-btn-blue',
              exportOptions: { columns: ':not(:last-child)' } },
        ],
        lengthMenu: [[10,25,50,100],[10,25,50,100]],
        pageLength: 25,
        order: [[0,'asc']],
    });
});
</script>