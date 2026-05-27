<?php

namespace App\Http\Controllers\Administracao;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdministracaoUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryUsuarios = User::select(
            'users.id as cod_usu',
            'users.name as nome_usu',
            'users.user as usuario',
            'users.email',
            'users.ativo',
            'roles.name as nome_role'
        )
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id');

        $usuarios = QueryBuilder::for($queryUsuarios)
        ->allowedFilters([
            AllowedFilter::partial('nome_usu', 'name'),
            AllowedFilter::exact('email'),
            AllowedFilter::partial('nome_role', 'roles.name'),
            AllowedFilter::callback('usuario_ativo', function ($query, $value) {
                if ($value === 'todos') {
                    return;
                }

                if (in_array($value, ['0', '1'])) {
                    $query->where('users.ativo', (int) $value);
                }
            }),
        ])
        ->when(! $request->filled('filter.usuario_ativo'), function ($q) {
            $q->where('users.ativo', 1);
        })
        ->paginate(10)
        ->appends(request()->query());

        return view('Admin.Usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perfis = DB::table('roles')->where('ativo',1)->orderBy('id')->distinct()->get();
        $permissoes = DB::table('permissions')->orderBy('id')->distinct()->get();

        return view('Admin.Usuarios.create_users',compact('perfis','permissoes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $messages = [
            'password.required' => 'O campo nova senha é obrigatório.',
            'password.min' => 'A nova senha deve ter pelo menos :min caracteres.', 
            'password.max' => 'A nova senha deve ter no máximo :max caracteres.',
            'password.letters' => 'A nova senha deve conter pelo menos uma letra.',
            'password.symbols' => 'A nova senha deve conter pelo menos um símbolo.',
            'password.numbers' => 'A nova senha deve conter pelo menos um número.',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::min(8)
                ->letters()
                ->symbols()
                ->numbers()
                ->mixedCase()
                ->max(16),
            ],
        ],$messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $permissoess = $request->input('permissoes', []);
        if (!empty($permissoess)) {
            $user->givePermissionTo($permissoess);
        }   

        $perfis = $request->input('role_id');
        if (!empty($perfis)) {
            $user->assignRole($perfis);
        }

        if($user){
            return redirect()->route('usuarios')->with('success','Usuário registrado com sucesso.');
        }else{
            return redirect()->route('usuarios')->with('error','Erro ao registrar usuário. Por favor, tente novamente.');
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
    public function edit(Request $request, $id)
    {
        $usuario = User::select()
        ->where('users.id', $id)
        ->get()
        ->first();

        $perfis = DB::table('roles')
        ->select(
            'roles.id', 
            'roles.name',
            DB::raw('MAX(users.id) as usu_id')
        )
        ->leftJoin('model_has_roles', 'model_has_roles.role_id', '=','roles.id')
        ->leftJoin('users', function ($join) use ($id){
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('users.id', '=', $id);
        })
        ->where('roles.ativo',1)
        ->groupBy('roles.id','roles.name')
        ->orderByRaw("CASE WHEN MAX(users.id) IS NOT NULL AND MAX(users.id) = ? THEN 0 ELSE 1 END", [$id])
        ->distinct()
        ->get();

        $permissoes = DB::table('permissions')
        ->select('permissions.id','permissions.name', 'model_id')
        ->leftJoin('modules as m',"m.id","permissions.modulo_id")
        ->leftJoin('model_has_permissions', function ($join) use ($id){
            $join->on('model_has_permissions.permission_id', '=', 'permissions.id')
                ->where('model_has_permissions.model_id', '=', $id);
        })
        ->orderBy('id')
        ->distinct()
        ->get();

        return view('Admin.Usuarios.edit_users', compact('usuario','perfis','permissoes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {        
        DB::table('users')
        ->where('id', $id)
        ->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
       
        if($request->ativo){
            DB::table('users')->where('id', $id)->update(['ativo' => $request->ativo,]);
        }
        if($request->password){
            DB::table('users')->where('id', $id)->update(['password' => Hash::make($request->password)]);
        }

        $usu = User::where('id', $id)->get()->first();

        $permissoess = $request->input('permissoes', []);
        $usu->syncPermissions($permissoess);

        $perfis = $request->input('role_id');
        if (!empty($perfis)) {
            $usu->syncRoles($perfis);
        }

        if ($usu === 0) {
            return redirect()->back()->withErrors(['id' => 'Usuário não encontrado.']);
        }

        return redirect()->route('usuarios')->with('success', 'Usuário alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $ativo) : RedirectResponse
    {
        $user = User::find($id);

        $user->ativo = $ativo;
        $user->save();

        return redirect()->route('usuarios')->with('success', 'Usuário alterado com sucesso.');

        return redirect()->route('usuarios')->with('error', 'Usuário não encontrado.');
    }
}
