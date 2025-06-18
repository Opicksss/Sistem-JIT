<x-layout>
    <x-slot:title>Account</x-slot:title>
    <div class="mb-3 text-uppercase breadcrumb-title">Master Account</div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Account</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item me-2">
                        <a href="javascript:void(0)"><i class="bx bx-package"></i></a>
                    </li>
                    <li> Master Account</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Master Account</h5>
                    </div>
                    <a href="{{ route('acount.create') }}" class="btn btn-primary px-3">
                        <i class="bx bx-plus me-1"></i>Account
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">ID Akun</th>
                                <th width="15%">Nama</th>
                                <th width="20%">Email</th>
                                <th width="20%">Alamat</th>
                                <th width="10%">Telepon</th>
                                <th width="10%">Role</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userss as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->profile->id_akun ?? '-' }}</td>
                                    <td>{{ ucwords($item->name) }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ ucfirst($item->profile->alamat ?? '-') }}</td>
                                    <td>{{ $item->profile->telepon ?? '-' }}</td>
                                    <td>{{ ucwords($item->role) }}</td>
                                    <td class="text-center">
                                         <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('acount.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $item->id }}">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal delete -->
                                <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                                    aria-labelledby="delete{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header justify-content-center border-bottom-0 py-2">
                                                <h5 class="modal-title text-danger text-decoration-underline fw-bold">
                                                    Konfirmasi Penghapusan
                                                </h5>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p class="mb-4">
                                                    Apakah Anda yakin ingin menghapus data
                                                    <strong style="font-size: 1rem;">{{ ucwords($item->nama) }}
                                                        ?</strong>
                                                    Tindakan ini tidak dapat dibatalkan.
                                                </p>
                                                <div class="d-flex justify-content-center">
                                                    <i class="bi bi-exclamation-circle-fill text-warning"
                                                        style="font-size: 6rem;"></i>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0">
                                                <button type="button" class="btn btn-outline-secondary "
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('acount.destroy', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //Modal delete -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>
