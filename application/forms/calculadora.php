<?php
	

session_start();	
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
?>
<div id="calc" style="width: 169; height: 176" class="drag">
  <form name="calculator">
    <table bordercolor="gray" border="3" cellspacing="2" cellpadding="2" width="150" bgcolor="black">
      <tr>
        <td colspan="4">
        <input style="color: red; background: black; text-align:right" length="19" name="ans" size="19" />                        </td>
	  </tr>
      <tr>
        <td align="middle">
        <input onmousedown="document.calculator.ans.value+='7'" value="  7  " name="seven" type="button"/>        </td>
        <td align="middle">
        <input value="  8  " name="eight" onclick="document.calculator.ans.value+='8'" type="button"/>        </td>
        <td align="middle">
        <input value="  9  " name="nine" onclick="document.calculator.ans.value+='9'" type="button"/>        </td>
        <td align="middle">
        <input value="  /  " name="divide" onclick="document.calculator.ans.value+='/'" type="button"/>        </td>
      </tr>
      <tr>
        <td align="middle">
        <input value="  4  " name="four" onclick="document.calculator.ans.value+='4'" type="button"/>        </td>
        <td align="middle">
        <input value="  5  " name="five" onclick="document.calculator.ans.value+='5'" type="button"/>        </td>
        <td align="middle">
        <input value="  6  " name="six" onclick="document.calculator.ans.value+='6'" type="button"/>        </td>
        <td align="middle">
        <input value="  *  " name="multiply" onclick="document.calculator.ans.value+='*'" type="button"/>        </td>
      </tr>
      <tr>
        <td align="middle">
        <input value="  1  " name="one" onclick="document.calculator.ans.value+='1'" type="button"/>        </td>
        <td align="middle">
        <input value="  2  " name="two" onclick="document.calculator.ans.value+='2'" type="button"/>        </td>
        <td align="middle">
        <input value="  3  " name="three" onclick="document.calculator.ans.value+='3'" type="button"/>        </td>
        <td align="middle">
        <input value="  -  " name="subtract" onclick="document.calculator.ans.value+='-'" type="button"/>        </td>
      </tr>
      <tr>
        <td align="middle">
        <input value="  C  " name="clear" onclick="document.calculator.ans.value=''" type="button"/>        </td>
        <td align="middle">
        <input value="  0  " name="zero" onclick="document.calculator.ans.value+='0'" type="button"/>        </td>
        <td align="middle">
        <input value="  =  " name="equal" onclick="document.calculator.ans.value=eval(document.calculator.ans.value)" type="button"/>        </td>
        <td align="middle">
        <input value="  +  " name="add" onclick="document.calculator.ans.value+='+'" type="button"/>        </td>
      </tr>
    </table>
  </form>
</div>