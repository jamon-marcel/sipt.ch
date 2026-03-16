<?php
namespace App\Console\Commands;

use App\Exports\StudentCourseAttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class ExportStudentCourseAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:student-course-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export students who attended a course in the last 3 years as XLSX';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $filename = 'sipt-kursbesuche_letzte_3_jahre.xlsx';
        $path = storage_path('app/' . $filename);

        Excel::store(new StudentCourseAttendanceExport, $filename, 'local');

        $this->info('Export saved to: ' . $path);
        return self::SUCCESS;
    }
}
