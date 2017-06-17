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
                                        	
                                            <header class="panel-heading font-bold">Customize Maintenance Message</header>
                                            <div class="panel-body">
                                            	
                                                {!!Form::open(array('action'=>'AdminController@admin_post_maintenance_message','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                                                                       
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Contents') }}
                                                        <textarea id="contents" name="contents"><?php echo $data[0]->Value;?></textarea>
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
                                                	{{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}
                                                
                                                {!!Form::close()!!}
                                    
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
