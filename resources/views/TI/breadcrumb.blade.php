<div class="my-3 only_pc" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
    @if(request()->route()->getName() != "ti")
      <li class="breadcrumb-item"><a href="{{route('ti')}}">TI</a></li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ ucfirst(Str::before(request()->route()->getName(), '.index')) }}
      </li>
    @else
      <li class="breadcrumb-item active" aria-current="page">TI</li>
    @endif
  </ol>
</div>