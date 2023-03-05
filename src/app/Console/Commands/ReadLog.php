<?php

namespace App\Console\Commands;

use App\Models\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ReadLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read log in path /var/www/app/strong';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $logFile = file(storage_path() . $this->argument('file'));
        foreach ($logFile as $line) {
            $explode = explode(" ", str_replace(["- ", '"', "\n", "[", "]"], [""], $line));
            Log::create([
                "service_names" => $explode[0],
                "route_info" => $explode[2] . " " . $explode[3] . " " . $explode[4],
                "status_code" => (int)$explode[5],
                "date_at" => Carbon::createFromFormat('d/M/Y:H:i:s', $explode[1])
                    ->format('Y-m-d H:i:s'),
            ]);
        }
        $this->info("DONE");
    }
}
