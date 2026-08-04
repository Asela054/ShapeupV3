@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-poll-h text-primary me-2"></i>Exam Result Details
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Exam Result Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- ── LEFT: Tab Content ── --}}
                        <div class="col-lg-9 p-4">
@endif

<div class="exam-result-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-poll-h text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Exam Result Details</h4>
    </div>
    @endif

    {{-- Form & Temporary "Create Table" Section --}}
    <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <span class="section-title-custom me-2">Exam Result Information</span>
                <div class="flex-grow-1 section-divider"></div>
            </div>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label-custom">Exam Type</label>
                    <select class="form-select form-select-sm bg-white" id="er_exam_type">
                        <option value="">Select Exam Type</option>
                        <option value="OL">O/L</option>
                        <option value="AL">A/L</option>
                        <option value="OTHER">Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Medium</label>
                    <select class="form-select form-select-sm bg-white" id="er_medium">
                        <option value="">Select Medium</option>
                        <option value="1">Sinhala</option>
                        <option value="2">Tamil</option>
                        <option value="3">English</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Year</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="er_year" placeholder="Year">
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">School</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="er_school" placeholder="School">
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Center No</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="er_center_no" placeholder="Center No">
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Index No</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="er_index_no" placeholder="Index No">
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Subject</label>
                    <select class="form-select form-select-sm bg-white" id="er_subject">
                        <option value="">Select Subject</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label-custom">Grade</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="er_grade" placeholder="Grade">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-primary btn-sm px-4" id="erAddToListBtn" style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add to list
                </button>
            </div>

            {{-- Temporary List Table ("Create Table") --}}
            <div class="table-responsive mt-3" id="erTempTableWrap" style="display:none;">
                <table class="table table-bordered table-sm bg-white" id="erTempTable">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase" style="background:#e2e8f0;">
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
                    <tbody id="erTempTableBody"></tbody>
                </table>

                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-primary btn-sm px-4" id="erCreateBtn" style="background-color: #0066ff; border-color: #0066ff;">
                        <i class="fas fa-plus me-1"></i> Create
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Saved DataTable Section --}}
    <div class="card border-0 mb-4" style="background-color: #ffffff; border-radius: 8px;">
        <div class="card-body p-4">
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
        </div>
    </div>

    <input type="hidden" id="er_emp_id" value="{{ $emp->id ?? ($employee->id ?? '') }}">
</div>

@if(!request()->ajax())
                        </div>

                        {{-- ── RIGHT: Sidebar Navigation ── --}}
                        <div class="col-lg-3 border-start" style="background:#f8fafc;">
                            {{-- Photo --}}
                            <div class="text-center py-4 border-bottom">
                                <div id="viewEmpPhotoWrap"
                                     style="width:110px;height:110px;border-radius:50%;overflow:hidden;
                                            margin:0 auto;background:#e2e8f0;display:flex;
                                            align-items:center;justify-content:center;">
                                    @if(isset($photo_url) && $photo_url)
                                        <img src="{{ $photo_url }}" alt="Photo" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <i class="fas fa-user text-muted" style="font-size:3rem;"></i>
                                    @endif
                                </div>
                            </div>
                            @include('employee_management.details.tab.sidebar')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif

