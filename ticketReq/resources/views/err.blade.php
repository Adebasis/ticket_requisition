<?php
# Page Name			: err.blade.php
# Page Decription 	: This page will be appear when any exceptions in the system and when click on "GO BACK" button to call javascript as history.back function
#					: Like NotFoundHttpException, ErrorException, FatalErrorException
?>
@section('title')
    Error
@stop

<?php
	$url = url()->current();
	$url = explode("/", $url);
	if(in_array("adminpanel", $url)){
		?>

@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section>
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
                                <div class="col-sm-6">
                                <strong><h1>We were unable to process your request</h1></strong><br />
                                <h2><a href="javascript:void(0);" onclick="goBack()"><u>Click HERE</u></a> to send a report to the Help Desk and return to your previous page</h2>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6"><!--<input type="button" class="btn btn-success btn-sm" id="btn" onclick="goBack()" value="GO BACK">--></div>
                                <div class="col-sm-1"></div>
                            </div>
                            <script>
							function goBack() {
								
								$('#btn').html('&nbsp;&nbsp;&nbsp;Processing ...&nbsp;&nbsp;');
								
								/*var url = $('#siteurl').val();
								var csrf = "aa";//$('#csrf').val();
								var page_url = $('#page_url').val();
								var err_desc = $('#err_desc').val();
								$.ajax({
									type: "GET",
									url: url + "/admin_post_error_logs",
									data: {"page_url":page_url ,"_token":csrf,"err_desc":err_desc},
									success: function (data) {
										if(data == "success"){
											window.history.back();
										}
									}
								});*/
								window.history.back();			
							}
							</script>
                            <?php /*?>{!! Form::open(['method'=>'POST','url'=>'adminpanel/requests','class'=>'','role'=>'search'])  !!}
                            <input type="hidden" id="siteurl" value="{{url('/')}}">
			                <input type="hidden" id="csrf" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" id="page_url" value="{{ $page_url }}">
                            <input type="hidden" id="err_desc" value="{{ $err_desc }}">
                            {!! Form::close() !!}<?php */?>
                            <div class="row">
                                <div class="col-sm-1" id="countdown_text"></div>
                            </div>                           
                        </section>
                    </section>
                </section>
        </section>
    </section>
</section>

@include('admin.includes.admin_footer')

<?php
	}else{
	?>
	    @include('includes.top')
        
        <section class="vbox">
    
			@include('includes.header')
    
            
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
                                <div class="col-sm-6">
                                <strong><h1>We were unable to process your request</h1></strong><br />
                                <h2><a href="javascript:void(0);" onclick="goBack()"><u>Click HERE</u></a> to send a report to the Help Desk and return to your previous page</h2>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6"><!--<input type="button" class="btn btn-success btn-sm" id="btn" onclick="goBack()" value="GO BACK">--></div>
                                <div class="col-sm-1"></div>
                            </div>
                            <script>
							function goBack() {
								
								$('#btn').html('&nbsp;&nbsp;&nbsp;Processing ...&nbsp;&nbsp;');
								
								/*var url = $('#siteurl').val();
								var csrf = "aa";//$('#csrf').val();
								var page_url = $('#page_url').val();
								var err_desc = $('#err_desc').val();
								$.ajax({
									type: "GET",
									url: url + "/admin_post_error_logs",
									data: {"page_url":page_url ,"_token":csrf,"err_desc":err_desc},
									success: function (data) {
										if(data == "success"){
											window.history.back();
										}
									}
								});*/
								window.history.back();			
							}
							</script>
                            {!! Form::open(['method'=>'POST','url'=>'adminpanel/requests','class'=>'','role'=>'search'])  !!}
                            <input type="hidden" id="siteurl" value="{{url('/')}}">
			                <input type="hidden" id="csrf" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" id="page_url" value="{{ $page_url }}">
                            <input type="hidden" id="err_desc" value="{{ $err_desc }}">
                            {!! Form::close() !!}
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
	@include('includes.admin_footer')
<?php }?>

