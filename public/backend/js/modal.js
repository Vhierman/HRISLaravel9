// Modal School
$('#SchoolModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var namasekolah = button.data('namasekolah')
    var noteleponsekolah = button.data('noteleponsekolah')
    var alamatsekolah = button.data('alamatsekolah')
    var emailsekolah = button.data('emailsekolah')
    var namagurupembimbing = button.data('namagurupembimbing')
    var nohpgurupembimbing = button.data('nohpgurupembimbing')
    var modal = $(this)
    modal.find('.modal-body #namasekolah').val(namasekolah);
    modal.find('.modal-body #noteleponsekolah').val(noteleponsekolah);
    modal.find('.modal-body #alamatsekolah').val(alamatsekolah);
    modal.find('.modal-body #emailsekolah').val(emailsekolah);
    modal.find('.modal-body #namagurupembimbing').val(namagurupembimbing);
    modal.find('.modal-body #nohpgurupembimbing').val(nohpgurupembimbing);

});
// End Modal School

// Modal Student
$('#StudentModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var nissiswa = button.data('nissiswa')
    var namasiswa = button.data('namasiswa')
    var namasekolah = button.data('namasekolah')
    var penempatan = button.data('penempatan')
    var tanggalmasukpkl = button.data('tanggalmasukpkl')
    var tanggalselesaipkl = button.data('tanggalselesaipkl')
    var tempatlahirsiswa = button.data('tempatlahirsiswa')
    var tanggallahirsiswa = button.data('tanggallahirsiswa')
    var jeniskelaminsiswa = button.data('jeniskelaminsiswa')
    var agamasiswa = button.data('agamasiswa')
    var alamatsiswa = button.data('alamatsiswa')
    var nohandphonesiswa = button.data('nohandphonesiswa')
    var jurusan = button.data('jurusan')
    var modal = $(this)
    modal.find('.modal-body #nissiswa').val(nissiswa);
    modal.find('.modal-body #namasiswa').val(namasiswa);
    modal.find('.modal-body #namasekolah').val(namasekolah);
    modal.find('.modal-body #penempatan').val(penempatan);
    modal.find('.modal-body #tanggalmasukpkl').val(tanggalmasukpkl);
    modal.find('.modal-body #tanggalselesaipkl').val(tanggalselesaipkl);
    modal.find('.modal-body #tempatlahirsiswa').val(tempatlahirsiswa);
    modal.find('.modal-body #tanggallahirsiswa').val(tanggallahirsiswa);
    modal.find('.modal-body #jeniskelaminsiswa').val(jeniskelaminsiswa);
    modal.find('.modal-body #agamasiswa').val(agamasiswa);
    modal.find('.modal-body #alamatsiswa').val(alamatsiswa);
    modal.find('.modal-body #nohandphonesiswa').val(nohandphonesiswa);
    modal.find('.modal-body #jurusan').val(jurusan);
});
// End Modal Student

// Modal Internship
$('#InternshipModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var nikmagang                   = button.data('nikmagang')
    var namamagang                  = button.data('namamagang')
    var jabatan                     = button.data('jabatan')
    var penempatan                  = button.data('penempatan')
    var tanggalmasukmagang          = button.data('tanggalmasukmagang')
    var tanggalselesaimagang        = button.data('tanggalselesaimagang')
    var tempatlahirmagang           = button.data('tempatlahirmagang')
    var tanggallahirmagang          = button.data('tanggallahirmagang')
    var agamamagang                 = button.data('agamamagang')
    var jeniskelaminmagang          = button.data('jeniskelaminmagang')
    var nomorhandphonemagang        = button.data('nomorhandphonemagang')
    var pendidikanterakhir_magang   = button.data('pendidikanterakhir_magang')
    var alamatmagang                = button.data('alamatmagang')
    var rtmagang                    = button.data('rtmagang')
    var rwmagang                    = button.data('rwmagang')
    var kelurahanmagang             = button.data('kelurahanmagang')
    var kecamatanmagang             = button.data('kecamatanmagang')
    var kotamagang                  = button.data('kotamagang')
    var provinsimagang              = button.data('provinsimagang')

    var modal = $(this)
    modal.find('.modal-body #nikmagang').val(nikmagang);
    modal.find('.modal-body #namamagang').val(namamagang);
    modal.find('.modal-body #jabatan').val(jabatan);
    modal.find('.modal-body #penempatan').val(penempatan);
    modal.find('.modal-body #tanggalmasukmagang').val(tanggalmasukmagang);
    modal.find('.modal-body #tanggalselesaimagang').val(tanggalselesaimagang);
    modal.find('.modal-body #tempatlahirmagang').val(tempatlahirmagang);
    modal.find('.modal-body #tanggallahirmagang').val(tanggallahirmagang);
    modal.find('.modal-body #agamamagang').val(agamamagang);
    modal.find('.modal-body #jeniskelaminmagang').val(jeniskelaminmagang);
    modal.find('.modal-body #nomorhandphonemagang').val(nomorhandphonemagang);
    modal.find('.modal-body #pendidikanterakhir_magang').val(pendidikanterakhir_magang);
    modal.find('.modal-body #alamatmagang').val(alamatmagang);
    modal.find('.modal-body #rtmagang').val(rtmagang);
    modal.find('.modal-body #rwmagang').val(rwmagang);
    modal.find('.modal-body #kelurahanmagang').val(kelurahanmagang);
    modal.find('.modal-body #kecamatanmagang').val(kecamatanmagang);
    modal.find('.modal-body #kotamagang').val(kotamagang);
    modal.find('.modal-body #provinsimagang').val(provinsimagang);

});
// End Modal Employee

