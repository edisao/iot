@extends('layouts.main')
@section('page_title', trans('labels.dashboard'))

@section('css_fullcalendar')
<link rel="stylesheet" href="{{ asset('css/plugins/fullcalendar/main.css') }}">
@endSection

@section('page_content')
    <!-- Content Page header -->
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>{{ trans('labels.dashboard') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">{{ trans('labels.inicio') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ trans('labels.dashboard') }}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 white-bg">
                <p>
                    <div class="hr-line-dashed"></div>
                </p>
                
                <div class="wrapper wrapper-content">
                </div>
                
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
    
    
</script>

@endSection