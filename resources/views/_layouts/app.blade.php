<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>通用语料库协同标注平台</title>
	<link href="/css/metisMenu.css" rel="stylesheet">
	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/sb-admin-2.css" rel="stylesheet">
	<link href="/css/font-awesome.css" rel="stylesheet">
	@yield('style')
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">通用语料库协同标注平台</a>
			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right" id="nav-global">

				</ul>
			</div>
		</div>
	</nav>

  	@yield('contentApp')
	
	@include('partials.modals')
	
	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="/js/metisMenu.js"></script>
	<script src="/js/sb-admin-2.js"></script>
	
	<script>
	$(function(){

		var ul_nav = '';
		var auth_user = '<?php echo Auth::user();?>';
		var auth_current_type = '<?php echo Auth::currentType();?>';
		
		if (auth_user && auth_current_type=='admin') {

			ul_nav = ''
				  + '<li><a href="/admin">后台首页</a></li>'
				  +	'<li class="dropdown">'
				  + 	'<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> {{ isset(Auth::user()->name)?Auth::user()->name:'' }}<span class="caret"></span></a>'
				  +		'<ul class="dropdown-menu" role="menu">'
				  +			'<li><a href="/auth/admin/logout">登出</a></li>'
				  +		'</ul>'
				  +	'</li>';

		} else if (localStorage.getItem("labeler_ls") || auth_current_type=='labeler'){

			var name = localStorage.getItem("labeler_ls") 
						? localStorage.getItem("labeler_ls") 
						: '<?php echo isset(Auth::user()->labelerName) ? Auth::user()->labelerName : ''; ?>';

			ul_nav = ''
				  + '<li><a href="/labeler/assign">前台首页</a></li>'
				  +	'<li class="dropdown">'
				  + 	'<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> ' + name + '<span class="caret"></span></a>'
				  +		'<ul class="dropdown-menu" role="menu">'
				  +			'<li><a href="/auth/labeler/logout" id="labeler-logout">登出</a></li>'
				  +		'</ul>'
				  +	'</li>';

		} else if (localStorage.getItem("super_ls") || auth_current_type=='super'){

			var name = localStorage.getItem("super_ls") 
						? localStorage.getItem("super_ls") 
						: '<?php echo isset(Auth::user()->name) ? Auth::user()->name : ''; ?>';

			ul_nav = ''
				  + '<li><a href="/super">后台首页</a></li>'
				  +	'<li class="dropdown">'
				  + 	'<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> ' + name + '<span class="caret"></span></a>'
				  +		'<ul class="dropdown-menu" role="menu">'
				  +			'<li><a href="/auth/super/logout" id="super-logout">登出</a></li>'
				  +		'</ul>'
				  +	'</li>';

		} else {

			ul_nav = '<li><a href="#" data-toggle="modal" data-target="#modal-member-login"> 登录</button></li>';

		}

		$("#nav-global").append(ul_nav);

		$("#labeler-logout").click(function() {
			localStorage.removeItem("labeler_ls");
		});

		$("#super-logout").click(function() {
			localStorage.removeItem("super_ls");
		});
	});
	</script>

	@yield('script')
</body>
</html>