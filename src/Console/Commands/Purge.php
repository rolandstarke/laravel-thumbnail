<?php

namespace Rolandstarke\Thumbnail\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Purge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbnail:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'deletes cached image dimensions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (config('thumbnail.presets', []) as $presetName => $preset) {
            if (
                is_array($preset)
                && isset($preset['destination'])
                && is_string($preset['destination']['path'])
                && is_string($preset['destination']['disk'])
            ) {
                $disk = $preset['destination']['disk'];
                $path = $preset['destination']['path'];

                if (in_array($path, ['', '/'], true) || empty($disk)) {
                    if (!$this->confirm('Do you want to delete ' . $path . ' on disk ' . $disk . '?', false)) {
                        continue;
                    } else {
                        $this->info('You can skip this confirmation if you do not use "/" inside the config `thumbnail.presets.' . $presetName . '.path`' );
                    }
                }

                $this->info('cleaning ' . $path . ' on disk ' . $disk);
                sleep(1);

                $directories = Storage::disk($disk)->directories($path);
                foreach ($directories as $directory) {
                    Storage::disk($disk)->deleteDirectory($directory);
                    $this->output->write('.', false);
                }
                $this->output->write('done' . PHP_EOL);
            }
        }
    }
}
