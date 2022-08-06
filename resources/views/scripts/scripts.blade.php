
<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>


<!-- appointment table data search -->

<script>
    toastr.options.preventDuplicates = true;

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function(){

        //=====================================================Get all Appointments=============================================
        $('#appointments-table').DataTable({
            processing:false,
            info:true,
            ajax:"{{ route('get.appointment.list')}}",
            "pageLength":5,
            "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
            columns:[
                // {data:'id', name:'id'},
                // {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'full_name', name:'full_name'},
                {data:'mobile_number', name:'mobile_number'},
                {data:'service_cost', name:'service_cost'},
                {data:'service_type', name:'service_type', orderable:false, searchable:false},
                {data:'bike_model', name:'bike_model', orderable:false, searchable:false},
                {data:'date', name:'date'},
                {data:'time', name:'time'},
                {data:'user_type', name:'user_type', orderable:false, searchable:false},
                {data:'membership', name:'membership', orderable:false, searchable:false},
                {data:'status', name:'status', orderable:false, searchable:false},
                {data:'percentage', name:'percentage'},
                {data:'actions', name:'actions', orderable:false, searchable:false},
            ]
        });


        //=========================================================add guest appointment===================================
        $(document).on('click','#guestAppointmentBtn', function(){
            var appointment_id = $(this).data('id');
            // alert(appointment_id);

            $.post('<?= route("admin.add.guest.appointment") ?>', function(data){
                // alert('test');

                $('.addGuestAppointment').find('form')[0].reset();
                $('.addGuestAppointment').find('span.error-text').text('');

                $('.addGuestAppointment').modal('show');
            },'json');
        });

        //=====================================================add guest appointment=====================================

        $('#add-appointment-form').on('submit', function(e){
            e.preventDefault();
            //alert('hello test');

            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                    $(form).find('span.error-text').text('');
                },
                success:function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else if(data.code == 2){
                        toastr.error(data.msg);
                    }else{
                        $('#appointments-table').DataTable().ajax.reload(null, false);
                        $('.addGuestAppointment').modal('hide');
                        $('.addGuestAppointment').find('form')[0].reset();
                        toastr.success(data.msg);
                    }
                }
            });
        });

        //===========================================================edit get details==================================================
        $(document).on('click','#editAppointmentBtn', function(){
            var appointment_id = $(this).data('id');
            //alert(appointment_id);

            $.post('<?= route("get.appointment.details") ?>',{appointment_id:appointment_id}, function(data){
                //alert(data.details.full_name);
                //console.log(data.details.full_name);

                $('.editAppointment').find('input[name="cid"]').val(data.details.id);
                $('.editAppointment').find('input[name="full_name"]').val(data.details.full_name);
                $('.editAppointment').find('input[name="service_cost"]').val(data.details.service_cost);
                $('.editAppointment').find('input[name="mobile_number"]').val(data.details.mobile_number);
                $('.editAppointment').find('select[name="service_type"]').val(data.details.service_type);
                $('.editAppointment').find('select[name="membership"]').val(data.details.membership);
                $('.editAppointment').find('select[name="user_type"]').val(data.details.user_type);
                $('.editAppointment').find('select[name="bike_model"]').val(data.details.bike_model);
                $('.editAppointment').find('input[name="date"]').val(data.details.date);
                $('.editAppointment').find('input[name="time"]').val(data.details.time);

                $('.editAppointment').modal('show');
            },'json');
        });


        // =============================================UPDATE COUNTRY DETAILS==============================================
        $('#update-appointment-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend: function(){
                    $(form).find('span.error-text').text('');
                },
                success: function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $('#appointments-table').DataTable().ajax.reload(null, false);
                        $('.editAppointment').modal('hide');
                        $('.editAppointment').find('form')[0].reset();
                        toastr.success(data.msg);
                    }
                }
            });
        });


        //guest service type for amount add
        $(function(){
            $("#guest_service_type").change(function(){
                var user_id = this.value;
                $.ajax({
                        url: '/getActiveService/'+user_id,
                        type: 'get',
                        dataType: 'json',
                        success: function(response){

                            $("#guest_amount").val(response[0]['price']);
                            // $("#service_type").val(response[0]['service_title']);

                        }
                    }
                );

            });
        });



        //=======================================================DELETE COUNTRY RECORD=======================================================
        $(document).on('click','#deleteAppointmentBtn', function(){
            var appointment_id = $(this).data('id');

            // alert(appointment_id)

            var url = '<?= route("delete.appointment") ?>';

            Swal.fire({
                title:'Are you sure?',
                html:'You want to <b>delete</b> this appointment',
                showCancelButton:true,
                showCloseButton:true,
                cancelButtonText:'Cancel',
                confirmButtonText:'Yes, Delete',
                cancelButtonColor:'#d33',
                confirmButtonColor:'#556ee6',
                width:300,
                allowOutsideClick:false
            }).then(function(result){
                if(result.value){
                    $.post(url,{appointment_id:appointment_id}, function(data){
                        if(data.code == 1){
                            $('#appointments-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }else{
                            toastr.error(data.msg);
                        }
                    },'json');
                }
            });
        });


        //=====================================================Today Appointments=============================================
        $('#today-appointments-table').DataTable({
            processing:false,
            info:true,
            ajax:"{{ route('get.today.appointment')}}",
            "pageLength":5,
            "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
            columns:[
                // {data:'id', name:'id'},
                // {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'full_name', name:'full_name'},
                {data:'membership', name:'membership', orderable:false, searchable:false},
                {data:'mobile_number', name:'mobile_number'},
                {data:'service_cost', name:'service_cost'},
                {data:'percentage', name:'percentage'},
                {data:'service_type', name:'service_type', orderable:false, searchable:false},
                {data:'bike_model', name:'bike_model', orderable:false, searchable:false},
                {data:'date', name:'date'},
                {data:'time', name:'time'},
                {data:'user_type', name:'user_type', orderable:false, searchable:false},
                {data:'status', name:'status', orderable:false, searchable:false},
            ]
        });


        //=======================================================Appointment Status Change=======================================================
        $(document).on('click','#appointmentStatusBtn', function(){
            var appointment_id = $(this).data('id');
            //alert(appointment_id);

            $.post('<?= route("get.today.appointment.details") ?>',{appointment_id:appointment_id}, function(data){
                //alert(data.details.full_name);
                //console.log(data.details.full_name);

                $('.changeStatus').find('input[name="cid"]').val(data.details.id);
                $('.changeStatus').find('select[name="status"]').val(data.details.status);

                $('.changeStatus').modal('show');
            },'json');

        });

        // =============================================Change state for appointment==============================================
        $('#status-change-appointment-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend: function(){
                    $(form).find('span.error-text').text('');
                },
                success: function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $('#today-appointments-table').DataTable().ajax.reload(null, false);
                        $('.changeStatus').modal('hide');
                        $('.changeStatus').find('form')[0].reset();
                        toastr.success(data.msg);
                    }
                }
            });
        });



        //=========================================Add current users appointment====================================================
        $(document).on('click','#userAppointmentBtn', function(){
            var appointment_id = $(this).data('id');
            //alert(appointment_id);

            $.post('<?= route("admin.new.users.add.appointment") ?>',{appointment_id:appointment_id}, function(data){
                //alert(data.details.full_name);
                //console.log(data.details.full_name);

                $('.addNewUsersAppointment').find('form')[0].reset();
                $('.addNewUsersAppointment').find('span.error-text').text('');

                $('.addNewUsersAppointment').modal('show');
            },'json');
        });

        // =============================================add current users appointment==============================================
        $('#add-new-appointment-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend: function(){
                    $(form).find('span.error-text').text('');
                },
                success: function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $('#appointments-table').DataTable().ajax.reload(null, false);
                        $('.addNewUsersAppointment').modal('hide');
                        $('.addNewUsersAppointment').find('form')[0].reset();
                        toastr.success(data.msg);
                    }
                }
            });
        });

        //roni's code
        //fill user information
        $(function(){
            $("#user_id").change(function(){
                var user_id = this.value;
                // console.log(user_id);

                $.ajax({
                        url: '/getActiveUser/'+user_id,
                        type: 'get',
                        dataType: 'json',
                        success: function(response){
                            // console.log(response[0]['first_name']);
                            $("#full_name").val(response[0]['first_name'] + ' ' + response[0]['last_name']);
                            $("#phone_number").val(response[0]['phone']);
                            $("#new_membership").val(response[0]['membership']);
                            // console.log($("#membership").val(response[0]['membership']));
                            $("#id").val(response[0]['id']);
                        }
                    }
                );
            });

        });

        //fill service amount
        $(function(){
            $("#service_title").change(function(){
                var status = this.value;
                $.ajax({
                        url: '/getActiveService/'+status,
                        type: 'get',
                        dataType: 'json',
                        success: function(response){
                            $("#new_user_amount").val(response[0]['price']);
                        }
                    }
                );

            });
        });


        //==========================================================Old user appointment==================================================
        $(document).on('click','#oldUserAppointmentBtn', function(){
            var appointment_id = $(this).data('id');
            //alert(appointment_id);

            $.post('<?= route("get.appointment.details") ?>',{appointment_id:appointment_id}, function(data){
                //alert(data.details.full_name);
                //console.log(data.details.full_name);

                // $('.oldUsersAppointment').find('input[name="id"]').val(data.details.id);
                $('.oldUsersAppointment').find('input[name="full_name"]').val(data.details.full_name);
                // $('.oldUsersAppointment').find('input[name="amount"]').val();
                $('.oldUsersAppointment').find('input[name="mobile_number"]').val(data.details.mobile_number);
                // $('.oldUsersAppointment').find('select[name="service_type"]').val(data.details.service_type);
                $('.oldUsersAppointment').find('select[name="user_type"]').val(data.details.user_type);
                // $('.editAppointment').find('select[name="membership"]').val(data.details.membership);
                $('.oldUsersAppointment').find('select[name="bike_model"]').val(data.details.bike_model);
                $('.oldUsersAppointment').find('input[name="date"]').val();
                $('.oldUsersAppointment').find('input[name="time"]').val();

                $('.oldUsersAppointment').modal('show');
            },'json');
        });

        // =============================================add old users appointment==============================================
        $('#old-users-appointment-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend: function(){
                    $(form).find('span.error-text').text('');
                },
                success: function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $('#appointments-table').DataTable().ajax.reload(null, false);
                        $('.oldUsersAppointment').modal('hide');
                        $('.oldUsersAppointment').find('form')[0].reset();
                        toastr.success(data.msg);
                    }
                }
            });
        });


        //Old user appointment
        $(function(){
            $("#service_type_for_old_user").change(function(){
                var user_id = this.value;
                $.ajax({
                        url: '/getActiveService/'+user_id,
                        type: 'get',
                        dataType: 'json',
                        success: function(response){
                            $("#old_user_appointment_amount").val(response[0]['price']);
                        }
                    }
                );

            });
        });


        //=======================================================Appointment List Status Change=======================================================
        $(document).on('click','#adminAppointmentListStatusBtn', function(){
            var appointment_id = $(this).data('id');
            //alert(appointment_id);

            $.post('<?= route("get.appointment.list.details") ?>',{appointment_id:appointment_id}, function(data){
                //alert(data.details.full_name);
                //console.log(data.details.full_name);

                $('.changeStatusForUserPanelAppointmentList').find('input[name="cid"]').val(data.details.id);
                $('.changeStatusForUserPanelAppointmentList').find('select[name="status"]').val(data.details.status);

                $('.changeStatusForUserPanelAppointmentList').modal('show');
            },'json');

        });

        // =============================================Change state for appointment==============================================
        $('#status-change-for-user-panel-appointment-list-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend: function(){
                    $(form).find('span.error-text').text('');
                },
                success: function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $('#appointments-table').DataTable().ajax.reload(null, false);
                        $('.changeStatusForUserPanelAppointmentList').modal('hide');
                        $('.changeStatusForUserPanelAppointmentList').find('form')[0].reset();
                        toastr.success(data.msg);
                    }
                }
            });
        });



        //=======================================================Membership Change=======================================================
        $(document).on('click','#adminAppointmentListMembershipBtn', function(){
            var membership_id = $(this).data('id');
            //alert(membership_id);

            $.post('<?= route("get.appointment.membership.list") ?>',{membership_id:membership_id, _token:'{{csrf_token()}}'}, function(data){
                // alert(data.details.id);
                //console.log(data.details.full_name);

                $('.changeMembership').find('input[name="cid"]').val(data.details.id);
                $('.changeMembership').find('select[name="membership"]').val(data.details.membership);

                $('.changeMembership').modal('show');
            },'json');

        });

        // =============================================Member-ship Change==============================================
        $('#membership-change-appointment-list-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend: function(){
                    $(form).find('span.error-text').text('');
                },
                success: function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else if(data.code == 2){
                        toastr.error(data.msg);
                    }else{
                        $('#appointments-table').DataTable().ajax.reload(null, false);
                        $('.changeMembership').modal('hide');
                        $('.changeMembership').find('form')[0].reset();
                        toastr.success(data.msg);
                    }
                }
            });
        });

    });

</script>
