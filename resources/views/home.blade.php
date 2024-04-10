@extends('layouts.app')

<style>
    table#AdminTable {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000000;
        background-color: #f2f2f2;
    }

    thead th {
        background-color: #2b273c;
        color: #ffffff;
        padding: 15px;

    }

    tbody td {
        padding: 15px;
    }

    #AdminTable tbody td.name-cell {
        background-color: #acacad1a;
        color: #000000;
    }

    #AdminTable tbody td.actions-cell {
        background-color: #cacacb1a;
        color: #000000;
    }

    tbody tr:nth-child(even) {
        background-color: #e6e6e6;
    }

    tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    .dataTables_wrapper .dataTables_filter {
        float: none;
        text-align: end;
        margin-bottom: 30px;
    }

    #show_name,
    #show_student_id {
        pointer-events: none;
        border: none;
        background: transparent;
    }


    #reader {
        margin: 0 auto;
    }

    .menu {
        text-align: center;
    }

    .menu a {
        display: inline-block;
        margin: 10px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .menu a:hover {
        background-color: #0056b3;
    }
</style>
{{-- <style>
    #realTimeClock {
        font-size: 24px;
        color: #333;
        background-color: #f9f9f9;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
</style> --}}


@section('content')
    <div class="container">
        @if (Auth::user()->role == 'Administrator')
            <div class="row justify-content-center">
                <div>
                    hello admin
                </div>
                <div class="fs-2 text-primary lead text-center">{{ __('ข้อมูลผู้ใช้งานทั้งหมด') }}</div>

                <div class="col-md-12">

                </div>


                <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel1" aria-hidden="true">
                    <input type="hidden" id="show_id">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel1">ข้อมูลผู้ใช้</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="show_name">ชื่อ-นามสกุล : </label>
                                    <input readonly type="text" name="show_name" id="show_name">
                                </div>


                                <div class="form-group">
                                    <label for="show_student_id">รหัสนักศึกษา : </label>
                                    <input type="text" name="show_student_id" id="show_student_id">
                                </div>

                                <div id="qr_code"></div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="table-responsive">
                    <table id="AdminTable" class="display" responsive="true">
                        <thead>
                            <tr>
                                <th hidden scope="row">#</th>
                                <th scope="row">ชื่อ</th>
                                <th scope="row">รหัสนักศึกษา</th>
                                <th scope="row">สาขา</th>
                                <th scope="row">ชั้นปี</th>
                                <th scope="row">บทบาท</th>
                                <th hidden scope="row">update_at</th>
                                <th scope="row" class="text-center">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color: #36304a; font-size:15px">
                                <td hidden scope="row">#</td>
                                <td scope="row"></td>
                                <td scope="row"></td>
                                <td scope="row" class="filter-label">
                                    <select id="branchFilter">
                                        <option value="">แสดงทั้งหมด</option>
                                        <option value="สาขาวิทยาการคอมพิวเตอร์">สาขาวิทยาการคอมพิวเตอร์
                                        </option>
                                        <option value="สาขาเทคโนโลยีสารสนเทศ">สาขาเทคโนโลยีสารสนเทศ</option>
                                        <option value="สาขาเทคโนโลยีเครือข่ายคอมพิวเตอร์">
                                            สาขาเทคโนโลยีเครือข่ายคอมพิวเตอร์</option>
                                        <option value="สาขาภูมิสารสนเทศ">สาขาภูมิสารสนเทศ</option>
                                    </select>
                                </td>
                                <td scope="row" class="filter-label">
                                    <select id="yearFilter">
                                        <option value="">แสดงทั้งหมด</option>
                                        <option value="นักศึกษาชั้นปีที่ 1">นักศึกษาชั้นปีที่ 1</option>
                                        <option value="นักศึกษาชั้นปีที่ 2">นักศึกษาชั้นปีที่ 2</option>
                                        <option value="นักศึกษาชั้นปีที่ 3">นักศึกษาชั้นปีที่ 3</option>
                                        <option value="นักศึกษาชั้นปีที่ 4">นักศึกษาชั้นปีที่ 4</option>
                                    </select>
                                </td>
                                <td scope="row" class="filter-label">
                                    <select id="roleFilter">
                                        <option value="">แสดงทั้งหมด</option>
                                        <option value="ผู้ดูแลระบบ">ผู้ดูแลระบบ</option>
                                        <option value="อาจารย์">อาจารย์</option>
                                        <option value="นักศึกษา">นักศึกษา</option>
                                    </select>
                                </td>
                                <td hidden scope="row">update_at</td>
                                <td scope="row"></td>
                            </tr>
                            {{-- @foreach ($users as $key => $user)
                                <tr>
                                    <th hidden>{{ $key + 1 }}</th>
                                    <td class="name-cell">{{ $user->name }}</td>
                                    <td>{{ $user->student_id }}</td>
                                    <td>{{ optional($user->branch)->name }}</td>
                                    <td>{{ optional($user->year)->name }}</td>
                                    <td>
                                        @if ($user->role == 'Teacher')
                                            อาจารย์
                                        @elseif($user->role == 'Student')
                                            นักศึกษา
                                        @elseif($user->role == 'Administrator')
                                            ผู้ดูแลระบบ
                                        @else
                                            ระบุบทบาท
                                        @endif
                                    </td>
                                    <td hidden>{{ $user->updated_at }}</td>
                                    <td class="text-center actions-cell">
                                        <a href="{{ route('users.destroy', ['id' => $user->id]) }}"
                                            class="btn btn-danger btn-sm shadow-none rounded-1">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                        <a href="{{ route('users.edit', ['id' => $user->id]) }}"
                                            class="btn btn-info btn-sm shadow-none rounded-1">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="" class="btn btn-warning btn-sm shadow-none rounded-1 show_data"
                                            data-bs-toggle="modal" data-bs-target="#showModal" data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}" data-student_id="{{ $user->student_id }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if (Auth::user()->role == 'Teacher')
            <div>
                hello teacher
            </div>
        @endif
        @if (Auth::user()->role == 'Student')
            @foreach ($users as $item)
                <div
                    style="padding: 20px; margin: 20px auto; max-width: 700px; border-radius: 8px; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden;">
                    <h2
                        style="text-align: center; font-size: 24px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                        สวัสดี {{ $item->name }}</h2>

                    <div style="width: 100%; margin: 0 auto; overflow: hidden;">
                        <div id="reader"></div>
                    </div>

                    <p
                        style="margin-top: 20px; text-align: center; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                        เวลาปัจจุบัน: <span id="realTimeClock" style="font-weight: bold;"></span></p>

                    <div class="menu">
                        <a href="/history">ดูประวัติการเช็คชื่อ</a>
                        <a href="/profile">ดูประวัติส่วนตัว</a>
                    </div>
                </div>


                <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
                <script>
                    function onScanSuccess(decodedText, decodedResult) {
                        window.location.href = decodedText;
                        console.log(`Code matched = ${decodedText}`, decodedResult);
                    }

                    function onScanFailure(error) {
                        console.warn(`Code scan error = ${error}`);
                    }

                    let html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            }
                        },
                        false);
                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                </script>
            @endforeach
        @endif




    </div>



    </div>
