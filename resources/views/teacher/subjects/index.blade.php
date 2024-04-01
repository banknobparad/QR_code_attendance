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
                            <span>{{ __('Subjects') }}</span>

                            <div class="button-create text-end">
                                <a class="btn btn-primary rounded-1 shadow-none ms-auto" href="{{ route('subject.create') }}"
                                    role="button">
                                    <i class="bi bi-plus-lg"></i>{{ __('Add Subjects') }}
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-md-12 table-responsive" id="subjectsTable">
                            <table class="table table-hover">
                                <thead class="table-dark">
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
                                            <td>#</td>
                                            <td>{{ $item->subject_id }}</td>
                                            <td>{{ $item->subject_name }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-info show_details"
                                                    data-bs-toggle="modal" data-bs-target="#SubjectDetailsModel"
                                                    data-subject_id="{{ $item->subject_id }}"
                                                    data-subject_name="{{ $item->subject_name }}"
                                                    data-subject_stus="{{ json_encode($item->subject_stus) }}">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>

                                                <a href="{{ route('subject.showedit', $item->subject_id) }}"
                                                    class="btn btn-sm btn-success"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>
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
                        <h5 class="modal-title" id="SubjectDetailsModelLabel">รายละเอียดเพิ่มเติมเกี่ยวกับ วิชา</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>ชื่อวิขา: <span id="subject_name"></span></p>
                        <p>รหัสวิชา: <span id="subject_id"></span></p>
                        <hr>
                        <!-- เพิ่มส่วนนี้เพื่อแสดงรายชื่อนักเรียน -->
                        <div id="student_list">
                            <!-- รายชื่อนักเรียนจะแสดงที่นี่ -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('.show_details').click(function(e) {
                    e.preventDefault();

                    var subject_id = $(this).data('subject_id');
                    var subject_name = $(this).data('subject_name');
                    var subject_stus = $(this).data('subject_stus');

                    $('#subject_id').text(subject_id);
                    $('#subject_name').text(subject_name);

                    // ตรวจสอบว่ามีข้อมูลนักเรียนหรือไม่
                    if (subject_stus && subject_stus.length > 0) {
                        // แสดงรายชื่อนักเรียน
                        var studentList = '';
                        $.each(subject_stus, function(index, student) {
                            studentList += '<p>' + student.student_code + ': ' + student.student_name +
                                '</p>';
                        });

                        $('#student_list').html(studentList);
                    } else {
                        $('#student_list').html('<p>No students found</p>'); // ถ้าไม่มีข้อมูลนักเรียน
                    }

                    $('#SubjectDetailsModel').modal('show');
                });
            });
        </script>
    @endsection
