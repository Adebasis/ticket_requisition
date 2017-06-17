@section('title')
    Maintenance Mode
@stop

@include('includes.top')

<section class="vbox">
	
    <section class="vbox">
	
    <header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
        <div class="navbar-header aside-md dk">
            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target="#nav"><i class="fa fa-bars"></i></a>
            <?php
            $appsettings = DB::table('appsettings')->where('id', 2)->get();
            ?>
            <a href="{{ url('/') }}" class="navbar-brand"><img src="{{ url('/') }}/public/admin_assets/images/<?php echo $appsettings[0]->Value; ?>" class="m-r-sm" alt="scale"><span class="hidden-nav-xs">eComps</span></a>
            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user"><i class="fa fa-cog"></i></a>
        </div>    
    </header>
        
    <section class="hbox stretch">
        <section id="content">
            <section class="hbox stretch">
                <section>
                    <section class="vbox">
                        <section class="scrollable padder">
                            <section class="row m-b-md" >
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6 text-right text-left-xs m-t-md"></div>
                            </section>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-10 text-center">
                                <?php
                                $err_data=DB::table("appsettings")->where('id',"=",6)->get();
								echo $err_data[0]->Value;
                                ?>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-1"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-1" id="countdown_text"></div>
                            </div>                           
                        </section>
                    </section>
                </section>
            </section>
        	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
    </section>