<script>
    (function () {
        function initExamResultTab() {
            var empId = $('#er_emp_id').val();
            if (!empId) return;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            var erListUrl   = '/employee_management/details/' + empId + '/exam-result/list';
            var erStoreUrl  = '/employee_management/details/' + empId + '/exam-result';
            var erDeleteTpl = '/employee_management/details/' + empId + '/exam-result/__ID__';

            var allSubjects = @json($examSubjects ?? []);

            function fetchSubjectsIfNeeded(callback) {
                if (allSubjects && allSubjects.length > 0) {
                    if (callback) callback();
                    return;
                }
                $.ajax({
                    url: '/employee_management/masterdata/exam_subject/data',
                    type: 'GET',
                    success: function (res) {
                        if (res && res.data) {
                            allSubjects = res.data;
                        }
                        if (callback) callback();
                    }
                });
            }

            function populateSubjectDropdown(examType) {
                var $subject = $('#er_subject');
                $subject.empty().append('<option value="">Select Subject</option>');

                if (examType && allSubjects) {
                    var filtered = allSubjects.filter(function (s) {
                        return String(s.exam_type).toUpperCase() === String(examType).toUpperCase();
                    });
                    filtered.forEach(function (s) {
                        var name = s.subject || s.name || '';
                        $subject.append('<option value="' + s.id + '" data-name="' + name + '">' + name + '</option>');
                    });
                }
            }

            $('#er_exam_type').off('change').on('change', function () {
                var examType = $(this).val();
                fetchSubjectsIfNeeded(function () {
                    populateSubjectDropdown(examType);
                });
            });

            fetchSubjectsIfNeeded();

            if ($.fn.DataTable.isDataTable('#erTable')) {
                $('#erTable').DataTable().destroy();
            }

            var erTable = $('#erTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: erListUrl,
                    type: 'GET',
                    error: function () {
                        erTable.ajax.url('/employee_management/details/' + empId + '/tab/exam-result/list').load();
                    }
                },
                columns: [
                    { data: 'exam_type',  name: 'exam_type' },
                    { data: 'subject',    name: 'subject' },
                    { data: 'grade',      name: 'grade' },
                    { data: 'school',     name: 'school' },
                    {
                        data: 'medium',
                        name: 'medium',
                        render: function (data) {
                            var map = { '1': 'Sinhala', '2': 'Tamil', '3': 'English' };
                            return map[data] || data || '-';
                        }
                    },
                    { data: 'year',       name: 'year' },
                    { data: 'center_no',  name: 'center_no', render: function(d){ return d || '-'; } },
                    { data: 'index_no',   name: 'index_no', render: function(d){ return d || '-'; } },
                    {
                        data: null,
                        className: 'text-end',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <button type="button" class="btn btn-sm btn-light-danger erDeleteBtn" data-id="${row.id}" title="Delete">
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
						extend: 'print',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child)' }
					},
					{
						extend: 'csv',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child):not(:nth-child(4))' }
					}
				],
            });

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
                            <td class="fw-semibold text-gray-800">${item.subject_name}</td>
                            <td>${item.grade}</td>
                            <td>${item.school}</td>
                            <td>${item.medium_name}</td>
                            <td>${item.year}</td>
                            <td>${item.center_no || '-'}</td>
                            <td>${item.index_no || '-'}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-light-danger erRemoveTempBtn" data-index="${index}" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });
            }

            $('#erAddToListBtn').off('click').on('click', function () {
                var examType    = $('#er_exam_type').val();
                var medium      = $('#er_medium').val();
                var mediumName  = $('#er_medium option:selected').text();
                var year        = $('#er_year').val().trim();
                var school      = $('#er_school').val().trim();
                var centerNo    = $('#er_center_no').val().trim();
                var indexNo     = $('#er_index_no').val().trim();
                var subjectId   = $('#er_subject').val();
                var subjectName = $('#er_subject option:selected').attr('data-name') || $('#er_subject option:selected').text();
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

                $('#er_subject').val('');
                $('#er_grade').val('');
                $('#er_center_no').val('');
                $('#er_index_no').val('');
            });

            $(document).off('click', '.erRemoveTempBtn').on('click', '.erRemoveTempBtn', function () {
                var index = $(this).data('index');
                tempList.splice(index, 1);
                renderTempTable();
            });

            $('#erCreateBtn').off('click').on('click', function () {
                if (tempList.length === 0) {
                    Swal.fire({ icon: 'warning', title: 'Empty', text: 'No records to save.' });
                    return;
                }

                $.ajax({
                    url: erStoreUrl,
                    type: 'POST',
                    data: {
                        records: JSON.stringify(tempList)
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Success', text: res.message || 'Exam result(s) saved successfully', timer: 2000, showConfirmButton: false });
                            tempList = [];
                            renderTempTable();
                            erTable.ajax.reload(null, false);
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Save failed.' });
                        }
                    },
                    error: function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong.';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });

            $(document).off('click', '.erDeleteBtn').on('click', '.erDeleteBtn', function () {
                var id = $(this).data('id');

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
                            url: erDeleteTpl.replace('__ID__', id),
                            type: 'POST',
                            data: { _method: 'DELETE' },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message || 'Deleted successfully', timer: 2000, showConfirmButton: false });
                                    erTable.ajax.reload(null, false);
                                } else {
                                    Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Delete failed.' });
                                }
                            },
                            error: function () {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete.' });
                            }
                        });
                    }
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initExamResultTab);
        } else {
            initExamResultTab();
        }
    })();
</script>