@endsection


@section('scripts')
    @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ Session::get('success') }}',
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ Session::get('error') }}',
            });
        </script>
    @endif

    @if (Session::has('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: '{{ Session::get('warning') }}',
            });
        </script>
    @endif

    @if (Session::has('question'))
        <script>
            Swal.fire({
                icon: 'question',
                title: 'Question',
                text: '{{ Session::get('question') }}',
            });
        </script>
    @endif

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

    {{-- <script>
        $(document).ready(function() {
            $("#searchUsers").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#UsersTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#searchExamsStudent").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#ExamsStudentTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });


            $(document).on('click', '.excelExamsStudent', function(e) {
                e.preventDefault(e);
                const start = Date.now();
                TableToExcel.convert(document.getElementById("ExamsStudentTable"), {
                    name: `${start}_Exams Student.xlsx`,
                    sheet: {
                        name: "Sheet 1"
                    }
                });

            });
            $(document).on('click', '.excelUsers', function(e) {
                e.preventDefault(e);
                const start = Date.now();
                TableToExcel.convert(document.getElementById("UsersTable"), {
                    name: `${start}_Users.xlsx`,
                    sheet: {
                        name: "Sheet 1"
                    }
                });
                Users
            });
        });
    </script> --}}


    <script>
        $(document).ready(function() {
            var adminTable = $('#AdminTable').DataTable({
                responsive: true,
                ordering: false,
                autoWidth: false,
                order: [
                    [6, 'desc']
                ],
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Thai.json"
                }
            });

            $('#roleFilter').change(function() {
                var selectedRole = $(this).val();
                adminTable.column(5).search(selectedRole).draw();
            });

            $('#branchFilter').change(function() {
                var selectedBranch = $(this).val();
                adminTable.column(3).search(selectedBranch).draw();
            });

            $('#yearFilter').change(function() {
                var selectedYear = $(this).val();
                adminTable.column(4).search(selectedYear).draw();
            });

            $(document).on('click', '.show_data', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let student_id = $(this).data('student_id');

                $('#show_id').val(id);
                $('#show_name').val(name);
                $('#show_student_id').val(student_id);

                // สร้าง QR code
                generateQRCode(student_id);
            });

            function generateQRCode(student_id) {

                let qrContainer = document.getElementById('qr_code');

                // ลบ QR code เก่า
                qrContainer.innerHTML = '';

                // สร้าง QR code
                let qrcode = new QRCode(qrContainer, {
                    text: student_id.toString(), //student_id เป็น string
                    width: 128,
                    height: 128
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            fetch();

            function isPresenCheckt(isPresent) {

                if (isPresent == 1) {
                    return `<span class="badge bg-success">Present</span>`;
                } else {
                    return `<span class="badge bg-danger">Absent</span>`;
                }
            }



            function fetch() {
                $.ajax({
                    type: "GET",
                    url: "/teacher/studentExam/getStudentExam",
                    dataType: "json",
                    success: function(response) {
                        // console.log(response.student_exams);
                        var count = 1;
                        $('tbody').empty();
                        $.each(response.student_exams, function(key, item) {
                            $('tbody').append(
                                '<tr class="align-middle"><td>' + count++ + '</td><td>' +
                                item.studentName +
                                '</td><td>' +
                                item.name +
                                '</td><td>' +
                                item.nameHall +
                                '</td><td>' +
                                item.hours +
                                '</td><td>' +
                                item.day +
                                '</td><td>' +
                                item.start +
                                '</td><td>' +
                                item.end +
                                '</td><td>' + isPresenCheckt(item.isPresent) +
                                '</td></tr>'
                            );

                        });
                    }
                });
            }
        });
    </script>
@endsection
