<a href="{{ route('kost.detail', $kost) }}" class="kost-card">
    <div class="kost-card-img">
        <img src="{{ $kost->getFotoUtamaUrl() }}" alt="{{ $kost->nama }}" loading="lazy" onerror="this.src='https://placehold.co/400x200/1E293B/818CF8?text=KostUnsur'">
        <div class="kost-type-badge badge-{{ $kost->tipe }}">{{ $kost->getTipeLabel() }}</div>
        <div class="kost-avail">{{ $kost->kamar_tersedia }} kamar</div>
    </div>
    <div class="kost-card-body">
        <div class="kost-card-name">{{ $kost->nama }}</div>
        <div class="kost-card-address">
            <i class="fa-solid fa-location-dot fa-xs"></i>
            {{ $kost->alamat }}
        </div>
        <div class="kost-meta">
            <div class="kost-price">{{ $kost->getHargaFormatted() }}<span style="font-size:.7rem;color:#64748B;font-weight:400;">/bln</span></div>
            <div class="kost-rating">
                <i class="fa-solid fa-star fa-xs"></i>
                {{ number_format($kost->rating_rata, 1) }}
                <span>({{ $kost->jumlah_ulasan }})</span>
            </div>
        </div>
        <div class="kost-facilities">
            @foreach(array_slice($kost->getFasilitasList(), 0, 4) as $fas)
                <div class="facility-chip"><i class="fa-solid {{ $fas['icon'] }} fa-xs"></i> {{ $fas['nama'] }}</div>
            @endforeach
            @if(count($kost->getFasilitasList()) > 4)
                <div class="facility-chip">+{{ count($kost->getFasilitasList()) - 4 }} lagi</div>
            @endif
        </div>
        @if($kost->jarak_kampus !== null)
        <div class="kost-distance">
            <i class="fa-solid fa-route fa-xs"></i>
            {{ $kost->getJarakFormatted() }} dari UNSUR
        </div>
        @endif
    </div>
</a>
