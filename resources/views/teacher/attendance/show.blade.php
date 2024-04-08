@extends('layouts.app')
@section('title')
@section('content')
    <style>
        #realTimeClock {
            font-size: 24px;
            color: #333;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .TimeClock {
            font-size: 24px;
            color: #333;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .time {
            font-size: 24px;
            color: #333;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>

    @foreach ($qrcodes as $index => $qrcode)
        <div class="container d-flex flex-column">
            <div class="card m-2">
                <div class="card-header">
                    <h3 class="card-title">สแกน QRcode เพื่อเช็คชื่อเข้าเรียน วิชา :
                        {{ $qrcode->qrcode_subject->subject_name }}</h3>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <p>{!! QrCode::size(350)->generate(url('/student/qrcode/checking/' . $qrcode->id)) !!}</p>
                            <br>

                            <p class="time">เวลาปัจจุบัน: <span id="realTimeClock"></span> น.</p>


                            <p class="time">
                                เวลาเริ่มเช็คชื่อ : <span class="TimeClock">{{ $qrcode->start_time }}</span> น.
                            </p>
                            <p class="time">
                                เวลาสาย : <span class="TimeClock">{{ $qrcode->late_time }}</span> น.
                            </p>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h6 class="card-subtitle mb-2 text-muted">สถานะการเข้าเรียน</h6>
                                </div>
                                <div class="col-sm-4">
                                    <h6 class="card-subtitle mb-2 text-muted">จำนวนนักเรียน :
                                        {{ $qrcode->qrcode_checks->count() }}</h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card text-white bg-success mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">เข้าเรียนปกติ</h5>
                                            <p class="card-text" id="normalAttendanceCount">จำนวน:
                                                {{ $qrcode->qrcode_checks->where('status', 'มา')->count() }} คน</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card text-white mb-3" style="background-color: #e2ab04">
                                        <div class="card-body">
                                            <h5 class="card-title">เข้าเรียนสาย</h5>
                                            <p class="card-text" id="lateAttendanceCount">จำนวน:
                                                {{ $qrcode->qrcode_checks->where('status', 'มาสาย')->count() }}
                                                คน</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card text-white bg-danger mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">ขาดเรียน</h5>
                                            <p class="card-text" id="absentAttendanceCount">จำนวน:
                                                {{ $qrcode->qrcode_checks->whereIn('status', ['ขาด', 'ลากิจ', 'ลาป่วย'])->count() }}
                                                คน

                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <table id="qrcodeChecksTable" class="table table-bordered py-1">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="d-none">#</th>
                                                <!-- หรือ class="visually-hidden" -->
                                                <th scope="col">#</th>
                                                <th scope="col">รหัสนักศึกษา</th>
                                                <th scope="col">ชื่อ-นามสกุล</th>
                                                <th scope="col">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($qrcode->qrcode_checks as $index => $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->student_id }}</td>
                                                    <td>{{ $item->student->name }}</td>
                                                    <td>
                                                        <select name="status" class="form-select status-select"
                                                            data-id="{{ $item->id }}"
                                                            data-student-id="{{ $item->student_id }}"
                                                            data-student-name="{{ $item->student->name }}">
                                                            <option value="มา"
                                                                {{ $item->status == 'มา' ? 'selected' : '' }}>มา</option>
                                                            <option value="มาสาย"
                                                                {{ $item->status == 'มาสาย' ? 'selected' : '' }}>มาสาย
                                                            </option>
                                                            <option value="ขาด"
                                                                {{ $item->status == 'ขาด' ? 'selected' : '' }}>ขาด</option>
                                                            <option value="ลากิจ"
                                                                {{ $item->status == 'ลากิจ' ? 'selected' : '' }}>ลากิจ
                                                            </option>
                                                            <option value="ลาป่วย"
                                                                {{ $item->status == 'ลาป่วย' ? 'selected' : '' }}>ลาป่วย
                                                            </option>
                                                        </select>
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
                <div class="card-footer">
                    <small class="text-muted">
                        <div class="btn btn-sm btn-info">
                            sdf
                        </div>
                    </small>
                </div>
            </div>
        </div>
    @endforeach


@endsection

@section('scripts')
    <script>
        function updateClock() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();

            hours = padZero(hours);
            minutes = padZero(minutes);
            seconds = padZero(seconds);

            var timeString = hours + ":" + minutes + ":" + seconds;
            document.getElementById('realTimeClock').innerHTML = timeString;

            requestAnimationFrame(updateClock);
        }

        function padZero(number) {
            return (number < 10 ? '0' : '') + number;
        }

        requestAnimationFrame(updateClock);
    </script>
    <script>
        $(document).ready(function() {
            $('#qrcodeChecksTable').DataTable({
                responsive: true,
                columnDefs: [{
                    targets: [0],
                    visible: false
                }]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.status-select').change(function() {
                var status = $(this).val();
                var id = $(this).data('id');
                var token = "{{ csrf_token() }}";

                $.ajax({
                    url: '/teacher/attendance/update-status',
                    type: 'POST',
                    data: {
                        id: id,
                        status: status,
                        student_id: $(this).data('student-id'), // เพิ่ม student_id ตรงนี้
                        student_name: $(this).data('student-name'), // เพิ่ม student_name ตรงนี้
                        _token: token
                    },
                    success: function(response) {
                        // อัปเดตจำนวนการเข้าเรียนโดยไม่ต้องรีโหลดหน้า
                        $('#normalAttendanceCount').html('จำนวน: ' + response.normalCount +
                            ' คน');
                        $('#lateAttendanceCount').html('จำนวน: ' + response.lateCount + ' คน');
                        $('#absentAttendanceCount').html('จำนวน: ' + response.absentCount +
                            ' คน');

                        Swal.fire({
                            icon: 'success',
                            title: 'เปลี่ยนสถานะสำเร็จ!',
                            html: `${response.student_name} รหัส ${response.student_id} : ${response.status}`
                        });
                    }
                });
            });
        });
    </script>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // เชื่อมต่อกับ Pusher โดยใช้ข้อมูลจาก .env
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        // สมัครสมาชิกสำหรับช่อง 'attendance-updates'
        var channel = pusher.subscribe('attendance-updates');

        // กำหนดการปรับปรุงข้อมูลเมื่อมีข้อมูลใหม่ถูกส่งมา
        channel.bind('App\\Events\\AttendanceUpdated', function(data) {
            // อัพเดทข้อมูลใน div ตามที่คุณต้องการ
            document.getElementById('normalAttendanceCount').innerText = 'จำนวน: ' + data.normal + ' คน';
            document.getElementById('lateAttendanceCount').innerText = 'จำนวน: ' + data.late + ' คน';
            document.getElementById('absentAttendanceCount').innerText = 'จำนวน: ' + data.absent + ' คน';
        });
    </script>

@endsection
