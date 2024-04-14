@extends('layouts.app')
@section('title')
@section('content')
    <style>
        .btn.btn-come {
            padding: 5px 24px;
        }

        .btn.btn-personalleave {
            padding: 5px 15px;
        }

        .btn.btn-info {
            padding: 5px 18px;
        }

        .btn.btn-sickleave {
            padding: 5px 16px;
        }

        .btn.btn-sickleave {
            padding: 5px 20px;
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
    </style>

    <div class="container">
        <div class="row justify-content-center col-md-12">

            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 mb-2 fs-2 lead" style="color: #282829">
                    <div class="d-flex justify-content-between">
                        <span>{{ __('ประวัติการเช็คชื่อวิชา :') }} {{-- {{ $qrcode->qrcode_subject->subject_name }} --}}</span>

                        <div class="button-create text-end">
                            <a class="btn btn-primary rounded-1 shadow-none ms-auto" href="{{-- {{ route('attendance.index') }} --}}"
                                role="button">
                                <i class="fa-solid fa-plus"></i> {{ __('สร้าง QR code สำหรับเช็คชื่อ') }}
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body border-0 mb-2 fs-2">
                    <div class="row row-cols-auto">
                        {{-- <div style="font-size: 18px;" class="col border no-rounded-border m-1">นักศึกษาทั้งหมด : <span
                                class="btn btn-sm btn-info" style="font-weight: bold; color:#ffffff">
                                {{ $qrcode_alls->count() }}</span> คน
                        </div>
                        <div>
                            <span style="color: #545454"> |</span>
                        </div>
                        <div style="font-size: 18px;" class="col border no-rounded-border m-1">เข้าเรียนปกติ : <span
                                class="btn btn-sm" style="font-weight: bold; background-color: #198754; color:#ffffff">
                                {{ $qrcode_alls->where('status', 'มา')->count() }}</span> คน
                        </div>
                        <div style="font-size: 18px;" class="col border no-rounded-border m-1">เข้าเรียนสาย : <span
                                class="btn btn-sm" style="font-weight: bold; background-color: #e2ab04; color:#ffffff">
                                {{ $qrcode_alls->where('status', 'มาสาย')->count() }}</span> คน
                        </div>
                     toArray());div style="font-size: 18px;" class="col border no-rounded-border m-1">ลากิจ/ลาป่วย : <span
                                class="btn btn-sm btn-secondary" style="font-weight: bold;">
                                {{ $qrcode_alls->whereIn('status', ['ลากิจ', 'ลาป่วย'])->count() }}</span> คน
                        </div>
                        <div style="font-size: 18px;" class="col border no-rounded-border m-1">ขาดเรียน : <span
                                class="btn btn-sm btn-danger" style="font-weight: bold;">
                                {{ $qrcode_alls->where('status', 'ขาด')->count() }}</span> คน
                        </div> --}}
                    </div>

                </div>

                <div class="button-create text-end">
                    <a class="btn btn-warning" href="{{-- {{ route('export.excel', ['id' => $qrcode->id]) }} --}}" role="button">
                        <i class="fa-regular fa-file-excel"></i> {{ __('Export to Excel') }}
                    </a>
                </div>




                <div class="col-md-12">
                    <div class="card my-4">

                        <table id="detailTable" class="table">
                            <thead style="background-color: #ececec">
                                <tr>
                                    <th scope="col" colspan="2" style="text-align: center;">ข้อมูลนักศึกษา</th>
                                    <th scope="col" colspan="4" style="text-align: center;">สรุปผลการเช็คชื่อ</th>
                                    <th scope="col" colspan="{{ count($qrcodes) }}" style="text-align: center;">
                                        ผลการเช็คชื่อ</th>

                                </tr>
                                <tr>
                                    <th width="130px" scope="col" style="text-align: left;">รหัสนักศึกษา</th>
                                    <th scope="col" style="text-align: left;">ชื่อ</th>
                                    <th width="110px" scope="col" style="text-align: center; font-size:13px;">เข้าเรียนปกติ</th>
                                    <th width="110px" scope="col" style="text-align: center; font-size:13px;">เข้าเรียนสาย</th>
                                    <th width="110px" scope="col" style="text-align: center; font-size:13px;">ลากิจ/ลาป่วย</th>
                                    <th width="110px" scope="col" style="text-align: center; font-size:13px;">ขาดเรียน</th>
                                    @foreach ($qrcodes as $item)
                                        <th scope="col" style="text-align: center;">
                                            ครั้งที่ {{ $loop->iteration }}<br>
                                            ({{ $item->created_at->thaidate('d M Y') }})
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($individualStatusCounts as $studentId => $statusCounts)
                                    <tr>
                                        <td style="text-align: left;">{{ $studentId }}</td>
                                        <td style="text-align: left;">{{ $individualStatusCounts[$studentId]['name'] }}</td>
                                        <td style="text-align: center;">{{ $statusCounts['มา'] ?? 0 }} ครั้ง</td>
                                        <td style="text-align: center;">{{ $statusCounts['มาสาย'] ?? 0 }} ครั้ง</td>
                                        <td style="text-align: center;">
                                            {{ ($statusCounts['ลาป่วย'] ?? 0) + ($statusCounts['ลากิจ'] ?? 0) }} ครั้ง</td>
                                        <td style="text-align: center;">{{ $statusCounts['ขาด'] ?? 0 }} ครั้ง</td>
                                        @foreach ($qrcodes as $item)
                                            <td style="text-align: center;">
                                                @foreach ($item->qrcode_all as $qrcode)
                                                    @if ($qrcode->student_id == $studentId)
                                                        {{ $qrcode->status }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
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
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#detailTable').DataTable({
                responsive: true,
                paging: false,
                "language": {
                    "sProcessing": "กำลังดำเนินการ...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sEmptyTable": "ไม่มีข้อมูลในตาราง",
                    "sInfo": "",
                    "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกหมวดหมู่)",
                    "sInfoPostFix": "",
                    "sSearch": "ค้นหา:",
                    "sUrl": "",
                    "oPaginate": {
                        // "sFirst": "เริ่มต้น",
                        // "sPrevious": "ก่อนหน้า",
                        // "sNext": "ถัดไป",
                        // "sLast": "สุดท้าย"
                    },
                    "oAria": {
                        "sSortAscending": ": เปิดใช้งานเพื่อเรียงลำดับคอลัมน์จากน้อยไปมาก",
                        "sSortDescending": ": เปิดใช้งานเพื่อเรียงลำดับคอลัมน์จากมากไปน้อย"
                    }
                },

            });
        });

        $('#reportTable').on('click', '.detail-btn', function() {
            // จัดการรายละเอียด
        });

        // เพิ่มการจัดการเมื่อคลิกที่ปุ่มรายงาน
        $('#reportTable').on('click', '.report-btn', function() {
            // จัดการรายงาน
        });
    </script>
@endsection
