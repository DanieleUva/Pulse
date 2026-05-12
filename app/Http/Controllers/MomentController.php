<?php

namespace App\Http\Controllers;

use App\Models\Moment;
use id;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MomentController extends Controller
{
    /**
     * Salva un nuovo Momento (Storia)
     */
    public function store(Request $request)
    {
        // Validazione: l'immagine è obbligatoria e deve essere un file grafico
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Caricamento dell'immagine nella cartella 'moments' dentro lo storage pubblico
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('moments', 'public');

            // Creazione del record nel database
            Moment::create([
                'user_id' => auth()->id(),
                'image_path' => $path,
                'expires_at' => now()->addDay(), // Imposta la scadenza a 24 ore da adesso
            ]);

            return back()->with('success', 'Momento pubblicato con successo!');
        }

        return back()->with('error', 'Si è verificato un problema con l\'immagine.');
    }

    /**
     * Elimina un momento manualmente (opzionale)
     */
    public function destroy(Moment $moment)
    {
        // Controlla che sia il proprietario a cancellarlo
        if ($moment->user_id !== auth()->id()) {
            abort(403);
        }

        // Elimina il file fisico e poi il record
        Storage::disk('public')->delete($moment->image_path);
        $moment->delete();

        return back()->with('success', 'Momento rimosso.');
    }
}