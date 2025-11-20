<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Trade;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    public function show()
    {
        $trades = Trade::all();
        return view('index', compact('trades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'matric_number' => 'required|string|unique:students,matric_number',
            'email' => 'required|email|unique:students,email',
            'phone_number' => 'required|string',
            'department' => 'required|string',
            'level' => 'required|integer',
            'trade_id' => 'required|exists:trades,id',
        ]);

        $student = Student::create($validated);

        try {
            $data = [
                "amount" => 15000 * 100,
                "reference" => paystack()->genTranxRef(),
                "email" => $student->email,
                "currency" => "NGN",
                "metadata" => [
                    'student_id' => $student->id,
                    'matric_number' => $student->matric_number,
                ],
            ];

            return paystack()->getAuthorizationUrl($data)->redirectNow();
        } catch (\Exception $e) {
            return Redirect::back()->withMessage(['msg' => 'The paystack token has expired. Please refresh the page and try again.', 'type' => 'error']);
        }
    }
}
