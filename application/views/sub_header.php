<!DOCTYPE Html>
<html lang="Ko">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>다윈중개 모바일</title>

<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover" />
<meta name="format-detection" content="telephone=no, address=no, email=no" />
<meta name="apple-mobile-web-app-capable" content="yes">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- link rel="stylesheet" type="text/css" href="/css/m_all.css?ver=< ? p h p e c h o $ t h i s - > c o n f i g - > i t e m ('js_css_ver') ? >" -->
<link rel="stylesheet" type="text/css" href="/css/m_reset.css?ver=<?php echo $this->config->item('js_css_ver'); ?>">
<link rel="stylesheet" type="text/css" href="/css/m_common.css?ver=<?php echo $this->config->item('js_css_ver'); ?>">
<link rel="stylesheet" type="text/css" href="/css/m_main.css?ver=<?php echo $this->config->item('js_css_ver'); ?>">
<link rel="stylesheet" type="text/css" href="/css/m_sub.css?ver=<?php echo $this->config->item('js_css_ver'); ?>">
<link rel="stylesheet" type="text/css" href="/css/m_seminar.css?ver=<?php echo $this->config->item('js_css_ver'); ?>">

<link rel="stylesheet" type="text/css" href="/css/SpoqaHanSans-kr.css">
<link rel="stylesheet" type="text/css" href="/css/notosanskr.css">
<link rel="stylesheet" type="text/css" href="/css/nanumsquare.css">

<script type="text/javascript">
var openState = "<?php echo $this->config->item('openAlert'); ?>";
</script>

<!-- jquery -->
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.cookie.js"></script>

<!-- swal alert -->
<script src="/js/sweetalert.min.js"></script>

<!-- 다음 지도 API -->
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a835b66d59703e60522fdeb1da106a8f&libraries=services,clusterer"></script>

<!-- 다음 주소 검색 API -->
<script src="/sellhome/getAvailDong"></script>
<?php if($this->config->item('HTTPS') == 'off') { ?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<?php } else { ?>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<?php } ?>

<!-- private setup -->
<script src="/js/mobile_menu.js?ver=<?php echo $this->config->item('js_css_ver')?>"></script>
<script src="/js/underscore.js"></script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '2410886338974162'); 
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" src="https://www.facebook.com/tr?id=2410886338974162&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code -->
</head>

<body>