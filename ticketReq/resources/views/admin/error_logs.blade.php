@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
    
    {!! Html::style('public/admin_assets/js/datatables/datatables.css') !!}
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
            
            <section class="panel">
                
                <div class="row wrapper">
                    
                    <div class="col-sm-3 m-b-xs">
                    <button type="button" class="btn btn-danger btn-sm" id="btnBulk" onclick="BulkUserDelete();" >
					<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Error Logs
                    </button>
                    </div>
                    
                    <div class="col-sm-5">
                    	
                    </div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/errors/logs','class'=>'','role'=>'search'])  !!}
                    
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search" placeholder="Search" value="{{ app('request')->get('search') }}">
                            <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Go!</button>
                            </span>
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    
                    <div class="col-sm-1">
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a href="{{ url('/adminpanel/useraccount/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="siteurl" value="{{url('/')}}">
                <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                <script>
				function checkedAll(){
					$("input:[name=IDs]").prop('checked', $('#checkAll')[0].checked);
				};
				function BulkUserDelete(status){
					
					var checkValues = $('input[name=IDs]:checked').map(function(){
										return $(this).val();
									}).get();
					
					if(checkValues == ""){
						alert("Select atleast one user to continue..");
						return false;
					}
					$('#btnBulk').attr("disabled", "true");
					
					var url = $('#siteurl').val();
					var csrf=$('#csrf').val();
					$.ajax({
						type: "POST",
						url: url + "/admin_post_error_logs_multi_delete",
						data: {"checkValues":checkValues ,"_token":csrf},
						success: function (data) {
							if(data == "success"){
								window.location = url+'/adminpanel/errors/logs'
							}
						}
					});
				}
				</script>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable text-center"><input type="checkbox" id="checkAll" onclick="checkedAll();" /></th>
                        <th width="350" class="th-sortable bgtable" data-toggle="class">Page Link</th>
                        <th class="th-sortable bgtable" data-toggle="class">Error Description</th>
                        <th width="150" class="text-center bgtable">Dated</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
					$query = app('request')->get('search');
					if($query){
						$str = "select * from error_logs where (err_desc like '%$query%' or page_url like '%$query%') order by created_date desc";
					}else{
						$str = "select * from error_logs order by created_date desc";
					}
					$data = DB::select(DB::raw($str));
					?>
                      @foreach ($data as $index=>$tmpdata)
                      <tr>
                        <td class="text-center"><input type="checkbox" name="IDs" value="{{ $tmpdata->id }}" /></td>
                        <td>{{ $tmpdata->page_url }}</td>
                        <td>{{ $tmpdata->err_desc }}</td>
                        <td class="text-center">{{ date('m/d/Y H:i A', strtotime($tmpdata->created_date)) }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </section>
    </section>
</section>

@include('admin.includes.admin_footer')
<style>
.dataTables_length, .dataTables_filter{display:none;}
.table{width:100%;}
</style>
<script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: []}]
	});
} );
</script>