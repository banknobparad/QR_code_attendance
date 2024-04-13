@extends('layouts.app')
@section('title')
    Attendance
@endsection

@section('activeAttendance')
    active border-2 border-bottom border-primary
@endsection

@section('content')
    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
            border-bottom-color: #0d6efd;
            /* สีขอบล่างเมื่อ focus */
        }

        .form-group {
            margin-bottom: 15px;
            /* ระยะห่างระหว่างกลุ่มฟอร์ม */
        }
    </style>
    <div class="container d-flex flex-column">
        <div class="card shadow-sm rounded-3 my-auto col-md-11 mx-auto">
            <div class="card-header p-3 h4" style="color: #0d6efd">
                Add New Book
            </div>
            <div class="card-body p-4">
                <form action="{{ route('attendance.qrcode.store') }}" method="POST" class="row">
                    @csrf
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">วิชาที่สอน</label>
                        <select class="form-control" name="subject_id">
                            <option value="" selected disabled>{{ __('เลือกวิชาที่สอน') }}</option>
                            @foreach ($subjects as $item)
                                <option value="{{ $item->subject_id }}"
                                    {{ old('subject_id') == $item->subject_id ? 'selected' : '' }}>
                                    {{ $item->subject_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="start_time">เวลาเริ่มเช็คชื่อ:</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="start_time" name="start_time"
                                placeholder="เวลาเริ่มเช็คชื่อ">
                            <span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
                        </div>

                        @error('start_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-lg-6">

                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="late_time">เวลาเริ่มเช็คเข้าเรียนสาย:</label>

                        <div class="input-group">
                            <input type="text" class="form-control" id="late_time" name="late_time"
                                placeholder="เวลาเริ่มเช็คชื่อสาย">
                            <span class="input-group-text"><i class="fa-regular fa-clock"></i></span>

                        </div>

                        @error('late_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">

                    </div>

                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="end_time">เวลาปิดการเช็คชื่อ:</label>

                        <div class="input-group">

                            <input type="text" class="form-control" id="end_time" name="end_time"
                                placeholder="เวลาปิดการเช็คชื่อ">
                            <span class="input-group-text"><i class="fa-regular fa-clock"></i></span>

                        </div>
                        @error('end_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>





                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-dark float-end " for="form-group-input">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        flatpickr('#start_time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: new Date()
        });

        // สร้างวัตถุ Date ปัจจุบัน
        let late_time = new Date();

        // เพิ่มเวลา 5 นาที
        late_time.setMinutes(late_time.getMinutes() + 30);

        // ใช้วัตถุ Date ที่มีเวลาเพิ่มไป 5 นาทีเป็นค่าเริ่มต้น
        flatpickr('#late_time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: late_time
        });

        // สร้างวัตถุ Date ปัจจุบัน
        let end_time = new Date();

        // เพิ่มเวลา 5 นาที
        end_time.setMinutes(end_time.getMinutes() + 120);

        // ใช้วัตถุ Date ที่มีเวลาเพิ่มไป 5 นาทีเป็นค่าเริ่มต้น
        flatpickr('#end_time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: end_time
        });
    </script>
@endsection
