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
                    <div class="col-sm-5"></div>
                    <div class="col-sm-3 m-b-xs"></div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/deliverytype','class'=>'','role'=>'search'])  !!}
                    
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
                            <a href="{{ url('/adminpanel/deliverytype/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable"></th>
                        <th class="th-sortable bgtable" data-toggle="class">Delivery  Type</th>
                        <th width="150" class="text-center bgtable">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
						$query = app('request')->get('search');
						if($query){
							$str = "select * from deliverytype where Name like '%$query%' order by Name";
						}else{
							$str = "select * from deliverytype order by id desc";		
						}
						$data = DB::select(DB::raw($str));
						?>
                      @foreach ($data as $index=>$tmpdata)
                      <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{ $tmpdata->Name }}</td>
                        <td class="text-center">
                          <a href="{{url('adminpanel/deliverytype')}}/{{$tmpdata->id}}/edit"><button type="button" class="btn btn-default btn-xs">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button></a>&nbsp;<a href="{{url('adminpanel/deliverytype')}}/{{$tmpdata->id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-default btn-xs">Delete</button></a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>        
        </section>

</section>

@include('admin.includes.admin_footer')


<style>
.dataTables_length, .dataTables_filter{display:none;}
.table{width:98%;}
</style>
{!! Html::style('public/admin_assets/js/datatables/datatables.css') !!}
{!!HTML::script('public/admin_assets/js/datatables/jquery.dataTables.min.js')!!}

<script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: [2]}]
	});
} );
</script>