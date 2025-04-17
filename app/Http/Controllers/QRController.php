<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Illuminate\Support\Facades\Log;

class QRController extends Controller
{
    public function generateQr($token)
    {
        // Depuración
        Log::info("Generating QR code for token: $token");
    
        return response(QrCode::format('png')->size(70)->generate($token));
    }
    
}
