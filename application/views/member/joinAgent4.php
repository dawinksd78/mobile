<div id="dawinWrap" class="bgrey">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button><span class="">뒤로</span></button>
        </span>
        <h2 class="title">중개사회원가입</h2>
    </header>
    
    <section id="container">
        <?php
        $attributes = array('method'=>'post','id'=>'joinagentform','onsubmit'=>'return joinprocess()'); //'onkeypress'=>'return event.keyCode != 13'
        echo form_open('/member/joinAgentResult',$attributes);
        ?>
        <div class="sub_container">
            <div class="cont_wrap join_wrap joinbk">
                <h2 class="subj_tit"><span class="m_tit">개인정보</span></h2>
                <div class="proc"> <a href="" class="bul_proc prev"></a><a href="" class="bul_proc prev"></a><a href="" class="bul_proc on"></a><a href="" class="bul_proc"></a></div>
                <p class="m_exp">안전하고 신뢰성 있는 중개를 위해 '대표 개업공인중개사'에 한해 회원가입이 가능합니다. 중개사무소 내 소속공인중개사 또는 보조중개원이 있을 경우, 회원가입 후 '마이페이지'에서 등록해주세요.</p>
                <div class="cont">
                    <div class="prof_area">
                        <div class="prof_frame"> <img id="" src="../../images/ex_prof.png" alt="프로필 사진" class="prof_image">
                            <button class="btn_pic">사진올리기</button>
                        </div>
                    </div>
                    <div class="inpbox readinp02">
                        <label for="bk_name" class="lbl">이름(대표자명)</label>
                        <input type="text" id="off_name" placeholder="대표자이름 자동입력" title="대표자이름 자동입력" class="inp readinp" autocomplete="off" readonly>
                    </div>
                    <div class="inpbox inpbn">
                        <label for="u_phone" class="lbl">휴대폰인증</label>
                        <button class="btn_type07 btn_cirtf">휴대폰인증</button>
                        <p class="add_text">* 대표자 명의의 휴대폰번호로 인증해주세요.</p>
                    </div>
                   <div class="inpbox inpbn">
                        <label for="u_id" class="lbl">아이디</label>
                        <input type="text" id="u_id" placeholder="아이디(이메일)를 입력하세요." title="아이디(이메일)를 입력하세요." class="inp" autocomplete="off">
                        <span class="dcbtn">
                        <button class="btn_line02">중복확인 </button>
                        </span> </div>
                    <div class="inpbox">
                        <label for="u_pass" class="lbl">비밀번호</label>
                        <input type="password" id="u_pass" placeholder="비밀번호를 입력하세요(영문+숫자8-15)" title="비밀번호를 입력하세요(영문+숫자8-15)" class="inp" autocomplete="off">             
                        <input type="password" id="" placeholder="비밀번호를 다시입력하세요." title="비밀번호를 다시입력하세요." class="inp error" autocomplete="off">
                        <!-- 입력내용 문제있을 경우 에러메세지 출력 -->
                        <div class="err_msg"><span>* 비밀번호가 동일하지 않습니다.</span></div>
                    </div>
                    <div class="inpbox">
                        <label for="bk_career" class="lbl">경력사항 <small>* 선택</small></label>
                        <textarea id="bk_career" class="txtarea" placeholder="중개의뢰 고객이 믿고 선택할 수 있도록, 내용을 상세하게 입력헤주세요. &#13;&#10;ex) 1. 금곡동 까치마을 주변에서 개업 (1995) &#13;&#10; 2. 분당구 중개사회 총무 (2010-2013) &#13;&#10; 3. 총 계약건수 200회 이상 등"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn double">
                <button class="btn_type03" type="button" onclick="history.back();">이전</button>
                <button class="btn_type02" type="submit">다음</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </section>
</div>