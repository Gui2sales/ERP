<div class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dho</li>
    @if (ucfirst(Str::before(request()->route()->getName(), '.index')) != "Dho")
      <li class="breadcrumb-item active" aria-current="page">{{ ucfirst(Str::before(request()->route()->getName(), '.index')) }}</li>
    @endif
  </ol>
</div>