@section('title')
    History
@stop

@include('includes.top')

<section class="vbox">
    
    @include('includes.header')
    
    <section>
        <section class="hbox stretch">
            
            <section class="panel">
                <?php
				$ecomps_admin_id = trim(Session::get('ecomps_vp_id'));
				
                $search = trim(app('request')->get('search'));
				$year = trim(app('request')->get('year'));
				$requestor = trim(app('request')->get('requestor'));
				
				$game = app('request')->get('game');
				if(count($game) == 0){
					$game = array();
				}
				
				$locationtype = trim(app('request')->get('locationtype'));
				$deliverytype = trim(app('request')->get('deliverytype'));
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="wrapper">
                            <div class="row wrapper">
                            <div class="col-lg-1 col-md-2 col-sm-3">
                            	<span style="font-size:14px; font-weight:bold;"><i class="fa fa-search"></i>&nbsp;<u>FILTER</u></span>
                            </div>
                            <div class="clearfix visible-xs"></div>
                            <div class="col-lg-1 hidden-md hidden-sm">&nbsp;</div>
                            <div class="col-md-2 col-sm-5 col-xs-6">
                                <div style="color:#000;"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Pending</strong></div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-6">
                                <div class="text-success"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Approve</strong></div>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-5 col-xs-6">
                                <div class="text-danger"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Reject</strong></div>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-4 col-xs-6">
                                <div class="text-warning"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Fulfill</strong></div>
                            </div>
                            <div class="clearfix hidden-lg"></div>
                            <div class="col-md-8 col-sm-7 hidden-lg">&nbsp;</div>
                            <div class="col-md-4 col-sm-5 m-b-xs">
                            {{Form::button('Approve Requisition',array('class'=>'btn btn-success btn-sm','id'=>'btnApr','onclick'=>'StatusChanged(1);'))}}
                            {{Form::button('Reject Requisition',array('class'=>'btn btn-danger btn-sm','id'=>'btnReject','onclick'=>'StatusChanged(4);'))}}
                            </div>
                        </div>
                        </div>
                        <div class="row wrapper">
                            
                            {!! Form::open(['method'=>'POST','url'=>'vp-approve/requests','class'=>'','role'=>'search'])  !!}
                            
                            <div class="col-lg-1 col-md-2 col-sm-6 mb-sm-10">
                                <select name="year" class="form-control">
                                	<option value="">-- ALL --</option>
                                    <?php
                                    $years = DB::select("SELECT YEAR(CreateDate) as yr from request GROUP by year(CreateDate) ORDER BY yr DESC");
									foreach($years as $yr){ ?>
                                    <option value="<?php echo $yr->yr;?>" <?php if($yr->yr == $year){?> selected="selected" <?php }?>><?php echo $yr->yr;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <?php
							$requestors = DB::select("SELECT id,FirstName,LastName from useraccount where id IN (select requestor_id from request) order by FirstName");
							?>
                            <div class="col-lg-2 col-md-3 col-sm-6 mb-sm-10">
                            	<select name="requestor" class="form-control">
                                	<option value="">ALL REQUESTORS</option>
                                    <?php foreach($requestors as $t){ ?>
                                    <option value="<?php echo $t->id;?>" <?php if($t->id == $requestor){?> selected="selected" <?php }?>><?php echo $t->FirstName;?> <?php echo $t->LastName;?></option>
                                    <?php }?>
                                </select>
                            </div>
							<?php
							$team = DB::select("SELECT g.id,t.Name,g.OriginalGameDate from team t,game g where t.id=g.team_id And g.requeststate_id=3 And g.id IN (select game_id from request) GROUP by g.id,t.Name,g.OriginalGameDate ORDER BY g.OriginalGameDate");
							?>
                            <div class="col-lg-2 col-md-3 col-sm-6 mb-sm-10">
                            	<select name="game[]"  multiple="multiple" class="form-control selectpicker">
                                    <?php foreach($team as $t){ ?>
                                    <option value="<?php echo $t->id;?>" <?php if(in_array($t->id, $game)){?> selected="selected" <?php }?>><?php echo date('m/d/Y', strtotime($t->OriginalGameDate));?> - <?php echo $t->Name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-3 mb-sm-10">
                            	<?php
								$locationtypes = DB::table('locationtype')->orderBy('Name')->get();
								?>
                                <select name="locationtype" class="form-control">
                                	<option value="">ALL LOCATIONS</option>
                                    <?php foreach($locationtypes as $t){ ?>
                                    <option value="<?php echo $t->id;?>" <?php if($t->id == $locationtype){?> selected="selected" <?php }?>><?php echo $t->Name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-3 mb-sm-10">
                            	<?php
								$deliverytypes = DB::table('deliverytype')->orderBy('Name')->get();
								?>
                                <select name="deliverytype" class="form-control">
                                	<option value="">ALL DELIVERY</option>
                                    <?php foreach($deliverytypes as $t){ ?>
                                    <option value="<?php echo $t->id;?>" <?php if($t->id == $deliverytype){?> selected="selected" <?php }?>><?php echo $t->Name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="clearfix hidden-lg"></div>
                            <div class="mt-10 hidden-lg"></div>
                            <div class="col-sm-3 col-md-12 col-lg-3">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" name="search" placeholder="Search By Recipient" value="{{ app('request')->get('search') }}">
                                    <span class="input-group-btn">
                                    <button class="btn btn-sm btn-default" type="submit">SEARCH</button>
                                    </span>
                                </div>
                            </div>
                            
                            {!! Form::close() !!}
                            
                        </div>
                        <input type="hidden" id="siteurl" value="{{url('/')}}">
                        <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                        <style>.bold{font-weight:bold; color:#C30; font-style:italic;}.ccc{text-decoration:line-through; color:#C30; font-style:italic;}</style>
                        
                        <script>
                        function checkedAll(){
                            $("input:[name=reqIDs]").prop('checked', $('#checkAll')[0].checked);
                        };
                        function StatusChanged(status){
                            var checkValues = $('input[name=reqIDs]:checked').map(function(){
                                                return $(this).val();
                                            }).get();
                            
                            if(checkValues == ""){
                                alert("Select atleast one request to continue..");
                                return false;
                            }
							if(status == '1'){
                            	var result=confirm("Are you sure you want to Approve this Request?");
							}else{
								var result=confirm("Are you sure you want to Reject this Request?");
							}
                            if(result){
								
								if(status == '1'){
									$('#btnApr').html('&nbsp;&nbsp;&nbsp;&nbsp;Processing ...&nbsp;&nbsp;&nbsp;&nbsp;');
								}else{
									$('#btnReject').html('&nbsp;&nbsp;&nbsp;Processing ...&nbsp;&nbsp;');
								}
								
								// POST Ajax
								var url = $('#siteurl').val();
								var csrf=$('#csrf').val();
								$.ajax({
									type: "POST",
									url: url + "/vc_post_requests_multi_approved",
									data: {"checkValues":checkValues ,"_token":csrf,"status":status},
									success: function (data) {
										console.log(data);
										if(data == "success"){
											window.location = url+'/vp-approve/requests';
										}
									}
								});
							}
                        }
                        </script>
                        <div class="table-responsive">
                          <table class="table table-striped table-hover b-t b-light" align="center" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000; font-size:13px;">
                            <thead>
                              <tr>
                                <th width="50" class="text-center bgtable"><input type="checkbox" id="checkAll" onclick="checkedAll();" /></th>
                                <th class="th-sortable bgtable" data-toggle="class">Requestor</th>
                                <th class="th-sortable bgtable" data-toggle="class">Recipient</th>
                                <th class="th-sortable bgtable" data-toggle="class">Company</th>
                                <th class="text-center bgtable" data-toggle="class">Game</th>
                                <th class="text-center bgtable" data-toggle="class">Created</th>
                                <th class="th-sortable bgtable" data-toggle="class">Request Position</th>
                                <th class="text-center bgtable" data-toggle="class">Comp</th>
                                <th class="text-center bgtable" data-toggle="class">Purch</th>
                                <th class="text-center bgtable" data-toggle="class">Location</th>
                                <th class="text-center bgtable" data-toggle="class">Delivery</th>
                                <th class="text-center bgtable" data-toggle="class">Approve</th>
                                <th class="text-center bgtable" data-toggle="class">Fulfill</th>
                                <th class="text-center bgtable" data-toggle="class">Used</th>
                                <th class="text-center bgtable action-width" width="127" data-toggle="class">Action</th>
                              </tr>
                            </thead>
                            <tbody>
							<?php
							$sch='';
							if($search !=''){
								$sch = $sch."(RecipientFirstName like '%$search%' OR RecipientLastName like '%$search%') AND ";
							}
							if($year!=''){
								$sch = $sch."year(CreateDate) = '$year%' AND ";
							}
							if($requestor!=''){
								$sch = $sch."requestor_id = '$requestor' AND ";
							}
							if(count($game) > 0){
								$tmp_games = implode(",", $game);
								$sch = $sch."game_id IN ($tmp_games) AND ";
							}
							if($locationtype!=''){
								$sch = $sch."locationtype_id = '$locationtype' AND ";
							}
							if($deliverytype!=''){
								$sch = $sch."deliverytype_id = '$deliverytype' AND ";
							}
							$sch = substr($sch,0,-5);
							
							// Get selected departments from User Account Table
							/*$tmp = DB::select(DB::raw("select dept_of_vp from useraccount where id='$ecomps_admin_id'"));
							
							$dept_of_vp = 0;
							if(count($tmp) > 0){
								$dept_of_vp = $tmp[0]->dept_of_vp;
							}
							
							if($sch!=''){
								$cond="id!='' And is_forward_to_fulfil=0 And is_fulfil=0 And is_cancel=0 And user_cancel=0 And dept_id in (".$dept_of_vp.") And ".$sch;
							}elseif($sch==''){
								$cond="id!='' And is_forward_to_fulfil=0 And is_fulfil=0 And is_cancel=0 And dept_id in (".$dept_of_vp.") And user_cancel=0";
							}*/
							if($sch!=''){
								$cond="id!='' And is_forward_to_fulfil=0 And is_fulfil=0 And is_cancel=0 And user_cancel=0 And ".$sch;
							}elseif($sch==''){
								$cond="id!='' And is_forward_to_fulfil=0 And is_fulfil=0 And is_cancel=0 And user_cancel=0";
							}
							$str = "select * from request where ".$cond." order by CreateDate desc";
							$data = DB::select(DB::raw($str));
								
                            //echo '<pre>';
                            //print_r($data);exit;
                            ?>
                            @foreach ($data as $index=>$tmpdata)
                                
                                <?php
								// 1 = APPROVED
								// 2 = FULFILLED
								// 4 = REJECTED
								$is_fulfil = $tmpdata->is_fulfil;
								
								if($is_fulfil == "1"){
									$approver_name = 'Fulfilled';
								}else if($is_fulfil == "0" && $tmpdata->is_forward_to_fulfil == "1"){
									$approver_name = 'Forwarded to Ticket Department';
								}
								if($tmpdata->id==22){
								//print_r($tmpdata);exit;
								}
								if($is_fulfil != "1"){
								//if(($is_fulfil != "1" && $tmpdata->is_cancel != "1" && $tmpdata->second_approver_status == "0") || $tmpdata->approve_by_admin == "1"){
								//if(($is_fulfil != "1" && $tmpdata->is_cancel != "1") || $tmpdata->approve_by_admin == "1"){
									
									
									$approver_name = '';
									$approver_level = '';
									
									$res_req = DB::table("useraccount")->select('FirstName', 'LastName')->where("id", $tmpdata->requestor_id)->get();
									if($tmpdata->requestor_id == trim($ecomps_admin_id)){
										$req_name = 'Me';
									}else{
										$req_name = $res_req[0]->FirstName.' '.$res_req[0]->LastName;
									}
									$approver = "";
									if(trim($tmpdata->req_position) == "1" && $tmpdata->first_approver > 0){
										$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->first_approver);
										$approver_level = 'First Level Approver';
										$approver_name = $approver->FirstName.' ('.$approver_level.')';
									}
									if($tmpdata->req_position == "2"){
										$approver_name = 'Second Level Approver';
									}								
									if($tmpdata->sent_to_vc == "1"){
										$approver_name = 'Direct Requsition';
									}
									$is_unread_message = DB::table('request_message')->where('request_id', '=', $tmpdata->id)->where('readby_vp', 0)->count();
									
									$cl = "";
									if($tmpdata->sent_to_vc == "1" && $tmpdata->user_cancel == "0"){
										$cl = "bold";
									}
									if($tmpdata->sent_to_vc == "1" && $tmpdata->user_cancel == "1"){
										$cl = "bold ccc";
									}
									if($tmpdata->sent_to_vc == "0" && $tmpdata->user_cancel == "1"){
										$cl = "ccc";
									}
                                	?>
                                  <tr style="cursor:pointer;">
                                    <td class="text-center" title="<?php echo $tmpdata->id;?>">
                                    
                                    <?php if($tmpdata->is_cancel || $tmpdata->vc_status == "2" || $tmpdata->user_cancel == "1"){?>
                                    <i class="fa fa-check-square" style="color:#f00;"></i>
                                    <?php }else if($is_fulfil == "1" || $tmpdata->vc_status == "1" || $tmpdata->approve_by_admin == "1" || ($tmpdata->first_approver_status == "1" && $tmpdata->second_approver_status == "1")){?>
                                    <i class="fa fa-check-square" style="color:#090;"></i>
                                    <?php }else{?>
                                    <input type="checkbox" name="reqIDs" value="{{ $tmpdata->id }}" />
                                    <?php }?>
                                    
                                    </td>
                                    <td class="<?php echo $cl;?>"><?php echo $req_name;?></td>
                                    <td class="<?php echo $cl;?>">{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                                    <td class="<?php echo $cl;?>">{{ $tmpdata->CompanyName }}</td>
                                    <td class="text-center <?php echo $cl;?>">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                                    <td class="text-center <?php echo $cl;?>">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                    <td class="<?php echo $cl;?>">{{ $approver_name }}</td>                                
                                    <td class="text-center <?php echo $cl;?>">{{ $tmpdata->Comp }}</td>
                                    <td class="text-center <?php echo $cl;?>">{{ $tmpdata->Purchased }}</td>
                                    <td class="text-center <?php echo $cl;?>">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                                    <td class="text-center <?php echo $cl;?>">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                                    <td class="text-center <?php echo $cl;?>">
                                    <?php
                                    if($tmpdata->sent_to_vc == "1"){
                                    ?>
                                    No Approver
                                    <?php }else{?>
                                        <div style="width:50%; text-align:center; float:left;">
                                            <div class="text-<?php if($tmpdata->first_approver_status=="1" || $tmpdata->approve_by_admin == "1"){?>success<?php }else if($tmpdata->first_approver_status=="2" || $tmpdata->is_cancel == "1"){?>danger<?php }?>">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                        </div>
                                        <div style="width:50%; text-align:center; float:left;">
                                            <div class="text-<?php if($tmpdata->second_approver_status=="1" || $tmpdata->approve_by_admin == "1"){?>success<?php }else if($tmpdata->second_approver_status=="2"){?>danger<?php }?>">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                        </div>
                                    <?php }?>
                                    </td>
                                    <td class="text-center">
                                    <div class="text-<?php if($is_fulfil=="1"){?>warning<?php }?>">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                    </td>
                                    <td class="text-center <?php echo $cl;?>">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td>
                                    
                                 	<td class="text-center"><a href="{{url('vp-approve/request')}}/{{$tmpdata->id}}/view/approver"><button type="button" class="btn btn-default btn-xs">View</button></a>&nbsp;<a href="{{url('vp-approve/request')}}/{{$tmpdata->id}}/message/board"><button type="button" class="btn btn-default btn-xs">Message</button><?php if($is_unread_message > 0){?>
                        <span class="badge badge-sm up bg-success count" style="display: inline-block;">!</span>
                        <?php }?></a></td>
                                  </tr>
                              		<?php }?>
                                    @endforeach
                            </tbody>
                          </table>
                        </div>
                        
                      </section>
					</div>
        		</div>
        </section>
    </section>
</section>

@include('includes.admin_footer')


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
		columnDefs: [ { orderable: false, targets: [0,11,12,13,14]}]
	});
} );
</script>