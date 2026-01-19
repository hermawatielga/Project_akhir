@include('layouts.navbar2')
@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .card-pretty {
            border: none;
            border-radius: 24px;
            background: var(--glass-bg);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(10px);
        }

        .profile-section {
            background: #f1f5f9;
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }

        .avatar-circle {
            width: 60px;
            height: 60px;
            background: var(--primary-gradient);
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 10px;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
        }

        /* Map Style */
        #map {
            height: 180px;
            width: 100%;
            border-radius: 15px;
            margin-bottom: 10px;
            border: 2px solid #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .btn-submit-presence {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .btn-submit-presence:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 20px -5px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .gps-status {
            font-size: 11px;
            padding: 6px 12px;
            border-radius: 8px;
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        .gps-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .gps-loading {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fef08a;
        }

        .gps-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>

    <div class="container mt-4 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="text-center mb-3">
                    <h3 class="fw-bold text-dark text-uppercase mb-0">Portal Absensi</h3>
                    <p class="text-muted small">Silakan verifikasi lokasi Anda</p>
                </div>

                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-3 d-flex align-items-center small">
                        <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-3 d-flex align-items-center small">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <div class="card card-pretty">
                    <div class="card-body p-4">
                        {{-- Profile & Map Section --}}
                        <div class="profile-section text-center">
                            <div class="avatar-circle">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            <h5 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h5>

                            <div class="mb-3">
                                <span class="badge bg-white text-dark border px-3 py-2 rounded-pill small">
                                    <i class="bi bi-clock-fill me-1 text-primary"></i>
                                    <span id="liveClock">{{ date('H:i:s') }}</span> WIB
                                </span>
                            </div>

                            {{-- Leaflet Map Element --}}
                            <div id="map"></div>

                            <div id="gpsFeedback" class="gps-status gps-loading">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                <span id="gpsText">Menghubungkan satelit GPS...</span>
                            </div>
                        </div>

                        @if (!$absen)
                            <form action="{{ route('absensi.masuk') }}" method="POST" enctype="multipart/form-data"
                                id="formAbsensi">
                                @csrf
                                <input type="hidden" name="latitude" id="latInput">
                                <input type="hidden" name="longitude" id="lngInput">

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Opsi
                                        Kehadiran</label>
                                    <select name="status" id="statusKehadiran" class="form-select shadow-sm" required
                                        onchange="toggleUpload()">
                                        <option value="hadir">✅ Hadir di Lokasi</option>
                                        <option value="sakit">🤒 Sedang Sakit</option>
                                        <option value="izin">✉️ Izin Keperluan</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="uploadSuratContainer" style="display: none;">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Unggah
                                        Bukti</label>
                                    <input type="file" name="dokumen" class="form-control" id="fileInput"
                                        accept="image/*,application/pdf">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary small text-uppercase">Keterangan
                                        (Opsional)</label>
                                    <textarea name="keterangan" class="form-control shadow-sm" rows="2" placeholder="Tulis catatan jika ada..."></textarea>
                                </div>

                                <button type="submit" id="btnSubmit" class="btn btn-submit-presence w-100 py-3" disabled>
                                    <i class="bi bi-fingerprint me-2"></i> KONFIRMASI ABSENSI
                                </button>
                            </form>
                        @elseif($absen->jam_pulang == null && $absen->status == 'hadir')
                            <div class="text-center">
                                <div class="p-3 bg-light rounded-4 border mb-3">
                                    <small class="text-uppercase fw-bold text-muted d-block mb-1">Jam Masuk</small>
                                    <h3 class="fw-bold text-primary mb-0">{{ $absen->jam_masuk }}</h3>
                                </div>
                                <form action="{{ route('absensi.pulang') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="latitude" id="latInputPulang">
                                    <input type="hidden" name="longitude" id="lngInputPulang">

                                    <button type="submit" id="btnSubmitPulang"
                                        class="btn btn-danger w-100 py-3 rounded-4 shadow-sm fw-bold" disabled>
                                        <i class="bi bi-box-arrow-right me-2"></i> PULANG SEKARANG
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="bi bi-check-all text-success" style="font-size: 4rem;"></i>
                                <h5 class="fw-bold">Absensi Selesai</h5>
                                <p class="text-muted small">Terima kasih, kerja keras Anda hari ini sudah tercatat.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let map, marker;

        // Fungsi Inisialisasi/Update Map
        function updateMap(lat, lng) {
            if (!map) {
                map = L.map('map', {
                    zoomControl: false
                }).setView([lat, lng], 17);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                marker = L.marker([lat, lng]).addTo(map);
            } else {
                map.setView([lat, lng], 17);
                marker.setLatLng([lat, lng]);
            }
        }
function getLocation() {
    const gpsFeedback = document.getElementById('gpsFeedback');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnSubmitPulang = document.getElementById('btnSubmitPulang'); // Tambahkan ini agar tombol pulang juga aktif

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Isi koordinat untuk form MASUK dan PULANG
                if(document.getElementById('latInput')) document.getElementById('latInput').value = lat;
                if(document.getElementById('lngInput')) document.getElementById('lngInput').value = lng;
                if(document.getElementById('latInputPulang')) document.getElementById('latInputPulang').value = lat;
                if(document.getElementById('lngInputPulang')) document.getElementById('lngInputPulang').value = lng;

                // Update Map
                updateMap(lat, lng);

                // Update UI Feedback
                gpsFeedback.className = "gps-status gps-success mt-2";
                gpsFeedback.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Lokasi Terkunci';

                // Aktifkan tombol yang ada
                if (btnSubmit) btnSubmit.disabled = false;
                if (btnSubmitPulang) btnSubmitPulang.disabled = false;
            },
            (error) => {
                gpsFeedback.className = "gps-status gps-error mt-2";
                gpsFeedback.innerHTML = `
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Gagal: ${error.message}
                    <button type="button" onclick="getLocation()" class="btn btn-sm btn-outline-danger ms-2 py-0" style="font-size:10px">Coba Lagi</button>
                `;
            }, 
            {
                enableHighAccuracy: false, // UBAH KE FALSE: Agar tidak memaksakan satelit (jauh lebih cepat)
                timeout: 10000,            // Menunggu maksimal 10 detik
                maximumAge: 30000          // Gunakan cache lokasi jika tersedia dalam 30 detik terakhir
            }
        );
    } else {
        gpsFeedback.innerHTML = "Browser tidak mendukung GPS.";
    }
}
        function toggleUpload() {
            const status = document.getElementById('statusKehadiran').value;
            const container = document.getElementById('uploadSuratContainer');
            const fileInput = document.getElementById('fileInput');

            if (status !== 'hadir') {
                container.style.display = 'block';
                fileInput.setAttribute('required', 'required');
            } else {
                container.style.display = 'none';
                fileInput.removeAttribute('required');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            getLocation();
            setInterval(() => {
                const now = new Date();
                document.getElementById('liveClock').innerText = now.toTimeString().split(' ')[0];
            }, 1000);
        });
    </script>
@endsection
