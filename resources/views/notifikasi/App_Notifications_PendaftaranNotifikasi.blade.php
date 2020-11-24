<a class="mark-as-read" href="{{ route('radiografer.pasien.pemeriksaan-pasien', ['id'=>$notification->data['pemeriksaan']['id']]) }}" data-id="{{ $notification->id }}" id="{{ $notification->id }}">
    <i class="fa fa-stethoscope text-aqua"></i>
    Pemeriksaan baru : {{ $notification->data['nama_pasien'] }}
</a>
