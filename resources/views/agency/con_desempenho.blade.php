<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0043)http://www.agence.com.br/caol/consultas.php -->
<HTML>
   <HEAD>
      <TITLE>CAOL - Controle de Atividades Online - Agence Interativa</TITLE>

      <!-- HTML HEADER -->
      <META http-equiv=Content-Type content="text/html; charset=windows-1252">
      <META content="NOINDEX, NOFOLLOW" name=ROBOTS>
      <META http-equiv=Content-Language content=pt-br>
      <META http-equiv=pragma content=no-cache>
      <META http-equiv=cache-Control content="no cache">
      <META http-equiv=expires content="sat, 04 dec 1993 21:29:02 gmt">
      <META http-equiv=Refresh content="600; url=main.php">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" href="{{asset('css/custom.css')}}">
      <script src="{{asset('js/app.js')}}"></script>
      <script src="{{asset('js/custom.js')}}"></script>
      <META content="MSHTML 6.00.2800.1106" name=GENERATOR>
   </HEAD>
   <BODY>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
         <TBODY>
            <TR>
               <TD width="100%" colSpan=3 height=10><IMG 
                  src="{{asset('inc/spacer.gif')}}" 
                  width=10></TD>
            </TR>
            <TR>
               <TD noWrap width=10><IMG 
                  src="{{asset('inc/spacer.gif')}}" 
                  width=10></TD>
               <TD width="100%">
                  <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
                     <TBODY>
                        <TR>
                           <TD style="BORDER-BOTTOM: #ccc 1px solid">&nbsp;</TD>
                           <TD width=98 background="" height=40 rowSpan=2><A 
                              href="http://www.agence.com.br/" target=_blank><IMG alt="" 
                              src="{{asset('inc/logo.gif')}}" 
                              border=0></A></TD>
                        </TR>
                        <TR>
                           <TD 
                              style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; BORDER-LEFT: #ccc 1px dotted; PADDING-TOP: 3px"><IMG 
                              height=15 alt="" 
                              src="{{asset('inc/fig.gif')}}" 
                              width=51 border=0></TD>
                        </TR>
                     </TBODY>
                  </TABLE>
               </TD>
               <TD noWrap width=10><IMG 
                  src="{{asset('inc/spacer.gif')}}" 
                  width=10></TD>
            </TR>
            <TR>
               <TD width="100%" colSpan=3 height=10><IMG 
                  src="{{asset('inc/spacer.gif')}}" 
                  width=10></TD>
            </TR>
            <TR>
               <TD noWrap width=10><IMG 
                  src="{{asset('inc/spacer.gif')}}" 
                  width=10></TD>
               <TD width="100%">&nbsp;</TD>
               <TD noWrap width=10><IMG 
                  src="{{asset('inc/spacer.gif')}}" 
                  width=10></TD>
            </TR>
         </TBODY>
      </TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
         <TBODY>
            <TR>
               <TD noWrap width=10><IMG 
                  src="{{asset('inc/spacer.gif')}}" 
                  width=10></TD>
               <TD width="100%">
                  <table cellspacing=0 cellpadding=0 width="100%" border=0>
                     <tr>
                        <td class=index style="PADDING-RIGHT: 10px; PADDING-LEFT: 10px; PADDING-BOTTOM: 10px; PADDING-TOP: 10px" valign=top>
                           <table border="0" width="100%" cellspacing="0" cellpadding="0">
                              <tr>
                                 <!--
                                    Para as abas ficarem com o visual apresentado na p&aacute;gina, &eacute; necess&aacute;rio colocar os inputs
                                    dentro de uma tabela. Essa tabela faz o papel de grade e gera algumas linhas pra completar
                                    o layout. 
                                    
                                    Importante:
                                    Note the a c&eacute;lula onde consta o botao principal (selecionado) n&atilde;o leva a classe CEL_TAB.
                                    
                                    Recomendo criar uma funcao/classe para gerar essas Abas com esse layout.
                                    
                                    -->
                                 <td nowrap valign="bottom" align="center" class="cel_tab" height="35"><input type="submit" value name="nothing2" class="nothing">
                                    &nbsp;&nbsp;
                                 </td>
                                 <form action="con_desempenho.htm">
                                    <td nowrap valign="bottom" align="center"><span class="cel_tab">
                                       <input type="submit" value="Por Consultor" name="act22223" class="tab_current">
                                       </span>
                                    </td>
                                 </form>
                                 <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;&nbsp;</td>
                                 <form action="con_desempenho_aba_cliente.htm">
                                    <td nowrap valign="bottom" align="center"><input type="submit" value="Por Cliente" name="act2" class="tab">                  </td>
                                 </form>
                                 <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;&nbsp;</td>
                                 <form action="cadastro_boleto_carregado_cancelado.htm">
                                    <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;</td>
                                 </form>
                                 <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;&nbsp;</td>
                                 <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;</td>
                                 <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;&nbsp;</td>
                                 <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;</td>
                                 <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;&nbsp;</td>
                                 <td nowrap valign="bottom" align="center" class="cel_tab">&nbsp;</td>
                                 <td valign="bottom" class="cel_tab" width="100%">&nbsp;</td>
                              </tr>
                           </table>
                           <br>
                           <table class="cust_tat" width="100%" cellpadding="3" cellspacing="1" 
                              bgcolor="#cccccc"  id="pesquisaAvancada">
                              <tbody>
                                 <tr bgcolor="#fafafa">
                                    <td width="10%" nowrap="nowrap" bgcolor="#efefef">
                                       <div align="right"><strong>Per&iacute;odo</strong></div>
                                    </td>
                                    <td>
                                       <font color="black">
                                          <select id="MonthI">
                                             <option value="01-01" selected>Jan
                                             <option value="02-01">Fev
                                             <option value="03-01">Mar
                                             <option value="04-01">Abr
                                             <option value="05-01">Mai                        
                                             <option value="06-01">Jun
                                             <option value="07-01">Jul
                                             <option value="08-01">Ago
                                             <option value="09-01">Set 
                                             <option value="10-01">Out                          
                                             <option value="11-01">Nov
                                             <option value="12-01">Dez
                                          </select>
                                          <select id="YearI">
                                             <option value="2003">2003
                                             <option value="2004">2004
                                             <option value="2005">2005</option>
                                             <option value="2006">2006</option>
                                             <option value="2007" selected>2007</option>
                                          </select>
                                          a
                                          <select id="MonthF">
                                             <option value="01-28">Jan
                                             <option value="02-28" selected>Fev
                                             <option value="03-28">Mar
                                             <option value="04-28">Abr
                                             <option value="05-28">Mai                        
                                             <option value="06-28">Jun
                                             <option value="07-28">Jul
                                             <option value="08-28">Ago
                                             <option value="09-28">Set 
                                             <option value="10-28">Out                          
                                             <option value="11-28">Nov
                                             <option value="12-28">Dez
                                          </select>
                                          <select id="YearF">
                                             <option value="2003">2003
                                             <option value="2004">2004
                                             <option value="2005">2005</option>
                                             <option value="2006">2006</option>
                                             <option value="2007" selected>2007</option>
                                          </select>
                                       </font>
                                    </td>
                                    <td width="20%" rowspan="2">
                                       <div align="center">
                                          <font color="black">
                                             <form action="con_desem_consultor_rel.htm">
                                                <input type="button" onclick="relatorio('<?php echo Request::root(); ?>/relatorio')" style="BORDER-RIGHT: 1px outset; BORDER-TOP: 1px outset; FONT-SIZE: 8pt; BACKGROUND-POSITION-Y: center; LEFT: 120px; BACKGROUND-IMAGE: url({{asset('img/')}}icone_relatorio.png); BORDER-LEFT: 1px outset; WIDTH: 110px; BORDER-BOTTOM: 1px outset; BACKGROUND-REPEAT: no-repeat; FONT-FAMILY: Tahoma, Verdana, Arial; HEIGHT: 22px; BACKGROUND-COLOR: #CCCCCC" value="Relat&oacute;rio" name="btSalvar22" />
                                             </form>
                                             <form action="con_desem_consultor_graf.htm">
                                                <input type="button" onclick="relatorio('<?php echo Request::root(); ?>/grafico')" style="BORDER-RIGHT: 1px outset; BORDER-TOP: 1px outset; FONT-SIZE: 8pt; BACKGROUND-POSITION-Y: center; LEFT: 120px; BACKGROUND-IMAGE: url({{asset('img/')}}icone_grafico.png); BORDER-LEFT: 1px outset; WIDTH: 110px; BORDER-BOTTOM: 1px outset; BACKGROUND-REPEAT: no-repeat; FONT-FAMILY: Tahoma, Verdana, Arial; HEIGHT: 22px; BACKGROUND-COLOR: #CCCCCC" value="Gr&aacute;fico" name="btSalvar222" />
                                             </form>
                                             <form action="con_desem_consultor_pizza.htm">
                                                <input type="button" onclick="relatorio('<?php echo Request::root(); ?>/pizza')" style="BORDER-RIGHT: 1px outset; BORDER-TOP: 1px outset; FONT-SIZE: 8pt; BACKGROUND-POSITION-Y: center; LEFT: 120px; BACKGROUND-IMAGE: url({{asset('img/')}}icone_pizza.png); BORDER-LEFT: 1px outset; WIDTH: 110px; BORDER-BOTTOM: 1px outset; BACKGROUND-REPEAT: no-repeat; FONT-FAMILY: Tahoma, Verdana, Arial; HEIGHT: 22px; BACKGROUND-COLOR: #CCCCCC" value="Pizza" name="btSalvar222" />
                                             </form>
                                          </font>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr bgcolor="#fafafa">
                                    <td nowrap="nowrap" bgcolor="#efefef">
                                       <div align="right"><strong>Consultores</strong></div>
                                    </td>
                                    <td>
                                       <table align="center">
                                          <tr>
                                             <td>
                                                <select multiple size="8" name="list1" id="list1" style="width:280">
                                                  @foreach($Consultores as $Consultor)
                                                    <option value='{{$Consultor->co_usuario}}'>{{$Consultor->no_usuario}}</option>
                                                  @endforeach
                                                </select>
                                             </td>
                                             <td align="center" valign="middle"><input name="button" type="button" onClick=move(list1,list2) value=">>">
                                                <br>
                                                <input name="button" type="button" onClick="move(list2,list1)" value="<<">
                                             </td>
                                             <td><select multiple size="8" name="list2" id="list2" style="width:280">
                                                </select>
                                                <input type="hidden"  name="lista_analista" value="">
                                             </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                           <p><br>
                              <br>
                              <br>
                              <br>
                           </form>
                           <div id="contenedor" style="text-align: -webkit-center;"></div>
                           <!-- Relatorio -->
                           </p>
                           <p>&nbsp;</p>
                           <p>&nbsp;</p>
                           <p>&nbsp;</p>
                           <p>&nbsp;</p>
                           <p>&nbsp;</p>
                           <p>&nbsp;</p>
                           <p>&nbsp;</p>
                           <p>&nbsp;    </p>
                        </td>
                     </tr>
                  </table>
               </TD>
               <TD noWrap width=10><IMG 
                  src="{{asset('inc/spacer.gif')}}" 
                  width=10></TD>
            </TR>
         </TBODY>
      </TABLE>
      <BR>
   </BODY>
</HTML>