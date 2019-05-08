<style>
.st_get_answer_loading{
  width:100%;
  height:100%;
  position: absolute;
  top:0;
  left:0;
  background-color: rgba(133, 133, 133, 0.54);
}
.st_get_answer_loading .st_dot_loading{
  top: 50%;
  left: 50%;
  display: inline-block;
  position: absolute;
  transform: translate(-50%, -50%);
}
.st_dot_loading{text-align: center}
.st_dot_loading span {
  display: inline-block;
  vertical-align: middle;
  width: .6em;
  height: .6em;
  margin: .19em;
  background: #007DB6;
  border-radius: .6em;
  animation: st_dot_loadingkey 1s infinite alternate;
}
.st_dot_loading span:nth-of-type(2) {
  background: #008FB2;
  animation-delay: 0.2s;
}
.st_dot_loading span:nth-of-type(3) {
  background: #009B9E;
  animation-delay: 0.4s;
}
.st_dot_loading span:nth-of-type(4) {
  background: #00A77D;
  animation-delay: 0.6s;
}
.st_dot_loading span:nth-of-type(5) {
  background: #00B247;
  animation-delay: 0.8s;
}
.st_dot_loading span:nth-of-type(6) {
  background: #5AB027;
  animation-delay: 1.0s;
}
.st_dot_loading span:nth-of-type(7) {
  background: #A0B61E;
  animation-delay: 1.2s;
}
@keyframes st_dot_loadingkey {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
</style>
<script>
var var_getDevideCookie = '<?php echo (isset($getDevideCookie)) ?$getDevideCookie:''?>';
var var_device = '<?php echo (isset($DEVICE)) ?$DEVICE:''?>';
function fnGoodsalert(goods_status){
  ;
}
function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}
function fnNewPopMobile(url) {
  //if(var_getDevideCookie=='1' && var_device=='AND') dawin_newpop(url)
  //else goPagePop(url)
	goPage(url);
}
function createloading(cnt){
  var loading = '<div class="st_dot_loading">';
  if( typeof cnt =='undefined') var cnt =7;
  if (cnt > 7) cnt = 7;
  for( var i=0 ; i < cnt ; i ++ ){
    loading += '<span></span>'
  }
  loading += '</div>';
  return loading;
}
</script>

<script type="text/template" id="qnalisttemplate">
  <% _.each(data, function(item, key, list) { %>
    <% if( item.tbname == 'UA') { %>
      <li class="itm_lst">
          <div class="itm_inner">
            <div class="ques">
              <% if( item.ans =='Y') { %>
                <span class="situ st01">답변완료</span>
              <% } else { %>
                <span class="situ st02">미답변</span>
              <% } %>
            <!-- 190410 매물정보영역 수정 -->
            <a class="itm_addr" href="javascript:;" onClick="<%= (item.GOODS_STATUS=='SB')? "fnNewPopMobile('/buyhome/saledetail/"+item.GOODS_IDX+"')":"fnGoodsalert('"+item.GOODS_STATUS+"')"%>">
              <span class="itm_info"><%= item.COMPLEX_NAME%><small><%= item.addr%></small></span>
            </a>
            <!-- // 매물정보영역 수정 끝 -->
            <a href="javascript:;" class="qitem <%= ( item.ans =='Y')? "close":""%>" data-idx="<%=item.idx%>" data-category="<%=item.tbname%>" <%= ( item.ans =='Y') ? 'onClick="fnqna.ans(this)"':'' %> >
              <b>Q.</b><%= nl2br(item.title)%></b>
              <div class="qa_date"><%= item.regdate_format%></div>
            </a>
          </div>
          <div class="st_answrap" style="display:none">
          </div>

        </div>
      </li>
    <% } else { %>
      <li class="itm_lst">
        <div class="itm_inner">
            <div class="ques">
              <% if( item.ans =='Y') { %>
                <span class="situ st01">답변완료</span>
              <% } else { %>
                <span class="situ st02">미답변</span>
              <% } %>
          <!-- 190410 카테고리영역추가 -->
          <span class="q_cate"><%= item.QNA_CATEGORY%></span>
            <a href="javascript:;" class="qitem <%= ( item.ans =='Y')? "close":""%>" data-idx="<%=item.idx%>" data-category="<%=item.tbname%>" <%= ( item.ans =='Y') ? 'onClick="fnqna.ans(this)"':'' %> >
              <b>Q.</b><%= item.title%>
              <div class="q_cont"><%= nl2br(item.cont)%></div>
              <div class="qa_date"><%= item.regdate_format%></div>
          </a>
          </div>
          <div class="st_answrap" style="display:none">
          </div>
        </div>
      </li>
    <% }%>
  <% }) %>
