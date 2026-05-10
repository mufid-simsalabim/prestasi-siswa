<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Services\C45Service;

class C45Controller extends Controller
{
    protected $c45;

    public function __construct(C45Service $c45)
    {
        $this->c45 = $c45;
    }

    public function index()
    {
        $penilaian = Penilaian::with('student')->get();
        $hasil     = $this->c45->prosesC45($penilaian);

        return view('c45.index', compact('hasil'));
    }

    public function proses()
    {
        $penilaian = Penilaian::with('student')->get();

        if ($penilaian->count() < 2) {
            return redirect()->back()
                ->with('error', 'Data penilaian minimal 2 untuk proses C4.5.');
        }

        $hasil = $this->c45->prosesC45($penilaian);

        return view('c45.hasil', compact('hasil'));
    }
}