<?php

namespace App\Http\Controllers\EmpDetail;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeAttachment;
use App\Services\EmpDetail\FilesTabService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FilesTabController extends Controller
{
    protected $service;

    public function __construct(FilesTabService $service)
    {
        $this->service = $service;
    }

    public function show(Employee $employee, Request $request)
    {
        $details = $this->service->getFilesDetails($employee);

        if ($request->wantsJson() && !$request->acceptsHtml()) {
            return response()->json([
                'success'          => true,
                'employee'         => $employee,
                'photo_url'        => $details['photo_url'],
                'attachment_types' => $details['attachmentTypes'],
            ]);
        }

        return view('employee_management.details.tab.files', [
            'emp'             => $employee,
            'employee'        => $employee,
            'photo_url'       => $details['photo_url'],
            'attachmentTypes' => $details['attachmentTypes'],
        ]);
    }

    public function data(Employee $employee)
    {
        $query = $this->service->getFilesQuery($employee);
        $attachmentTypes = $this->service->getAttachmentTypes();

        return DataTables::of($query)
            ->addColumn('emp_ath_id', function ($row) {
                return $row->id;
            })
            ->addColumn('file_name', function ($row) {
                return basename($row->emp_ath_file_name);
            })
            ->addColumn('file_url', function ($row) {
                return asset('storage/' . $row->emp_ath_file_name);
            })
            ->addColumn('attachment_type_name', function ($row) use ($attachmentTypes) {
                return $attachmentTypes[$row->attachment_type] ?? 'Other';
            })
            ->addColumn('empcomment', function ($row) {
                return $row->empcomment ?: '-';
            })
            ->make(true);
    }

    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'file'            => ['required', 'file', 'max:10240'],
            'attachment_type' => ['required'],
            'empcomment'      => ['nullable', 'string', 'max:1000'],
        ]);

        $file = $this->service->storeFile($employee, $validated, $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Employee file uploaded successfully',
            'data'    => $file,
        ]);
    }

    public function destroy(Employee $employee, EmployeeAttachment $file)
    {
        $this->service->deleteFile($file);

        return response()->json([
            'success' => true,
            'message' => 'Employee file deleted successfully',
        ]);
    }
}
