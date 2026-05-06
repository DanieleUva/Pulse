<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. Recuperiamo la parola cercata dall'input 'query' della navbar
        $query = $request->input('query');

        // 2. Se la query è vuota, reindirizziamo alla home (opzionale ma consigliato)
        if (!$query) {
            return redirect('/');
        }
        
        // 3. Cerchiamo utenti che nel nome o nello username contengono la parola
        // Usiamo 'LIKE' per una ricerca parziale (es. 'dan' troverà 'daniele')
        $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('username', 'LIKE', "%{$query}%")
                    ->get();

        // 4. Restituiamo la vista dei risultati passando i dati trovati
        return view('search.results', compact('users', 'query'));
    }
}