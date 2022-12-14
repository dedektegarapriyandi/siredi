<?php

namespace App\Http\Controllers;

use App\Models\MedicalPrescription;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicalPrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('medical_prescriptions.index', [
            'pageTitle' => 'Resep Obat Pasien',
            'medRecords' => MedicalRecord::all(),
            'prescriptions' => MedicalPrescription::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalPrescription  $medicalPrescription
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalPrescription $medicalPrescription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalPrescription  $medicalPrescription
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalPrescription $medicalPrescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalPrescription  $medicalPrescription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalPrescription $medicalPrescription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalPrescription  $medicalPrescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalPrescription $medicalPrescription)
    {
        //
    }

    public function printDetail(MedicalPrescription $resep_obat)
    {
        // dd($resep_obat->medicine->id_obat);
        return view('prints.prescriptions.show', [
            'pageTitle' => "Cetak Resep Obat",
            'prescriptions' => $resep_obat
        ]);
    }

    public function print(MedicalPrescription $resep_obat)
    {
        if ($resep_obat->status === 'menunggu') {
            MedicalPrescription::where('id_resep', $resep_obat->id_resep)->update([
                'status' => 'selesai'
            ]);

            // update stok
            $old_stock = $resep_obat->medicine->stok;

            $new_stock = $old_stock - $resep_obat->jumlah;

            Medicine::where('id_obat', $resep_obat->medicine->id_obat)->update([
                'stok' => $new_stock
            ]);
        }

        return view('prints.prescriptions.print', [
            'pageTitle' => "Cetak Resep Obat",
            'prescriptions' => $resep_obat
        ]);
    }
}