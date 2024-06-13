@include('layout.header')
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <div id="kt_app_hero" class="app-hero py-6">
        <div id="kt_app_hero_container" class="app-container container-xxl d-flex">
            <div class="d-flex flex-stack flex-wrap flex-lg-nowrap flex-row-fluid gap-4 gap-lg-10 mb-10">
                <div class="d-flex align-items-center me-3">
                    <h1 class="page-heading d-flex text-white fw-bolder fs-2 flex-column justify-content-center my-0">{{$menu}}
                </div>
            </div>
        </div>
    </div>
    <div class="app-container container-xxl">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="d-flex flex-column flex-column-fluid">
                <div id="kt_app_content" class="app-content">
                    <div id="kt_app_toolbar" class="app-toolbar d-flex flex-column py-6">
                        <div class="app-toolbar-wrapper d-flex align-items-center flex-stack flex-wrap gap-2 py-4 w-100">
                            <div class="page-title d-flex flex-column justify-content-center gap-2 me-3">
                                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 m-0">Form {{$menu}}</h1>
                                {!!$breadcrumb!!}
                            </div>
                            <div class="d-flex align-items-center gap-2 gap-lg-3">
                                <a href="{{route('taskJawaban.index');}}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold"> <i class="fa fa-rotate"></i> Kembali</a>
                                <button style="display: none;" id="buttonPublishTask" class="btn btn-flex btn-success h-40px fs-7 fw-bold"> <i class="fa fa-save"></i> Publish</button>
                            </div>
                        </div>
                    </div>
                    <!--begin::Card-->
                    <div class="card mb-2">
                        <div class="card-body">
                            <input type="hidden" id="detail-task-id" value="{{$id_task}}">
                            <div class="row">
                                <div class="alert alert-success text-center" role="alert" id="alert-publish" style="display: none;">
                                    Published
                                </div>
                                <div class="alert alert-warning text-center" role="alert" id="alert-draft" style="display: none;">
                                    Draft
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4 fv-row">
                                        <label class="required form-label">Kode</label>
                                        <input type="text" id="detail-task-kode" class="form-control mb-2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 fv-row">
                                        <label class="required form-label">Nama Kegiatan</label>
                                        <input type="text" id="detail-task-nama" class="form-control mb-2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 fv-row">
                                        <label class="required form-label">Tanggal Kegiatan</label>
                                        <input type="date" id="detail-task-tanggal" class="form-control mb-2">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card px-4 mb-4">
                                        <div class="card-body">
                                            <h2>Domisili Kegiatan</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Provinsi Domisili</label>
                                                    <input type="text" id="detail-task-provinsi" class="form-control mb-2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Kota/Kabupaten Domisili</label>
                                                    <input type="text" id="detail-task-kota" class="form-control mb-2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Kecamatan Domisili</label>
                                                    <input type="text" id="detail-task-kecamatan" class="form-control mb-2">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Kelurahan Domisili</label>
                                                    <input type="text" id="detail-task-kelurahan" class="form-control mb-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 fv-row">
                                        <label class="required form-label">Surveyor</label>
                                        <input type="text" id="detail-task-surveyor" class="form-control mb-2">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4 fv-row">
                                        <label class="required form-label">Jenis Kegiatan</label>
                                        <input type="text" id="detail-task-kegiatan" class="form-control mb-2">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4 fv-row">
                                        <label class="required form-label">Objek</label>
                                        <input type="text" id="detail-task-objek" class="form-control mb-2">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card px-4 mb-4">
                                        <div class="card-body" id="divPilihan">
                                            <h2>Jawaban</h2>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableJawabanPertanyaanTask">
                                                <thead>
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                        <th>No Urut</th>
                                                        <th class="min-w-125px">Pertanyaan</th>
                                                        <th>Jawaban Survey</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade modal-xl" id="detailModalJawaban" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel">Detail Data</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" id="detail-id_task_jawaban">
                                                <input type="hidden" id="detail-jenis_pertanyaan">
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Pertanyaan:</label>
                                                    <input type="text" class="form-control" id="detail-task_pertanyaan_jawaban">
                                                </div>
                                                <div>
                                                    <label class="required form-label">Jawaban:</label>
                                                    <div id="detail-jawaban-container">
                                                    </div>
                                                </div>
                                                
                                                <hr>
                                                <div class="mb-4 fv-row">
                                                    <label class="required form-label">Jawaban baru:</label>
                                                    <div id="list-jawaban-baru"></div>
                                                    
                                                </div>
                                                <div class="mb-4 fv-row">
                                                    <button id="updateJawabanAction" class="btn btn-flex btn-warning h-40px fs-7 fw-bold"> <i class="fa fa-save"></i> Update Jawaban</button>
                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Content wrapper-->

        </div>
        <!--end:::Main-->
    </div>
    <!--end::Wrapper container-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var id_task = $('#detail-task-id').val();
        var url = "{{ route('task.showDetailTask', ':id_task') }}";
        url = url.replace(':id_task', id_task);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#detail-task-kode').val(response.kode_task).prop('disabled', true);
                $('#detail-task-nama').val(response.nama_task).prop('disabled', true);
                $('#detail-task-tanggal').val(response.tanggal_task).prop('disabled', true);

                $('#detail-task-surveyor').val(response.surveyor).prop('disabled', true);
                $('#detail-task-kelurahan').val(response.kelurahan_nama).prop('disabled', true);
                $('#detail-task-kecamatan').val(response.kecamatan_nama).prop('disabled', true);
                $('#detail-task-kota').val(response.kabkota_nama).prop('disabled', true);
                $('#detail-task-provinsi').val(response.provinsi_nama).prop('disabled', true);
                $('#detail-task-kegiatan').val(response.kegiatan).prop('disabled', true);
                $('#detail-task-objek').val(response.objek).prop('disabled', true);

                if (response.publish_task === 'Y') {
                    $('#buttonPublishTask').hide();
                    $('#alert-publish').show();
                    $('#alert-draft').hide();

                } else {
                    $('#buttonPublishTask').show();
                    $('#alert-publish').hide();
                    $('#alert-draft').show();
                }
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    $('#dataDetail').html('<p>Data not found</p>');
                } else {
                    $('#dataDetail').html('<p>An error occurred</p>');
                }
            }
        });
    });

    $(document).ready(function() {
        $('#updateJawabanAction').click(function(e) {
            e.preventDefault();
            var id_task_jawaban = $('#detail-id_task_jawaban').val();
            var jenis_pertanyaan = $('#detail-jenis_pertanyaan').val();

            if(jenis_pertanyaan === "M"){
                var pilihanValue = [];
                $('#list-jawaban-baru input[type="checkbox"]:checked').each(function() {
                    pilihanValue.push($(this).val());
                });
            }else if(jenis_pertanyaan === "S"){
                var pilihanValue = $('input[name="radioPilihan"]:checked').val();
                
            }else if(jenis_pertanyaan === "F"){
                var pilihanValue = $('#jawabanPertanyaan').val();
            }else{
                var pilihanValue = $('#jawabanPertanyaan').val();
            }

            // alert(pilihanValue);
            // Menampilkan alert konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengubah jawaban ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('updateJawabanTaskAction') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_task_jawaban: id_task_jawaban,
                            jenis_pertanyaan: jenis_pertanyaan,
                            pilihanValue: pilihanValue
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data Berhasil Disimpan',
                                icon: 'success'
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Data Gagal Disimpan', 'error');
                        }
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        var id_task = $('#detail-task-id').val();
        // alert(kabkota_kode);
        var url = "{{ route('taskjawaban.detailTaskJawaban', ':id_task') }}";
        url = url.replace(':id_task', id_task);
        Swal.fire({
            title: 'Loading...',
            text: 'Sedang memuat data',
            didOpen: () => {
                Swal.showLoading()
            },
            allowOutsideClick: false
        });
        $('#tableJawabanPertanyaanTask').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'pertanyaan',
                    name: 'pertanyaan'
                },
                {
                    data: 'list_pilihan_field',
                    name: 'list_pilihan_field',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'view_button',
                    name: 'view_button',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        Swal.close();

        $(document).on('click', '.close', function() {
                $('#detailModalJawaban').modal('hide');
            });

        $(document).on('click', '.btn-view-detail-jawaban', function() {
            var id_task_jawaban = $(this).data('id');
            var url = "{{ route('taskjawaban.showDetailTaskPertanyaanJawaban', ':id_task_jawaban') }}";
            url = url.replace(':id_task_jawaban', id_task_jawaban);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#detail-task_pertanyaan_jawaban').val(response.pertanyaan).prop('disabled', true);
                    $('#detail-id_task_jawaban').val(response.id_task_jawaban);
                    $('#detail-jawaban').val(response.jawaban);
                    $('#detail-jenis_pertanyaan').val(response.jenis_pertanyaan);
                    

                    $('#detail-jawaban-container').empty();

                    if(response.jenis_pertanyaan === 'M'){
                        let jawabanArray = response.jawaban.split('|||');
                        jawabanArray.forEach(function(jawaban, index) {
                            let checkbox = $('<input>').attr({
                                type: 'checkbox',
                                id: `jawaban${index}`,
                                name: `jawaban${index}`,
                                value: jawaban,
                                class: 'form-check-input',
                                checked: true, 
                                disabled: true
                            });
                            let label = $('<label>').text(jawaban).attr('for', `jawaban${index}`).addClass('form-check-label');
                            let div = $('<div>').addClass('form-check mb-4').append(checkbox).append(label);
                            $('#detail-jawaban-container').append(div);
                            fetchPilihanJawabanCheck(response.id_pertanyaan);
                        });
                    }else if(response.jenis_pertanyaan ==='S'){
                        let jawabanObject = response.jawaban;
                        let index = 0;
                        let radio = $('<input>').attr({
                            type: 'radio',
                            id: `jawaban${index}`,
                            name: 'jawaban', 
                            value: jawabanObject,
                            class: 'form-check-input',
                            checked: true,   
                            disabled: true   
                        });
                        let label = $('<label>').text(jawabanObject).attr('for', `jawaban${index}`).addClass('form-check-label');
                        let div = $('<div>').addClass('form-check').append(radio).append(label);
                        $('#detail-jawaban-container').append(div);
                        fetchPilihanJawabanRadio(response.id_pertanyaan);
                    }else if(response.jenis_pertanyaan ==='F'){
                        let jawabanObject = response.jawaban;
                        let index = 0;
                        let input = $('<input>').attr({
                            type: 'text',
                            id: `jawaban${index}`,
                            name: 'jawaban',
                            value: jawabanObject,
                            class: 'form-control',
                            disabled: true
                        });
                        let label = $('<label>').text(jawabanObject).attr('for', `jawaban${index}`).addClass('form-label');
                        let div = $('<div>').addClass('form-group').append(input);
                        $('#detail-jawaban-container').append(div);
                        var $inputContainer = $('#list-jawaban-baru');
                        $inputContainer.empty();
                        $inputContainer.append('<div class="mb-4 form-group"><input class="form-control" type="text" id="jawabanPertanyaan" name="jawabanPertanyaan" value=""></div>');
                    }else{
                    }
                    
                    
                    $('#detailModalJawaban').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        function fetchPilihanJawabanCheck(id_pertanyaan) {
            var id_pertanyaan = id_pertanyaan;
            var url = "{{ route('getPilihanPertanyaan', ':id_pertanyaan') }}";
            url = url.replace(':id_pertanyaan', id_pertanyaan);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    var $checkboxContainer = $('#list-jawaban-baru');
                    $checkboxContainer.empty();
                    data.forEach(function(item) {
                        $checkboxContainer.append('<div class="form-check mb-4"><input class="form-check-input" type="checkbox" id="checkbox_' + item.id_pertanyaan_pilihan + '" name="checkPilihan[]" value="' + item.pilihan + '"><label class="form-check-label" for="checkbox_' + item.id_pertanyaan_pilihan + '">' + item.pilihan + '</label></div>');
                        
                    });
                },
                error: function(xhr) {
                    console.error('An error occurred while fetching kegiatan data');
                }
            });
        }

        function fetchPilihanJawabanRadio(id_pertanyaan) {
            var id_pertanyaan = id_pertanyaan;
            var url = "{{ route('getPilihanPertanyaan', ':id_pertanyaan') }}";
            url = url.replace(':id_pertanyaan', id_pertanyaan);
            
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    var $radioContainer = $('#list-jawaban-baru');
                    $radioContainer.empty();
                    
                    if (Array.isArray(data)) {
                        data.forEach(function(item) {
                            $radioContainer.append('<div class="form-check mb-4"><input class="form-check-input" type="radio" id="radio_' + item.id_pertanyaan_pilihan + '" name="radioPilihan" value="' + item.pilihan + '"><label class="form-check-label" for="radio_' + item.id_pertanyaan_pilihan + '">' + item.pilihan + '</label></div>');
                        });
                    } else {
                        console.error('Expected an array from server, but received:', data);
                    }
                },
                error: function(xhr) {
                    console.error('An error occurred while fetching pilihan pertanyaan data');
                }
            });
        }

    });


    
</script>

@include('layout.footer')