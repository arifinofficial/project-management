<div class="dropdown">
    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" style="">
        <button class="dropdown-item editAction" data-action={{ $edit_url }}><i class="fas fa-pencil-alt text-info"></i> Ubah</button>
        <button class="dropdown-item deleteAction" data-action="{{ $delete_url }}"><i class="fas fa-trash text-danger"></i> Hapus</button>
    </div>
</div>