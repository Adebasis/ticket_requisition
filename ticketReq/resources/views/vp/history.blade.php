@section('title')
    History
@stop

@include('vp.includes.top')

<section class="vbox">
    
    @include('vp.includes.header')
    
    <section>
        <section class="hbox stretch">
            
            <section class="panel">
                <?php
				$ecomps_admin_id = trim(Session::get('ecomps_user_id'));
				
                $search = trim(app('request')->get('search'));
				$year = trim(app('request')->get('year'));
				$requestor = trim(app('request')->get('requestor'));
				//$game = "";
				//echo $game = array(app('request')->get('game[]'));exit;
				
				//echo '<pre>';
				//print_r($game);
				$game = app('request')->get('game');
				if(count($game) == 0){
					$game = array();
				}
				//print_r($game);exit;
				//print_r(app('request')->all());exit;
				$locationtype = trim(app('request')->get('locationtype'));
				$deliverytype = trim(app('request')->get('deliverytype'));
				
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row wrapper" style="padding-left:2%;">
                            <div class="row wrapper" style="padding-left:2%;">
                            <div class="col-sm-1">
                            	<span style="font-size:14px; font-weight:bold;"><i class="fa fa-search"></i>&nbsp;<u>FILTER</u></span>
                            </div>
                            <div class="col-sm-4">&nbsp;</div>
                            <div class="col-sm-1">
                                <div style="color:#000;"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Pending</strong></div>
                            </div>
                            <div class="col-sm-1">
                                <div class="text-success"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Approve</strong></div>
                            </div>
                            <div class="col-sm-1">
                                <div class="text-danger"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Reject</strong></div>
                            </div>
                            <div class="col-sm-1">
                                <div class="text-warning"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Fulfill</strong></div>
                            </div>
                            <div class="col-sm-3 m-b-xs">
                            {{Form::button('Approve Requisition',array('class'=>'btn btn-success btn-sm','id'=>'btnApr','onclick'=>'StatusChanged(1);'))}}
                            {{Form::button('Reject Requisition',array('class'=>'btn btn-danger btn-sm','id'=>'btnReject','onclick'=>'StatusChanged(4);'))}}
                            </div>
                        </div>
                        </div>
                        <div class="row wrapper" style="padding-left:2%;">
                            
                            {!! Form::open(['method'=>'POST','url'=>'vice-president/history','class'=>'','role'=>'search'])  !!}
                            
                            <div class="col-sm-9 row">&nbsp;</div>
                            <?php /*?><div class="col-sm-1 row">
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
                            <div class="col-sm-2">
                            	<select name="requestor" class="form-control">
                                	<option value="">ALL REQUESTORS</option>
                                    <?php foreach($requestors as $t){ ?>
                                    <option value="<?php echo $t->id;?>" <?php if($t->id == $requestor){?> selected="selected" <?php }?>><?php echo $t->FirstName;?> <?php echo $t->LastName;?></option>
                                    <?php }?>
                                </select>
                            </div>
							<?php
							$team = DB::select("SELECT g.id,t.Name,g.OriginalGameDate from team t,game g where t.id=g.team_id And g.requeststate_id=3 And g.id IN (select game_id from request) GROUP by g.id,t.Name,g.OriginalGameDate ORDER BY t.Name");
							?>
                            <div class="col-sm-2">
                            	<select name="game[]"  multiple="multiple" class="form-control selectpicker">
                                    <?php foreach($team as $t){ ?>
                                    <option value="<?php echo $t->id;?>" <?php if(in_array($t->id, $game)){?> selected="selected" <?php }?>><?php echo date('m/d/Y', strtotime($t->OriginalGameDate));?> - <?php echo $t->Name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-sm-2">
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
                            <div class="col-sm-2">
                            	<?php
								$deliverytypes = DB::table('deliverytype')->orderBy('Name')->get();
								?>
                                <select name="deliverytype" class="form-control">
                                	<option value="">ALL DELIVERY</option>
                                    <?php foreach($deliverytypes as $t){ ?>
                                    <option value="<?php echo $t->id;?>" <?php if($t->id == $deliverytype){?> selected="selected" <?php }?>><?php echo $t->Name;?></option>
                                    <?php }?>
                                </select>
                            </div><?php */?>
                            <div class="col-sm-3">
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
                        <style>.bold{font-weight:bold; color:#C30; font-style:italic;}</style>
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
											window.location = url+'/vice-president/history';
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
                                <th class="text-center bgtable" width="120" data-toggle="class">Action</th>
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
							
							if($sch!=''){
								$cond="id!='' And ".$sch;
							}elseif($sch==''){
								$cond="id!=''";
							}
							
							$str = "select * from request where ".$cond." order by is_approve,CreateDate desc";
							$data = DB::select(DB::raw($str));
								
                            //echo '<pre>';
                            //print_r($data);exit;
                            ?>
                            @foreach ($data as $index=>$tmpdata)
                                
                                <?php
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
								// 1 = APPROVED
								// 2 = FULFILLED
								// 4 = REJECTED
								$is_fulfil = $tmpdata->is_fulfil;
								
								if($is_fulfil == "1"){
									$approver_name = 'Fulfilled';
								}else if($is_fulfil == "0" && $tmpdata->is_forward_to_fulfil == "1"){
									$approver_name = 'Forwarded to Ticket Department';
								}
								
                                ?>
                              <tr style="cursor:pointer;">
                                <td class="text-center">
                                
								<?php if($tmpdata->is_cancel || $tmpdata->vc_status == "2"){?>
                                <i class="fa fa-check-square" style="color:#f00;"></i>
                                <?php }else if($is_fulfil == "1" || $tmpdata->vc_status == "1" || $tmpdata->approve_by_admin == "1" || ($tmpdata->first_approver_status == "1" && $tmpdata->second_approver_status == "1")){?>
                                <i class="fa fa-check-square" style="color:#090;"></i>
                                <?php }else{?>
                                <input type="checkbox" name="reqIDs" value="{{ $tmpdata->id }}" />
                                <?php }?>
                                
                                </td>
                                <td <?php if($tmpdata->sent_to_vc == "1"){?> class="bold" <?php }?>><?php echo $req_name;?></td>
                                <td <?php if($tmpdata->sent_to_vc == "1"){?> class="bold" <?php }?>>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                                <td <?php if($tmpdata->sent_to_vc == "1"){?> class="bold" <?php }?>>{{ $tmpdata->CompanyName }}</td>
                                <td class="text-center <?php if($tmpdata->sent_to_vc == "1"){?> bold <?php }?>">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                                <td class="text-center<?php if($tmpdata->sent_to_vc == "1"){?> bold <?php }?>">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                <td <?php if($tmpdata->sent_to_vc == "1"){?> class="bold" <?php }?>>{{ $approver_name }}</td>                                
                                <td class="text-center<?php if($tmpdata->sent_to_vc == "1"){?> bold <?php }?>">{{ $tmpdata->Comp }}</td>
                                <td class="text-center<?php if($tmpdata->sent_to_vc == "1"){?> bold <?php }?>">{{ $tmpdata->Purchased }}</td>
                                <td class="text-center<?php if($tmpdata->sent_to_vc == "1"){?> bold <?php }?>">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                                <td class="text-center<?php if($tmpdata->sent_to_vc == "1"){?> bold <?php }?>">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                                <td class="text-center<?php if($tmpdata->sent_to_vc == "1"){?> bold <?php }?>">
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
                                <td class="text-center<?php if($tmpdata->sent_to_vc == "1"){?> bold <?php }?>">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td>
                                
                                <td class="text-center"><a href="{{url('vice-president/request')}}/{{$tmpdata->id}}/view/approver"><button type="button" class="btn btn-default btn-xs">View</button></a>&nbsp;<a href="{{url('vice-president/history/request')}}/{{$tmpdata->id}}/message/board"><button type="button" class="btn btn-default btn-xs">Message</button></a></td>
                              </tr>
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