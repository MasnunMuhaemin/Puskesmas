<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
   public function index() {
        return Poli::all();
    }

    public function store(Request $request) {
        return Poli::create($request->all());
    }

    public function show($id) {
        return Poli::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $poli = Poli::findOrFail($id);
        $poli->update($request->all());
        return $poli;
    }

    public function destroy($id) {
        Poli::destroy($id);
        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
