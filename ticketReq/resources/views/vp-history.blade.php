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
                        <div class="row wrapper" style="padding-left:2%;">
                            <div class="row wrapper" style="padding-left:2%;">
                            <div class="col-lg-3 mb-10">
                            	<span style="font-size:14px; font-weight:bold;"><i class="fa fa-search"></i>&nbsp;<u>FILTER</u></span>
                            </div>
                            <div class="clearfix visible-xs"></div>
                            <div class="col-md-1 col-sm-5 col-xs-6">
                                <div style="color:#000;"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Pending</strong></div>
                            </div>
                            <div class="col-md-1 col-sm-4 col-xs-6">
                                <div class="text-success"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Approve</strong></div>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-6">
                                <div class="text-primary"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Approve By VP</strong></div>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-5 col-xs-6">
                                <div class="text-danger"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Reject</strong></div>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-4 col-xs-6">
                                <div class="text-warning"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Fulfill</strong></div>
                            </div>
                            <div class="col-md-3 col-sm-5 m-b-xs">
                            	<div class="text-warning" style="color:#C30;"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Direct Requsition</strong></div>
                            </div>
                        </div>
                        </div>
                        <div class="row wrapper" style="padding-left:2%;">
                            
                            {!! Form::open(['method'=>'POST','url'=>'vp-approve/history','class'=>'','role'=>'search'])  !!}
                            
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
                        <style>.bold{font-weight:bold; color:#C30; font-style:italic;}</style>
                        
                        <div class="table-responsive">
                          <table class="table table-striped table-hover b-t b-light" align="center" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000; font-size:13px;">
                            <thead>
                              <tr>
                                <th width="50" class="text-center bgtable"><i class="fa fa-check-square" style="color:#060;"></i></th>
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
                                <th class="text-center bgtable action-width" width="120" data-toggle="class">Action</th>
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
							
							$ecomps_vp_id = trim(Session::get('ecomps_vp_id'));
							
							// Get selected departments from User Account Table
							$tmp = DB::select(DB::raw("select dept_of_vp from useraccount where id='$ecomps_vp_id'"));
							
							$dept_of_vp = 0;
							if(count($tmp) > 0){
								$dept_of_vp = $tmp[0]->dept_of_vp;
							}
							$str = "select * from request where ".$cond." And is_fulfil=1 or vc_status=1 order by is_fulfil";
							//$str = "select * from request where ".$cond." And is_fulfil=1 And dept_id in (".$dept_of_vp.") order by CreateDate desc";
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
								
								$approver_name = '';
								$approver_level = '';
								
								$res_req = DB::table("useraccount")->select('FirstName', 'LastName')->where("id", $tmpdata->requestor_id)->get();
								if($tmpdata->requestor_id == trim($ecomps_vp_id)){
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
							
								?>
                              <tr style="cursor:pointer;">
                                <td class="text-center">
                                
                                <?php if($tmpdata->is_cancel || $tmpdata->vc_status == "2"){?>
                                <i class="fa fa-check-square" style="color:#f00;"></i>
                                <?php }else if($tmpdata->vc_status == "1"){?>
                                <i class="fa fa-check-square" style="color:#09F;"></i>
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
                                        <?php
										$cl = "";
										if($tmpdata->vc_status == "1"){
											$cl = "primary";
										}else if(($tmpdata->first_approver_status=="1" || $tmpdata->approve_by_admin == "1" || $is_fulfil=="1") && $tmpdata->vc_status == "0"){
											$cl = "success";
										}else if($tmpdata->first_approver_status=="2" || $tmpdata->is_cancel == "1"){
											$cl = "danger";
										}
										?>
                                        <div class="text-<?php echo $cl;?>"><i class="fa fa-circle"></i>
                                        </div>
                                    </div>
                                    <div style="width:50%; text-align:center; float:left;">
                                        <?php
										$cl = "";
										if($tmpdata->vc_status == "1"){
											$cl = "primary";
										}else if(($tmpdata->second_approver_status=="1" || $tmpdata->approve_by_admin == "1" || $is_fulfil=="1") && $tmpdata->vc_status == "0"){
											$cl = "success";
										}else if($tmpdata->second_approver_status=="2" || $tmpdata->is_cancel == "1"){
											$cl = "danger";
										}
										?>
                                        <div class="text-<?php echo $cl;?>"><i class="fa fa-circle"></i>
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
                                <td class="text-center"><a href="{{url('vp-approve/request')}}/{{$tmpdata->id}}/view/approver"><button type="button" class="btn btn-default btn-xs">View</button></a>&nbsp;<a href="{{url('vp-approve/request')}}/{{$tmpdata->id}}/message/board"><button type="button" class="btn btn-default btn-xs">Message</button></a>
                                
                                </td>
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