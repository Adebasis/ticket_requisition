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
                
                <div class="wrapper">
                    <div class="col-sm-5">
                    </div>
                    <div class="col-sm-2 m-b-xs">
                    </div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/departments','class'=>'col-sm-3','role'=>'search'])  !!}
                    
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
                            <a href="{{ url('/adminpanel/departments/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable"></th>
                        <th width="250" class="th-sortable bgtable" data-toggle="class">Department</th>
                        <th width="250" class="th-sortable bgtable" data-toggle="class">First Approver</th>
                        <th class="th-sortable bgtable" data-toggle="class">Second Approvers</th>
                        <th width="250" class="text-center bgtable">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php
					$query = app('request')->get('search');
					if($query){
						$str = "select * from department where Name like '%$query%' order by Name";
					}else{
						$str = "select * from department order by id desc";		
					}
					$data = DB::select(DB::raw($str));
					?>
                      
                      @foreach ($data as $index=>$tmpdata)
                      <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{ $tmpdata->Name }}</td>
                        <?php
						// Find approver_level = 1 is First Level approver and match with dept_id
						$user = DB::table('useraccount')->select('FirstName', 'LastName')->where('dept_id', '=', $tmpdata->id)->where('approver_level', '=', 1)->get();
						$approver = '';
						if(count($user) > 0){
							$approver = $user[0]->FirstName.' '.$user[0]->LastName;
						}
						$second_approvers = "";
						$user = DB::select("SELECT GROUP_CONCAT(CONCAT(FirstName,' ',LastName)) AS UNAME FROM useraccount WHERE approver_level=2 and find_in_set(".$tmpdata->id.", dept_second_approver)");
						if(count($user) > 0){
							$second_approvers = $user[0]->UNAME;
						}
						?>
                        <td>{{ $approver }}</td>
                        <td>{{ $second_approvers }}</td>
                        <?php
						/*if($tmpdata->first_approver > 0){
							$lbl = '&nbsp;&nbsp;Edit Approver&nbsp;';
						}else{
							$lbl = 'Assign Approver';
						}*/
						$lbl = 'Manage Approvers';
						?>
                        <td class="text-center">
                          <a href="{{url('adminpanel/departments')}}/{{$tmpdata->id}}/approver"><button type="button" class="btn btn-default btn-xs">{{ $lbl }}</button></a>&nbsp;<a href="{{url('adminpanel/departments')}}/{{$tmpdata->id}}/edit"><button type="button" class="btn btn-default btn-xs">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button></a>&nbsp;<a href="{{url('adminpanel/departments')}}/{{$tmpdata->id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-default btn-xs">Delete</button></a>
                        </td>
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
.table{width:98%;}
</style>
{!! Html::style('public/admin_assets/js/datatables/datatables.css') !!}
{!!HTML::script('public/admin_assets/js/datatables/jquery.dataTables.min.js')!!}

<script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: [4]}]
	});
} );
</script>