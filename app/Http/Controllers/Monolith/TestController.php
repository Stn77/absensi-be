<?php

namespace App\Http\Controllers\Monolith;

use App\Http\Controllers\Controller;
use App\Http\Controllers\WhatsAppController;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    // public $whatsapp;

    // public function __construct()
    // {
    //     $this->whatsapp = WhatsAppController::class;
    // }

    public function index()
    {
        $this->createIzin();
    }

    // public function test_send_message()
    // {
    //     $token = '87XFf1T4BLuyGpp9p5CG';
    //     $nomorTujuan = '085850149741';
    //     $isiPesan = 'yoo';

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->post('https://api.fonnte.com/send', [
    //         'target' => $nomorTujuan,
    //         'message' => $isiPesan,
    //     ]);

    //     if($response->successful()){
    //         echo 'iki iso';
    //         echo $response;
    //     }else{
    //         echo 'gao iso';
    //     }
    // }

    public function createIzin()
    {
        $siswa = Auth::user()->siswa->id;
        dd($siswa);
    }
}
