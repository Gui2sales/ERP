<?php

namespace App\Http\Controllers\Administracao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdministracaoPerfisController extends Controller
{
    public function index(Request $request)
    {
        $queryPerfis = Role::select('roles.id as role_id','roles.name as role_name',        
            DB::raw("GROUP_CONCAT(distinct(modules.nome) SEPARATOR ', ') as modulo"),
            "roles.ativo as ativo")
        ->leftJoin('role_has_permissions','role_has_permissions.role_id','=','roles.id')
        ->leftJoin('permissions','permissions.id','=','role_has_permissions.permission_id')
        ->leftJoin('modules','modules.id','=','permissions.modulo_id')
        ->groupBy('roles.id','roles.name', 'roles.ativo')
        ->orderBy('roles.id', 'desc')
        ->orderBy('permissions.modulo_id', 'desc');

        $perfis = QueryBuilder::for($queryPerfis)
        ->allowedFilters([
            AllowedFilter::callback('perfil_ativo', function ($query, $value) {
                if (in_array($value, ['0', '1'])) {
                    $query->where('roles.ativo', (int) $value);
                }
                else return;                
            }),
        ])
        ->when(! $request->filled('filter.perfil_ativo'), function ($q) {
            $q->where('roles.ativo', 1);
        })
        ->paginate(10)
        ->appends(request()->query());

        return view('Admin.Perfis.index', compact('perfis'));
    }

    public function create()
    {
        $perfis = DB::table('roles')->orderBy('id')->distinct()->get();
        $permissoes = DB::table('permissions')->orderBy('id')->distinct()->get();

        return view('Admin.Perfis.create_perfis', compact('perfis','permissoes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $roleName = $request->input('name');
        $role = Role::create(['name' => $roleName, 'ativo' => 1]);

        $permissoess = $request->input('permissoes', []);
        if (!empty($permissoess)) {
            $role->givePermissionTo($permissoess);
        }   

        if($role){
            return redirect()->route('perfis')->with('success','Perfíl criado com sucesso.');
        }else{
            return redirect()->route('perfis')->with('error','Erro ao criar perfíl. Por favor, tente novamente.');
        }
    }

    public function edit($id)
    {
        $perfis = DB::table('roles')->where('id',$id)->get()->first();
        $permissoes = DB::table('permissions')
        ->orderBy('id')
        ->distinct()
        ->get();

        $permissoes = DB::table('permissions')
        ->select('permissions.id','permissions.name', 'role_id')
        ->leftJoin('role_has_permissions', function ($join) use ($id){
            $join->on('role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id', '=', $id);
        })
        ->orderBy('id')
        ->distinct()
        ->get();
        
        return view('Admin.Perfis.edit_perfis', compact('perfis','permissoes'));
    }

    public function update(Request $request, $id)
    {
        $permissoess = $request->input('permissoes', []);
        $role = Role::where('id', $id)->get()->first();
        $role->syncPermissions($permissoess);

        if ($role === 0) {
            return redirect()->back()->withErrors(['id' => 'Perfil não encontrado.']);
        }

        return redirect()->route('perfis')->with('success', 'Perfil alterado com sucesso.');        
    }

    public function destroy($id, $ativo)
    {
        if($id == 4){
            return redirect()->route('perfis')->with('error', 'Perfil não pode ser excluido.');
        }

        $perfis = Role::findById($id);
        $usuarios = $perfis->users;

        if ($perfis && $usuarios) {
            $perfis->ativo = $ativo;
            $perfis->save();

            if($ativo == 0){
                foreach ($usuarios as $usuario){
                    $usuario->removeRole($perfis);
                    $usuario->assignRole('Usuário Padrão');
                }   
            }

            return redirect()->route('perfis')->with('success', 'Perfil excluído com sucesso.');
        }

        return redirect()->route('perfis')->with('error', 'Perfil não pode ser excluido.');
    }
}
