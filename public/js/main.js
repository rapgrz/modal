jQuery.noConflict();
jQuery(function($) {
    $(document).ready(function() {
        function monthDiff(dateFrom, dateTo) {
            return dateTo.getMonth() - dateFrom.getMonth() +
                (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
        }

        function throttle(f, delay){
            var timer = null;
            return function(){
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = window.setTimeout(function(){
                        f.apply(context, args);
                    },
                    delay || 800);
            };
        }

        $('#modalas .btn-primary').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: $('#modalas').find('form').attr('action'),
                type: 'POST',
                data: {
                    _token:$('input[name="_token"]').val(),
                    data: $('form').serialize(),
                    title: $('#title').val(),
                    company_code: $('#company-code').val(),
                    address: $('#address').val(),
                    city: $('#city option:selected').val()
                },

                success: function(result) {
                    var html = '<tr id="'+result.success+'"><td>'+$('#title').val()+'</td><td>'+$('#company-code').val()+'</td><td>'+$('#address').val()+'</td>' +
                        '<td>'+result.city+'</td><td>'+$('#sum').val()+'</td><td class="float-right"><a href="'+result.edit+'"><i class="fa fa-edit text-primary mr-3"></i></a>' +
                        '<a href="#" class="manage-delete" data-toggle="modal" data-target="#deleteConfirm" target="'+result.success+'" action="'+result.delete+'">' +
                        '<i class="fa fa-trash text-danger"></i></a></td>';
                    $('#list tbody').prepend(html);
                    $('#modalas .close').trigger('click');
                }
            });
        })

        $('#sum').change(throttle(function(){
            $(this).attr('readonly', 'true');
            var splitFrom = $('#date-from').val().split('-');
            var splitTo = $('#date-to').val().split('-');
            var startDate = new Date(splitFrom[0], splitFrom[1]);
            var diff = monthDiff(startDate, new Date(splitTo[0], splitTo[1]));
            diff++;
            var money = parseInt($(this).val()) / diff;
            var html = '<table class="table table-striped"><thead><tr>' +
                '<th scope="col">#</th><th scope="col">Mėnuo</th><th scope="col">Suma</th>' +
                '</tr></thead><tbody>';
            for(var i = 0; i < diff; i++){
                var row = i + 1;
                if(i !=  0){
                    startDate.setMonth(startDate.getMonth()+1);
                }
                var month = startDate.getMonth();
                var year = startDate.getFullYear();
                if(startDate.getMonth() == 0){
                    month = 12
                    year--;
                }
                html += '<tr><th scope="row">'+row+'</th><td>'+year+'-'+month+'</td>';
                html += '<input type="hidden" name="dates[]" value="'+year+'-'+month+'">';
                html += '<td><input id="'+i+'" type="number" name="dates_val[]" class="form-control date" value="'+money+'" required></td>';
            }
            html += '</tr></tbody></table>';
            $('#modalas .modal-body').append(html);
        }));

        $(document).on('click', '.manage-delete', function(e){
            $('.delete-sure').attr('target', $(this).attr('target'));
            $('.delete-sure').attr('action', $(this).attr('action'));
        });

        $(document).on('click', '.delete-sure', function(e) {
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: {
                    _token:$('input[name="_token"]').val(),
                },

                success: function(result) {
                    $.each(result, function(key, value) {
                        $('.msg').html('<div class="alert alert-'+key+'">'+value+'</div>').fadeTo(5000, 500).slideUp(500, function(){
                            $(this).slideUp(500);
                        });
                    });
                }
            });
            $('#deleteConfirm .close').trigger('click');
            $('tr[id="' + $(this).attr('target') + '"]').remove();
        });

        $(document).on('change', '.date', function(){
           var sum = 0;
           $('.date').each(function( index ) {
               if($(this).val()){
                   sum += parseFloat($(this).val());
               }
           });

           $('#sum').val(0);
           $('#sum').val(sum);
        });
    });
});