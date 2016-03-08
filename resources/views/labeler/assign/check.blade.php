@extends('_layouts.app')

@section('contentApp')

<div id="labeler-page-wrapper">
	<table width="960" border="0" align="center" cellpadding="12" cellspacing="1" bgcolor="#C9F1FF" style="margin-top: 80px;"><tr>
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
	'yuliaoID':  '<?=$assign["id"]?>',
	'userID'  :  '<?=$assign["labelerId"]?>'
};

var params = {
	'quality'          : 'high',
	'bgcolor'          : '#ffffff',
	'allowscriptaccess': 'sameDomain',
	'allowfullscreen'  : 'true'
};

var attributes = {
	'id'   : '<?=$assign['flashPath']?>',
	'name' : '<?=$assign['flashPath']?>',
	'align': 'center'
};

swfobject.embedSWF(
    "/flash/<?=$assign['flashPath']?>.swf", 
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
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="900" id='<?=$assign['flashPath']?>'>
        <param name="movie" value="<?=$assign['flashPath']?>.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#ffffff" />
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="allowFullScreen" value="true" />

        <object type="application/x-shockwave-flash" data="<?=$assign['flashPath']?>.swf" width="100%" height="900">
            <param name="quality" value="high" />
            <param name="bgcolor" value="#ffffff" />
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="allowFullScreen" value="true" />
        </object>
    </object>
</noscript>
@endsection