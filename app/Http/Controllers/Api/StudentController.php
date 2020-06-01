<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Student;
use App\Http\Requests\StudentStoreRequest;
use Illuminate\Http\Request;

class StudentController extends Controller
{
  public function __construct(Student $student)
  {
    $this->student = $student;
    $this->authorizeResource(Student::class, 'student');
  }

  /**
   * Get all students
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return new DataCollection($this->student->get());
  }

  /**
   * Get current student
   * 
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function show(Student $student)
  {
    return response()->json($this->student->with('user')->find($student->id));
  }

  /**
   * Edit current student
   * 
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function edit(Student $student)
  {
    return response()->json($this->student->with('user')->find($student->id));
  }

  /**
   * Update the current student
   *
   * @param Student $student
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Student $student, StudentStoreRequest $request)
  {
    $student->update($request->all());
    $student->save();
    return response()->json('successfully updated');
  }
}