// Modal Employee
$('#EmployeeModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var namaperusahaan      = button.data('namaperusahaan')
    var nikkaryawan         = button.data('nikkaryawan')
    var namakaryawan        = button.data('namakaryawan')
    var jabatan             = button.data('jabatan')
    var penempatan          = button.data('penempatan')
    var jammasuk            = button.data('jammasuk')
    var emailkaryawan       = button.data('emailkaryawan')
    var nomorabsen          = button.data('nomorabsen')
    var nomornpwp           = button.data('nomornpwp')
    var tempatlahir         = button.data('tempatlahir')
    var tanggallahir        = button.data('tanggallahir')
    var agama               = button.data('agama')
    var jeniskelamin        = button.data('jeniskelamin')
    var pendidikanterakhir  = button.data('pendidikanterakhir')
    var golongandarah       = button.data('golongandarah')
    var alamat              = button.data('alamat')
    var rt                  = button.data('rt')
    var rw                  = button.data('rw')
    var kelurahan           = button.data('kelurahan')
    var kecamatan           = button.data('kecamatan')
    var kota                = button.data('kota')
    var nomorjkn            = button.data('nomorjkn')
    var nomorjht            = button.data('nomorjht')
    var statusnikah         = button.data('statusnikah')
    var nomorkartukeluarga  = button.data('nomorkartukeluarga')
    var namaayah            = button.data('namaayah')
    var namaibu             = button.data('namaibu')
    var statuskerja         = button.data('statuskerja')
    var tanggalmulaikerja   = button.data('tanggalmulaikerja')
    var tanggalakhirkerja   = button.data('tanggalakhirkerja')
    var namabank            = button.data('namabank')
    var nomorrekening       = button.data('nomorrekening')

    var modal = $(this)
    modal.find('.modal-body #namaperusahaan').val(namaperusahaan);
    modal.find('.modal-body #nikkaryawan').val(nikkaryawan);
    modal.find('.modal-body #namakaryawan').val(namakaryawan);
    modal.find('.modal-body #jabatan').val(jabatan);
    modal.find('.modal-body #penempatan').val(penempatan);
    modal.find('.modal-body #jammasuk').val(jammasuk);
    modal.find('.modal-body #emailkaryawan').val(emailkaryawan);
    modal.find('.modal-body #nomorabsen').val(nomorabsen);
    modal.find('.modal-body #nomornpwp').val(nomornpwp);
    modal.find('.modal-body #tempatlahir').val(tempatlahir);
    modal.find('.modal-body #tanggallahir').val(tanggallahir);
    modal.find('.modal-body #agama').val(agama);
    modal.find('.modal-body #jeniskelamin').val(jeniskelamin);
    modal.find('.modal-body #pendidikanterakhir').val(pendidikanterakhir);
    modal.find('.modal-body #golongandarah').val(golongandarah);
    modal.find('.modal-body #alamat').val(alamat);
    modal.find('.modal-body #rt').val(rt);
    modal.find('.modal-body #rw').val(rw);
    modal.find('.modal-body #kelurahan').val(kelurahan);
    modal.find('.modal-body #kecamatan').val(kecamatan);
    modal.find('.modal-body #kota').val(kota);
    modal.find('.modal-body #nomorjkn').val(nomorjkn);
    modal.find('.modal-body #nomorjht').val(nomorjht);
    modal.find('.modal-body #statusnikah').val(statusnikah);
    modal.find('.modal-body #nomorkartukeluarga').val(nomorkartukeluarga);
    modal.find('.modal-body #namaayah').val(namaayah);
    modal.find('.modal-body #namaibu').val(namaibu);
    modal.find('.modal-body #statuskerja').val(statuskerja);
    modal.find('.modal-body #tanggalmulaikerja').val(tanggalmulaikerja);
    modal.find('.modal-body #tanggalakhirkerja').val(tanggalakhirkerja);
    modal.find('.modal-body #rw').val(rw);
    modal.find('.modal-body #namabank').val(namabank);
    modal.find('.modal-body #nomorrekening').val(nomorrekening);

});
// End Modal Employee