</script>
<script type="text/template" id="qnalanstemplate">
  <div class="ans_wrap_items">
  <% _.each(data, function(item, key, list) { %>
      <% if (category =='UH_DW') { %>
          <% if ( item.is_ans == 'Y') { %>
            <div class="aitem">
                <div class="ans_adm">
                    <p class="name">관리자</p>
                </div>
                <p><%= nl2br(item.QNA_ANSWER)%></p>
                <div class="qa_date"><%= item.regdate_format%></div>
            </div>
          <% } else { %>
            <div class="aitem">
                <p><%= nl2br(item.QNA_ANSWER)%></p>
                <div class="qa_date"><%= item.regdate_format%></div>
            </div>
          <% } %>
      <% } else if (key == 0 ) { %>
      <div class="aitem aitem_realtor">
          <div class="ans_bk">
              <div class="thumbnail_area">
                  <div class="thumbnail"><img src="<%= item.img%>"></div>
              </div>
              <div class="broker_info">
                  <p class="commtype"><%= item.OFFICE_NAME%></p>
                  <p class="name"><%= item.MBR_NAME%></p>
              </div>
          </div>
          <p><%= nl2br(item.CONTENTS)%></p>
          <div class="qa_date"><%= item.regdate_format%></div>
      </div>
      <% } else if ( item.is_ans == 'N') { %>
        <div class="aitem aitem_my">
            <p><%= nl2br(item.CONTENTS)%></p>
            <div class="qa_date"><%= item.regdate_format%></div>
        </div>
      <% } else { %>
        <div class="aitem aitem_1">
            <div class="ans_bk">
                <div class="thumbnail_area">
                    <div class="thumbnail"><img src="<%= item.img%>"></div>
                </div>
                <div class="broker_info">
                    <p class="commtype"><%= item.OFFICE_NAME%></p>
                    <p class="name"><%= item.MBR_NAME%></p>
                </div>
            </div>
            <p><%= nl2br(item.CONTENTS)%></p>
            <div class="qa_date"><%= item.regdate_format%></div>
        </div>
      <% } %>
    <% }) %>
  </div>
  <div class="rt_items">
      <div class="inpbn">
        <form onSubmit="return false;">
          <input type="hidden" name="idx" value="<%= idx%>">
          <input type="hidden" name="tb" value="<%= category%>">
          <input type="text" name="question" placeholder="댓글을 써주세요." title="댓글을 써주세요." class="inp" autocomplete="off" onkeyup="if (window.event.keyCode == 13){fnqna.sendQuestionMorekey(this)}">
        </form>
      <button class="btn_type05" onClick="fnqna.sendQuestionMore(this)">등록</button>
    </div>
  </div>
</script>
<script type="text/template" id="qnamorequetemplate">
  <div class="aitem aitem_newreply">
      <p><%= nl2br(CONTENTS)%></p>
      <div class="qa_date">지금</div>
  </div>
</script>


