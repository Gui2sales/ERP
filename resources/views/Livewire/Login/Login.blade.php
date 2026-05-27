<div id="caixa_login">
    <span class="text-secondary"> Efetue o login com usuário e senha OPUS.</span>

    <form wire:submit.prevent="login" class="mt-2">
        <div class="input-group">
            <span class="input-group-text col-3 fw-bold">Usuário</span>
            <input id="usuario" class="form-control" type="text" name="usuario" required wire:model='usuario'/>
        </div>

        <div class="input-group mt-3">
            <span class="input-group-text col-3 fw-bold">Senha</span>
            <input id="senha" class="form-control" type="password" name="senha" required wire:model='senha'/>
        </div>

        <!-- Remember Me -->
        {{-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Lembrar de mim') }}</span>
            </label>
        </div> --}}

        <div class="flex items-center justify-between mt-3">
            <span class="text-danger">{{$erro}}</span>
            <button 
                wire:loading.attr="disabled"
                type="submit"
            >
                <span wire:loading wire:target="login" class="btn btn-secondary disabled">
                    @include('components.carregando')
                </span>
                <span wire:loading.remove wire:target="login" class="btn btn-primary">Entrar</span>
            </button>
        </div>
    </form>
    
</div>
