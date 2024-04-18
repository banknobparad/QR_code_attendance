@extends('layouts.app')
@section('title')
    Subject
@endsection

@section('activeSubject')
    active border-2 border-bottom border-primary
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            <span style="color: #362cbc;">{{ __('Subjects') }} <i class="fa-solid fa-book"
                                    style="color: #362cbc;"></i></span>

                            <div class="button-create text-end">
                                <a class="btn btn-primary rounded-1 shadow-none ms-auto"
                                    style="background-color: #362cbc; color: #ffffff" href="{{ route('subject.create') }}"
                                    role="button">
                                    <i class="fa-solid fa-book" style="color: #ffffff;"> &nbsp; </i>{{ __('Add Subjects') }}
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-md-12 table-responsive" id="subjectsTable">
                            <table class="table table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th scope="row">#</th>
                                        <th scope="row">subject_id</th>
                                        <th scope="row">subject_name</th>
                                        <th scope="row" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->subject_id }}</td>
                                            <td>{{ $item->subject_name }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-secondary btn-sm  show_details"
                                                    data-bs-toggle="modal" data-bs-target="#SubjectDetailsModel"
                                                    data-subject_id="{{ $item->subject_id }}"
                                                    data-subject_name="{{ $item->subject_name }}"
                                                    data-student="{{ $item->subject_stu }}">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>

                                                <a href="{{ route('subject.showedit', $item->subject_id) }}"
                                                    class="btn btn-sm btn-success"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>

                                                <a href="{{ route('subject.students.homedelete', $item->id) }}"
                                                    class="btn btn-sm btn-danger delete-btn"><i
                                                        class="fa-regular fa-trash-can"></i></a>

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


        <div class="modal fade" id="SubjectDetailsModel" tabindex="-1" aria-labelledby="SubjectDetailsModelLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="SubjectDetailsModelLabel"><i class="fa-solid fa-list-ul"
                                style="color: #362cbc;"></i>&nbsp; รายละเอียดเพิ่มเติมเกี่ยวกับ วิชา <span
                                id="subject_name-title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p style="font-size: 18px;"><i class="fa-solid fa-school" style="color: #362cbc;"></i> &nbsp; &nbsp;
                            ชื่อวิชา:
                            <span id="subject_name"></span>
                        </p>
                        <p style="font-size: 18px;"><i class="fa-solid fa-hashtag" style="color: #362cbc;"></i> &nbsp;
                            &nbsp; &nbsp; รหัสวิชา:
                            <span id="subject_id"></span>
                        </p>
                        <hr>
                        <h5>รายชื่อนักเรียน</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">รหัสนักศึกษา</th>
                                        <th scope="col">ชื่อนักศึกษา</th>
                                    </tr>
                                </thead>
                                <tbody id="students_list">
                                    <!-- ข้อมูลนักเรียนจะแสดงที่นี่ -->
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
            document.addEventListener('DOMContentLoaded', function() {
                // เลือกปุ่มลบ
                const deleteButtons = document.querySelectorAll('.delete-btn');

                // กำหนดการทำงานเมื่อคลิกที่ปุ่มลบ
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(event) {
                        event.preventDefault(); // ยกเลิกการดำเนินการค่าเริ่มต้นของลิงก์

                        // แสดง SweetAlert2 เพื่อยืนยันการลบ
                        Swal.fire({
                            title: 'คุณแน่ใจหรือไม่?',
                            text: "คุณต้องการที่จะลบรายการนี้หรือไม่?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'ใช่, ลบ!',
                            cancelButtonText: 'ยกเลิก',
                            dangerMode: true // เพิ่มตัวเลือกนี้เพื่อให้สร้างหน้าต่างแสดงเฉพาะเมื่อคลิกที่ปุ่ม "ใช่, ลบ!"
                        }).then((result) => {
                            // หากผู้ใช้ยืนยันการลบ
                            if (result.isConfirmed) {
                                // นำผู้ใช้ไปยัง URL ที่ระบุเพื่อลบ
                                window.location.href = button.getAttribute('href');
                            }
                        });
                    });
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                $('.show_details').click(function(e) {
                    e.preventDefault();

                    var subject_id = $(this).data('subject_id');
                    var subject_name = $(this).data('subject_name');
                    var students = $(this).data('student');

                    $('#subject_id').text(subject_id);
                    $('#subject_name').text(subject_name);
                    $('#subject_name-title').text(subject_name);
                    $('#students_list').empty(); // เคลียร์รายชื่อนักเรียนก่อน

                    // เพิ่มข้อมูลนักเรียนลงในตาราง
                    $.each(students, function(index, student) {
                        $('#students_list').append('<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + student.student_id + '</td>' +
                            '<td>' + student.name + '</td>' +
                            '</tr>');
                    });
                });
            });
        </script>
    @endsection
