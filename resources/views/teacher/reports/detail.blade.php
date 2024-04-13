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
                        <span>{{ __('ประวัติการเช็คชื่อวิชา :') }} {{ $qrcode->qrcode_subject->subject_name }}</span>

                        <div class="button-create text-end">
                            <a class="btn btn-primary rounded-1 shadow-none ms-auto" href="{{ route('attendance.index') }}"
                                role="button">
                                <i class="fa-solid fa-plus"></i> {{ __('สร้าง QR code สำหรับเช็คชื่อ') }}
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body border-0 mb-2 fs-2">
                    <div class="row row-cols-auto">
                        <div style="font-size: 18px;" class="col border no-rounded-border m-1">นักศึกษาทั้งหมด : <span
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
                        <div style="font-size: 18px;" class="col border no-rounded-border m-1">ลากิจ/ลาป่วย : <span
                                class="btn btn-sm btn-secondary" style="font-weight: bold;">
                                {{ $qrcode_alls->whereIn('status', ['ลากิจ', 'ลาป่วย'])->count() }}</span> คน
                        </div>
                        <div style="font-size: 18px;" class="col border no-rounded-border m-1">ขาดเรียน : <span
                                class="btn btn-sm btn-danger" style="font-weight: bold;">
                                {{ $qrcode_alls->where('status', 'ขาด')->count() }}</span> คน
                        </div>
                    </div>

                </div>

                <div class="button-create text-end">
                    <a class="btn btn-warning" href="{{ route('export.excel', ['id' => $qrcode->id]) }}" role="button">
                        <i class="fa-regular fa-file-excel"></i> {{ __('Export to Excel') }}
                    </a>
                </div>




                <div class="col-md-12">
                    <div class="card my-4">

                        <table id="detailTable" class="table">
                            <thead style="background-color: #ececec">
                                <tr>
                                    <th scope="col" style="text-align: left;">รหัสนักศึกษา</th>
                                    <th scope="col" style="text-align: left;">ชื่อ</th>
                                    <th scope="col" style="text-align: left;">สถานะ</th>
                                    <th scope="col" style="text-align: center;">วันที่/เวลาเช็คชื่อ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($qrcode_alls as $item)
                                    <tr>
                                        <td style="text-align: left;">{{ $item->student_id }} </td>
                                        <td style="text-align: left;">{{ $item->student_substu->name }}</td>
                                        <td style="text-align: left;">
                                            <div>
                                                @if ($item->status === 'มา')
                                                    <button class="btn btn-come"
                                                        style="font-weight: bold; background-color: #198754; color:#ffffff">
                                                        มา</button>
                                                @elseif($item->status === 'มาสาย')
                                                    <button class="btn"
                                                        style="font-weight: bold; background-color: #e2ab04; color:#ffffff">
                                                        มาสาย </button>
                                                @elseif($item->status === 'ลากิจ')
                                                    <button class="btn btn-personalleave"
                                                        style="font-weight: bold; background-color: #6c757d; color:#ffffff">
                                                        ลากิจ </button>
                                                @elseif($item->status === 'ลากิจ')
                                                    <button class="btn btn-personalleave"
                                                        style="font-weight: bold; background-color: #6c757d; color:#ffffff">
                                                        ลากิจ </button>
                                                @elseif($item->status === 'ลาป่วย')
                                                    <button class="btn btn-sickleave"
                                                        style="font-weight: bold; background-color: #17a2b8; color:#ffffff">
                                                        ลากิจ </button>
                                                @elseif($item->status === 'ขาด')
                                                    <button class="btn btn-danger btn-sickleave">
                                                        ขาด </button>
                                                @else
                                                    <!-- สถานะอื่นๆ ที่คุณต้องการจะจัดการ -->
                                                    <button class="btn btn-info">Error</button>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            @if (isset($item->updated_at))
                                                วัน{{ $item->updated_at->thaidate('l j F Y H:i') }} น.
                                            @else
                                                -
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
