<div class="btn-group">
    <a href="{{route('proveedores.show', $id)}}" class="btn btn-primary btn-sm mr-2" >
        <i class="fas fa-eye"></i>
    </a>
    <button class="btn btn-danger btn-sm" onclick="remove({{$id}})">
        <i class="fas fa-trash"></i>
    </button>
</div>