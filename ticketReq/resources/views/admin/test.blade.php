@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
    
    <script>
	app.controller('useraccontCtrl', function($scope, $sce, $filter, $http, $window, API_URL) {
		
		//declare an empty array
		$scope.allItems = [];
		
		$http.get(API_URL + "adminpanel/api/useraccount").success(function(response) {
			//console.log(response)
			$scope.allItems = response;
		});
		
	});
	</script>
        
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
        	
            <section class="panel" ng-controller="useraccontCtrl">
                
                <div class="row wrapper">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-3 m-b-xs"></div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/useraccount','class'=>'','role'=>'search'])  !!}
                    
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search" ng-model="search" placeholder="Search" value="{{ app('request')->get('search') }}">
                            <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Go!</button>
                            </span>
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    
                    <div class="col-sm-1">
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a href="{{ url('/adminpanel/useraccount/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable"></th>
                        <th class="th-sortable bgtable" data-toggle="class">User Name</th>
                        <th class="th-sortable bgtable" data-toggle="class">Email Address</th>
                        <th class="th-sortable bgtable" data-toggle="class">Department</th>
                        <th class="th-sortable bgtable" data-toggle="class">Employee Type</th>
                        <th width="300" class="text-center bgtable">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <tr dir-paginate="tmpdata in allItems|orderBy:sortKey:reverse|filter:search|itemsPerPage:25|track by:0">
                        <td class="text-center">@{{$index + 1}}</td>
                        <td>@{{ tmpdata.FirstName }} @{{ tmpdata.LastName }}</td>
                        <td>@{{ tmpdata.EmailAddress }}</td>
                        <td><?php /*?>@{{ tmpdata.dept_id }} <?php */?>@{{ getDataFromTable("department","Name","id", tmpdata.dept_id ) }}</td>
                        <td></td>
                        <?php
						/*if($tmpdata->password == ""){
							$password_label = 'New Password';
						}else{
							$password_label = 'Edit Password';
						}*/
						?>
                        <td class="text-center">
                          
                        </td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
                
                <div class="row" style="margin-right:0;">
                    <div class="col-sm-4 hidden-xs"></div>
                    <div class="col-sm-3 text-center"></div>
                    <div class="col-sm-5 text-right text-center-xs">
                    <dir-pagination-controls max-size="5" direction-links="true" boundary-links="true" ></dir-pagination-controls>
                    </div>
                  </div>
              </section>
        
        </section>
    </section>
</section>

@include('admin.includes.admin_footer')
