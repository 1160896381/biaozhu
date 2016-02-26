@extends('_layouts.app')

@section('contentApp')
<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-default sidebar" role="navigation">
		    <div class="sidebar-nav navbar-collapse">
		      	<ul class="nav" id="side-menu">
		        	<li class="sidebar-search">
		            	<div class="input-group custom-search-form">
		                  	<input type="text" class="form-control" placeholder="Search...">
		                  	<span class="input-group-btn">
		                      	<button class="btn btn-default" type="button">
		                          	<i class="fa fa-search"></i>
		                      	</button>
		                  	</span>
		              	</div>
		          	</li>
		          	<li>
	            	  	<a href="#"><i class="fa fa-dashboard fa-fw"></i> 资源管理<span class="fa arrow"></span></a>
		              	<ul class="nav nav-second-level">
		                  	<li>
		                  		<a href="/admin/resource">查看</a>
		                  	</li>
		                  	<li>
                      			<a href="flot.html">批量上传文本</a>
		                  	</li>
		                  	<li>
	                      		<a href="morris.html">批量上传图片</a>
		                  	</li>
		              	</ul>	
		          	</li>
		          	<li>
		              	<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 任务管理<span class="fa arrow"></span></a>
		              	<ul class="nav nav-second-level">
		                  	<li>
                      			<a href="flot.html">文本数据表</a>
		                  	</li>
		                  	<li>
	                      		<a href="morris.html">图片数据表</a>
		                  	</li>
		              	</ul>
		          	</li>
		          	<li>
	              		<a href="#"><i class="fa fa-table fa-fw"></i> 人员管理<span class="fa arrow"></span></a>
		              	<ul class="nav nav-second-level">
		                  	<li>
                      			<a href="flot.html">注册</a>
		                  	</li>
		                  	<li>
	                      		<a href="morris.html">名单列表</a>
		                  	</li>
		              	</ul>
		          	</li>
		          	<li>
	              		<a href="#"><i class="fa fa-edit fa-fw"></i> 规范制定<span class="fa arrow"></span></a>
	              		<ul class="nav nav-second-level">
		                  	<li>
                      			<a href="flot.html">标注任务</a>
		                  	</li>
		                  	<li>
	                      		<a href="morris.html">任务类型（一级名称）</a>
		                  	</li>
  		                  	<li>
  	                      		<a href="morris.html">任务类型（二级名称）</a>
  		                  	</li>
		              	</ul>
		          	</li>
		          	<li>
		              	<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 可视化统计<span class="fa arrow"></span></a>
		              	<ul class="nav nav-second-level">
		                  	<li>
                      			<a href="flot.html">资源</a>
		                  	</li>
		                  	<li>
	                      		<a href="morris.html">任务</a>
		                  	</li>
		                  	<li>
	                      		<a href="morris.html">人员</a>
		                  	</li>
		              	</ul>
		          	</li>
		      	</ul>
		    </div>
		</div>
	</nav>

	@yield('contentAdmin')

</div>
@endsection