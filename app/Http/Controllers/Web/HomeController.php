<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        return $this->index();
    }

    public function index()
    {
        // Se o usuário está autenticado, redirecionar para o dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // Página inicial pública
        return view('home.index');
    }

    public function about()
    {
        return view('home.about');
    }

    public function features()
    {
        return view('home.features');
    }

    public function pricing()
    {
        return view('home.pricing');
    }

    public function contact()
    {
        return view('home.contact');
    }
}
