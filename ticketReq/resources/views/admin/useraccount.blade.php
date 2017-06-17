@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
        	
            <section class="panel">
                
                <div class="row wrapper">
                    
                    <div class="col-sm-2 m-b-xs">
                    <button type="button" class="btn btn-danger btn-sm" id="btnBulk" onclick="BulkUserDelete();" >
					<i class="fa fa-trash-o"></i>&nbsp;&nbsp;Bulk Delete
                    </button>
                    </div>
                    
                    <div class="col-sm-5">
                    	<i class="glyphicon glyphicon-star-empty" style="color:#C0C;"></i>&nbsp;<span style="color:#C0C;">Fulfiler</span>&nbsp;|&nbsp;<i class="glyphicon glyphicon glyphicon-asterisk" style="color:#090;"></i>&nbsp;<span style="color:#090;">First Level Approver</span>&nbsp;|&nbsp;<i class="fa fa-mortar-board" style="color:#C03;"></i>&nbsp;<span style="color:#C03;">Second Level Approver</span>&nbsp;|&nbsp;<i class="fa fa-life-ring" style="color:#09C;"></i>&nbsp;<span style="color:#09C;">Vice President</span>
                    </div>
                    <?php
					$search = app('request')->get('search');
					$level = app('request')->get('level');
					?>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/useraccount','class'=>'','role'=>'search'])  !!}
                    
                    <div class="col-sm-2">
                        <select name="level" class="form-control">
                            <option value="">-- ALL --</option>
                            <option value="first-level" <?php if ($level == "first-level") { ?> selected="selected" <?php } ?>>Level I Approvers</option>
                            <option value="second-level" <?php if ($level == "second-level") { ?> selected="selected" <?php } ?>>Level II Approvers</option>
                            <option value="fulfiler" <?php if ($level == "fulfiler") { ?> selected="selected" <?php } ?>>Fulfilers</option>
                            <option value="vp" <?php if ($level == "vp") { ?> selected="selected" <?php } ?>>Vice President</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
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
					var result=confirm("Are you sure you want to Delete this User?");
					
					// POST Ajax
					if(result){
						
						$('#btnBulk').attr("disabled", "true");
						
						var url = $('#siteurl').val();
						var csrf=$('#csrf').val();
						$.ajax({
							type: "POST",
							url: url + "/admin_post_users_multi_delete",
							data: {"checkValues":checkValues ,"_token":csrf},
							success: function (data) {
								if(data == "success"){
									window.location = url+'/adminpanel/useraccount'
								}
								//console.log(data);
							}
						});
					}
				}
				</script>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable text-center"><input type="checkbox" id="checkAll" onclick="checkedAll();" /></th>
                        <th class="th-sortable bgtable" data-toggle="class">User Name</th>
                        <th class="th-sortable bgtable" data-toggle="class">Email Address</th>
                        <th class="th-sortable bgtable" data-toggle="class">Department</th>
                        <th class="th-sortable bgtable" data-toggle="class">Employee Type</th>
                        <th width="320" class="text-center bgtable">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
					$sch = '';
					if ($search != '') {
						$sch = $sch . "(FirstName like '%$search%' OR LastName like '%$search%') AND ";
					}
					if ($level != '') {
						if($level == "first-level"){
							$sch = $sch . "approver_level = '1' AND ";
						}
						if($level == "second-level"){
							$sch = $sch . "approver_level = '2' AND ";
						}
						if($level == "fulfiler"){
							$sch = $sch . "is_fulfiler = '1' AND ";
						}
						if($level == "vp"){
							$sch = $sch . "is_vp = '1' AND ";
						}
					}
					$sch = substr($sch, 0, -5);
					if ($sch != '') {
						$cond = "is_deleted=0 And " . $sch;
					} elseif ($sch == '') {
						$cond = "is_deleted=0";
					}
					$str = "select * from useraccount where ".$cond." order by FirstName";
					$data = DB::select(DB::raw($str));
					?>
                      @foreach ($data as $index=>$tmpdata)
                      <tr>
                        <td class="text-center"><?php if($tmpdata->is_vp == "0"){?><input type="checkbox" name="IDs" value="{{ $tmpdata->id }}" /><?php }else{?><input type="checkbox" disabled="disabled" /><?php }?></td>
                        <td>{{ $tmpdata->FirstName }} {{ $tmpdata->LastName }}<?php if($tmpdata->is_fulfiler == "1"){?>&nbsp;&nbsp;<i class="glyphicon glyphicon-star-empty" style="color:#C0C;" title="Fulfiler"></i><?php }?><?php if($tmpdata->approver_level == "1"){?>&nbsp;&nbsp;<i class="glyphicon glyphicon-asterisk" style="color:#090;" title="First Level of Approver"></i><?php }?><?php if($tmpdata->approver_level == "2"){?>&nbsp;&nbsp;<i class="fa fa-mortar-board" style="color:#C03;" title="Second Level of Approver"></i><?php }?><?php if($tmpdata->is_vp == "1"){?>&nbsp;&nbsp;<i class="fa fa-life-ring" style="color:#09C;" title="Vice President"></i><?php }?></td>
                        <td>{{ $tmpdata->EmailAddress }}</td>
                        <td>{{ getDataFromTable("department","Name","id", $tmpdata->dept_id ) }}</td>
                        <td>{{ getDataFromTable("employeetype","Name","id", $tmpdata->employeetype_id ) }}</td>
                        <?php
						if($tmpdata->password == ""){
							$password_label = 'New Password';
						}else{
							$password_label = 'Edit Password';
						}
						?>
                        <td class="text-center">
                          <a href="{{url('adminpanel/useraccount')}}/{{$tmpdata->id}}/assign-reports"><button type="button" class="btn btn-primary btn-xs">Assign Reports</button></a>&nbsp;<a href="{{url('adminpanel/useraccount')}}/{{$tmpdata->id}}/setpassword"><button type="button" class="btn btn-success btn-xs">{{ $password_label }}</button></a>&nbsp;<a href="{{url('adminpanel/useraccount')}}/{{$tmpdata->id}}/edit"><button type="button" class="btn btn-info btn-xs">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button></a>&nbsp;<?php if($tmpdata->is_vp == "0"){?><a href="{{url('adminpanel/useraccount')}}/{{$tmpdata->id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-danger btn-xs">Delete</button></a><?php }else{?><a href="javascript:void(0);" onclick="alert('You can not delete the vice president account.');"><button type="button" class="btn btn-danger btn-xs">Delete</button></a><?php }?>
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

<script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: [0,5]}]
	});
} );
</script>