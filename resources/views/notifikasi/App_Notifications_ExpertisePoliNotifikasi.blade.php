<a class="mark-as-read" href="{{ route('dokterPoli.pasien.detail-pemeriksaan', ['id' => $notification->data['expertise']['id']]) }}" data-id="{{ $notification->id }}" id="{{ $notification->id }}">
    <i class="fa fa-stethoscope text-green"></i>
        Pemeriksaan selesai : {{ $notification->data['nama_pasien'] }}
</a>

