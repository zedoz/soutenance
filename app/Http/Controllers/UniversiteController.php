<?php

namespace App\Http\Controllers;

use App\Models\Insertion;
use App\Models\Universite;
use Illuminate\Http\Request;

class UniversiteController extends Controller {

    public function index(Request $request) {
        $universites = Universite::query();

        if ($request->entreprise) {
            $universites = $universites->where('uo_lib', 'like', '%' . $request->entreprise . '%')->orWhere('etablissement_id_paysage', 'like', '%' . $request->entreprise . '%');
        }

        if ($request->trie) {
            $universites = $universites->where('uo_lib', 'like', '%' . $request->entreprise . '%')->orWhere('etablissement_id_paysage', 'like', '%' . $request->entreprise . '%');

            switch ($request->trie) {
                case 'nom_croiss':
                    $universites = $universites->orderBy('uo_lib', 'asc');
                    break;

                case 'nom_decroiss':
                    $universites = $universites->orderByDesc('uo_lib', 'desc');
                    break;

                case 'id_croiss':
                    $universites = $universites->orderBy('etablissement_id_paysage', 'asc');
                    break;

                case 'id_decroiss':
                    $universites = $universites->orderByDesc('etablissement_id_paysage', 'desc');
                    break;

                default:
                    # code...
                    break;
            }

        }

        $universites = $universites->paginate(10);
        return view('listUniversite', compact('universites'));
    }

    public function show(Universite $universite){
        $insertions = $universite->insertions;

        return view('detailUniversite', compact('universite', 'insertions'));
    }

}
