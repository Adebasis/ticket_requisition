<?php echo $__env->make('admin.includes.top', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xl">
    	<?php
		$appsettings = DB::table('appsettings')->where('id', 2)->get();
		?>
    	<a class="navbar-brand1 block" style="text-align:center;"><img src="<?php echo e(url('/')); ?>/public/admin_assets/images/<?php echo $appsettings[0]->Value;?>" class="m-r-lg" alt="scale" style="width:30%; min-height:inherit; height:95px !important;"></a>
        <section class="m-b-lg">
            <header class="wrapper text-center">
                <strong>Sign in Here</strong>
            </header>
        	        
            <?php echo Form::open(array('action' => 'AdminController@postLogin', 'id'=>'form1','autocomplete'=>'on')); ?>

            
            	<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            	
                <div class="list-group">
                    <div class="list-group-item">
                    <?php echo e(Form::input('text', 'txtUsername', null, ['class' => 'form-control no-border','placeholder'=>'Email Address OR User Name','autofocus'=>'true','required'])); ?>

                    </div>
                    <div class="list-group-item">
                    <?php echo e(Form::input('password', 'txtPassword', null, ['class' => 'form-control no-border','placeholder'=>'***********','required'])); ?>

                    </div>
                </div>
                
            	<?php echo e(Form::submit('Sign In', array('class'=>'btn btn-lg btn-primary btn-block'))); ?>

                
                <p><h4 style="color:#F00;">
                <?php if(Session::has('error')): ?>
                <?php echo Session::get('error'); ?>

                <?php endif; ?>
                </h4>
                </p>
                
                <div class="text-center m-t m-b"><a href="<?php echo e(url('adminpanel/reset/password')); ?>"><small>Reset password?</small></a></div>
                <div class="line line-dashed"></div>
            
            <?php echo Form::close(); ?>

        
        </section>
    </div>
</section>

<?php echo $__env->make('admin.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>