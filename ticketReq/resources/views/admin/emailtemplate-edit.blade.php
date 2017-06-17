@include('admin.includes.top')

<script>
function Validation(){
	if($('#Name').val().trim() == ""){
		$('#Name').focus();
		return false;
	}
}
</script>

{!!HTML::script('public/ckeditor/ckeditor.js')!!}

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
            <section id="content">
                <section class="hbox stretch">
                    <section>
                        <section class="vbox">
                            <section class="scrollable padder">              
                                <section class="row m-b-md"></section>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">Email Template [Edit]</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'AdminController@admin_post_emailtemplate_edit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    
                                                    <div class="form-group">
                                                        {{ Form::label('title', 'Title') }}
                                                        {!!Form::text('title',$data[0]->title,array('class'=>'form-control','id'=>'Name', 'autofocus'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('subject', 'Subject') }}
                                                        {!!Form::text('subject',$data[0]->subject,array('class'=>'form-control'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Body') }}
                                                        <textarea id="contents" name="contents"><?php echo $data[0]->contents;?></textarea>
														<script type="text/javascript">						 
                                                        CKEDITOR.replace( 'contents', {
                                                        height : 300,
                                                        uiColor :'#CCCCCC',
                                                        filebrowserBrowseUrl :'ckeditor/filemanager/browser/default/browser.html?Connector=ckeditor/filemanager/connectors/php/connector.php',
                                                        filebrowserImageBrowseUrl : 'ckeditor/filemanager/browser/default/browser.html?Type=Image&amp;Connector=ckeditor/filemanager/connectors/php/connector.php',
                                                        filebrowserFlashBrowseUrl :'ckeditor/filemanager/browser/default/browser.html?Type=Flash&amp;Connector=ckeditor/filemanager/connectors/php/connector.php',
                                                        filebrowserUploadUrl  :'ckeditor/filemanager/connectors/php/upload.php?Type=File',
                                                        filebrowserImageUploadUrl : 'ckeditor/filemanager/connectors/php/upload.php?Type=Image',
                                                        filebrowserFlashUploadUrl : 'ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
                                                        });
                                                        </script>
                                                    </div>
                                                	{{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/emailtemplate', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                
                                                {!!Form::close()!!}
                                    
                                            </div>
                                            
                                        </section>
                                        
                                                
                                    </div>
                                    <div class="col-sm-4">
                                        <section class="panel panel-default">
                                        	
                                            <header class="panel-heading font-bold">Variable Lists</header>
                                            <div class="panel-body">
                                            	
                                                <div class="form-group">
                                                    {{ Form::label('title', '%GAME_DATE%  = Game Date') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%DEMAND_TYPE% = Demand Type') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%OPPONENT% = Team Name') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%REQUESTER% = Request Name') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%RECIPIENT% = Receipient Name') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%TYPE%  = Delivery Type') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%COMP%  = Comp') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%PURCHASED% = Purchased') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%TOTAL%  = Comp + Purchased') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%APPROVER_LEVEL% = Approver Name') }}
                                                </div>
                                                <div class="form-group">
                                                    {{ Form::label('title', '%GAME_NAME% = Game Name') }}
                                                </div>
                                            </div>
                                            
                                        </section>
                                        
                                                
                                    </div>
                                </div>
                            
                            </section>
                            
                        </section>
                    </section>
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')
