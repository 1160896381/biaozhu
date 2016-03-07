@extends('_layouts.app')

@section('contentApp')

<div id="labeler-page-wrapper">
	<table width="960" border="0" align="center" cellpadding="12" cellspacing="1" bgcolor="#C9F1FF"><tr>
	    <td width="20%" valign="top" bgcolor="#FFFFFF">
	        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
	        <div id="flashContent" />
	        </table>
	    </td>
	</tr></table>
</div>

@include('partials.footer')

@endsection

@section('script')
<script src="/flash/swfobject.js"></script>
<script>
var swfVersionStr = "11.1.0";
var xiSwfUrlStr = "playerProductInstall.swf";

var flashvars = {
	'yuliaoID':  '<?=$yuliaoID?>',
	'classID' :  '<?=$classID?>',
	'userID'  :  '<?=$user[userid]?>',
	'adminID' :  '<?=$adminID?>',
	'userName':  '<?=$user[username]?>',
	'state2'  :  '<?=$state2?>'
};

var params = {
	'quality'          : 'high',
	'bgcolor'          : '#ffffff',
	'allowscriptaccess': 'sameDomain',
	'allowfullscreen'  : 'true'
};

var attributes = {
	'id'   : '<?=$flashpath?>',
	'name' : '<?=$flashpath?>',
	'align': 'center'
};

swfobject.embedSWF(
    "<?=$flashpath?>.swf", 
    "flashContent", 
    "100%", 
    "900", 
    swfVersionStr, 
    xiSwfUrlStr, 
    flashvars, 
    params, 
    attributes
);

swfobject.createCSS(
	"#flashContent", 
	"display:block; text-align:right;"
);
 
</script>
<noscript>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="900" id='<?=$flashpath?>'>
        <param name="movie" value="<?=$flashpath?>.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="allowFullScreen" value="true" />

        <object type="application/x-shockwave-flash" data="<?=$flashpath?>.swf" width="100%" height="900">
            <param name="quality" value="high" />
            <param name="bgcolor" value="#ffffff" />
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="allowFullScreen" value="true" />
        </object>
    </object>
</noscript>
@endsection