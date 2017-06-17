@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
        	
            <section class="panel">
                
                <div class="wrapper">
                    
                    <div class="col-sm-3 m-b-xs"><i class="glyphicon glyphicon-user"></i><span class="font-bold">&nbsp;Manage Sub Admin</span></div>
                    
                    <div class="col-sm-4">
                    	
                    </div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/subadmin','class'=>'col-sm-3','role'=>'search'])  !!}
                    
                    <div class="">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search" placeholder="Search" value="{{ app('request')->get('search') }}">
                            <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Go!</button>
                            </span>
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    
                    <div class="col-sm-2">
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a href="{{ url('/adminpanel/subadmin/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable text-center"></th>
                        <th class="th-sortable bgtable" data-toggle="class">SubAdmin Name</th>
                        <th class="th-sortable bgtable" data-toggle="class">Email Address</th>
                        <th class="th-sortable bgtable" data-toggle="class">Department</th>
                        <th width="220" class="text-center th-sortable bgtable" data-toggle="class">Created Date</th>
                        <th width="120" class="text-center bgtable">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
					$query = app('request')->get('search');
					if($query){
						$str = "select s.id as record_id,s.CreateDate as subadminCreateDate,u.* from subadmin s,useraccount u where u.id=s.user_id And u.FirstName like '%$query%' or u.LastName like '%$query%' order by u.FirstName";
					}else{
						$str = "select s.id as record_id,s.CreateDate as subadminCreateDate,u.* from subadmin s,useraccount u where u.id=s.user_id order by id desc";
					}
					$data = DB::select(DB::raw($str));
					?>
                      @foreach ($data as $index=>$tmpdata)
                      <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{ $tmpdata->FirstName }} {{ $tmpdata->LastName }}</td>
                        <td>{{ $tmpdata->EmailAddress }}</td>
                        <td>{{ getDataFromTable("department","Name","id", $tmpdata->dept_id ) }}</td>
                        <td class="text-center"><?php echo date('m/d/Y H:i A', strtotime($tmpdata->subadminCreateDate));?></td>
                        <td class="text-center">
                          <a href="{{url('adminpanel/subadmin')}}/{{$tmpdata->record_id}}/edit"><button type="button" class="btn btn-default btn-xs">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button></a>&nbsp;<a href="{{url('adminpanel/subadmin')}}/{{$tmpdata->record_id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-default btn-xs">Delete</button></a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </section>
        
        </section>
    </section>
</section>

@include('admin.includes.admin_footer')

<style>
.dataTables_length, .dataTables_filter{display:none;}
.table{width:98%;}
</style>
{!! Html::style('public/admin_assets/js/datatables/datatables.css') !!}
{!!HTML::script('public/admin_assets/js/datatables/jquery.dataTables.min.js')!!}

{!! Html::style('public/admin_assets/css/bootstrap-select.min.css') !!}
{!!HTML::script('public/admin_assets/js/bootstrap-select.min.js')!!}

<script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: [5]}]
	});
} );
</script>