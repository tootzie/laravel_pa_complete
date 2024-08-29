@forelse ($roles as $role)
<tr>
    <td class="text-truncate"> {{$role->id}}</td>
    <td class="text-truncate"> {{$role->name}}</td>
    <td>
        <div class="action-buttons">
            <a type="button" class="btn btn-icon btn-warning" href="{{ route('user-roles-edit', $role->id) }}">
                <span class="tf-icons mdi mdi-square-edit-outline"></span>
            </a>
            <a type="button" class="btn btn-icon btn-danger" href="#" data-bs-toggle="modal" data-bs-target="#modalToggle{{$role->id}}">
                <span class="tf-icons mdi mdi-trash-can-outline"></span>
            </a>
            <!-- Modal 1-->
            <div class="modal fade" id="modalToggle{{$role->id}}" aria-labelledby="modalToggleLabel{{$role->id}}" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalToggleLabel">Hapus Role</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Hapus role '{{$role->name}}'?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('user-roles-delete', $role->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center">Data Tidak Tersedia</td>
</tr>
@endforelse


