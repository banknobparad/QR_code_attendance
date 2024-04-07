
<div style="width: 100%" id="reader"></div>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:

        window.location.href = decodedText;

        console.log(`Code matched = ${decodedText}`, decodedResult);
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
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
        /* verbose= */
        false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

</div>
<p class="text-center">เวลาปัจจุบัน: {{ date('H:i:s') }}</p>

<h3 class="mt-3">ประวัติเช็คชื่อวันนี้</h3>
<table class="table table-bordered">
<thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">วิชา</th>
        <th scope="col">แผนก</th>
        <th scope="col">สถานะ</th>

        <th scope="col">เวลาเช็คชื่อ</th>


    </tr>
</thead>
<tbody>
    @foreach ($checkings as $index => $checking)
        @php
            $index++;
        @endphp
        <tr>
            <th scope="row">{{ $index }}</th>


            <td>{{ $checking->subject->subject_name }}</td>
            <td>{{ $checking->branch->name }}</td>
            <td>
                @if ($checking->status == 'present')
                    <span class="badge badge-success  text-bg-success">ตรงเวลา</span>
                @elseif($checking->status == 'late')
                    <span class="badge badge-danger text-bg-danger">สาย</span>
                @else
                    <span class="badge badge-secondary">สถานะไม่ทราบ</span>
                @endif
            </td>

            <td>{{ $checking->created_at }}</td>


        </tr>
    @endforeach

</tbody>
</table>
@endif

</div>
