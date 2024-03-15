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
                        <div class="col-md-12 table-responsive">
                            <div class="form-group col-lg-4">
                                <label class="form-control-label" for="form-group-input">วิชาที่สอน</label>
                                <select class="form-control" name="ctgy_book">
                                    <option value="" selected disabled>{{ __('เลือกวิชาที่สอน') }}</option>
                                    @foreach ($subjects as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('ctgy_book') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name_book }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('ctgy_book')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
