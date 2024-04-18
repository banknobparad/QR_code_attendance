@extends('layouts.app')
@section('title')
    Report All {{ $subject_stu[0]['subject_name'] }}
@endsection
@section('activeReport')
    active border-2 border-bottom border-primary
@endsection
@section('content')
    <style>
        .btn.btn-come {
            padding: 5px 17px;
            font-size: 12px;
        }

        .btn.btn-personalleave {
            padding: 5px 12px;
            font-size: 12px;
        }

        .btn.btn-info {
            padding: 5px 12px;
            font-size: 12px;
        }

        .btn.btn-sickleave {
            padding: 5px 7px;
            font-size: 13px;
        }

        .btn.btn-absent {
            padding: 5px 14px;
        }


        .btn.btn-late {
            padding: 5px 5px;
            font-size: 13px;
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

                        <span>{{ __('ประวัติการเช็คชื่อวิชา :') }} {{ $subject_stu[0]['subject_name'] }}
                            {{ __('รหัสวิชา :') }} {{ $subject_stu[0]['subject_id'] }}</span>



                        <div class="button-create text-end">
                            <a class="btn btn-primary rounded-1 shadow-none ms-auto" href="{{ route('attendance.index') }}"
                                role="button">
                                <i class="fa-solid fa-plus"></i> {{ __('สร้าง QR code สำหรับเช็คชื่อ') }}
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body border-0 mb-1 fs-2">
                    <div class="row row-cols-auto">
                        <div style="font-size: 18px;" class="col border no-rounded-border m-1">นักศึกษาทั้งหมด : <span
                                class="btn btn-sm btn-info" style="font-weight: bold; color:#ffffff">
                                @foreach ($subject_stu as $item)
                                    {{-- @php

                            dd($item->toArray());
                        @endphp --}}
                                    {{ $item->subject_stu->count() }}
                            </span> คน
                            @endforeach
                        </div>

                    </div>

                </div>

                {{-- <div class="button-create text-end">
                    <a class="btn btn-warning" href="{{ route('export.excel.all', ['id' => $subject->id]) }}"
                        role="button">
                        <i class="fa-regular fa-file-excel"></i> {{ __('Export to Excel') }}
                    </a>
                </div> --}}




                <div class="col-md-12">
                    <div class="card my-3">

                        <table id="detailTable" class="table table-striped" style="width:100%">
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
                                    <th width="100px" scope="col" style="text-align: center; font-size:13px;">
                                        เข้าเรียนปกติ</th>
                                    <th width="100px" scope="col" style="text-align: center; font-size:13px;">
                                        เข้าเรียนสาย</th>
                                    <th width="100px" scope="col" style="text-align: center; font-size:13px;">
                                        ลากิจ/ลาป่วย</th>
                                    <th width="100px" scope="col" style="text-align: center; font-size:13px;">ขาดเรียน
                                    </th>
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
                                        <td style="text-align: left;">{{ $individualStatusCounts[$studentId]['name'] }}
                                        </td>
                                        <td style="text-align: center;">{{ $statusCounts['มา'] ?? 0 }} ครั้ง</td>
                                        <td style="text-align: center;">{{ $statusCounts['มาสาย'] ?? 0 }} ครั้ง</td>
                                        <td style="text-align: center;">
                                            {{ ($statusCounts['ลาป่วย'] ?? 0) + ($statusCounts['ลากิจ'] ?? 0) }} ครั้ง</td>
                                        <td style="text-align: center;">{{ $statusCounts['ขาด'] ?? 0 }} ครั้ง</td>
                                        @foreach ($qrcodes as $item)
                                            <td style="text-align: center;">
                                                @foreach ($item->qrcode_all as $qrcode)
                                                    @if ($qrcode->student_id == $studentId)
                                                        @if ($qrcode->status === 'มา')
                                                            <button class="btn btn-sm btn-come"
                                                                style="font-weight: bold; background-color: #198754; color:#ffffff">
                                                                มา
                                                            </button>
                                                        @elseif($qrcode->status === 'มาสาย')
                                                            <button class="btn btn-sm btn-late"
                                                                style="font-weight: bold; background-color: #e2ab04; color:#ffffff">
                                                                มาสาย
                                                            </button>
                                                        @elseif($qrcode->status === 'ลากิจ')
                                                            <button class="btn btn-sm btn-personalleave"
                                                                style="font-weight: bold; background-color: #6c757d; color:#ffffff">
                                                                ลากิจ
                                                            </button>
                                                        @elseif($qrcode->status === 'ลาป่วย')
                                                            <button class="btn btn-sm btn-sickleave"
                                                                style="font-weight: bold; background-color: #17a2b8; color:#ffffff">
                                                                ลาป่วย
                                                            </button>
                                                        @elseif($qrcode->status === 'ขาด')
                                                            <button class="btn btn-sm btn-absent"
                                                                style="font-weight: bold; background-color: #dc3545; color:#ffffff">
                                                                ขาด
                                                            </button>
                                                        @else
                                                            <!-- สถานะอื่นๆ ที่คุณต้องการจะจัดการ -->
                                                            <button class="btn btn-info">Error</button>
                                                        @endif
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.print.min.js"></script>



    <script>
        $(document).ready(function() {
            $('#detailTable').DataTable({
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                },
                responsive: true,
                paging: false,
                "ordering": false,

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
    </script>
@endsection
