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
                        <span><i class="fa-solid fa-book"></i> {{ __('รายงานเช็คชื่อ') }}</span>

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

                    <form  method="get"> 
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
        <!-- <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="level">ระดับชั้น:</label>
                <select class="form-control" name="year_id">
                    <option value="" selected >{{ __('ระดับชั้น') }}</option>
                    @foreach ($years as $year)
                    <option value="{{ $year->id }}"
                        {{ old('year_id') == $year->id ? 'selected' : '' }}>
                        {{ $year->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div> -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="branch_id">ห้อง:</label>
                <select class="form-control" name="branch_id">
                    <option value="" selected >{{ __('แผนก') }}</option>
                    @foreach ($branchs as $branch)
                    <option value="{{ $branch->id }}"
                        {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        
    </div>
   
    <button type="submit" class="btn btn-primary">บันทึก</button>
    <button onclick="printDiv('printableContent')" class="btn btn-warning"><i class="fa-solid fa-print"></i> พิมพ์</button>

</form>



                        @error('ctgy_book')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body" id="printableContent">
                        <h3>รายงานเช็คชื่อ</h3>
                    <table  class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">ชื่อ-นามสกุล</th>
      <th scope="col">วิชา</th>
      <th scope="col">แผนก</th>
      <th scope="col">เวลาเช็คชื่อ</th>
      <th scope="col">สถานะ</th>


    </tr>
  </thead>
  <tbody>
    @foreach ($data as $index => $qrcode)
    @php
        $index ++;
    @endphp
    <tr>
      <th scope="row">{{$index}}</th>
      <td>{{ $qrcode->student->name }}</td>

      <td>{{$qrcode->subject->subject_name}}</td>
      <td>{{$qrcode->branch->name}}</td>
      <td>{{$qrcode->created_at}}</td>
      <td>
      @if($qrcode->status == 'present')
        <span class="badge badge-success  text-bg-success">ตรงเวลา</span>
    @elseif($qrcode->status == 'late')
        <span class="badge badge-danger text-bg-danger">สาย</span>
    @else
        <span class="badge badge-secondary">สถานะไม่ทราบ</span>
    @endif
      </td>


    </tr>
    @endforeach
   
  </tbody>
</table>
                    </div>
                </div>

        </div>
    </div>
</div>
<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

@endsection