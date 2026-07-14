{{-- Add Form --}}
<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Exam Type</label>
                <select class="form-select form-select-sm" id="er_exam_type">
                    <option value="">Select Exam Type</option>
                    <option value="OL">O/L</option>
                    <option value="AL">A/L</option>
                    <option value="OTHER">Other</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Medium</label>
                <select class="form-select form-select-sm" id="er_medium">
                    <option value="">Select Medium</option>
                    <option value="1">Sinhala</option>
                    <option value="2">Tamil</option>
                    <option value="3">English</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Year</label>
                <input type="text" class="form-control form-control-sm" id="er_year" placeholder="">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">School</label>
                <input type="text" class="form-control form-control-sm" id="er_school" placeholder="">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Center No</label>
                <input type="text" class="form-control form-control-sm" id="er_center_no" placeholder="">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Index No</label>
                <input type="text" class="form-control form-control-sm" id="er_index_no" placeholder="">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Subject</label>
                <select class="form-select form-select-sm" id="er_subject">
                    <option value="">Select Subject</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Grade</label>
                <input type="text" class="form-control form-control-sm" id="er_grade" placeholder="">
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-primary btn-sm px-4" id="erAddToListBtn">
                <i class="fas fa-plus me-1"></i> Add to list
            </button>
        </div>

        {{-- Temporary List Table --}}
        <div class="table-responsive mt-3" id="erTempTableWrap" style="display:none;">
            <table class="table table-bordered table-sm" id="erTempTable">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                        <th>Subject</th>
                        <th>Grade</th>
                        <th>School</th>
                        <th>Medium</th>
                        <th>Year</th>
                        <th>Center No</th>
                        <th>Index No</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="erTempTableBody"></tbody>
            </table>

            <div class="d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-primary btn-sm px-4" id="erCreateBtn">
                    <i class="fas fa-plus me-1"></i> Create
                </button>
            </div>
        </div>
    </div>
</div>

<hr class="my-3">

{{-- Saved DataTable --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-3" id="erTable">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>Exam</th>
                <th>Subject</th>
                <th>Grade</th>
                <th>School</th>
                <th>Medium</th>
                <th>Year</th>
                <th>Center No</th>
                <th>Index No</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<input type="hidden" id="er_emp_id" value="{{ $emp->id ?? '' }}">

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var allSubjects = @json($examSubjects ?? []);

    // ── Load subjects on exam type change ──
    $('#er_exam_type').on('change', function () {
        var examType = $(this).val();
        var $subject = $('#er_subject');
        $subject.empty().append('<option value="">Select Subject</option>');

        if (examType) {
            var filtered = allSubjects.filter(function (s) {
                return s.exam_type === examType;
            });
            filtered.forEach(function (s) {
                $subject.append('<option value="' + s.id + '" data-name="' + s.subject + '">' + s.subject + '</option>');
            });
        }
    });

    // ──  DataTable ──
    var erTable = $('#erTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee-management/details/' + $('#er_emp_id').val() + '/tab/exam-result/list',
            type: 'GET'
        },
        columns: [
            { data: 'exam_type',  name: 'exam_type' },
            { data: 'subject',    name: 'subject' },
            { data: 'grade',      name: 'grade' },
            { data: 'school',     name: 'school' },
            { data: 'medium',     name: 'medium' },
            { data: 'year',       name: 'year' },
            { data: 'center_no',  name: 'center_no' },
            { data: 'index_no',   name: 'index_no' },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-light-danger erDeleteBtn" data-id="${row.id}" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>`;
                }
            }
        ],
        dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv me-1"></i> CSV',
                className: 'btn btn-success btn-sm me-1',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger btn-sm me-1',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                className: 'btn btn-info btn-sm me-1',
                exportOptions: { columns: ':not(:last-child)' }
            }
        ],
        drawCallback: function () {
            KTMenu.createInstances();
        }
    });

    // ── Temp list  ──
    var tempList = [];

    function renderTempTable() {
        var $tbody = $('#erTempTableBody');
        $tbody.empty();

        if (tempList.length === 0) {
            $('#erTempTableWrap').hide();
            return;
        }

        $('#erTempTableWrap').show();

        tempList.forEach(function (item, index) {
            $tbody.append(`
                <tr>
                    <td>${item.subject_name}</td>
                    <td>${item.grade}</td>
                    <td>${item.school}</td>
                    <td>${item.medium_name}</td>
                    <td>${item.year}</td>
                    <td>${item.center_no}</td>
                    <td>${item.index_no}</td>
                    <td>
                        <button class="btn btn-sm btn-light-danger erRemoveTempBtn" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }

    // ── Add to temp list ──
    $('#erAddToListBtn').on('click', function () {
        var examType    = $('#er_exam_type').val();
        var medium      = $('#er_medium').val();
        var mediumName  = $('#er_medium option:selected').text();
        var year        = $('#er_year').val().trim();
        var school      = $('#er_school').val().trim();
        var centerNo    = $('#er_center_no').val().trim();
        var indexNo     = $('#er_index_no').val().trim();
        var subjectId   = $('#er_subject').val();
        var subjectName = $('#er_subject option:selected').text();
        var grade       = $('#er_grade').val().trim();

        if (!examType)  { Swal.fire({ icon: 'warning', title: 'Required', text: 'Exam Type is required.' }); return; }
        if (!subjectId) { Swal.fire({ icon: 'warning', title: 'Required', text: 'Subject is required.' }); return; }
        if (!grade)     { Swal.fire({ icon: 'warning', title: 'Required', text: 'Grade is required.' }); return; }
        if (!school)    { Swal.fire({ icon: 'warning', title: 'Required', text: 'School is required.' }); return; }
        if (!medium)    { Swal.fire({ icon: 'warning', title: 'Required', text: 'Medium is required.' }); return; }
        if (!year)      { Swal.fire({ icon: 'warning', title: 'Required', text: 'Year is required.' }); return; }

        tempList.push({
            exam_type:    examType,
            medium:       medium,
            medium_name:  mediumName,
            year:         year,
            school:       school,
            center_no:    centerNo,
            index_no:     indexNo,
            subject_id:   subjectId,
            subject_name: subjectName,
            grade:        grade
        });

        renderTempTable();

        // clear subject and grade only
        $('#er_subject').val('');
        $('#er_grade').val('');
        $('#er_center_no').val('');
        $('#er_index_no').val('');
    });

    // ── Remove from temp list ──
    $(document).on('click', '.erRemoveTempBtn', function () {
        var index = $(this).data('index');
        tempList.splice(index, 1);
        renderTempTable();
    });

    // ── Create (save all temp to DB) ──
    $('#erCreateBtn').on('click', function () {
        if (tempList.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Empty', text: 'No records to save.' });
            return;
        }

        var empId = $('#er_emp_id').val();

        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/exam-result',
            type: 'POST',
            data: {
                records: JSON.stringify(tempList)
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    tempList = [];
                    renderTempTable();
                    erTable.ajax.reload(null, false);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
            }
        });
    });

    // ── Delete saved record ──
    $(document).on('click', '.erDeleteBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#er_emp_id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the exam result record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/exam-result/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            erTable.ajax.reload(null, false);
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                        }
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete.' });
                    }
                });
            }
        });
    });

});
</script>