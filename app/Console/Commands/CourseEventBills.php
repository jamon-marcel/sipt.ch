<?php
namespace App\Console\Commands;

use App\Tasks\CourseEventBills as CourseEventBillsTask;
use Illuminate\Console\Command;

class CourseEventBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:event-bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute course event bills task';

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
     * @return int
     */
    public function handle(): int
    {
        $task = new CourseEventBillsTask();
        $task();
        
        $this->info('Course event bills task executed successfully');
        return self::SUCCESS;
    }
}