<div id="dawinWrap" class="mpwrap">
    <header id="header" class="header maphd">
    	<span class="btn_back back02">
        	<button type="button" onclick="history.back();"><span>뒤로</span></button>
        </span>
        <span class="btn_alarm">
        	<button type="button" onclick="goPage('/mypage/alarm')"><span>알람</span></button>
        </span>

        <!-- hamburgerMenu -->
      	<script>hamburgerMenuList('menu_wh');</script>
	</header>

    <section id="container">
        <div class="sub_container">
            <div class="infobox">
                <div class="user_info">
                    <p class="name"><?php echo $this->userinfo['MBR_NAME']; ?></p>
                    <p class="id"><?php echo $this->userinfo['MBR_EMAIL']; ?></p>
                </div>
                <div class="mp_tab">
                    <ul>
                        <li><a href="#" onclick="goPage('/mypage/myzzimsale')">내집구하기</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myhousesale')">내집내놓기</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myinfo')">내정보</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myinquiry')" class="on">1:1문의</a></li>
                    </ul>
                </div>
            </div>

            <div class="cont_wrap public_cont02 mp mp_qna">
                <div class="cont">
                    <div class="itmcard_wrap" id="qnadiv">
                        <br><br>
                    </div>
                </div>
            </div>

            <div class="btn_area bot_btn">
                <button class="btn_type02" type="button" onclick="goPage('/board/inquiry')">1:1문의하기</button>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
var prevScroll = $.cookie('myinquiryPostion');

$("document").ready(function(){
	if(prevScroll > 0 && prevScroll != 'undefined') {
		$(".cont_wrap").scrollTop(prevScroll);
	}
	
	$(".cont_wrap").on('scroll', function(){
	    var scrollValue = $(this).scrollTop();
	    $.cookie('myinquiryPostion', scrollValue);
	});
});

// 답변보기
function replyView(idx)
{
	if($("#inquiryPrint"+idx).css('display') == 'none')
	{
		$(".inquiryPrintClass").children().remove().end();
		$(".qitem").removeClass('close');
		$(".qitem").addClass('open');
		$(".inquiryPrintClass").css('display', 'none');
		$(".rt_items").css('display', 'none');

		$("#inquiryPrint"+idx).children().remove().end();
		$("#qnatitle"+idx).removeClass('open');
		$("#qnatitle"+idx).addClass('close');
		$("#inquiryPrint"+idx).css('display', 'block');
		$("#inquiryReply"+idx).css('display', 'block');
	}
	else
	{
		$(".inquiryPrintClass").children().remove().end();
		$(".qitem").removeClass('close');
		$(".qitem").addClass('open');
		$(".inquiryPrintClass").css('display', 'none');
		$(".rt_items").css('display', 'none');
	}

	// 리스트 가져오기
	$.ajax({
    	type: "POST",
    	dataType: "json",
    	async: false,
    	url:"/mypage/myinquiry_reply",
    	data: "&idx=" + idx,
    	success: function(data) {
    		var html = '';
    		for(var i = 0, len = data.length; i < len; ++i) {
    		    html += '<div class="aitem">';
    		    if(data[i].broker_photo != '') {
    		    	html += '    <div class="ans_bk">';
    		    	html += '        <div class="thumbnail_area"><div class="thumbnail"><img src="' + data[i].broker_photo + '" alt="중개사사진" /></div></div>';
    		    	html += '        <div class="broker_info"><p class="commtype">' + data[i].broker_office + '</p><p class="name">' + data[i].broker_name + '</p></div>';
    		    	html += '    </div>';
    		    }
    		    html += '    <p>' + data[i].contents + '</p>';
    		    html += '    <div class="qa_date">' + data[i].reply_date + '</div>';
    		    html += '</div>';
    		}
    		$('#inquiryPrint'+idx).append(html);
    	}
   	});
}

// 댓글쓰기
function replywrite(idx)
{
	// 전송할 데이터
    var send_data = "&idx=" + idx + "&comments=" + $('#replycomments'+idx).val();

    $.ajax({
    	type: "POST",
    	dataType: "text",
    	async: false,
    	url: "/mypage/myinquiry_replycomment",
    	data: send_data,
    	success: function(data) {
     		if(data == 'SUCCESS') {
      			swal('등록이 완료 되었습니다.');
      			$('#replycomments'+idx).val('');
      			replyView(idx);
     		}
     		else {
     			swal('등록에 실패하였습니다.');
     		}
    	},
    	error:function(data){
     		alert('comment write ajax error');
    	}
   	});
}
</script>



