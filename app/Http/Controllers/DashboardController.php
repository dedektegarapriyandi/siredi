<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\MedicalPrescription;
use App\Models\Medicine;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Pharmacist;
use App\Models\Poly;
use App\Models\Queue;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $getPolyCreatedDate = Queue::pluck('created_at');
        // $arr = explode('-', $getPolyCreatedDate);
        // $getDate = substr($arr[2], 0, 2);


        return view('dashboard.index', [
            'pageTitle' => 'Dashboard',
            'patientCount' => Patient::all()->count(),
            'doctorCount' => Doctor::all()->count(),
            'nurseCount' => Nurse::all()->count(),
            'queueCount' => Queue::all()->count(),
            'pharmacistCount' => Pharmacist::all()->count(),
            'medicineCount' => Medicine::all()->count(),
            'polyCount' => Poly::all()->count(),

            'prescriptions' => MedicalPrescription::latest()->get(),
            'queues' => Queue::all()->filter(function ($todayQueue) {
                if (str_contains($todayQueue, now()->toDateString())) {
                    return Queue::all();
                }
            })
        ]);
    }
}