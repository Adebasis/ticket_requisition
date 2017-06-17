@section('title')
    My Requests
@stop

@include('includes.top')

<section class="vbox">
    
    @include('includes.header')
    
    <section>
        <section class="hbox stretch">
            
            <section class="panel">
                
                <?php
				$ecomps_admin_id = Session::get('ecomps_vp_id');
				?>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row wrapper" style="padding-left:2%;">
                            
                            <div class="col-sm-5">
                            <span style="font-size:14px; font-weight:bold;"><i class="fa fa-envelope icon-muted"></i>&nbsp;My Requests</span>
                            </div>
                            
                            {!! Form::open(['method'=>'GET','url'=>'vp-approve/my-requests','class'=>'','role'=>'search'])  !!}
                            
                            <div class="col-sm-3 m-b-xs">
                            
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" name="search" placeholder="Search By Event Code" value="{{ app('request')->get('search') }}">
                                    <span class="input-group-btn">
                                    <button class="btn btn-sm btn-default" type="submit">Go!</button>
                                    </span>
                                </div>
                            </div>
                            
                            {!! Form::close() !!}
                            
                            <div class="col-sm-1">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-toggle="modal" data-target="#myGameModal"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                                    </span>
                                </div>
                            </div>
                            
                        </div>
                        <input type="hidden" id="siteurl" value="{{url('/')}}">
                        <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                        <style>.ccc{text-decoration:line-through; color:#C30; font-style:italic;}</style>
                        <div class="table-responsive" style=" margin-left:2%; margin-right:1%;">
                          <table class="table table-striped table-hover b-t b-light" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000; font-size:13px;">
                            <thead>
                              <tr>
                                <th width="50" class="text-center bgtable"></th>
                                <th class="th-sortable bgtable" data-toggle="class">Recipient</th>
                                <th class="text-center bgtable" data-toggle="class">Game</th>
                                <th class="text-center bgtable" data-toggle="class">Created</th>
                                <th class="th-sortable bgtable" data-toggle="class">Request Position</th>
                                <th class="th-sortable bgtable" data-toggle="class">Company</th>
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
							  if(isset($search)){
								  $data = DB::table('request')->orWhere('RecipientFirstName', 'LIKE', '%' . $search . '%')->orWhere('RecipientLastName', 'LIKE', '%' . $search . '%')->where('requestor_id', '=', $ecomps_admin_id)->orderBy('CreateDate', 'desc')->paginate(20);
							  }else{
								  $data = DB::table('request')->where('requestor_id', '=', $ecomps_admin_id)->orderBy('CreateDate', 'desc')->paginate(20);
							  }
							  
							  ?>
                              @foreach ($data as $index=>$tmpdata)
                                
                                <?php
								$approver_name = '';
								$approver_level = '';
								$is_fulfil = $tmpdata->is_fulfil;
								
								if($is_fulfil == "1"){
									$approver_name = 'Fulfilled';
								}else if($is_fulfil == "0" && $tmpdata->is_forward_to_fulfil == "1"){
									$approver_name = 'Forwarded to Ticket Department';
								}
																
                                ?>
                              <tr style="cursor:pointer;">
                                <td class="text-center">
                                    <i class="fa fa-check-square" style="color:#000;"></i>
                                </td>
                                <td>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                                <td class="text-center">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                                <td class="text-center">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                <td>{{ $approver_name }}</td>
                                <td>{{ $tmpdata->CompanyName }}</td>
                                <td class="text-center">{{ $tmpdata->Comp }}</td>
                                <td class="text-center">{{ $tmpdata->Purchased }}</td>
                                <td class="text-center">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                                <td class="text-center">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                                <td class="text-center">
                                <div style="width:50%; text-align:center; float:left;">
                                    <div class="text-success">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                </div>
                                <div style="width:50%; text-align:center; float:left;">
                                    <div class="text-success">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                </div>
                                </td>
                                <td class="text-center">
                                <div class="text-<?php if($tmpdata->is_fulfil=="1"){?>warning<?php }?>">
                                    <i class="fa fa-circle"></i>
                                </div>
                                </td>
                                <td class="text-center">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td>
                                <td class="text-center"><a href="{{url('vp-approve/request')}}/{{$tmpdata->id}}/show/approver">
                                <button type="button" class="btn btn-default btn-xs">View</button></a></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        
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

<script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: [0,10,11,12,13]}]
	});
} );
</script>