<script>
function getQnaList() {
  var self,opt, template, anstemplate, moretemplate;
  var page=0 ;
  var morebtn = "off";
  return {
    init: function (option){
      self = this;
      opt = option;
      if (typeof opt.classname == 'undefined') opt.classname ='itm_box';
      if (typeof opt.perpage == 'undefined') opt.perpage =100000;
      template = _.template( option.cont );
      anstemplate = _.template( option.ans );
      moretemplate = _.template ( option.more);
      $(opt.target).empty();
      $(opt.target).append('<ul class="'+opt.classname+' st_getqna" />');
      $(opt.target).append( '<div class="more" style="display:none"><a href="javasciprt:;" class="linebtn">더보기<b class="ico_down"></b></a></div><div class="st_btn_loader_wrapper hide">' + createloading(4) + '</div>')
      console.log( $(opt.target).html() )
      //$(opt.target + " a.linebtn").click( self.get );
      self.get();
    },
    get: function () {
      $.ajax({
        url: '/userapi/getQna',
        type: 'GET',
        data: {page:page, perpage : opt.perpage },
        dataType: 'json',
        success: function (result) {
            if( result.data.length < opt.perpage ){
              $(opt.target + " div.more").remove();
            }
            if ( result.data.length  < 1) {
              morebtn = "off";
              return;
            }
            $(opt.target + " > ul.st_getqna").append(template(result));
            page++;
            if (result.nextpage=="on") morebtn = "on";
            else morebtn = "off";
        },
        error : function(request, status, error) {
          console.log(error);
        },
        beforeSend: function() {
          $(opt.target + " div.more").hide();
          $(opt.target + " div.st_btn_loader_wrapper").show();
         },
         complete: function(){
           if( morebtn == "on"){
             $(opt.target + " div.more").show();
           }
           $(opt.target + " div.st_btn_loader_wrapper").hide();
         },
        });
    },
    ans : function (ln) {
      if( $(ln).hasClass("open") ) {
        $(ln).removeClass("open").addClass("close");
        $(ln).parent().next(".st_answrap").hide();
        return;
      }else {
        $.ajax({
          url: '/userapi/getQnaAns',
          type: 'GET',
          data: {idx:$(ln).data('idx'),category:$(ln).data('category')},
          dataType: 'json',
          success: function (result) {
            if(result.code==200){
                $(ln).parent().next('.st_answrap').html( anstemplate(result) );

                $("ul.st_getqna li a.qitem.open").each( function() {
                  $(this).removeClass("open").addClass("close");
                  $(this).parent().next(".st_answrap").hide();
                });
                $(ln).addClass("open");
                $(ln).parent().next(".st_answrap").show();

            }else if( result.msg != '') swal ( result.msg );
          },
          error : function(request, status, error) {
            console.log(error);
          },
          beforeSend : function () {
            $(ln).parent().append('<div class="st_get_answer_loading">'+createloading()+'<div>')
          },
          complete: function(){
            $(ln).parent().children("div.st_get_answer_loading").remove();
          }
        });
      }
    },
    sendQuestionMorekey:function(inp) {
      self.sendQuestionMore($(inp).closest('.st_answrap').children(".rt_items").children('.inpbn').children('button.btn_type05'))
    },
    sendQuestionMore : function(bt){
      var param = $(bt).parent().children("form").serialize();
      $.ajax({
        url: '/userapi/setQuestionMore',
        type: 'post',
        data: $(bt).parent().children("form").serialize(),
        dataType: 'json',
        success: function (result) {
          if(result.code==200){
            $(bt).closest('.st_answrap').children (".ans_wrap_items").append(moretemplate(result));
            $(bt).parent().children("form").children("input[type=text]").each( function () {$(this).val('')});
          }else if( result.msg != '') swal ( result.msg );
        },
        error : function(request, status, error) {
          console.log(error);
        },
      });
    }
  }
}
var fnqna = getQnaList();
fnqna.init({target:"#qnadiv", cont: $("#qnalisttemplate").html(), ans : $("#qnalanstemplate").html(), more : $("#qnamorequetemplate").html() });
</script>
