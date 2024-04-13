@extends('layouts.app')
@section('title')
@section('content')
    <style>
        .btn.btn-success {
            padding: 6px 27px;
            /* Adjust padding as needed */
        }
    </style>

    </style>
    <div class="container">
        <div class="row justify-content-center col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                    <div class="d-flex justify-content-between">
                        <span>{{ __('ประวัติการเช็คชื่อ') }}</span>

                        <div class="button-create text-end">
                            <a class="btn btn-primary rounded-1 shadow-none ms-auto" href="{{-- {{ route('subject.create') }} --}}"
                                role="button">
                                <i class="fa-solid fa-plus"></i> {{ __('สร้าง QR code สำหรับเช็คชื่อ') }}
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-sm-12 ">
                    <div class="card my-4">

                        <table id="reportTable" class="table table-bordered">
                            <thead style="background-color: #e0dede">
                                <tr>
                                    <th width="120px" scope="col" style="text-align: center;">ครั้งที่เช็คชื่อ</th>
                                    <th width="200px" scope="col" style="text-align: left;">วันที่/เวลาเช็คชื่อ</th>
                                    <th width="200px" scope="col" style="text-align: left;">สาขาวิชา</th>
                                    <th width="200px" scope="col" style="text-align: left;">ชั้นปีที่</th>
                                    <th scope="col" style="text-align: center;">เมนู</th>
                                    <th width="180px" scope="col" style="text-align: center;">รายงาน</th>
                                </tr>
                            </thead>
                            @foreach ($subjects as $subject)
                                <thead style="background-color: #ecececd1">
                                    <th scope="col" colspan="3"
                                        style="text-align: left; font-size:17px; color:#242424">วิชา :
                                        {{ $subject->subject_name }} รหัสวิชา {{ $subject->subject_id }} </th>
                                    <th scope="col" colspan="3" style="text-align: left;"></th>

                                </thead>
                                <tbody>
                                    <?php $count = 0; ?>
                                    @foreach ($subject->qrcode_att->sortBy('created_at') as $qrcode_att)
                                        <tr>
                                            <td style="text-align: center;">(ครั้งที่ : {{ ++$count }})</td>
                                            <td style="text-align: left;">
                                                {{ $qrcode_att->created_at->thaidate('d M Y H:i') }} น.
                                            </td>
                                            <td style="text-align: left;">{{ $subject->branch->name }}</td>
                                            <td style="text-align: left;">{{ $subject->year->name }}</td>
                                            <td style="text-align: center;">
                                                <div style="display: flex; justify-content: center; align-items: center;">
                                                    <div class="text-center">
                                                        @if ($qrcode_att->status === 'expired')
                                                            <button class="btn btn-danger"><i class="fa-solid fa-x"></i> ปิดการเช็คชื่อแล้ว</button>
                                                        @elseif($qrcode_att->status === 'active')
                                                            <button class="btn btn-success"><i class="fa-solid fa-check"></i> กำลังเช็คชื่อ</button>
                                                        @else
                                                            <button class="btn btn-sm btn-secondary">สถานะไม่ระบุ</button>
                                                        @endif
                                                    </div>
                                                    <div style="padding-left: 10px;">
                                                        <form action="">
                                                            <button class="btn btn-sm btn-success"><i class="fa-solid fa-check"></i> รายละเอียด</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="text-align: center;">
                                                <form action="{{ route('report.detail', ['id' => $qrcode_att->id]) }}">
                                                    <button class="btn btn-secondary"><i
                                                            class="fa-regular fa-file-lines"></i> รายงานการเช็คชื่อ
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
            $('#reportTable').DataTable({
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
    </script>
@endsection
