@section('title')
Home
@stop

@include('includes.top')

<section class="vbox">

    @include('includes.header')

    <section>
        <section class="hbox stretch">

            <section id="content">
                <section class="hbox stretch">

                    <section>
                        <section class="vbox md-block">
                            <section class="scrollable padder">
                                <section class="row m-b-md" >
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6 text-right text-left-xs m-t-md"></div>
                                </section>
                                <div class="row">
                                    <div class="col-sm-5"></div>
                                    <div class="col-sm-5"><strong>RECENT ACTIVITY</strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <!--<div id="calendar" class="calendar bg-light dker m-l-n-xxs m-r-n-xxs"></div>-->
                                        <?php
                                        $ecomps_user_id = Session::get('ecomps_user_id') ? Session::get('ecomps_user_id') : 0;
                                        $users = DB::table('useraccount')->where('id', $ecomps_user_id)->get();
                                        $department = DB::table('department')->where('id', $users[0]->dept_id)->get();
                                        $department_name = '';
                                        if (count($department) > 0) {
                                            $department_name = $department[0]->Name;
                                        }
                                        ?>
                                        <div class="wrapper">
                                            <section class="panel no-border bg-primary lt">
                                                <div class="panel-body">
                                                    <div class="row m-t-xl">
                                                        <div class="col-xs-3 text-right padder-v">
                                                          <!--<a href="#" class="btn btn-primary btn-icon btn-rounded m-t-xl"><i class="i i-mail2"></i></a>-->
                                                        </div>
                                                        <div class="col-sm-6 text-center">
                                                            <div class="">
                                                                <div class="easypiechar1t easyPieChart1" data-percent="75" data-line-width="6" data-bar-color="#fff" data-track-color="#2796de" data-scale-color="false" data-size="140" data-line-cap="butt" data-animate="1000" style="height: 140px; line-height: 140px;">
                                                                    <div class="thumb-lg avatar">
                                                                        <img src="{{ url('/') }}/public/admin_assets/images/a0.png" class="dker">
                                                                    </div>
                                                                    <canvas width="140" height="140"></canvas></div>
                                                                <div class="h4 m-t m-b-xs font-bold text-lt"><?php echo $users[0]->FirstName; ?>&nbsp;<?php echo $users[0]->LastName; ?></div>
                                                                <small class="text-muted m-b"><?php echo $department_name; ?></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-3 padder-v">
                                                            <!--<a href="#" class="btn btn-primary btn-icon btn-rounded m-t-xl" data-toggle="class:btn-danger">
                                                              <i class="i i-phone text"></i>
                                                              <i class="i i-phone2 text-active"></i>
                                                            </a>-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <footer class="panel-footer dk text-center no-border">
                                                    <div class="row pull-out">
                                                        <?php
                                                        //echo $ecomps_user_id;
                                                        $no_total = DB::table('request')->where('requestor_id', $ecomps_user_id)->count();
                                                        $no_pending = DB::table('request')->where('requestor_id', $ecomps_user_id)->where('req_prec', 0)->count();
                                                        $no_approve = DB::table('request')->where('requestor_id', $ecomps_user_id)->where('req_prec', 1)->count();
                                                        $no_fulfil = DB::table('request')->where('requestor_id', $ecomps_user_id)->where('req_prec', 2)->count();
                                                        $no_reject = DB::table('request')->where('requestor_id', $ecomps_user_id)->where('req_prec', 3)->count();
                                                        $no_cancel = DB::table('request')->where('requestor_id', $ecomps_user_id)->where('req_prec', 4)->count();
                                                        ?>
                                                        <div class="col-xs-2 col-xxs-4 bb">
                                                            <div class="padder-v">
                                                                <span class="m-b-xs h3 block text-white"><?php echo $no_total; ?></span>
                                                                <small class="text-muted">Total</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-xxs-4 bb dker">
                                                            <div class="padder-v">
                                                                <span class="m-b-xs h3 block text-white"><?php echo $no_pending; ?></span>
                                                                <small class="text-muted">Pending</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-xxs-4 bb dker">
                                                            <div class="padder-v">
                                                                <span class="m-b-xs h3 block text-white"><?php echo $no_approve; ?></span>
                                                                <small class="text-muted">Approve</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-xxs-4 bb">
                                                            <div class="padder-v">
                                                                <span class="m-b-xs h3 block text-white"><?php echo $no_fulfil; ?></span>
                                                                <small class="text-muted">Fulfill</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-xxs-4 bb dker">
                                                            <div class="padder-v">
                                                                <span class="m-b-xs h3 block text-white"><?php echo $no_reject; ?></span>
                                                                <small class="text-muted">Reject</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-xxs-4 bb dker">
                                                            <div class="padder-v">
                                                                <span class="m-b-xs h3 block text-white"><?php echo $no_cancel; ?></span>
                                                                <small class="text-muted">Cancel</small>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </footer>
                                            </section>
                                        </div>

                                    </div>
                                    <input type="hidden" id="siteurl" value="{{url('/')}}">
                                    <script>
                                        function redirectto(game_id) {
                                            var url = $('#siteurl').val();
                                            window.location = url + '/game/' + game_id + '/view';
                                        }
                                    </script>
                                    <div class="col-md-7 row">
                                        <div class="col-sm-12">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                                                    <thead>
                                                        <tr>
                                                            <th width="150" class="bgtable">Game</th>
                                                            <th class="bgtable">Recipient</th>
                                                            <th width="80" class="text-center bgtable">Type</th>
                                                            <th width="50" class="text-center bgtable">Comp</th>
                                                            <th width="50" class="text-center bgtable">Purch</th>
                                                            <th width="150" class="text-center bgtable">Created</th>
                                                            <th width="70" class="text-center bgtable">Status</th>
                                                            <th width="90" class="text-center bgtable">Message</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    $current_date = date('Y-m-d');
                                                    $ecomps_user_id = Session::get('ecomps_user_id') ? Session::get('ecomps_user_id') : 0;
                                                    $reqs = DB::table('request')->orderBy('id', 'desc')->where('requestor_id', $ecomps_user_id)->limit(5)->get();
                                                    if (count($reqs) > 0) {
                                                        ?>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($reqs as $index => $tmpreqs) {

                                                                $requeststate = '';
                                                                $OriginalGameDate = '';
                                                                if ($tmpreqs->game_id > 0) {
                                                                    $tmpgame = DB::table('game')->select('requeststate_id', 'OriginalGameDate')->where('id', $tmpreqs->game_id)->get();
                                                                    $requeststate = getDataFromTable("gamerequeststate", "Name", "id", $tmpgame[0]->requeststate_id);
                                                                    $OriginalGameDate = date('m/d/Y h:i A', strtotime($tmpgame[0]->OriginalGameDate));
                                                                }
                                                                $CreateDate = date('m/d/Y h:i A', strtotime($tmpreqs->CreateDate));

                                                                $approver_name = '';
                                                                $approver_level = '';

                                                                if ($tmpreqs->req_position == "1" && $tmpreqs->first_approver > 0) {

                                                                    $approver = getDataFromTableMultiColumns("useraccount", "FirstName,LastName", "id", $tmpreqs->first_approver);
                                                                    $approver_level = 'First Level Approver';
                                                                    $approver_name = $approver->FirstName . ' (' . $approver_level . ')';
                                                                }

                                                                if ($tmpreqs->req_position == "2") {
                                                                    $approver_name = 'Second Level Approver';
                                                                }
                                                                if ($tmpreqs->sent_to_vc == "1") {
                                                                    $approver_name = 'Vice President';
                                                                }

                                                                $is_fulfil = $tmpreqs->is_fulfil;

                                                                if ($is_fulfil == "1") {
                                                                    $approver_name = 'Fulfilled';
                                                                } else if ($is_fulfil == "0" && $tmpreqs->is_forward_to_fulfil == "1") {
                                                                    $approver_name = 'Forwarded to Ticket Department';
                                                                }
                                                                $is_unread_message = DB::table('request_message')->where('request_id', '=', $tmpreqs->id)->where('readby_requestor', 0)->count();
                                                                //exit;
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $OriginalGameDate; ?></td>
                                                                    <td><?php echo $approver_name; ?></td>
                                                                    <td class="text-center"><?php echo $requeststate; ?></td>
                                                                    <td class="text-center"><?php echo $tmpreqs->Comp; ?></td>
                                                                    <td class="text-center"><?php echo $tmpreqs->Purchased; ?></td>
                                                                    <td class="text-center"><?php echo $CreateDate; ?></td>
                                                                    <td class="text-center">
                                                                        <?php
                                                                        if ($tmpreqs->sent_to_vc == "1") {
                                                                            ?>
                                                                            <div style="width:100%; text-align:center; float:left;">
                                                                                <div class="text-<?php if ($tmpreqs->vc_status == "1" || $tmpreqs->approve_by_admin == "1") { ?>success<?php } else if ($tmpreqs->vc_status == "2" || $tmpreqs->is_cancel == "1") { ?>danger<?php } ?>">
                                                                                    <i class="fa fa-circle"></i>
                                                                                </div>
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <div style="width:50%; text-align:center; float:left;">
                                                                                <div class="text-<?php if ($tmpreqs->first_approver_status == "1" || $tmpreqs->approve_by_admin == "1") { ?>success<?php } else if ($tmpreqs->first_approver_status == "2") { ?>danger<?php } ?>">
                                                                                    <i class="fa fa-circle"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div style="width:50%; text-align:center; float:left;">
                                                                                <div class="text-<?php if ($tmpreqs->second_approver_status == "1" || $tmpreqs->approve_by_admin == "1") { ?>success<?php } else if ($tmpreqs->second_approver_status == "2") { ?>danger<?php } ?>">
                                                                                    <i class="fa fa-circle"></i>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td class="text-center"><a href="{{url('history/request/')}}/{{$tmpreqs->id}}/message/board"><button type="button" class="btn btn-default btn-xs">Message</button><?php if ($is_unread_message > 0) { ?>
                                                                                <span class="badge badge-sm up bg-success count" style="display: inline-block;">!</span>
                                                                            <?php } ?></a></td>

                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
    <?php if (count($reqs) == 0) { ?>
                                                                <tr>
                                                                    <td colspan="6" class="text-center">NO RECENT ACTIVITY FOUND !!!</td>
                                                                </tr>
    <?php } ?>
                                                        </tbody>

<?php } ?>
                                                </table>
                                            </div>

                                            <?php
                                            $ecomps_admin_id = trim(Session::get('ecomps_user_id'));
                                            $approver_level = trim(Session::get('ecomps_user_approver_level'));
                                            if ($approver_level == "first") {
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-8"><strong>NEW REQUESTS</strong></div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                                                        <thead>
                                                            <tr>
                                                                <th class="bgtable">Requestor</th>
                                                                <th class="bgtable">Recipient</th>
                                                                <th class="text-center bgtable">Company</th>
                                                                <th class="text-center bgtable">Game</th>
                                                                <th class="text-center bgtable">Created</th>
                                                                <th class="text-center bgtable">Location</th>
                                                                <th class="text-center bgtable">Delivery</th>
                                                                <th class="text-center bgtable">Comp/Purch</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $str = "select * from request where first_approver='$ecomps_admin_id' And user_cancel=0 And is_fulfil=0 And vc_status=0 And approve_by_admin=0 order by CreateDate desc";
                                                        $data = DB::select(DB::raw($str));
                                                        ?>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($data as $index => $tmpdata) {

                                                                $res_req = DB::table("useraccount")->select('FirstName', 'LastName')->where("id", $tmpdata->requestor_id)->get();
                                                                $req_name = $res_req[0]->FirstName . ' ' . $res_req[0]->LastName;
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $req_name; ?></td>
                                                                    <td>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                                                                    <td class="text-center">{{ $tmpdata->CompanyName }}</td>
                                                                    <td class="text-center">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                                                                    <td class="text-center">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                                                    <td class="text-center">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                                                                    <td class="text-center">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                                                                    <td class="text-center">{{ $tmpdata->Comp }}/{{ $tmpdata->Purchased }}</td>

                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
    <?php if (count($data) == 0) { ?>
                                                                <tr>
                                                                    <td colspan="8" class="text-center">NO RECENT REQUEST FOUND !!!</td>
                                                                </tr>
    <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } ?>

                                            <?php
                                            $ecomps_admin_id = trim(Session::get('ecomps_user_id'));
                                            $is_fulfiler = trim(Session::get('ecomps_user_is_fulfiler'));
                                            if ($is_fulfiler == "1") {
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-8"><strong>NEW REQUESTS</strong></div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                                                        <thead>
                                                            <tr>
                                                                <th class="bgtable">Requestor</th>
                                                                <th class="bgtable">Recipient</th>
                                                                <th class="text-center bgtable">Company</th>
                                                                <th class="text-center bgtable">Game</th>
                                                                <th class="text-center bgtable">Created</th>
                                                                <th class="text-center bgtable">Location</th>
                                                                <th class="text-center bgtable">Delivery</th>
                                                                <th class="text-center bgtable">Comp/Purch</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        $str = "select * from request where is_forward_to_fulfil=1 And is_fulfil=0 order by CreateDate desc";
                                                        $data = DB::select(DB::raw($str));
                                                        ?>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($data as $index => $tmpdata) {

                                                                $res_req = DB::table("useraccount")->select('FirstName', 'LastName')->where("id", $tmpdata->requestor_id)->get();
                                                                $req_name = $res_req[0]->FirstName . ' ' . $res_req[0]->LastName;
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $req_name; ?></td>
                                                                    <td>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                                                                    <td class="text-center">{{ $tmpdata->CompanyName }}</td>
                                                                    <td class="text-center">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                                                                    <td class="text-center">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                                                    <td class="text-center">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                                                                    <td class="text-center">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                                                                    <td class="text-center">{{ $tmpdata->Comp }}/{{ $tmpdata->Purchased }}</td>

                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            ?>
                                                            <?php if (count($data) == 0) { ?>
                                                                <tr>
                                                                    <td colspan="8" class="text-center">NO RECENT REQUEST FOUND !!!</td>
                                                                </tr>
                                                <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
<?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>
                    </section>

                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>

        </section>

        @include('includes.admin_footer')
        {!!HTML::script('public/admin_assets/js/fullcalendar/fullcalendar.min.js')!!}
        {!! Html::style('public/admin_assets/js/fullcalendar/fullcalendar.css') !!}
        {!! Html::style('public/admin_assets/js/fullcalendar/theme.css')!!}