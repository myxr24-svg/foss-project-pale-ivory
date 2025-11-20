<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = paystack()->getPaymentData();

        $studentId = $paymentDetails['data']['metadata']['student_id'] ?? null;
        $reference = $paymentDetails['data']['reference'];

        if (!$studentId) {
            return redirect()->route('home')->with('error', 'Could not verify payment details.');
        }

        $student = Student::find($studentId);

        if (!$student) {
            return redirect()->route('home')->with('error', 'Student record not found.');
        }

        return view('success', compact('student', 'reference'));
    }

    public function downloadReceipt(Student $student, $reference)
    {
        $pdf = Pdf::loadView('receipt', compact('student', 'reference'));
        $filename = 'receipt-' . str_replace(['/', '\\'], '-', $student->matric_number) . '.pdf';
        return $pdf->download($filename);
    }
}
