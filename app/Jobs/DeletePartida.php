<?php

namespace App\Jobs;
use App\Models\Partida;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;



class DeletePartida implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $partidaId;
    /**
     * Create a new job instance.
     */
    public function __construct($partidaId)
    {
        $this->partidaId = $partidaId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $partida = DB::table('partida')->where('id', $this->partidaId)->first();


        $partida?->delete();
    }
}
