<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckUserActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $inactiveTime = 1; // Tiempo en minutos de inactividad permitido

        // Obtener usuarios activos cuya última actividad fue hace más de 30 minutos
        DB::table('users')
            ->where('is_active', 1)
            ->where('updated_at', '<', Carbon::now()->subMinutes($inactiveTime))
            ->update(['is_active' => 0]);
    }
}
