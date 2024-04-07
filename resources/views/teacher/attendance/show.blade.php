@extends('layouts.app')
@section('title')
@section('content')


    @foreach ($qrcodes as $index => $qrcode)
        <div class="container d-flex flex-column">
            <div class="card m-2">
                <div class="card-header">
                    <h4 class="card-title">สแกน QRcode เพื่อเช็คชื่อเข้าเรียน วิชา :
                        {{ $qrcode->qrcode_subject->subject_name }}</h4>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <td>{!! QrCode::size(300)->generate(url('/student/qrcode/checking/' . $qrcode->id)) !!}</td>

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
                                            <p class="card-text">จำนวน:
                                                {{ $qrcode->qrcode_checks->where('status', 'มา')->count() }} คน
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card text-white mb-3" style="background-color: #e2ab04">
                                        <div class="card-body">
                                            <h5 class="card-title">เข้าเรียนสาย</h5>
                                            <p class="card-text">จำนวน:
                                                {{ $qrcode->qrcode_checks->where('status', 'มาสาย')->count() }} คน
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card text-white bg-danger mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">ขาดเรียน</h5>
                                            <p class="card-text">จำนวน:
                                                {{ $qrcode->qrcode_checks->whereIn('status', ['ขาด', 'ลากิจ', 'ลาป่วย'])->count() }} คน
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
                    <small class="text-muted">ขณะนี้เวลา 23:09:16</small>
                </div>
            </div>
        </div>
    @endforeach


@endsection

@section('scripts')
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
                        student_id: $(this).data('student-id'),
                        student_name: $(this).data('student-name'),
                        _token: token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'เปลี่ยนสถานะสำเร็จ!',
                            html: `${response.student_name} รหัส ${response.student_id} : ${response.status}`
                        });
                    } // ปิดวงเล็บ success ที่นี่
                }); // ปิดวงเล็บ ajax ที่นี่
            });
        });
    </script>

@endsection
