<form action="{{ route('biaya-operasional.restore', $data->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn-cst btn-success d-flex align-items-center justify-content-center w-auto px-2 gap-2">
        <i class="ph ph-check fs-5"></i>
        Aktifkan
    </button>
</form>
