<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button><span class="">뒤로</span></button>
        </span>
        <h2 class="title">로그인</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap find_wrap">
                <div class="v_align_wrap">
                    <div class="ntc_txt">
                        <p class="ntc_p">기존 핸드폰 번호가 확인되지 않습니다.<br>핸드폰 본인 인증을 진행해 주세요.</p>
                    </div>
                    <div class="inpbox">
                      	<input type="tell" name="phoneNumber" id="phoneNumber" placeholder="휴대폰 번호를 입력해주세요." title="휴대폰 번호를 입력해주세요." class="inp" autocomplete="off">
                    </div>
                    
                    <!-- 휴대폰인증영역 -->
                    <div class="btn_area mgt">
                        <button type="button" class="btn_type07 btn_cirtf">휴대폰인증</button>
                    </div>                    
                </div>
                
                <!-- 비밀번호 찾기, 회원가입 링크는 휴대폰인증영역시만 오픈 -->
                <div class="lg_link"><a href="javascript:void(0);" onclick="goPage('/member/findpass1')">비밀번호찾기</a> <a href="javascript:void(0);" onclick="goPage('/member/join1')">회원가입</a></div>
            </div>
            
            <div class="btn_area bot_btn">
                <button class="btn_type03">확인</button>
            </div>
        </div>
    </section>
</div>