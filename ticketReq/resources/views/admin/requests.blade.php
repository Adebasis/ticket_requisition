@include('admin.includes.top')

<section class="vbox">

    @include('admin.includes.header')

    {!! Html::style('public/admin_assets/js/datatables/datatables.css') !!}

    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            <?php /* ?>@include('admin.includes.left')<?php */ ?>
            <!-- /.aside -->

            <?php
            $no_pending = DB::table('request')->where('req_prec', 0)->count();
            $no_approve = DB::table('request')->where('req_prec', 1)->count();
            $no_fulfil = DB::table('request')->where('req_prec', 2)->count();
            $no_reject = DB::table('request')->where('req_prec', 3)->count();
            $no_cancel = DB::table('request')->where('req_prec', 4)->count();

            $search = trim(app('request')->get('search'));
            $year = trim(app('request')->get('year'));
            $requestor = trim(app('request')->get('requestor'));
            $req_prec = trim(app('request')->get('req_prec'));

            $game = app('request')->get('game');
            if (count($game) == 0) {
                $game = array();
            }

            $locationtype = trim(app('request')->get('locationtype'));
            $deliverytype = trim(app('request')->get('deliverytype'));
            ?>

            <section class="panel">
                <div class="wrapper">
                    <div class="col-xlg-2 mb-10 mt-xs-50">
                        <span style="font-size:14px; font-weight:bold;"><i class="fa fa-envelope icon-muted"></i>&nbsp;Manage Requests</span>
                    </div>
                    <div class="clearfix hidden-xlg"></div>
                    <div class="col-sm-2 col-xs-6">
                        <div style="color:#000;"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Pending(<?php echo $no_pending; ?>)</strong></div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="text-success"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Approve(<?php echo $no_approve; ?>)</strong></div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="text-danger"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Reject(<?php echo $no_reject; ?>)</strong></div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="text-warning"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Fulfill(<?php echo $no_fulfil; ?>)</strong></div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="text-warning" style="color:#F60;text-decoration:line-through;"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Cancel(<?php echo $no_cancel; ?>)</strong></div>
                    </div>
                    <div class="clearfix hidden-xlg"></div>
                    <div class="col-sm-9 col-lg-9 col-md-8 hidden-sm hidden-xs"></div>
                    <div class="col-lg-3 col-md-4 mt-md-10 m-b-xs">
                        <div class="clearfix"></div>
                        {{Form::button('Approve Requisition',array('class'=>'btn btn-success btn-sm','id'=>'btnApr','onclick'=>'StatusChanged(1);'))}}
                        {{Form::button('Reject Requisition',array('class'=>'btn btn-danger btn-sm','id'=>'btnReject','onclick'=>'StatusChanged(4);'))}}
                    </div>
                </div>

                {!! Form::open(['method'=>'POST','url'=>'adminpanel/requests','class'=>'','role'=>'search'])  !!}

                <div class="wrapper">
                    <div class="col-lg-1 col-md-3 col-sm-4 mb-md-10">
                        <select name="year" class="form-control">
                            <option value="">-- ALL --</option>
                            <?php
                            $years = DB::select("SELECT YEAR(CreateDate) as yr from request GROUP by year(CreateDate) ORDER BY yr DESC");
                            foreach ($years as $yr) {
                                ?>
                                <option value="<?php echo $yr->yr; ?>" <?php if ($yr->yr == $year) { ?> selected="selected" <?php } ?>><?php echo $yr->yr; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php
                    $requestors = DB::select("SELECT id,FirstName,LastName from useraccount where id IN (select requestor_id from request) order by FirstName");
                    ?>
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-md-10">
                        <select name="requestor" class="form-control">
                            <option value="">ALL REQUESTORS</option>
                            <?php foreach ($requestors as $t) { ?>
                                <option value="<?php echo $t->id; ?>" <?php if ($t->id == $requestor) { ?> selected="selected" <?php } ?>><?php echo $t->FirstName; ?> <?php echo $t->LastName; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php
                    $team = DB::select("SELECT g.id,t.Name,g.OriginalGameDate from team t,game g where t.id=g.team_id And g.requeststate_id=3 And g.id IN (select game_id from request) GROUP by g.id,t.Name,g.OriginalGameDate ORDER BY g.OriginalGameDate");
                    ?>
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-md-10">
                        <select name="game[]"  multiple="multiple" class="form-control selectpicker">
                            <?php foreach ($team as $t) { ?>
                                <option value="<?php echo $t->id; ?>" <?php if (in_array($t->id, $game)) { ?> selected="selected" <?php } ?>><?php echo date('m/d/Y', strtotime($t->OriginalGameDate)); ?> - <?php echo $t->Name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-md-10">
                        <?php
                        $locationtypes = DB::table('locationtype')->orderBy('Name')->get();
                        ?>
                        <select name="locationtype" class="form-control">
                            <option value="">ALL LOCATIONS</option>
                            <?php foreach ($locationtypes as $t) { ?>
                                <option value="<?php echo $t->id; ?>" <?php if ($t->id == $locationtype) { ?> selected="selected" <?php } ?>><?php echo $t->Name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-md-10">
                        <?php
                        $deliverytypes = DB::table('deliverytype')->orderBy('Name')->get();
                        ?>
                        <select name="deliverytype" class="form-control">
                            <option value="">ALL DELIVERY</option>
                            <?php foreach ($deliverytypes as $t) { ?>
                                <option value="<?php echo $t->id; ?>" <?php if ($t->id == $deliverytype) { ?> selected="selected" <?php } ?>><?php echo $t->Name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php
                    // 0 = Pending
                    // 1 = approve
                    // 2 = fulfil
                    // 3 = reject/cancel
                    // 4 = user cancel
                    ?>
                    <div class="col-lg-1 col-md-3 col-sm-4 mb-md-10">
                        <select name="req_prec" class="form-control">
                            <option value="">STATUS</option>
                            <option value="0" <?php if ($req_prec == "0") { ?> selected="selected" <?php } ?>>Pending</option>
                            <option value="1" <?php if ($req_prec == "1") { ?> selected="selected" <?php } ?>>Approve</option>
                            <option value="2" <?php if ($req_prec == "2") { ?> selected="selected" <?php } ?>>Fulfil</option>
                            <option value="3" <?php if ($req_prec == "3") { ?> selected="selected" <?php } ?>>Reject</option>
                            <option value="4" <?php if ($req_prec == "4") { ?> selected="selected" <?php } ?>>Cancel</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-md-10">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search" placeholder="Search By Recipient" value="{{ app('request')->get('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">SEARCH</button>
                            </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                {!! Form::close() !!}

                <input type="hidden" id="siteurl" value="{{url('/')}}">
                <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                <style>.ccc{text-decoration:line-through; color:#C30; font-style:italic;}</style>
                <script>
                    function request_redirectme(pk_id) {
                        var url = $('#tmp_site_url').val();
                        window.location = url + '/adminpanel/requests/' + pk_id + '/view/edit';
                    }
                    function checkedAll() {
                        $("input:[name=reqIDs]").prop('checked', $('#checkAll')[0].checked);
                    }
                    ;
                    function StatusChanged(status) {
                        var checkValues = $('input[name=reqIDs]:checked').map(function () {
                            return $(this).val();
                        }).get();

                        if (checkValues == "") {
                            alert("Select atleast one request to continue..");
                            return false;
                        }
                        if (status == '1') {
                            var result = confirm("Are you sure you want to Approve this Request?");
                        } else {
                            var result = confirm("Are you sure you want to Reject this Request?");
                        }

                        // POST Ajax
                        if (result) {

                            if (status == '1') {
                                $('#btnApr').html('&nbsp;&nbsp;&nbsp;&nbsp;Processing ...&nbsp;&nbsp;&nbsp;&nbsp;');
                            } else {
                                $('#btnReject').html('&nbsp;&nbsp;&nbsp;Processing ...&nbsp;&nbsp;');
                            }
                            var url = $('#siteurl').val();
                            var csrf = $('#csrf').val();
                            $.ajax({
                                type: "POST",
                                url: url + "/admin_post_requests_multi_approved",
                                data: {"checkValues": checkValues, "_token": csrf, "status": status},
                                success: function (data) {
                                    if (data == "success") {
                                        window.location = url + '/adminpanel/requests'
                                    }
                                    //console.log(data);
                                }
                            });
                        }
                    }
                </script>
                <div class="table-responsive">
                    <table class="table table-striped table-hover b-t b-light" border="1" id="example" align="center" bordercolor="#ccc" style="border-collapse:collapse; color:#000; font-size:12px;">
                        <thead>
                            <tr>
                                <th width="50" class="bgtable text-center"><input type="checkbox" id="checkAll" onclick="checkedAll();" /></th>
                                <th class="th-sortable bgtable" width="130" data-toggle="class">Requestor</th>
                                <th class="text-center bgtable" data-toggle="class">Game</th>
                                <th class="text-center bgtable" data-toggle="class">Created</th>
                                <th class="th-sortable bgtable" width="120" data-toggle="class">Recipient</th>
                                <th class="th-sortable bgtable" data-toggle="class">Company</th>
                                <th class="th-sortable bgtable" data-toggle="class">Department</th>
                                <th class="text-center bgtable" width="70" data-toggle="class">Comp</th>
                                <th class="text-center bgtable" width="70" data-toggle="class">Purch</th>
                                <th class="text-center bgtable" data-toggle="class">Location</th>
                                <th class="text-center bgtable" data-toggle="class">Delivery</th>
                                <th class="text-center bgtable" data-toggle="class">Approve</th>
                                <th class="th-sortable bgtable" width="20" data-toggle="class">Fulfill</th>
                                <!--<th class="text-center bgtable" data-toggle="class">Used</th>-->
                                <th class="th-sortable bgtable" width="35" data-toggle="class">Status</th>
                                <th class="text-center bgtable action-width" width="125" data-toggle="class">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sch = '';
                            if ($search != '') {
                                $sch = $sch . "(RecipientFirstName like '%$search%' OR RecipientLastName like '%$search%') AND ";
                            }
                            if ($year != '') {
                                $sch = $sch . "year(CreateDate) = '$year%' AND ";
                            }
                            if ($requestor != '') {
                                $sch = $sch . "requestor_id = '$requestor' AND ";
                            }
                            if (count($game) > 0) {
                                $tmp_games = implode(",", $game);
                                $sch = $sch . "game_id IN ($tmp_games) AND ";
                            }
                            if ($locationtype != '') {
                                $sch = $sch . "locationtype_id = '$locationtype' AND ";
                            }
                            if ($deliverytype != '') {
                                $sch = $sch . "deliverytype_id = '$deliverytype' AND ";
                            }
                            if ($req_prec != '') {
                                $sch = $sch . "req_prec = '$req_prec' AND ";
                            }
                            $sch = substr($sch, 0, -5);

                            if ($sch != '') {
                                $cond = "id!='' And " . $sch;
                            } elseif ($sch == '') {
                                $cond = "id!=''";
                            }
                            //echo $cond;
                            $query = app('request')->get('search');
                            if ($query) {
                                $str = "select *,(select CONCAT(FirstName,' ',LastName) from useraccount where id=requestor_id) as requester_name,(select OriginalGameDate from game where id=game_id) as OriginalGameDate,(select Name from department where id=dept_id) as department,(select Name from locationtype where id=locationtype_id) as locationtype,(select Name from deliverytype where id=deliverytype_id) as deliverytype from request where " . $cond . " order by req_prec ASC,CreateDate DESC";
                            } else {
                                $str = "select *,(select CONCAT(FirstName,' ',LastName) from useraccount where id=requestor_id) as requester_name,(select OriginalGameDate from game where id=game_id) as OriginalGameDate,(select Name from department where id=dept_id) as department,(select Name from locationtype where id=locationtype_id) as locationtype,(select Name from deliverytype where id=deliverytype_id) as deliverytype from request WHERE " . $cond . " order by req_prec ASC,CreateDate DESC";
                            }
                            $data = DB::select(DB::raw($str));
							
                            ?>

                            @foreach ($data as $index=>$tmpdata)

                            <?php
                            $requester_name = $tmpdata->requester_name;

                            $approver = "";

                            // Get Status
                            // 1 = APPROVED
                            // 2 = FULFILLED
                            // 4 = REJECTED
                            $is_fulfil = $tmpdata->is_fulfil;

                            $is_unread_message = DB::table('request_message')->where('request_id', '=', $tmpdata->id)->where('readby_admin', '=', NULL)->count();
                            $is_forward_to_fulfil = $tmpdata->is_forward_to_fulfil;
                            ?>
                            <tr style="cursor:pointer;">
                                <td class="text-center">
                                    <?php if ($is_fulfil == "1" || $is_forward_to_fulfil == "1" || $tmpdata->approve_by_admin == "1") { ?>
                                        <i class="fa fa-check-square" style="color:#090;"></i>
                                    <?php } else if ($tmpdata->first_approver_status == "2" || $tmpdata->second_approver_status == "2" || $tmpdata->vc_status == "2" || $tmpdata->is_cancel == 1 || $tmpdata->user_cancel == "1") { ?>
                                        <i class="fa fa-check-square" style="color:#f00;"></i>
                                    <?php } else { ?>
                                        <!--<i class="fa fa-check-square" style="color:#000;"></i>-->
                                        <input type="checkbox" name="reqIDs" value="{{ $tmpdata->id }}" />
                                    <?php } ?>
                                </td>
                                <td <?php if ($tmpdata->user_cancel == "1") { ?> class="ccc" <?php } ?>>{{ $requester_name }}</td>

                                <td class="text-center <?php
                                if ($tmpdata->user_cancel == "1") {
                                    echo "ccc";
                                }
                                ?>">
                                <?php echo date('m/d/Y', strtotime($tmpdata->OriginalGameDate)); ?></td>
                                <td class="text-center <?php
                                if ($tmpdata->user_cancel == "1") {
                                    echo "ccc";
                                }
                                ?>">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                <td <?php if ($tmpdata->user_cancel == "1") { ?> class="ccc" <?php } ?>>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                                <td <?php if ($tmpdata->user_cancel == "1") { ?> class="ccc" <?php } ?>>{{ $tmpdata->CompanyName }}</td>
                                <td <?php if ($tmpdata->user_cancel == "1") { ?> class="ccc" <?php } ?>><?php echo $tmpdata->department; ?></td>
                                <td class="text-center <?php
                                    if ($tmpdata->user_cancel == "1") {
                                        echo "ccc";
                                    }
                                    ?>">{{ $tmpdata->Comp }}</td>
                                <td class="text-center <?php
                                if ($tmpdata->user_cancel == "1") {
                                    echo "ccc";
                                }
                                ?>">{{ $tmpdata->Purchased }}</td>
                                <td class="text-center <?php
                                    if ($tmpdata->user_cancel == "1") {
                                        echo "ccc";
                                    }
                                    ?>"><?php echo $tmpdata->locationtype; ?></td>
                                <td class="text-center <?php
                                    if ($tmpdata->user_cancel == "1") {
                                        echo "ccc";
                                    }
                                    ?>"><?php echo $tmpdata->deliverytype; ?></td>
                                <td class="text-center">
										<?php
                                        if ($tmpdata->sent_to_vc == "1") {
                                            ?>
                                        <div style="width:100%; text-align:center; float:left;">
                                            <div class="text-<?php if ($tmpdata->vc_status == "1" || $tmpdata->approve_by_admin == "1") { ?>success<?php } else if ($tmpdata->is_cancel == "1") { ?>danger<?php } ?>">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                        </div>
										<?php } else { ?>
                                            <?php
                                            $is_app = $tmpdata->first_approver_status;
                                            ?>
                                        <div style="width:50%; text-align:center; float:left;">
                                            <div class="text-<?php if ($is_app == "1" || $is_forward_to_fulfil == "1" || $tmpdata->approve_by_admin == "1") { ?>success<?php } else if ($is_app == "2" || $tmpdata->is_cancel == "1") { ?>danger<?php } ?>">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                        </div>
										<?php
                                        $is_app = $tmpdata->second_approver_status;
                                        ?>
                                        <div style="width:50%; text-align:center; float:left;">
                                            <div class="text-<?php if ($is_app == "1" || $is_forward_to_fulfil == "1" || $tmpdata->approve_by_admin == "1") { ?>success<?php } else if ($is_app == "2" || $tmpdata->is_cancel == "1") { ?>danger<?php } ?>">
                                                <i class="fa fa-circle"></i>
                                            </div>
                                        </div>
                                        <?php } ?>
                                </td>
                                <td class="text-center">
                                    <div class="text-<?php if ($is_fulfil == "1") { ?>warning<?php } ?>">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                </td>
                                <?php /* ?><td class="text-center <?php if($tmpdata->user_cancel == "1"){ echo "ccc"; }?>">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td><?php */ ?>
                                <td class="text-center <?php
                                        if ($tmpdata->user_cancel == "1") {
                                            echo "ccc";
                                        }
                                        ?>">
								<?php
                                if ($tmpdata->req_prec == 0) {
                                    echo "Pending";
                                } else if ($tmpdata->req_prec == "1") {
                                    echo "Approve";
                                } else if ($tmpdata->req_prec == "2") {
                                    echo "Fulfil";
                                } else if ($tmpdata->req_prec == "3") {
                                    echo "Reject";
                                } else if ($tmpdata->req_prec == "4") {
                                    echo "Cancel";
                                }
                                ?>
                                </td>
                                <td class="text-center"><a href="{{url('adminpanel/requests')}}/{{$tmpdata->id}}/view/edit">
                                        <button type="button" class="btn btn-default btn-xs">View</button></a>&nbsp;<a href="{{url('adminpanel/requests')}}/{{$tmpdata->id}}/message/board">
                                        <button type="button" class="btn btn-default btn-xs">Message</button>
                                        <?php if ($is_unread_message > 0) { ?>
                                            <span class="badge badge-sm up bg-success count" style="display: inline-block;">!<?php //echo $is_unread_message;  ?></span>
<?php } ?>
                                    </a></td>
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
        .table{width:100%;}
    </style>
    {!! Html::style('public/admin_assets/js/datatables/datatables.css') !!}
    {!!HTML::script('public/admin_assets/js/datatables/jquery.dataTables.min.js')!!}

    {!! Html::style('public/admin_assets/css/bootstrap-select.min.css') !!}
    {!!HTML::script('public/admin_assets/js/bootstrap-select.min.js')!!}
<?php /* ?><script>
  $(document).ready(function() {
  $('#example').DataTable({
  order: [],
  "pageLength": 50,
  columnDefs: [ { orderable: false, targets: [0,11,12,13,15]}]
  });
  } );
  </script><?php */ ?>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                order: [],
                "pageLength": 10,
                columnDefs: [{orderable: false, targets: [0, 11, 12, 13, 14]}]
            });
        });
    </script>