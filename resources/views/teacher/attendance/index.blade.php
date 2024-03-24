@extends('layouts.app')
@section('title')
Attendance
@endsection

@section('activeAttendance')
active border-2 border-bottom border-primary
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                    <div class="d-flex justify-content-between">
                        <span><i class="fa-solid fa-qrcode"></i> {{ __('สร้าง QR code') }}</span>

                        <div class="button-create text-end">

                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <div class="col-md-12 ">
                    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

                    <form  action="{{ route('qrcode.store') }}" method="POST"> 
                        @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-control-label" for="form-group-input">วิชาที่สอน</label>
                <select class="form-control" name="subject_id">
                    <option value="" selected disabled>{{ __('เลือกวิชาที่สอน') }}</option>
                    @foreach ($subjects as $item)
                    <option value="{{ $item->id }}"
                        {{ old('subject_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->subject_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="level">ระดับชั้น:</label>
                <select class="form-control" name="year_id">
                    <option value="" selected >{{ __('เลือกวิชาที่สอน') }}</option>
                    @foreach ($years as $year)
                    <option value="{{ $year->id }}"
                        {{ old('year_id') == $year->id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="branch_id">ห้อง:</label>
                <select class="form-control" name="branch_id">
                    <option value="" selected >{{ __('เลือกวิชาที่สอน') }}</option>
                    @foreach ($branchs as $branch)
                    <option value="{{ $branch->id }}"
                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="start_time">เวลาเริ่มเช็คชื่อ:</label>
                <input type="time" class="form-control" id="start_time" name="start_time">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="late_time">เวลาเริ่มเช็คเข้าเรียนสาย:</label>
                <input type="time" class="form-control" id="late_time" name="late_time">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="end_time">เวลาปิดการเช็คชื่อ:</label>
                <input type="time" class="form-control" id="end_time" name="end_time">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">บันทึก</button>
</form>



                        @error('ctgy_book')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                    <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">QR Code</th>
      <th scope="col">วิชา</th>
      <th scope="col">แผนก</th>
      <th scope="col">เวลาเช็คชื่อ</th>
      <th scope="col">เวลาเช็คชื่อสาย</th>
      <th scope="col">เวลาสิ้นสุดเช็คชื่อ</th>

    </tr>
  </thead>
  <tbody>
    @foreach ($qrcodes as $index => $qrcode)
    @php
        $index ++;
    @endphp
    <tr>
      <th scope="row">{{$index}}</th>
      <td>{!! QrCode::size(100)->generate($qrcode->id) !!}</td>
      <td>{{$qrcode->subject->subject_name}}</td>
      <td>{{$qrcode->branch->name}}</td>
      <td>{{$qrcode->start_time}}</td>
      <td>{{$qrcode->late_time}}</td>
      <td>{{$qrcode->end_time}}</td>

    </tr>
    @endforeach
   
  </tbody>
</table>
                    </div>
                </div>

        </div>
    </div>
</div>
@endsection