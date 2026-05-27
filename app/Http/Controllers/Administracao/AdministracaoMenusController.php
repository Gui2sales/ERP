<?php

namespace App\Http\Controllers\Administracao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdministracaoMenusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Menus.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modulos = DB::table('modules')->get();

        return view('Admin.Menus.create_menus', compact('modulos','ordem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $modulo =  DB::table('modules')->insert([
            'nome' => $request->name,
            'icone' => $request->icone,
            'descricao' => $request->descricao,
            'sistema' => mb_strtoupper($request->sistema, 'UTF-8'),
            'status' => 2,
            'ativo' => 1,
        ]);

        $id_modulo = DB::getPdo()->lastInsertId();

        Permission::firstOrCreate(['name' => mb_strtolower($request->name), 'modulo_id' => $id_modulo, 'tela_id' => 0, 'funcao' => '']);

        if($modulo){
            return redirect()->route('menus')->with('success','Menu criado com sucesso.');
        }else{
            return redirect()->route('menus')->with('error','Erro ao registrar menu. Por favor, tente novamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $modulos = DB::table('modules')->where('id',$id)->first();

        return view('Admin.Menus.edit_menus',compact('modulos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'icone' => 'nullable|string|max:255',
            'status' => 'required|int',
        ]);

        $affected = DB::table('modules')
        ->where('id', $id)
        ->update([
            'nome' => $validated['name'],
            'descricao' => $validated['descricao'],
            'icone' => $validated['icone'],
            'status' => $validated['status'],
        ]);

        if ($affected === 0) {
            return redirect()->back()->withErrors(['id' => 'Módulo não encontrado.']);
        }

        return redirect()->route('menus')->with('success', 'Módulo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $ativo) : RedirectResponse
    {
        $modulo =  DB::table('modules')->where('id', $id)->update(['ativo' => $ativo]);

        if ($modulo && $ativo == 1) {
            return redirect()->route('menus')->with('success', 'Modulo ativado com sucesso.');
        } elseif ($modulo && $ativo == 0) {
            return redirect()->route('menus')->with('success', 'Modulo inativado com sucesso.');
        }
        else {
            return redirect()->route('menus')->with('error', 'Erro ao alterar o módulo. Por favor, tente novamente.');
        }
    }
}
