<div class="modal fade" id="{{$missao['chamado']}}" tabindex="-1" aria-labelledby="{{$missao['chamado']}}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Encerrar chamado - {{$missao['chamado']}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('missoes.encerra', [$missao['chamado'], auth()->user()->id]) }}" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <label for="descricao" class="form-label">Descrição</label> <span class="campo_obrigatorio"> *</span>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-square encerrar_chamado"> Encerrar </i>
                    </button>
                </div>
            </form>        
        </div>
    </div>
</div>