<?php

namespace Database\Seeders;

use App\Models\{ProfilDesa, Misi, Dusun, FasePemerintahan, KepalaDesa, TokohDesa};
use Illuminate\Database\Seeder;

class ProfilDesaSeeder extends Seeder
{
    public function run(): void
    {
        ProfilDesa::updateOrCreate(['id' => 1], [
            'visi' => 'Gotong royong, membangun Desa Jiwut yang jujur, adil, sejahtera, berbudaya dan berakhlak mulia',
            'video_profil_url' => 'https://youtu.be/2c6uIQJjIrI?si=NLsmEfyoEz1m2Pw0', // sementara, nanti diganti admin
            'sejarah_intro' => 'Sejarah Desa Jiwut diwariskan turun-temurun dari generasi ke generasi, sering kali dikaitkan dengan kisah-kisah asal-usul tempat yang dianggap sakral. Desa Jiwut terdiri dari lima dusun, masing-masing punya riwayat asal-usulnya sendiri.',
            'sejarah_penutup' => 'Berdirinya Desa Jiwut diperkirakan pada pertengahan abad ke-18, diawali kedatangan pengembara dari Surakarta yang menempati wilayah Ngrobyong dan Baran...',
            'sejarah_pemerintahan_intro' => 'Sebagai bagian dari Kecamatan Nglegok dalam wilayah Negara Kesatuan Republik Indonesia, sistem pemerintahan Desa Jiwut mengalami beberapa fase perubahan mengikuti regulasi nasional:',
        ]);

        foreach ([
            'Mempublikasikan setiap anggaran kegiatan agar masyarakat mengetahui semua kegiatan pemerintah desa',
            'Melaksanakan musyawarah dusun untuk menampung aspirasi masyarakat',
            'Meningkatkan kapasitas perangkat desa',
            'Mewujudkan perekonomian dan kesejahteraan warga desa',
            'Meningkatkan pelayanan kesehatan masyarakat desa yang maksimal',
            'Meningkatkan kehidupan desa secara dinamis dalam segi keagamaan dan kebudayaan',
        ] as $i => $isi) {
            Misi::create(['isi' => $isi, 'urutan' => $i]);
        }

        foreach ([
            ['Dusun Ngrobyong', 'Konon, dahulu di wilayah ini tumbuh sebatang pohon durian yang usianya sudah sangat tua...'],
            ['Dusun Darungan', 'Kisah asal-usul dusun ini bermula dari seorang perantau asal Solo bernama Karso Suwito...'],
            ['Dusun Klampok', 'Wilayah ini pertama kali dibuka oleh seorang tokoh bernama Ngerpani...'],
            ['Dusun Jiwut', 'Nama dusun ini berasal dari keberadaan sebatang pohon Kuwut yang tumbuh tinggi menjulang...'],
            ['Dusun Bendil', 'Berbeda dengan dusun lainnya, Dusun Bendil sebenarnya merupakan gabungan dari tiga wilayah...'],
        ] as $i => $d) {
            Dusun::create(['nama' => $d[0], 'deskripsi' => $d[1], 'urutan' => $i]);
        }

        foreach ([
            ['Sebelum UU No. 5 Tahun 1979', 'Pemerintahan desa masih memakai tradisi lama dengan sebutan Lurah, Carik, Kamituwo, Kebayan, Jogotirto, Jogoboyo, dan Modin.'],
            ['UU No. 5 Tahun 1979', 'Struktur pemerintah desa diseragamkan secara nasional: Kepala Desa (masa jabatan 8 tahun), Sekretaris Desa, Kepala Urusan, dan Kamituwo. Lembaga legislatifnya adalah Lembaga Musyawarah Desa (LMD).'],
            ['UU No. 22 Tahun 1999', 'Masa jabatan Kepala Desa menjadi 2 x 5 tahun (10 tahun). Legislatif berubah menjadi Badan Perwakilan Desa (BPD).'],
            ['UU No. 32 Tahun 2004', 'Masa jabatan Kepala Desa menjadi 6 tahun, Sekretaris Desa diisi oleh PNS Kabupaten. BPD berubah nama menjadi Badan Permusyawaratan Desa.'],
            ['UU No. 6 Tahun 2014 — Sekarang', 'Masa jabatan Kepala Desa tetap 6 tahun, aturan ini yang masih berlaku hingga saat ini.'],
        ] as $i => $f) {
            FasePemerintahan::create(['periode' => $f[0], 'deskripsi' => $f[1], 'urutan' => $i]);
        }

        foreach ([
            ['Goeno Karijo Redjo', '1895 – 1905', false],
            ['Iro Dikromo', '1905 – 1922', false],
            ['Djoyo Sentono', '1922 – 1932', false],
            ['H. Djaelani', '1932 – 1949', false],
            ['Soeradji', '1945 – 1972', false],
            ['Hadi Poernomo', '1972 – 1989', false],
            ['Zaenudin', '1989 – 1997', false],
            ['Muh. Fakih Hudin', '1998 – 2013', false],
            ['Kasbolah', '2013 – 2019', false],
            ['Yanwar', '2019 – Sekarang', true],
        ] as $i => $k) {
            KepalaDesa::create(['nama' => $k[0], 'masa_jabatan' => $k[1], 'is_aktif' => $k[2], 'urutan' => $i]);
        }

        foreach ([
            ['Sanusi', 'RT2 RW8', '1930-2005', '-'],
            ['H. Dimyati', 'RT3 RW6', '1935-1980', 'Agama'],
            ['H. Danuri', 'RT3 RW5', '1935-1975', 'Agama'],
            // ... lanjutkan sisanya sesuai data asli
        ] as $i => $t) {
            TokohDesa::create(['nama' => $t[0], 'alamat' => $t[1], 'tahun' => $t[2], 'unsur' => $t[3], 'urutan' => $i]);
        }

    }
}