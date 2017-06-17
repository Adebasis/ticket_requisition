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
                    <div class="col-sm-4">
                    <span style="font-size:14px; font-weight:bold;"><i class="fa fa-envelope icon-muted"></i>&nbsp;Manage Games</span>
                    </div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/game','class'=>'','role'=>'search'])  !!}
                    <?php
					$teams = DB::table('team')->orderBy('Name', 'asc')->pluck('Name','id');
					?>
                    <div class="col-sm-3 m-b-xs">
                    {{ Form::select('team', $teams, app('request')->get('team') , array('placeholder' => 'Select Team ...', 'class'=>'form-control','id'=>'team', 'autofocus', '')) }}
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
                    
                    <div class="col-sm-2">
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a href="{{ url('/adminpanel/game/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable text-center">Sl.</th>
                        <th width="120" class="bgtable" data-toggle="class">Event Code</th>
                        <th class="bgtable" data-toggle="class">Team Name</th>
                        <th class="bgtable" data-toggle="class">Game Date</th>
                        <th class="text-center bgtable" data-toggle="class">GameNo</th>
                        <th class="th-sortable bgtable" data-toggle="class">DemandType</th>
                        <th class="th-sortable bgtable" data-toggle="class">PriceType</th>
                        <th class="text-center bgtable" data-toggle="class">RequestState</th>
                        <!--<th class="text-center bgtable" data-toggle="class">Purch</th>
                        <th class="text-center bgtable" data-toggle="class">Location</th>
                        <th class="text-center bgtable" data-toggle="class">Delivery</th>
                        <th class="text-center bgtable" data-toggle="class">Approve</th>
                        <th class="th-sortable bgtable" data-toggle="class">Fulfill</th>
                        <th class="text-center bgtable" data-toggle="class">Used</th>-->
                        <th class="text-center bgtable" width="120" data-toggle="class">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
					$query = app('request')->get('search');
					$team_id = app('request')->get('team');
					if($query != "" && $team_id == ""){
						$data = DB::table('game')->where('EventCode', 'LIKE', '%' . $query . '%')->get();
					}else if($query == "" && $team_id != ""){
						$data = DB::table('game')->where('team_id', '=', $team_id)->get();
					}else if($query != "" && $team_id != ""){
						$data = DB::table('game')->where('team_id', '=', $team_id)->where('EventCode', 'LIKE', '%' . $query . '%')->get();
					}else{
						$data = DB::table('game')->orderBy('id', 'desc')->get();
					}
					?>
                      @foreach ($data as $index=>$tmpdata)
                      	
                        <?php
						$res_team = DB::select("select * from team where id = '".$tmpdata->team_id."'");						
						?>
                      <tr style="cursor:pointer;">
                        <td class="text-center">{{$index + 1}}</td>
                        <td class="text-center">{{ $tmpdata->EventCode }}</td>
                        <td>{{ $res_team[0]->Name }}</td>
                        <td>{{ date('m/d/Y', strtotime($tmpdata->OriginalGameDate)) }}</td>
                        <td class="text-center">{{ $tmpdata->GameNumber }}</td>
                        <td>{{ getDataFromTable("demandtype","Name","id", $tmpdata->demandtype_id ) }}</td>
                        <td>{{ getDataFromTable("pricingtype","Name","id", $tmpdata->pricingtype_id ) }}</td>
                        <td class="text-center">{{ getDataFromTable("gamerequeststate","Name","id", $tmpdata->requeststate_id ) }}</td>
                        <!--<td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center">
                        
                        </td>
                        <td class="text-center">
                        
                        </td>-->
                        <td class="text-center"><a href="{{url('adminpanel/game')}}/{{$tmpdata->id}}/edit"><button type="button" class="btn btn-default btn-xs">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button></a>&nbsp;<a href="{{url('adminpanel/game')}}/{{$tmpdata->id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-default btn-xs">Delete</button></a></td>
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
		columnDefs: [ { orderable: false, targets: [8]}]
	});
} );
</script>