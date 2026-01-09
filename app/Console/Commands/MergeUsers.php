<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MergeUsers extends Command
{
  protected $signature = 'user:merge {--dry-run : Preview the merge without making any changes}';
  protected $description = 'Merge two student accounts by transferring all data from one to another';

  public function handle(): int
  {
    $sourceEmail = $this->ask('Enter the email of the student account to be MERGED (will be deleted)');
    $targetEmail = $this->ask('Enter the email of the student account to KEEP');

    if (strtolower($sourceEmail) === strtolower($targetEmail)) {
      $this->error('Source and target email addresses must be different.');
      return self::FAILURE;
    }

    $sourceUser = User::where('email', $sourceEmail)->first();
    $targetUser = User::where('email', $targetEmail)->first();

    if (!$sourceUser) {
      $this->error("User not found: {$sourceEmail}");
      return self::FAILURE;
    }

    if (!$targetUser) {
      $this->error("User not found: {$targetEmail}");
      return self::FAILURE;
    }

    if (!$sourceUser->student) {
      $this->error("Source user has no student record: {$sourceEmail}");
      return self::FAILURE;
    }

    if (!$targetUser->student) {
      $this->error("Target user has no student record: {$targetEmail}");
      return self::FAILURE;
    }

    $sourceStudent = $sourceUser->student;
    $targetStudent = $targetUser->student;
    $isDryRun = $this->option('dry-run');

    if ($isDryRun) {
      $this->warn("\n[DRY RUN MODE - No changes will be made]\n");
    }

    // Display info
    $this->info("=== Merge Preview ===\n");
    $this->line("SOURCE (will be deleted):");
    $this->line("  Email: {$sourceUser->email}");
    $this->line("  Student: {$sourceStudent->firstname} {$sourceStudent->name} (#{$sourceStudent->number})");

    $this->line("\nTARGET (will be kept):");
    $this->line("  Email: {$targetUser->email}");
    $this->line("  Student: {$targetStudent->firstname} {$targetStudent->name} (#{$targetStudent->number})");

    // Count what will be transferred
    $invoiceCount = Invoice::where('student_id', $sourceStudent->id)->count();
    $courseEventCount = DB::table('course_event_student')->where('student_id', $sourceStudent->id)->count();

    $this->info("\n=== Data to be transferred ===");
    $this->line("  Invoices: {$invoiceCount}");
    $this->line("  Course event bookings: {$courseEventCount}");

    if ($isDryRun) {
      $this->info("\n[DRY RUN COMPLETE - No changes were made]");
      return self::SUCCESS;
    }

    if (!$this->confirm("\nProceed with merge?")) {
      $this->info('Merge cancelled.');
      return self::SUCCESS;
    }

    try {
      DB::beginTransaction();

      // Update student_id on invoices
      Invoice::where('student_id', $sourceStudent->id)
        ->update(['student_id' => $targetStudent->id]);

      // Update student_id on course_event_student pivot table
      DB::table('course_event_student')
        ->where('student_id', $sourceStudent->id)
        ->update(['student_id' => $targetStudent->id]);

      // Delete source student and user
      $sourceStudent->delete();
      $sourceUser->delete();

      DB::commit();

      $this->info("\n✓ Merge completed!");
      $this->info("  - Transferred {$invoiceCount} invoice(s)");
      $this->info("  - Transferred {$courseEventCount} course event booking(s)");
      $this->info("  - Deleted user: {$sourceEmail}");

      return self::SUCCESS;
    } catch (\Exception $e) {
      DB::rollBack();
      $this->error("Merge failed: " . $e->getMessage());
      return self::FAILURE;
    }
  }
}
