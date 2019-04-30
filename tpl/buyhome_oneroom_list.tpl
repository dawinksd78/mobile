			<% if(data.length < 1 ) { %>
				<div class="itm_inner"><p>해당 검색에 맞는 데이터가 없습니다.</p></div>
			<% } else { %>
				<% _.each(data, function(item, key, list){ %>
					<div class="itm_inner" style="padding:5px;">
                        <div class="itm_pic">
                            <div class="like_area"> <span class="like <%=(item.isfavo == 1)?'on':'' %>" data-saleno="<%=item.GOODS_IDX%>" onclick="complexFavorate(this)"></span> </div>
                            <% if(getSamrt == '1') { %>
                            	<% if(memSet > 0) { %>
                            		<div class="itm_thumb" onclick="dawin_newpop('/buyhome/saledetail/<%=item.GOODS_IDX%>')"><img src="<%= (item.img =='') ? '/images/img_noimg02.png' : item.img %>" /></div>
                            	<% } else { %>
                            		<div class="itm_thumb" onclick="fnpoploginOpen()"><img src="<%= (item.img =='') ? '/images/img_noimg02.png' : item.img %>" /></div>
                            	<% } %>
                            <% } else { %>
                            	<% if(memSet > 0) { %>
                            		<div class="itm_thumb" onclick="goPagePop('/buyhome/saledetail/<%=item.GOODS_IDX%>')"><img src="<%= (item.img =='') ? '/images/img_noimg02.png' : item.img %>" /></div>
                            	<% } else { %>
                            		<div class="itm_thumb" onclick="fnpoploginOpen()"><img src="<%= (item.img =='') ? '/images/img_noimg02.png' : item.img %>" /></div>
                            	<% } %>
                            <% } %>
                        </div>
                        
                        <% if(getSamrt == '1') { %>
                        	<% if(memSet > 0) { %>
                        		<a class="itm_info" onclick="dawin_newpop('/buyhome/saledetail/<%=item.GOODS_IDX%>')">
                        	<% } else { %>
                        		<a class="itm_info" onclick="fnpoploginOpen()">
                        	<% } %>
                        <% } else { %>
                        	<% if(memSet > 0) { %>
                        		<a class="itm_info" onclick="goPagePop('/buyhome/saledetail/<%=item.GOODS_IDX%>')">
                        	<% } else { %>
                        		<a class="itm_info" onclick="fnpoploginOpen()">
                        	<% } %>
                        <% } %>
                            <div class="itm_exp oitem">
                                <p class="price bolder"><span class="s_type0<%=item.TRADE_TYPE%>"><b><%=(item.TRADE_TYPE==3)?'월세':( (item.TRADE_TYPE==2)?'전세':'매매')%></b>
	                                <% if (item.TRADE_TYPE==3) { %>
		                  				<%=fnMoneyAboutText(item.PRICE2*10000)%> / <%=fnMoneyAboutText(item.PRICE3*10000)%>
		                			<% } else if (item.TRADE_TYPE==2) { %>
		                  				<%=fnMoneyAboutText(item.PRICE2*10000)%>
		                			<% } else { %>
		                  				<%=fnMoneyAboutText(item.PRICE1*10000)%>
		                			<% } %> 
                                </span></p>
                                <p class="area"><%= (space_unit=='m')? Math.floor(item.AREA1): conv_m3(item.AREA1)%><%= (space_unit=='m')?"m²":"평"%> <span><%=Math.floor(item.AREA1/3.3)%>평형</span></p>
                                <p class="ex_info">
                                	<%= item.ROOM_TYPE_TEXT %>, 
                                	<%=item.FLOOR%><% if(item.TOTAL_FLOOR > 0) {%>/총 <%=item.TOTAL_FLOOR%>층<% } %>, 
                                	<% if( item.ANIMAL =='1') { %>
		                				반려동물가능
		              				<% } else if ( item.ANIMAL =='2' ) { %>
		                				반려동물불가능
		               				<% } %> 
                                	<%= ( (item.ANIMAL==1 || item.ANIMAL==2) && (item.PARKING_FLAG =='Y'|| item.PARKING_FLAG =='N') ) ? ",":"" %>
			            			<% if( item.PARKING_FLAG =='Y') { %>
			              				<b class="exp01">주차가능</b>
			            			<% } else if ( item.PARKING_FLAG =='N' ) { %>
			              				<b class="exp01">주차불가능</b>
			            			<% } %>
                                </p>
                            </div>
                        </a>
                    </div>
                <% }) %>
			<% } %>