<a href="{!! action('PostulantesController@generatePDF', ['id'=>$project->id]) !!}"> <button type="button" class="btn btn-success btn-lg pull-right">
                        <i class="fa fa-file-excel-o"></i> Imprimir Listado
                        </button></a>

                        for (var i=0; i<data.length;i++)
                {
                    $('select[name="city_id"]').append('<option value="'+ data[i].CiuId+'">'+ data[i].CiuNom +'</option>');
                }

