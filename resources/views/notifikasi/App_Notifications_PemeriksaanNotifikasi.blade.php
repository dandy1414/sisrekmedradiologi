<a class="mark-as-read" href="{{ route('dokterRadiologi.pasien.expertise-pasien', ['id' => $notification->data['new_pemeriksaan']['id']]) }}" data-id="{{ $notification->id }}" data-id="{{ $notification->id }}">
    <i class="fa fa-stethoscope text-aqua"></i>
    Expertise baru : {{ $notification->data['nama_pasien'] }}
</a>
