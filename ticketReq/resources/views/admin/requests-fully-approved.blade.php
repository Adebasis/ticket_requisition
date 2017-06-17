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
                    <span style="font-size:14px; font-weight:bold;"><i class="fa fa-envelope icon-muted"></i>&nbsp;Fully Approved Requests</span>
                    </div>
                    <div class="col-sm-3 m-b-xs">
                    </div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/fully-approved-requests','class'=>'col-sm-3','role'=>'search'])  !!}
                    
                    <div class="">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search" placeholder="Search By Recipient" value="{{ app('request')->get('search') }}">
                            <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Go!</button>
                            </span>
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    
                    <div class="col-sm-1">
                        <div class="input-group">
                            <span class="input-group-btn">
                            <!--<a href="{{ url('/adminpanel/requests/entry') }}"><button class="btn btn-sm btn-default" type="button">NEW REQUEST</button></a>-->
                            </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" align="center" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable text-center"><!--<input type="checkbox" id="checkAll" disabled="disabled" />--></th>
                        <th class="th-sortable bgtable" data-toggle="class">Requestor</th>
                        <th class="text-center bgtable" data-toggle="class">Game</th>
                        <th class="text-center bgtable" data-toggle="class">Created</th>
                        <th class="th-sortable bgtable" data-toggle="class">Recipient</th>
                        <th class="th-sortable bgtable" data-toggle="class">Company</th>
                        <th class="th-sortable bgtable" data-toggle="class">Department</th>
                        <th class="text-center bgtable" data-toggle="class">Comp</th>
                        <th class="text-center bgtable" data-toggle="class">Purch</th>
                        <th class="text-center bgtable" data-toggle="class">Location</th>
                        <th class="text-center bgtable" data-toggle="class">Delivery</th>
                        <th class="text-center bgtable" data-toggle="class">Used</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
					$str = "select * from request where (first_approver_status= 1 And second_approver_status = 1) or approve_by_admin = 1 or vc_status=1 order by CreateDate desc";
					$data = DB::select(DB::raw($str));
					?>
                    	
                      @foreach ($data as $index=>$tmpdata)
                      	
                        <?php
						$approver_name = '';
						$approver_level = '';
						$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->requestor_id);
						$requester_name = '';
						if(count($requester) > 0){
							$requester_name = $requester->FirstName.' '.$requester->LastName;
						}
						
						$approver = "";
						if($tmpdata->req_position == "1" && $tmpdata->first_approver > 0){
							$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->first_approver);
							$approver_level = 'First Level Approver';
							$approver_name = $approver->FirstName.' ('.$approver_level.')';
						}
						if($tmpdata->req_position == "2"){
							//$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->second_approver);
							$approver_level = 'Second Level Approver';
							
						}
									
						// Get Status
						// 1 = APPROVED
						// 2 = FULFILLED
						// 4 = REJECTED
						$is_approve = $tmpdata->requeststatustype_id;
						$is_fulfil = $tmpdata->is_fulfil;
						
						if($is_fulfil == "1"){
							$approver_name = 'Fulfilled';
						}else if($is_fulfil == "0" && $tmpdata->is_forward_to_fulfil == "1"){
							$approver_name = 'Forwarded to Ticket Department';
						}
						?>
                      <tr style="cursor:pointer;">
                        <td class="text-center">{{$index+1}}
                       <!-- <input type="checkbox" name="reqIDs" value="{{ $tmpdata->id }}" disabled="disabled" />-->
                        </td>
                        <td>{{ $requester_name }}</td>
                        <td class="text-center">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                        <td class="text-center">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                        <td>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                        <td>{{ $tmpdata->CompanyName }}</td>
                        <td>{{ getDataFromTable("department","Name","id", $tmpdata->dept_id ) }}</td>
                        <td class="text-center">{{ $tmpdata->Comp }}</td>
                        <td class="text-center">{{ $tmpdata->Purchased }}</td>
                        <td class="text-center">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                        <td class="text-center">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                        <td class="text-center">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td>
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

{!! Html::style('public/admin_assets/css/bootstrap-select.min.css') !!}
{!!HTML::script('public/admin_assets/js/bootstrap-select.min.js')!!}

<script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: []}]
	});
} );
</script>