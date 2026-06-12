@extends('layouts.app')
@section('title', 'Organization')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/organization.css') }}">
@endpush

@section('content')

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-danger">{{ session('error') }}</div>
@endif

{{-- ══ TAB BAR ══ --}}
<div class="org-tabs">
    @php $activeTab = request('tab', 'company'); @endphp
    @foreach([
        'company'     => 'Company',
        'bank'        => 'Bank',
        'jobcategory' => 'Job Category',
        'salary'      => 'Salary Adjustments',
        'leave'       => 'Leave Deductions',
    ] as $key => $label)
        <a href="{{ route('organization.index', ['tab' => $key]) }}"
           class="org-tab {{ $activeTab === $key ? 'active' : '' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="org-content">

    @if($activeTab === 'company')
        @include('organization.partials.company-tab')
    @elseif($activeTab === 'bank')
        @include('organization.partials.bank-tab')
    @elseif($activeTab === 'jobcategory')
        @include('organization.partials.jobcategory-tab')
    @elseif($activeTab === 'salary')
        @include('organization.partials.salary-tab')
    @elseif($activeTab === 'leave')
        @include('organization.partials.leave-tab')
    @endif

</div>

@include('organization.partials.confirm-modal')

@endsection

@push('scripts')
    <script src="{{ asset('js/organization.js') }}"></script>
@endpush