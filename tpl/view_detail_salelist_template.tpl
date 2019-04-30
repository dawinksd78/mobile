<% _.each(data, function(item, key, list) { %>
<tr class="">
  <td class="contract"><%=item.TRADE_YM%> <%=item.rangecode%></td>
  <td class="real-price"><%= (item.TRADE_TYPE=='2') ? '전세':'매매'%></td>
  <td class="dong"><%= fnMoneyAboutText( (item.TRADE_TYPE=='2') ? item.PRICE2*10000 : item.PRICE1*10000 )%></td>
  <td class="floor"><%=item.FLOOR%>층 </td>
</tr>
<% });%>
