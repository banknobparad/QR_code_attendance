<?php

namespace App\Console\Commands;

use App\Models\Qrcode;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class QRExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:expire'; // เปลี่ยนชื่อคำสั่งที่นี่


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $currentTime = Carbon::now()->toTimeString();
        // // info('Current Time: ' . $currentTime);

        // $affectedRows = Qrcode::where(DB::raw("TIME(end_time)"), '<=', $currentTime)->update(['status' => 'expired']);
        // // info('Affected Rows: ' . $affectedRows);
    }
}
