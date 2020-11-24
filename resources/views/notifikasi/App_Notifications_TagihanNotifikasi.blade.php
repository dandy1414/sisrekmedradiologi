<a class="mark-as-read" href="{{ route('kasir.pasien.pembayaran-pasien', ['id'=>$notification->data['tagihan']['id']]) }}" data-id="{{ $notification->id }}" id="{{ $notification->id }}">
    <i class="fa fa-money text-aqua"></i>
    Tagihan baru : {{ $notification->data['nama_pasien'] }}
</a>
