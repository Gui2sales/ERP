<?php

use App\Http\Controllers\Administracao\AdministracaoMenusController;
use App\Http\Controllers\Administracao\AdministracaoUsuariosController;
use App\Http\Controllers\Administracao\AdministracaoPerfisController;
use App\Http\Controllers\Home;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TI\ChamadosController;
use App\Http\Controllers\TI\GestaoTiController;
use App\Http\Controllers\TI\MissoesController;
use App\Http\Controllers\U_AprovacoesGerais\UB_SAP;
use App\Http\Controllers\V_Suprimento\VC_Cotacao;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('Perfil.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('Perfil.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('Perfil.destroy');

    Route::resource('/', Home::class)->names('home')
    ->only(['index']);
});

Route::prefix('administracao')->middleware(['auth', 'verified', PermissionMiddleware::class.':admin'])->group(function () {
    Route::resource('usuarios', AdministracaoUsuariosController::class)
        ->names(['index' => 'usuarios'], 'usuarios')
        ->only(['index', 'create', 'store', 'edit', 'update']);
    Route::delete('usuarios/{id}/{ativo}', [AdministracaoUsuariosController::class, 'destroy'])
        ->name('Inativa Usuario');
    Route::resource('menus', AdministracaoMenusController::class)
        ->names(['index' => 'menus'], 'menus')
        ->only(['index', 'create', 'edit', 'store','update']);
    Route::delete('menus/{id}/{ativo}', [AdministracaoMenusController::class, 'destroy'])
        ->name('Inativa Menu');
    Route::resource('perfis', AdministracaoPerfisController::class)
        ->names(['index' => 'perfis'], 'perfis')
        ->only(['index', 'create', 'edit', 'store','update']);
    Route::delete('perfis/{id}/{ativo}', [AdministracaoPerfisController::class, 'destroy'])
        ->name('Deleta Perfil');
});

// Route::prefix('dho')->middleware(['auth', 'verified', PermissionMiddleware::class.':dho'])->group(function () {
//     Route::get('/', function () {
//         return view('Dho.main');
//     })->name('dho');
//     Route::resource('bancodetalentos', BancoDeTalentosController::class)
//         ->names(['index' => 'Banco de Talentos'], 'bancodetalentos')
//         ->only(['index','create','store', 'show']);
// });

Route::prefix('ti')->middleware(['auth', 'verified', PermissionMiddleware::class.':ti'])->group(function () {
    Route::get('/', function () {
        return view('TI.main');
    })->name('ti');
    Route::resource('missoes', MissoesController::class)
        ->middleware([PermissionMiddleware::class.':ti.missoes'])
        ->only(['index', 'create', 'store','edit','update','show'])
        ->names(['index' => 'missoes'], 'missoes');
    Route::delete('missoes/{chamado}/{usuario}/{ordem}', [MissoesController::class, 'destroy'])
        ->name('missoes.destroy');
    Route::delete('missoes/{chamado}/{colaborador}', [MissoesController::class, 'encerra'])
        ->name('missoes.encerra');
    Route::resource('chamados', ChamadosController::class)
        ->middleware([PermissionMiddleware::class.':ti.chamados'])
        ->names(['index' => 'chamados']);
    Route::resource('gestao', GestaoTiController::class)
        ->middleware([PermissionMiddleware::class. ':ti.gestao'])
        ->names(['index' => 'gestao']);
});

Route::prefix('suprimentos')->middleware(['auth', 'verified', PermissionMiddleware::class.':suprimentos'])->group(function() {
    Route::get('/', function () {
        return redirect()->route('home.index');
    })->name('suprimentos');

    Route::prefix('cotacao')->middleware(['auth', 'verified', PermissionMiddleware::class.':cotacao'])->group(function() {
        Route::get('/', function () {
            return view('Suprimentos.main');
        })->name('cotacao');

        Route::resource('/aprovacotacao', VC_Cotacao::class)
        ->names(['index' => 'Aprova Cotação'])
        ->only(['index']);

        Route::get('/aprovacotacao/{filial}/{cotacao}', [VC_Cotacao::class, 'show'])->name('AprovaCotação');
    });
});

// Route::prefix('vendas')->middleware(['auth', 'verified', PermissionMiddleware::class.':vendas'])->group(function() {
//     Route::get('/', function () {
//         return view('Vendas.main');
//     })->name('vendas');
// });

Route::prefix('aprovacoesGerais')->middleware(['auth', 'verified', PermissionMiddleware::class.':aprovacoesGerais'])->group(function() {
    Route::get('/', function () {
        return redirect()->route('home.index');
    })->name('aprovacoesGerais');

    Route::prefix('sap')->group(function() {
        Route::get('/', [UB_SAP::class, 'index'])->name('SAP');
        Route::get('/ubd', [UB_SAP::class, 'ubd'])->name('Historico de Compras');
        Route::get('/ubd/{numero}/{rota}/{sequencia}', [UB_SAP::class, 'aprovacao'])->name('Aprova SAP');
    });

});

Route::get('/teste', function () {
    return view('index-modules');
})->name('teste');

require __DIR__.'/auth.php';