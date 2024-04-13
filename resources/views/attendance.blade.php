<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
</head>
<body>
    <h1>Attendance Report</h1>
    <table>
        <thead>
            <tr>
                <th>QR Code ID</th>
                <th>Teacher ID</th>
                <th>Subject ID</th>
                <th>Student ID</th>
                <th>Status</th>
                <th>Check</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendanceData as $row)
            <tr>
                <td>{{ $row->qrcode_id }}</td>
                <td>{{ $row->teacher_id }}</td>
                <td>{{ $row->subject_id }}</td>
                <td>{{ $row->student_id }}</td>
                <td>{{ $row->status }}</td>
                <td>{{ $row->check }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
