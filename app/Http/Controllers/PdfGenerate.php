<?php

namespace App\Http\Controllers;

use App\Models\Proposals;
use App\Models\recognitions;
use App\Models\User;
use App\Services\PdfGenerator;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PdfGenerate extends Controller
{
    public function recognitionPDF(Proposals $proposal)
    {
        if (recognitions::where('proposal_id', '=', $proposal->id)->exists()) {
            return redirect()->route("proposals.index")->with('error', 'Esta propuesta ya cuenta con un reconocimiento!');
        } else {
            $pdfGenerator = new PdfGenerator();
            $pdfPath = storage_path('app/public');
            $user = User::find($proposal->user_id);
            $filename =  $proposal->id . $user->name;
            $pdfGenerator->generatePDF($pdfPath, $filename, $user->name . ' ' . $user->paternal_surname . ' ' . $user->maternal_surname, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
            recognitions::create(
                [
                    'path' => $pdfPath . '/' . $filename . '.pdf',
                    'code' => Hash::make($user->name . $proposal->id),
                    'proposal_id' => $proposal->id,
                    'announcements_id' => $proposal->announcement_id,
                    'user_id' => $user->id,
                ]
            );
            /*return response()->file($pdfPath, ['Content-Type' => 'application/pdf']);*/
            return response('Reconocimiento asignado con exito correctamente!', 200);
        }
    }

    public function downloadRecognitionPDF(Proposals $proposal)
    {
        $user = User::find($proposal->user_id);
        $filename = $proposal->id . $user->name . '.pdf';

        $pathToFile = storage_path('app/public/' . $filename);

        return response()->download($pathToFile);
    }
}
