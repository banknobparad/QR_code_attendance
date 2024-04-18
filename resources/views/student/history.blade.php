@extends('layouts.app')

@section('title', 'Your Subjects')

@section('content')
    <style>
        .btn.btn-come {
            padding: 3px 22px;
        }

        .btn.btn-personalleave {
            padding: 3px 13px;
        }

        .btn.btn-info {
            padding: 3px 16px;
        }

        .btn.btn-sickleave {
            padding: 3px 14px;
        }

        .btn.btn-absent {
            padding: 3px 18px;
        }

        .custom-box {
            border: 1px solid #ccc;
            padding: 10px;
            width: 430px;
            height: 45px;
        }

        .no-rounded-border {
            border-radius: 10px;
        }

        .modal-dialog {
            /* position: absolute; */
            /* left: 50%; */
            top: 10%;
            /* transform: translate(-50%, -50%); */
        }
    </style>
    <div class="container mt-2">
        <div class="row">
            <div class="card p-1">
                <h3 class="text-center" style="color: #362cbc">ประวัติการเช็คชื่อ &nbsp; <i
                        class="fa-solid fa-person-rays"></i></h3>
            </div>
            &nbsp;
            <p style="font-size: 18px;">ชื่อ : {{ $subject_stu[0]->name }}</p>
            <p style="font-size: 18px;">รหัสนักศึกษา : {{ $subject_stu[0]->student_id }}</p>
            @foreach ($subject_stu as $subject)
                {{-- @php
                    dd($subject);
                @endphp --}}
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">วิชา : {{ $subject->subject->subject_name }}</h5>
                            <p class="card-text">รหัสวิชา : {{ $subject->subject->subject_id }}</p>
                            <p class="card-text">อาจารย์ : {{ $subject->subject->user->name }}</p>
                            <hr>

                            <button class="btn btn-primary btn-sm view-details"
                                data-name-student="{{ $subject_stu[0]->name }}" data-id="{{ $subject->subject->id }}"
                                data-name="{{ $subject->subject->subject_name }}" data-subject-id="{{ $subject->id }}"
                                data-qrcode-list="{{ json_encode($subject->qrcode_all) }}"> ดูประวัตการเช็คชื่อ <i
                                    class="fa-regular fa-eye"></i></button>



                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="subjectModal" tabindex="-1" role="dialog" aria-labelledby="subjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-size: 20px;" class="modal-title" id="subjectModalLabel">วิชา : <span
                            id="subjectName"></span></h5>
                </div>
                <div class="modal-body">
                    <p><i class="fa-solid fa-user-astronaut"></i> ประวัติการเช็คชื่อ : <span id="studentName"></span></p>

                    <table id="qrcodeTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>วันที่เช็คชื่อ</th>
                                <th>เวลา</th>
                                <th style="text-align: center;">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ใส่ข้อมูลที่จะเพิ่มในตารางที่นี่ -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        function thaiDate(date) {
            const thaiMonths = [
                'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
            ];

            const thaiDays = [
                'วันอาทิตย์', 'วันจันทร์', 'วันอังคาร', 'วันพุธ', 'วันพฤหัสบดี', 'วันศุกร์', 'วันเสาร์'
            ];

            const day = date.getDate();
            const month = thaiMonths[date.getMonth()];
            const dayOfWeek = thaiDays[date.getDay()];

            return `${dayOfWeek} ที่ ${day} ${month}`;
        }
        $(document).ready(function() {
            $('.view-details').click(function() {
                var subjectId = $(this).data('id');
                var subjectName = $(this).data('name');
                var studentName = $(this).data('name-student');
                var subjectStuId = $(this).data('subject-id');
                var qrcodeList = $(this).data('qrcode-list');

                $('#subjectName').text(subjectName);
                $('#studentName').text(studentName);
                $('#qrcodeList').empty(); // Clear previous data

                // Loop through qrcode_all data and append to modal
                $.each(qrcodeList, function(index, qrcode) {
                    // สร้างแถวใหม่ในตาราง
                    var newRow = $('<tr>');
                    // เพิ่มคอลัมน์สำหรับชื่อนักเรียน
                    newRow.append('<td>' + thaiDate(new Date(qrcode.updated_at)) + '</td>');
                    // เพิ่มคอลัมน์สำหรับรหัสนักเรียน

                    newRow.append('<td>' + (new Date(qrcode.updated_at).toLocaleTimeString(
                        'th-TH', {
                            hour12: false
                        })) + '</td>');

                    var statusButtonDiv = $('<div>');

                    // เช็คสถานะและสร้างปุ่มตามเงื่อนไข
                    if (qrcode.status === 'มา') {
                        statusButtonDiv.append(
                            '<button class="btn btn-come" style="font-weight: bold; background-color: #198754; color:#ffffff">มา</button>'
                        );
                    } else if (qrcode.status === 'มาสาย') {
                        statusButtonDiv.append(
                            '<button class="btn" style="font-weight: bold; font-size: 13px; background-color: #e2ab04; color:#ffffff">มาสาย</button>'
                        );
                    } else if (qrcode.status === 'ลากิจ') {
                        statusButtonDiv.append(
                            '<button class="btn btn-personalleave" style="font-weight: bold; background-color: #6c757d; color:#ffffff">ลากิจ</button>'
                        );
                    } else if (qrcode.status === 'ลาป่วย') {
                        statusButtonDiv.append(
                            '<button class="btn btn-sickleave" style="font-weight: bold; background-color: #17a2b8; color:#ffffff">ลาป่วย</button>'
                        );
                    } else if (qrcode.status === 'ขาด') {
                        statusButtonDiv.append(
                            ' <button class="btn btn-sm btn-absent" style="font-weight: bold; font-size: 15px; bold; background-color: #dc3545; color:#ffffff">ขาด</button>'
                        );
                    } else {
                        statusButtonDiv.append('<button class="btn btn-info">Error</button>');
                    }

                    // เพิ่มคอลัมน์สำหรับปุ่มสถานะ
                    newRow.append('<td style="text-align: center;">' + statusButtonDiv.html() +
                        '</td>'); // เพิ่มแถวในตาราง
                    $('#qrcodeTable tbody').append(newRow);
                });

                $('#subjectModal').modal('show');
            });
            // เพิ่มฟังก์ชันเพื่อลบข้อมูลเมื่อปุ่มปิดถูกคลิก
            $('.close-modal').click(function() {
                $('#subjectModal').modal('hide');
                clearModalData(); // เพิ่มเส้นโค้ดเรียกใช้ฟังก์ชันเพื่อลบข้อมูล
            });


            // เพิ่มฟังก์ชันเพื่อลบข้อมูลเมื่อ modal ถูกซ่อนไปโดยไม่ได้คลิกปุ่ม
            $('#subjectModal').on('hidden.bs.modal', function(e) {
                clearModalData();
            });

            // ฟังก์ชันสำหรับลบข้อมูลทั้งหมดใน modal
            function clearModalData() {
                $('#subjectName').empty(); // Clear subject name
                $('#studentName').empty(); // Clear student name
                $('#qrcodeTable tbody').empty(); // Clear QR code table body
            }
        });
    </script>
@endsection
